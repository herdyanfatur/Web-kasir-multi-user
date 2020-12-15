<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
	{

		public function __construct()
		{
			parent::__construct();
		// 		if($this->session->userdata('masuk') !=TRUE){

		// 	$users_id = $this->db->get_where('users',['id'])->row_array();
		// $this->session->set_userdata($users_id);
  //           $url=base_url();
  //           redirect($url);
  //       };

			if(!$_SESSION['role_id']){
				redirect('/');
			}
			$this->load->model('m_users');
			$this->load->model('m_karyawan');
		}

		public function index()
		{
			
			$data['title'] = 'Dashboard';

			if($_SESSION['role_id'] == 1){
				$data['users'] = $this->db->get_where('users', ['id' => $_SESSION['user_id']])->row_array();
			}elseif($_SESSION['role_id'] == 3) {
				$data['users'] = $this->db->get_where('users', ['id' => $_SESSION['user_id']])->row_array();
				
			}else{
				$data['karyawan'] = $this->db->get_where('karyawan', ['id_kar' => $_SESSION['karyawan_id']])->row_array();
			}

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/index', $data);
			$this->load->view('templates/dashboard_footer');

   	 }

    	public function profile()
    	{
    		
    		$data['title'] = 'My Profile';
    		if($_SESSION['role_id'] == 1){
				$data['users'] = $this->db->get_where('users', ['id' => $_SESSION['user_id']])->row_array();
				$data['data']=$this->m_users->tampil_data_users();
				$this->load->view('templates/dashboard_header', $data);
				$this->load->view('templates/dashboard_sidebar', $data);
				$this->load->view('templates/dashboard_topbar', $data);
				$this->load->view('admin/v_profile_users', $data);
				$this->load->view('templates/dashboard_footer');
			}elseif($_SESSION['role_id'] == 3) {
				$data['users'] = $this->db->get_where('users', ['id' => $_SESSION['user_id']])->row_array();
				$data['data']=$this->m_users->tampil_data_users();
				$this->load->view('templates/dashboard_header', $data);
				$this->load->view('templates/dashboard_sidebar', $data);
				$this->load->view('templates/dashboard_topbar', $data);
				$this->load->view('admin/v_profile_admin', $data);
				$this->load->view('templates/dashboard_footer');
				
			}else{
				$data['karyawan'] = $this->db->get_where('karyawan', ['id_kar' => $_SESSION['karyawan_id']])->row_array();
				$data['data']=$this->m_karyawan->tampil_data_kar();
				$this->load->view('templates/dashboard_header', $data);
				$this->load->view('templates/dashboard_sidebar', $data);
				$this->load->view('templates/dashboard_topbar', $data);
				$this->load->view('karyawan/index', $data);
				$this->load->view('templates/dashboard_footer');
			}
			

    	}
    	public function editProfileAdmin(){
    	if($_SESSION['role_id'] != 3){
			
			redirect('auth/blocked');
		}else{
    		$data['title'] = 'Edit Profile';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();
			$data['data']=$this->m_users->tampil_data_users();

			$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', ['is_unique' => 'Email sudah terdaftar!']);

			if ($this->form_validation->run() == false) {

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/v_edit_Admin', $data);
			$this->load->view('templates/dashboard_footer');
			}else{
				$nama = htmlspecialchars($this->input->post('name', true));
				$email = htmlspecialchars($this->input->post('email', true));

				// cek jika ada gambar yang akan di upload
				$upload_image = $_FILES['image']['name'];

				if ($upload_image) {
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']     = '2048';
					$config['upload_path']  = './assets/img/profile/';
					$new_file_name = $_SESSION['users_id'].'__'.$upload_image;
					$config['file_name'] = $new_file_name;

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('image'))  {

						$old_image = $data['users']['image'];
						if ($old_image != 'defaultimage.jpg') {
							unlink(FCPATH . './assets/img/profile/' . $old_image);
						}

						$new_image = $this->upload->data('file_name');
						$this->db->set('image', $new_image);

					} else {
						echo $this->upload->display_errors();
					}
				}

				$this->m_users->update_users($nama,$email, $new_image);
						

				$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Profile berhasil diubah</div>');
						redirect('Dashboard/editProfileAdmin');
			}
		}
		}

		function editPasswordAdmin(){
		if($_SESSION['role_id'] != 3){
			
			redirect('auth/blocked');
		}else{
			$data['title'] = 'Edit Password';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();
			$data['data']=$this->m_users->tampil_data_users();

			$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
			$this->form_validation->set_rules('new_password1', 'New Pasword', 'required|trim|min_length[6]|matches[new_password2]', [
								'matches' => 'Password tidak sesuai',
								'min_length' => 'Password minimal 6 karakter'
							]);
			$this->form_validation->set_rules('new_password2', 'New Pasword', 'required|trim|matches[new_password1]');

			if ($this->form_validation->run() == false) {

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/v_edit_password_admin', $data);
			$this->load->view('templates/dashboard_footer');
			}else{
				$current_password = $this->input->post('current_password');
				$new_password 	  = $this->input->post('new_password1');
				$email 			  = $this->input->post('email');
				$data['users'] = $this->db->get_where('users', ['email' => $email])->row_array();
				

				if (!password_verify($current_password, $data['users']['password']))  {
							$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password yang anda masukkan salah</div>');
								redirect('Dashboard/EditPasswordAdmin');
						} else {
							if ($current_password == $new_password) {
								$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password sama dengan yang lama !!</div>');
								redirect('Dashboard/EditPasswordAdmin');
							} else{
								// password baru yang sudah ok
								$password = password_hash($new_password, PASSWORD_DEFAULT);

								$this->m_users->update_password($email,$password);
								$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Password berhasil diubah !!</div>');
								redirect('Dashboard/EditPasswordAdmin');
							}
						}

			}
		}

		}

    	public function editProfileUser(){
    		$data['title'] = 'Edit Profile';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();
			$data['data']=$this->m_users->tampil_data_users();

			$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', ['is_unique' => 'Email sudah terdaftar!']);

			if ($this->form_validation->run() == false) {

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/v_edit_users', $data);
			$this->load->view('templates/dashboard_footer');
			}else{
				$nama = htmlspecialchars($this->input->post('name', true));
				$email = htmlspecialchars($this->input->post('email', true));

				// cek jika ada gambar yang akan di upload
				$upload_image = $_FILES['image']['name'];

				if ($upload_image) {
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']     = '2048';
					$config['upload_path']  = './assets/img/profile/';
					$new_file_name = $_SESSION['users_id'].'__'.$upload_image;
					$config['file_name'] = $new_file_name;

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('image'))  {

						$old_image = $data['users']['image'];
						if ($old_image != 'defaultimage.jpg') {
							unlink(FCPATH . './assets/img/profile/' . $old_image);
						}

						$new_image = $this->upload->data('file_name');
						$this->db->set('image', $new_image);

					} else {
						echo $this->upload->display_errors();
					}
				}

				$this->m_users->update_users($nama,$email, $new_image);
						

				$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Profile berhasil diubah</div>');
						redirect('Dashboard/editProfileUser');
			}
		}

		function editPasswordUser(){
			$data['title'] = 'Edit Password';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();
			$data['data']=$this->m_users->tampil_data_users();

			$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
			$this->form_validation->set_rules('new_password1', 'New Pasword', 'required|trim|min_length[6]|matches[new_password2]', [
								'matches' => 'Password tidak sesuai',
								'min_length' => 'Password minimal 6 karakter'
							]);
			$this->form_validation->set_rules('new_password2', 'New Pasword', 'required|trim|matches[new_password1]');

			if ($this->form_validation->run() == false) {

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/v_edit_password_users', $data);
			$this->load->view('templates/dashboard_footer');
			}else{
				$current_password = $this->input->post('current_password');
				$new_password 	  = $this->input->post('new_password1');
				$email 			  = $this->input->post('email');
				$data['users'] = $this->db->get_where('users', ['email' => $email])->row_array();
				

				if (!password_verify($current_password, $data['users']['password']))  {
							$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password yang anda masukkan salah</div>');
								redirect('Dashboard/EditPasswordUser');
						} else {
							if ($current_password == $new_password) {
								$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password sama dengan yang lama !!</div>');
								redirect('Dashboard/EditPasswordUser');
							} else{
								// password baru yang sudah ok
								$password = password_hash($new_password, PASSWORD_DEFAULT);

								$this->m_users->update_password($email,$password);
								$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Password berhasil diubah !!</div>');
								redirect('Dashboard/EditPasswordUser');
							}
						}

			}

		}

		public function editProfileKaryawan(){
    		$data['title'] = 'Edit Profile';
			$data['karyawan'] = $this->db->get_where('karyawan',['email_kar' =>
			$this->session->userdata('email_kar')])->row_array();
			$data['data']=$this->m_karyawan->tampil_data_kar();
			

			$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[karyawan.email_kar]', ['is_unique' => 'Gagal update profile, Email sudah terdaftar!!']);

			if ($this->form_validation->run() == false) {

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('karyawan/v_edit_profile', $data);
			$this->load->view('templates/dashboard_footer');
			}else{
				$nama = htmlspecialchars($this->input->post('name', true));
				$email = htmlspecialchars($this->input->post('email', true));


				// cek jika ada gambar yang akan di upload
				$upload_image = $_FILES['image']['name'];

				if ($upload_image) {
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']     = '2048';
					$config['upload_path']  = './assets/img/profile/';
					$new_file_name = $_SESSION['users_id'].'__'.$upload_image;
					$config['file_name'] = $new_file_name;

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('image'))  {

						$old_image = $data['karyawan']['image_kar'];
						if ($old_image != 'defaultimage.jpg') {
							unlink(FCPATH . 'assets/img/profile/' . $old_image);
						}

						$new_image = $this->upload->data('file_name');
						$this->db->set('image', $new_image);

					} else {
						echo $this->upload->display_errors();
					}
				}

				$this->m_karyawan->update_karyawan($nama,$email, $new_image);
						

				$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Profile berhasil diubah</div>');
				redirect('Dashboard/EditProfileKaryawan');
			}
		}

		function editPasswordKaryawan(){
			$data['title'] = 'Edit Password';
			$data['karyawan'] = $this->db->get_where('karyawan',['email_kar' =>
			$this->session->userdata('email_kar')])->row_array();
			$data['data']=$this->m_karyawan->tampil_data_kar();

			$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
			$this->form_validation->set_rules('new_password1', 'New Pasword', 'required|trim|min_length[6]|matches[new_password2]', [
								'matches' => 'Password tidak sesuai',
								'min_length' => 'Password minimal 6 karakter'
							]);
			$this->form_validation->set_rules('new_password2', 'New Pasword', 'required|trim|matches[new_password1]');

			if ($this->form_validation->run() == false) {

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('karyawan/v_edit_password', $data);
			$this->load->view('templates/dashboard_footer');
			}else{
				$current_password = $this->input->post('current_password');
				$new_password 	  = $this->input->post('new_password1');
				$email 			  = $this->input->post('email');
				$data['karyawan'] = $this->db->get_where('karyawan', ['email_kar' => $email])->row_array();

				if (!password_verify($current_password, $data['karyawan']['password_kar']))  {
							$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password lama yang anda masukkan salah</div>');
								redirect('Dashboard/EditPasswordKaryawan');
						} else {
							if ($current_password == $new_password) {
								$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password sama dengan yang lama !!</div>');
								redirect('Dashboard/EditPasswordKaryawan');
							} else{
								// password baru yang sudah ok
								$password = password_hash($new_password, PASSWORD_DEFAULT);

								$this->m_karyawan->update_password($email,$password);

								$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Password berhasil diubah !!</div>');
								redirect('Dashboard/EditPasswordKaryawan');
							}
						}

			}

		}


    	
	}