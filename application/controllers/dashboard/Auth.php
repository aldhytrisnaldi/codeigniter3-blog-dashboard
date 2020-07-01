<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language','clean']);
		$this->load->model('Ion_auth_model','iam');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}
	
	function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('dashboard/auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin())
		{
			show_error('You must be an administrator to view this page.');
		}
		else
		{
			redirect('dashboard/home', 'refresh');
		}
	}

	public function users()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('dashboard/auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin())
		{
			show_error('You must be an administrator to view this page.');
		}
		else
		{
			$this->data['pages']    = strtoupper(clean2($this->uri->segment(2)));
			$this->data['sub']      = strtoupper(clean2($this->uri->segment(3)));
			$this->data['title'] 	= $this->lang->line('index_heading');
			$this->data['message'] 	= (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['users'] 	= $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			$this->_render_page('back/auth' . DIRECTORY_SEPARATOR . 'index', $this->data);
		}
	}

	public function login()
	{
		$this->data['title'] 			= $this->lang->line('login_heading');
		$this->data['captcha'] 			= $this->recaptcha->getWidget();
	 	$this->data['script_captcha'] 	= $this->recaptcha->getScriptTag();
	 	$recaptcha 						= $this->input->post('g-recaptcha-response');
		$response 						= $this->recaptcha->verifyResponse($recaptcha);
		   
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
		$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');

		if ($this->ion_auth->logged_in() || $this->ion_auth->is_admin())
		{
			redirect('dashboard/auth', 'refresh');
		}
		if ($this->form_validation->run() === TRUE || !isset($response['success']) || $response['success'] === TRUE)
		{
			$remember = (bool)$this->input->post('remember');
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('dashboard/home', 'refresh');
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('dashboard/auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['identity'] = [
				'name' 			=> 'identity',
				'id' 			=> 'identity',
				'type' 			=> 'text',
				'class'			=> 'form-control',
				'placeholder'	=> 'Email',
				'value' 		=> $this->form_validation->set_value('identity'),
			];
			$this->data['password'] = [
				'name'			=> 'password',
				'id' 			=> 'password',
				'type' 			=> 'password',
				'class'			=> 'form-control',
				'placeholder'	=> 'Password',
			];
			$this->data['pages']    = strtoupper(clean2($this->uri->segment(2)));
			$this->data['sub']      = strtoupper(clean2($this->uri->segment(3)));
			$this->_render_page('back/auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
		}
	}

	public function logout()
	{
		$this->ion_auth->logout();
		redirect('dashboard/auth/login', 'refresh');
	}

	public function activate($id, $code = FALSE)
	{
		$activation = FALSE;
		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}
		if ($activation)
		{
			$this->session->set_flashdata('message', '<div class="callout callout-success">'.$this->ion_auth->messages().'</div>');
			redirect("dashboard/auth/users", 'refresh');
		}
		else
		{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("dashboard/auth/users", 'refresh');
		}
	}

	public function deactivate($id, $code = FALSE)
	{
		$deactivation = FALSE;
		if ($code !== FALSE)
		{
			$deactivation = $this->ion_auth->deactivate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$deactivation = $this->ion_auth->deactivate($id);
		}
		if ($deactivation)
		{
			$this->session->set_flashdata('message', '<div class="callout callout-success">'.$this->ion_auth->messages().'</div>');
			redirect("dashboard/auth/users", 'refresh');
		}
		else
		{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("dashboard/auth/users", 'refresh');
		}
	}

	public function create_user()
	{
		$this->data['title'] = $this->lang->line('create_user_heading');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('dashboard/auth', 'refresh');
		}
		$tables 			= $this->config->item('tables', 'ion_auth');
		$identity_column 	= $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
		if ($identity_column !== 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		if ($this->form_validation->run() === TRUE)
		{
			$email 		= strtolower($this->input->post('email'));
			$identity 	= ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password 	= $this->input->post('password');
			$additional_data = [
				'first_name'	=> $this->input->post('first_name'),
				'last_name' 	=> $this->input->post('last_name'),
				'phone' 		=> $this->input->post('phone'),
			];
		}
		if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data))
		{
			$this->session->set_flashdata('message', '<div class="callout callout-success">'.$this->ion_auth->messages().'</div>');
			redirect("dashboard/auth/users", 'refresh');
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['first_name'] = [
				'placeholder'	=> 'First Name',
				'name' 			=> 'first_name',
				'id' 			=> 'first_name',
				'type' 			=> 'text',
				'class'			=> 'form-control',
				'value' 		=> $this->form_validation->set_value('first_name'),
			];
			$this->data['last_name'] = [
				'placeholder'	=> 'Last Name',
				'name' 			=> 'last_name',
				'id' 			=> 'last_name',
				'type' 			=> 'text',
				'class'			=> 'form-control',
				'value' 		=> $this->form_validation->set_value('last_name'),
			];
			$this->data['identity'] = [
				'name' 		=> 'identity',
				'id' 		=> 'identity',
				'type' 		=> 'text',
				'class'		=> 'form-control',
				'value' 	=> $this->form_validation->set_value('identity'),
			];
			$this->data['email'] = [
				'placeholder'	=> 'Email',
				'name' 			=> 'email',
				'id' 			=> 'email',
				'type' 			=> 'text',
				'class'			=> 'form-control',
				'value' 		=> $this->form_validation->set_value('email'),
			];
			$this->data['phone'] = [
				'placeholder'	=> 'Phone',
				'name' 			=> 'phone',
				'id' 			=> 'phone',
				'type' 			=> 'text',
				'class'			=> 'form-control',
				'value' 		=> $this->form_validation->set_value('phone'),
			];
			$this->data['password'] = [
				'placeholder'	=> 'Password',
				'name' 			=> 'password',
				'id' 			=> 'password',
				'type' 			=> 'password',
				'class'			=> 'form-control',
				'value' 		=> $this->form_validation->set_value('password'),
			];
			$this->data['password_confirm'] = [
				'placeholder'	=> 'Confirm Password',
				'name' 			=> 'password_confirm',
				'id' 			=> 'password_confirm',
				'type' 			=> 'password',
				'class'			=> 'form-control',
				'value' 		=> $this->form_validation->set_value('password_confirm'),
			];
			$this->data['pages']    = strtoupper(clean2($this->uri->segment(2)));
			$this->data['sub']      = strtoupper(clean2($this->uri->segment(3)));
			$this->_render_page('back/auth' . DIRECTORY_SEPARATOR . 'create_user', $this->data);
		}
	}

	public function update_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('dashboard/auth', 'refresh');
		}
		$user 			= $this->ion_auth->user($id)->row();
		$groups 		= $this->ion_auth->groups()->result_array();
		$currentGroups 	= $this->ion_auth->get_users_groups($id)->result();
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim');
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			if ($this->form_validation->run() === TRUE)
			{
				if ($_FILES['photos']['error'] <> 4)
				{								
					$nmfile = strtolower(url_title($this->input->post('first_name'))).strtolower('avatar');
					$config['upload_path']      = './upload/users/';
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
						redirect('dashboard/auth/update_user/'.$id);
					}
					else
					{
						$photos = $this->upload->data();
						$data = [
							'photos'        => $nmfile.$photos['file_ext'],
							'first_name' 	=> $this->input->post('first_name'),
							'last_name' 	=> $this->input->post('last_name'),
							'phone' 		=> $this->input->post('phone'),
						];
						if ($this->input->post('password'))
						{
							$data['password'] = $this->input->post('password');
						}
						if ($this->ion_auth->is_admin())
						{
							$this->ion_auth->remove_from_group('', $id);
							$groupData = $this->input->post('groups');
							if (isset($groupData) && !empty($groupData))
							{
								foreach ($groupData as $grp)
								{
									$this->ion_auth->add_to_group($grp, $id);
								}
							}
						}
						if ($this->ion_auth->update($user->id, $data))
						{
							$this->session->set_flashdata('message', '<div class="callout callout-success">'.$this->ion_auth->messages().'</div>');
							$this->redirectUser();
						}
						else
						{
							$this->session->set_flashdata('message', '<div class="callout callout-danger">'. $this->ion_auth->errors().'</div>');
							$this->redirectUser();
						}
					}
				}
				else
				{
					$data = [
						'first_name' 	=> $this->input->post('first_name'),
						'last_name' 	=> $this->input->post('last_name'),
						'phone' 		=> $this->input->post('phone'),
					];
					if ($this->input->post('password'))
					{
						$data['password'] = $this->input->post('password');
					}
					if ($this->ion_auth->is_admin())
					{
						$this->ion_auth->remove_from_group('', $id);
						$groupData = $this->input->post('groups');
						if (isset($groupData) && !empty($groupData))
						{
							foreach ($groupData as $grp)
							{
								$this->ion_auth->add_to_group($grp, $id);
							}
						}
					}
					if ($this->ion_auth->update($user->id, $data))
					{
						$this->session->set_flashdata('message', '<div class="callout callout-success">'.$this->ion_auth->messages().'</div>');
						$this->redirectUser();
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="callout callout-danger">'. $this->ion_auth->errors().'</div>');
						$this->redirectUser();
					}	
				}
			}
		}
		$this->data['csrf'] 			= $this->_get_csrf_nonce();
		$this->data['message'] 			= (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['user'] 			= $user;
		$this->data['groups'] 			= $groups;
		$this->data['currentGroups'] 	= $currentGroups;

		$this->data['photos'] = [
			'name'  	=> 'photos',
			'id'    	=> 'photos',
			'type'  	=> 'file',
			'class'		=> 'custom-file-input',
			'value' 	=> $this->form_validation->set_value('photos', $user->photos),
		];
		$this->data['first_name'] = [
			'name'  	=> 'first_name',
			'id'    	=> 'first_name',
			'type'  	=> 'text',
			'class'		=> 'form-control',
			'value' 	=> $this->form_validation->set_value('first_name', $user->first_name),
		];
		$this->data['last_name'] = [
			'name'  	=> 'last_name',
			'id'    	=> 'last_name',
			'type'  	=> 'text',
			'class'		=> 'form-control',
			'value' 	=> $this->form_validation->set_value('last_name', $user->last_name),
		];
		$this->data['email'] = [
			'name'  	=> 'email',
			'id'    	=> 'email',
			'type'  	=> 'email',
			'class'		=> 'form-control',
			'disabled'	=> 'disabled',
			'value' 	=> $this->form_validation->set_value('email', $user->email),
		];
		$this->data['phone'] = [
			'name'  	=> 'phone',
			'id'    	=> 'phone',
			'type'  	=> 'text',
			'class'		=> 'form-control',
			'value' 	=> $this->form_validation->set_value('phone', $user->phone),
		];
		$this->data['password'] = [
			'name' 		=> 'password',
			'id'   		=> 'password',
			'type' 		=> 'password',
			'class'		=> 'form-control',
		];
		$this->data['password_confirm'] = [
			'name' 		=> 'password_confirm',
			'id'   		=> 'password_confirm',
			'type' 		=> 'password',
			'class'		=> 'form-control',
		];
		$this->data['pages']    = strtoupper(clean2($this->uri->segment(2)));
		$this->data['sub']      = strtoupper(clean2($this->uri->segment(3)));
		$this->_render_page('back/auth/edit_user', $this->data);
	}

	public function delete_user($id)
	{
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin())
		{
			show_error('You must be an administrator to view this page.');
		}	
		else
		{
			$delete = $this->iam->delete_by_id($id);
			$dir    = "./upload/users/".$delete->photos;
			unlink($dir);

			$this->iam->delete_user($id);
			$this->session->set_flashdata('message', '<div class="callout callout-success">Delete user success!</div>');
			redirect(site_url('dashboard/auth/users'));
		}   
	}

	public function forgot_password()
	{
		$this->data['title'] = $this->lang->line('forgot_password_heading');
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			$this->data['identity'] = [
				'name' 			=> 'identity',
				'id' 			=> 'identity',
				'class'			=> 'form-control',
				'placeholder'	=> 'Email',
			];
			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}
			$this->data['pages']    = strtoupper(clean2($this->uri->segment(2)));
			$this->data['sub']      = strtoupper(clean2($this->uri->segment(3)));
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('back/auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();
			if (empty($identity))
			{
				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("dashboard/auth/forgot_password", 'refresh');
			}
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
			if ($forgotten)
			{
				$this->session->set_flashdata('message', '<div class="callout callout-success">'.$this->ion_auth->messages().'</div>');
				redirect("dashboard/auth/login", 'refresh');
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="callout callout-danger">'.$this->ion_auth->errors().'</div>');
				redirect("dashboard/auth/forgot_password", 'refresh');
			}
		}
	}

	public function redirectUser()
	{
		if ($this->ion_auth->is_admin()){
			redirect('dashboard/auth/users', 'refresh');
		}
		redirect('dashboard/auth/home', 'refresh');
	}

	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return [$key => $value];
	}

	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
			return FALSE;
	}

	public function _render_page($view, $data = NULL, $returnhtml = FALSE)
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}
}