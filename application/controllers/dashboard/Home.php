<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}

		$this->load->model('Home_model','hm');
		$this->load->library('datatables'); 
	}

	public function index()
	{
		$qadmin				= $this->hm->c_admin();
		$qmember			= $this->hm->c_member();
		$qactive			= $this->hm->c_active();
		$qdeactive			= $this->hm->c_deactive();

		$data['admin']		= $qadmin->num_rows();
		$data['member']		= $qmember->num_rows();
		$data['active']		= $qactive->num_rows();
		$data['deactive']	= $qdeactive->num_rows();
		$data['pages']		= strtoupper($this->uri->segment(2));
		$this->load->view('back/dashboard/home',$data);
	}
}