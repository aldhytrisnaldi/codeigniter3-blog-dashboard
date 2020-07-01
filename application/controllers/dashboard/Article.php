<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
        }
        
        $this->load->helper(['clean','seo_slug']);
        $this->load->model('Article_model','am');
        $this->load->library(['form_validation','datatables']);        
    }

	public function index()
	{
        $data['pages']	= strtoupper(clean2($this->uri->segment(2)));
		$this->load->view('back/article/article',$data);
    }
    
    public function json()
	{
        header('Content-Type: application/json');
        echo $this->am->json();
    }

    public function add_article()
    {
        $data['title'] = array(
			'placeholder'	=> 'Title',
			'name'  		=> 'title',
			'id'    		=> 'title',
			'class' 		=> 'form-control',
			'value' 		=> $this->form_validation->set_value('title'),
        );
        
		$data['id_cat'] = array(
			'name'  	=> 'id_cat',
			'id'    	=> 'id_cat',
            'class' 	=> 'form-control',
            'onChange'  => 'viewSubcat()',
        );

        $data['id_subcat'] = array(
			'name'  	=> 'id_subcat',
			'id'    	=> 'id_subcat',
            'class' 	=> 'form-control',
        );

        $data['description'] = array(
			'placeholder'	=> 'Description',
			'name'  		=> 'description',
			'id'    		=> 'description',
			'class' 		=> 'form-control',
			'value' 		=> $this->form_validation->set_value('description'),
        );
        
        $data['category'] 	    = 	$this->am->category();
		$data['button']		    = 	'Submit';
		$data['action']		    = 	site_url('dashboard/article/add_action');
        $data['pages']	        =   strtoupper(clean2($this->uri->segment(2)));
        $data['sub']	        =   strtoupper(clean2($this->uri->segment(3)));
        
        $this->load->view('back/article/add_article',$data);
    }

    public function add_action()
    {
        $this->load->helper('clean');
        $this->_rules();
        if ($this->form_validation->run() == FALSE)
        {
            $this->add_article();
        }
        else
        {
            if ($_FILES['photos']['error'] <> 4)
			{
				$nmfile = strtolower(url_title($this->input->post('title'))).date('His');
				$config['upload_path']      = './upload/article/';
				$config['allowed_types']    = 'jpg|jpeg|png';
				$config['max_size']         = '500';
				$config['width']          	= 300;
				$config['height']         	= 1200;
				$config['remove_spaces	']	= TRUE;
				$config['file_name']        = $nmfile;
				$this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('photos'))
				{
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('message', '<div class="callout callout-danger">'.$error['error'].'</div>');
					$this->add_article();
                }
                else
                {
                    $photos = $this->upload->data();
                    $data = array(
                        'photos'        => $nmfile.$photos['file_ext'],
                        'author'        => $this->session->userdata('user_id'),
                        'title'         => $this->input->post('title',TRUE),
                        'slug'          => strtolower(url_title($this->input->post('title',TRUE))),
                        'id_cat'        => $this->input->post('id_cat',TRUE),
                        'id_subcat'     => $this->input->post('id_subcat',TRUE),
                        'status'        => $this->input->post('status',TRUE),
                        'description'   => $this->input->post('description',TRUE),
                        'created_at'    => date('Y-m-d H:i:s'),
                    );
                    $this->am->insert($data);
                    $this->session->set_flashdata('message', '<div class="callout callout-success">Add article success!</div>');
                    redirect(site_url('dashboard/article'));
                }
            }
            else
            {
                $data = array(
                        'author'        => $this->session->userdata('user_id'),
                        'title'         => $this->input->post('title',TRUE),
                        'slug'          => strtolower(url_title($this->input->post('title',TRUE))),
                        'id_cat'        => $this->input->post('id_cat',TRUE),
                        'id_subcat'     => $this->input->post('id_subcat',TRUE),
                        'status'        => $this->input->post('status',TRUE),
                        'description'   => $this->input->post('description',TRUE),
                        'created_at'    => date('Y-m-d H:i:s'),
                );
                    $this->am->insert($data);
                    $this->session->set_flashdata('message', '<div class="callout callout-warning">Add article success! (Without images)</div>');
                    redirect(site_url('dashboard/article'));
            }
        }
    }

    public function update($id)
    {
        $row            = $this->am->get_by_id($id);
        if($row)
        {
            $data['id_article'] = array(
                'name'  		=> 'id_article',
                'id'    		=> 'id_article',
                'type' 			=> 'hidden',
                'value' 		=> $this->form_validation->set_value('name',$row->id_article),
            );
    
            $data['title'] = array(
                'name'  		=> 'title',
                'id'    		=> 'title',
                'class' 		=> 'form-control',
                'value' 		=> $this->form_validation->set_value('name',$row->title),
            );
            
            $data['id_cat'] = array(
                'name'  	    => 'id_cat',
                'id'    	    => 'id_cat',
                'class' 	    => 'form-control',
                'onChange'      => 'viewSubcat()',
            );

            $data['id_subcat'] = array(
                'name'  	    => 'id_subcat',
                'id'    	    => 'id_subcat',
                'class' 	    => 'form-control',
            );
            
            $data['description'] = array(
                'name'  		=> 'description',
                'id'    		=> 'description',
                'class' 		=> 'form-control',
                'value' 		=> $this->form_validation->set_value('description',$row->description),
            );
            
            $sub                    =   $row->id_cat;
            $data['article']        =   $this->am->get_by_id($id);
            $data['category'] 	    = 	$this->am->category();
            $data['subcategory'] 	= 	$this->am->subcategory($sub);
            $data['button']		    = 	'Update';
            $data['action']		    = 	site_url('dashboard/article/update_action');
            $data['pages']	        =   strtoupper(clean2($this->uri->segment(2)));
            $data['sub']	        =   strtoupper(clean2($this->uri->segment(3)));
            
            $this->load->view('back/article/edit_article',$data);
        }
        else
		{
            $this->session->set_flashdata('message', '<div class="callout callout-danger">Article not found!</div>');
            redirect(site_url('dashboard/article'));
        }
    }

    public function update_action()
    {
        $this->load->helper('clean');
        $this->_rules();
        if ($this->form_validation->run() == FALSE)
        {
            $this->update($this->input->post('id_article', TRUE));
        }
        else
        {
            if ($_FILES['photos']['error'] <> 4)
			{
                $delete = $this->am->delete_by_id($this->input->post('id_article'));
				$dir    = "./upload/article/".$delete->photos;
                unlink($dir);
                
				$nmfile = strtolower(url_title($this->input->post('title'))).date('His');
				$config['upload_path']      = './upload/article/';
				$config['allowed_types']    = 'jpg|jpeg|png';
				$config['max_size']         = '500';
				$config['width']          	= 300;
				$config['height']         	= 1200;
				$config['remove_spaces	']	= TRUE;
				$config['file_name']        = $nmfile;
				$this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('photos'))
				{
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('message', '<div class="callout callout-danger">'.$error['error'].'</div>');
					$this->update($this->input->post('id_article'));
                }
                else
                {
                    $photos = $this->upload->data();
                    $data = array(
                        'photos'        => $nmfile.$photos['file_ext'],
                        'author'        => $this->session->userdata('user_id'),
                        'title'         => $this->input->post('title',TRUE),
                        'slug'          => strtolower(url_title($this->input->post('title',TRUE))),
                        'id_cat'        => $this->input->post('id_cat',TRUE),
                        'id_subcat'     => $this->input->post('id_subcat',TRUE),
                        'status'        => $this->input->post('status',TRUE),
                        'description'   => $this->input->post('description',TRUE),
                        'updated_at'    => date('Y-m-d H:i:s'),
                    );
                    $this->am->update($this->input->post('id_article'), $data);
                    $this->session->set_flashdata('message', '<div class="callout callout-success">Update article success!</div>');
                    redirect(site_url('dashboard/article'));
                }
            }
            else
            {
                $data = array(
                    'author'        => $this->session->userdata('user_id'),
                    'title'         => $this->input->post('title',TRUE),
                    'slug'          => strtolower(url_title($this->input->post('title',TRUE))),
                    'id_cat'        => $this->input->post('id_cat',TRUE),
                    'id_subcat'     => $this->input->post('id_subcat',TRUE),
                    'status'        => $this->input->post('status',TRUE),
                    'description'   => $this->input->post('description',TRUE),
                    'updated_at'    => date('Y-m-d H:i:s'),
                );
                $this->am->update($this->input->post('id_article'), $data);
                $this->session->set_flashdata('message', '<div class="callout callout-warning">Update item success! (Whitout Images)</div>');
                redirect(site_url('dashboard/article'));
            }
        }
    }

    public function delete($id) 
    {
        $row = $this->am->get_by_id($id);
        $dir = "./upload/article/".$row->photos;
        unlink($dir);
        
        if ($row)
		{
            $this->am->delete($id);
			$this->session->set_flashdata('message', '<div class="callout callout-success">Delete article success!</div>');
			redirect(site_url('dashboard/article'));
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Delete article failed!</div>');
            redirect(site_url('dashboard/article'));
        }
    }
    
    public function get_subcategory()
    {
		$data['subcategory']    =   $this->am->subcategory($this->uri->segment(4));
		$this->load->view('back/article/subcategory',$data);
	}

    public function _rules() 
    {
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('id_cat', 'category', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('id_article', 'id_article', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}