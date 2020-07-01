<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}

		$this->load->helper(['clean','seo_slug']);
		$this->load->library(['form_validation','datatables']);
		$this->load->model('Category_model','cm');        
	}

	public function index()
	{
		$data['pages']	= strtoupper(clean2($this->uri->segment(2)));
		$data['sub']	= strtoupper(clean2($this->uri->segment(3)));
		$this->load->view('back/category/category',$data);
	}

	public function json()
	{
        header('Content-Type: application/json');
        echo $this->cm->json();
    }

	public function add_category()
	{
		$data['category'] = array(
			'placeholder'	=> 'Category',
			'name'  		=> 'category',
			'id'    		=> 'category',
			'class' 		=> 'form-control',
			'value' 		=> $this->form_validation->set_value('category'),
		);
		
		$data['button']		= 'Submit';
		$data['action']		= site_url('dashboard/category/add_action');
		$data['pages']		= strtoupper(clean2($this->uri->segment(2)));
		$data['sub']		= strtoupper(clean2($this->uri->segment(3)));
		$this->load->view('back/category/add_category',$data);
	}

	public function add_action()
	{
		$this->_rules();
		if($this->form_validation->run() == FALSE)
		{
            $this->add_category();
		}
		else
		{
            $data = array(
				'category' 			=> $this->input->post('category',TRUE),
				'category_slug' 	=> seo_slug($this->input->post('category',TRUE)),
	    	);
            $this->cm->insert($data);
			$this->session->set_flashdata('message', '<div class="callout callout-success">Add category success!</div>');
            redirect(site_url('dashboard/category'));
        }
	}

	public function update($id) 
    {
		$row 			= $this->cm->get_by_id($id);
		$data['cat'] 	= $this->cm->get_by_id($id);
		if($row)
		{
            $data['category'] = array(
				'name'  		=> 'category',
				'id'   			=> 'category',
				'type'  		=> 'text',
				'class' 		=> 'form-control',
			);
			
			$data['id_category'] = array(
				'name'  		=> 'id_category',
				'id'   			=> 'id_category',
				'type'  		=> 'hidden',
			);
			
			$data['pages']		= strtoupper(clean2($this->uri->segment(2)));
			$data['sub']		= strtoupper(clean2($this->uri->segment(3)));
			$data['button']		= 'Update';
			$data['action']		= site_url('dashboard/category/update_action');
            $this->load->view('back/category/edit_category', $data);
		}
		else
		{
            $this->session->set_flashdata('message', '<div class="callout callout-danger">Category not found!</div>');
            redirect(site_url('dashboard/category'));
        }
	}
	
	public function update_action() 
    {
        $this->_rules();
		if($this->form_validation->run() == FALSE)
		{
            $this->update($this->input->post('id_category', TRUE));
		}
		else
		{
            $data = array(
				'category' 			=> $this->input->post('category',TRUE),
				'category_slug'		=> seo_slug($this->input->post('category',TRUE))
			);
            $this->cm->update($this->input->post('id_category', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="callout callout-success">Update category success!</div>');
			redirect(site_url('dashboard/category'));
        }
	}
	
	public function delete($id) 
    {
        $row = $this->cm->get_by_id($id);
		if ($row)
		{
            $this->cm->delete($id);
			$this->session->set_flashdata('message', '<div class="callout callout-success">Delete category success!</div>');
			redirect(site_url('dashboard/category'));
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Delete category failed!</div>');
            redirect(site_url('dashboard/category'));
        }
	}
	
	public function _rules() 
    {
        $this->form_validation->set_rules('category', 'category', 'trim|required');
        $this->form_validation->set_rules('id_category', 'id_category', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}