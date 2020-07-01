<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}

		$this->load->helper(['clean','seo_slug']);
		$this->load->library(['form_validation','datatables']);
		$this->load->model('Subcategory_model','sm');
	}

	public function index()
	{
		$data['pages']		= strtoupper($this->uri->segment(2));
		$this->load->view('back/subcategory/subcategory',$data);
	}
	
	public function json()
	{
        header('Content-Type: application/json');
        echo $this->sm->json();
    }
    
    public function add_subcategory()
	{

		$data['subcategory'] = array(
			'placeholder'	=> 'Subcategory',
			'name'  		=> 'subcategory',
			'id'    		=> 'subcategory',
			'class' 		=> 'form-control',
			'value' 		=> $this->form_validation->set_value('subcategory'),
		);
		
		$data['id_parent'] = array(
			'name'  	=> 'id_parent',
			'id'    	=> 'id_parent',
			'class' 	=> 'form-control',
		);
		
		$data['category'] 	= $this->sm->category();
		$data['button']		= 'Submit';
		$data['action']		= site_url('dashboard/subcategory/add_action');
        $data['pages']		= strtoupper($this->uri->segment(2));
        $data['sub']		= strtoupper(clean2($this->uri->segment(3)));
		$this->load->view('back/subcategory/add_subcategory',$data);
	}

	public function add_action()
	{
		$this->_rules();
		if($this->form_validation->run() == FALSE)
		{
            $this->add_subcategory();
		}
		else
		{
            $data = array(
				'subcategory' 		=> $this->input->post('subcategory',TRUE),
				'id_parent' 		=> $this->input->post('id_parent',TRUE),
				'subcategory_slug' 	=> seo_slug($this->input->post('subcategory',TRUE)),
			);
			
            $this->sm->insert($data);
			$this->session->set_flashdata('message', '<div class="callout callout-success">Add subcategory success!</div>');
            redirect(site_url('dashboard/subcategory'));
        }
	}
	
	public function update($id) 
    {
		$row 				= $this->sm->get_by_id($id);
		$data['subcat'] 	= $this->sm->get_by_id($id);
		if($row)
		{
            $data['subcategory'] = array(
				'name'  		=> 'subcategory',
				'id'   			=> 'subcategory',
				'type'  		=> 'text',
				'class' 		=> 'form-control',
			);
			
			$data['id_parent'] = array(
				'name'  		=> 'id_parent',
				'id'   			=> 'id_parent',
				'type'  		=> 'text',
				'class' 		=> 'form-control',
			);

			$data['id_subcategory'] = array(
				'name'  		=> 'id_subcategory',
				'id'   			=> 'id_subcategory',
				'type'  		=> 'hidden',
			);
			
			$data['category'] 	= $this->sm->category();
			$data['pages']		= strtoupper(clean2($this->uri->segment(2)));
			$data['sub']		= strtoupper(clean2($this->uri->segment(3)));
			$data['button']		= 'Update';
			$data['action']		= site_url('dashboard/subcategory/update_action');
            $this->load->view('back/subcategory/edit_subcategory', $data);
		}
		else
		{
            $this->session->set_flashdata('message', '<div class="callout callout-danger">Subcategory not found!</div>');
            redirect(site_url('dashboard/subcategory'));
        }
	}

	public function update_action()
	{
		$this->_rules();
		if($this->form_validation->run() == FALSE)
		{
            $this->update($this->input->post('id_subcategory', TRUE));
		}
		else
		{
            $data = array(
				'subcategory' 		=> $this->input->post('subcategory',TRUE),
				'id_parent' 		=> $this->input->post('id_parent',TRUE),
				'subcategory_slug' 	=> seo_slug($this->input->post('subcategory',TRUE)),
			);
			
            $this->sm->update($this->input->post('id_subcategory', TRUE), $data);
			$this->session->set_flashdata('message', '<div class="callout callout-success">Update subcategory success!</div>');
            redirect(site_url('dashboard/subcategory'));
        }
	}

	public function delete($id) 
    {
        $row = $this->sm->get_by_id($id);
		if ($row)
		{
            $this->sm->delete($id);
            $this->session->set_flashdata('message', '<div class="callout callout-success">Delete subcategory success!</div>');
            redirect(site_url('dashboard/subcategory'));
		}
		else
		{
            $this->session->set_flashdata('message', '<div class="callout callout-danger">Delete subcategory failed!</div>');
            redirect(site_url('dashboard/subcategory'));
        }
	}
	
	public function _rules() 
    {
		$this->form_validation->set_rules('subcategory', 'subcategory', 'trim|required');
		$this->form_validation->set_rules('id_parent', 'category', 'trim|required');
		$this->form_validation->set_rules('id_subcategory', 'id_subcategory', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}