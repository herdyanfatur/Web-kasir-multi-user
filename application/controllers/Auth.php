<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
	{
	public function __construct()
	{
		parent::__construct();
			$this->load->library('form_validation');


			

	}
	public function index()
	{
		// if ($this->session->userdata('email')) {
		// 		redirect('user'); 
		// 	}

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if($this->form_validation->run() == false) {

		$data['title'] = 'Login Page';
		$this->load->view('templates/auth_header', $data);
		$this->load->view('auth/login');
		$this->load->view('templates/auth_footer');
	} else {
		// validasi sukses
		$this->_login();
	}

}

private function _login() {
	$email = $this->input->post('email');
	$password = $this->input->post('password');

	# check user and karyawan
	$users = $this->db->get_where('users',['email' => $email])->row_array();
	$karyawan  = $this->db->get_where('karyawan', [ 'email_kar' => $email ])->row_array();
	
	$data = [];

	if($users && password_verify(($password), $users['password'])){
		if ($users['is_active'] == 1) {
			$data = [
			'users_id' => $users['id'],
			'role_id' => $users['role_id'],
			'email' => $users['email'],
			'user_name' => $users['name'],
			'user_id' => $users['id'],
			'image' => $users['image'],
			'tgl' => $users['date_created']
		];
		} else {
			$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Email Belum di Aktivasi!!</div>');
			redirect('auth');
		}
		
	}elseif ($karyawan && password_verify(($password), $karyawan['password_kar'])) {
		if ($users['is_active'] == 1) {
		$data = [
			'users_id' => $karyawan['id_kar'],
			'role_id' => $karyawan['role_id'],
			'email' => $karyawan['email_kar'],
			'user_name' => $karyawan['name_kar'],
			'karyawan_id' => $karyawan['id_kar'],
			'image' => $karyawan['image_kar'],
			'tgl' => $karyawan['date_created'],
			'user_id' => $karyawan['karyawan_users_id']
		];
		} else {
			$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Email di NonAktifkan!!</div>');
			redirect('auth');
		}
	}else{
		$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Email atau Password salah!!</div>');
		redirect('auth');
	}

	# set session data
	$this->session->set_userdata($data);
	redirect('dashboard');
}
		// private function loginkaryawan() {
		// $email = $this->input->post('email_kar');
		// $password = $this->input->post('password_kar');

		// $karyawan = $this->db->get_where('karyawan',['email_kar' => $email])->row_array();
		

		// // validasi users
		// if ($karyawan) {
		// 	// jika user aktif
		// 	// if ($users['is_active'] == 1) {
		// 		//cek password
			
		// 		if (password_verify($password, $karyawan['password_kar'])) {
		// 			$data = [
		// 					'email_kar' => $karyawan['email_kar'],
		// 					'role_id' => $karyawan['role_id']

							

		// 			];
		// 			$this->session->set_userdata($data);
		// 			$this->session->set_userdata('masuk_karyawan',true);

		// 				$id_kar=$karyawan['id_kar'];
		// 	            $nama_kar=$karyawan['nama_kar'];
		// 	            $email_kar=$karyawan['email_kar'];

		// 	            $this->session->set_userdata('id_kar',$id_kar);
		// 	            $this->session->set_userdata('nama_kar',$nama_kar);

		// 			redirect('admin');
					

		// 			// if ($this->session->userdata('masuk_karyawan')) {
		// 			// 	#						$user_id=$users['id'];
		// 	  //           $name_kar=$karyawan['name_kar'];
		// 	  //            $email_kar=$karyawan['email_kar'];

		// 	  //           $this->session->set_userdata('id_kar',$kar_id);
		// 	  //           $this->session->set_userdata('nama_kar',$name_kar);
		// 	  //           $this->session->set_userdata('users_kar_id',$name_kar);
		// 	  //           	redirect('admin');
		// 			// }
		// 		}else {
		// 		$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Email belum melakukan aktivasi!!</div>');
		// 				redirect('auth/karyawan');

		// 				}

		// 	}else {
		// 	$this->session->set_flashdata('aaa', '<div class="alert alert-danger" role="alert">Email belum terdaftar!!</div>');
		// 				redirect('auth/karyawan');
		// 	}
		// }
			

	public function registration()
		{
			if ($this->session->userdata('email')) {
				// redirect('auth'); 
			}
			
			$this->form_validation->set_rules('name', 'Name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', ['is_unique' => 'Email sudah terdaftar!']);
			$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
								'matches' => 'Password tidak sesuai',
								'min_length' => 'Password minimal 6 karakter'
							]);
			$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');



			if( $this->form_validation->run() == false){
				$data['title'] = 'User Registration';
				$this->load->view('templates/auth_header', $data);
				$this->load->view('auth/registration');
				$this->load->view('templates/auth_footer');
			} else {
				$email = $this->input->post('email', true);
				$data  = [
							'name' => htmlspecialchars($this->input->post('name', true)),
							'email' => htmlspecialchars($email),
							'image' => 'defaultimage.jpg',
							'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
							'role_id' => 1,
							'is_active' => 0
							
						];

				// siapkan token
				$token = base64_encode(random_bytes(32));
				$user_token = [
								'email'        => $email,
								'token' 	   => $token
								
								];

				$this->db->insert('users', $data);
				$this->db->insert('user_token', $user_token);

				$this->_sendEmail($token, 'verify');

				$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">
 									 Selamat, Anda Sudah Terdaftar! Silahkan Aktivasi akun anda !
 									 !</div>');
							redirect('auth');

			}

		}

		private function _sendEmail($token, $type){

			$config = [
						 'protocol'  => 'smtp',
						 'smtp_host' => 'ssl://smtp.googlemail.com',
						 'smtp_user' => 'herdyan256@gmail.com',
						 'smtp_pass' => 'hantumacal552',
						 'smtp_port' => 465,
						 'mailtype' => 'html',
						 'charset' => 'utf-8',
						 'starttls'  => true,
						 'newline' => "\r\n"
						];
						$this->load->library('email', $config);

						$this->email->from('herdyan256@gmail.com', 'Mata Usaha');
						$this->email->to($this->input->post('email'));

						if ($type == 'verify') {
							
							$this->email->subject('Aktivasi Akun');
							$this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi</a>');
						}elseif($type == 'forgot'){
							$this->email->subject('Reset Password');
							$this->email->message('Click this link to Reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
						}elseif($type == 'forgot_kar'){
							$this->email->subject('Reset Password');
							$this->email->message('Click this link to Reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
						}


						if($this->email->send()) {
							return true;
						}else{
							echo $this->email->print_debugger();
							die;
						}


		}

		public function verify() {

			$email = $this->input->get('email');
			$token = $this->input->get('token');

			$user = $this->db->get_where('users', ['email' => $email])->row_array();

			if ($user) {
				$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

				if ($user_token) {
					
						$this->db->set('is_active', 1);
						$this->db->where('email',  $email);
						$this->db->update('users');


						$this->db->delete('user_token', ['email', $email]);

						$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">
 									 Aktivasi  Berhasil! Silahkan Login!
 									 !</div>');
					redirect('auth');
					
				}else{
					$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
 									 Aktivasi invalid!!
 									 !</div>');
					redirect('auth');
				}
			}else{
			$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
 									 Aktivasi Gagal! Email Salah!
 									 !</div>');
			redirect('auth');

			}
		}



		public function logout()
		{
			// $this->session->unset_userdata('email');
			// $this->session->unset_userdata('role_id');
			$this->session->sess_destroy();

			$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">
 									 Anda berhasil Logout!
 									 !</div>');
			redirect('auth');

		}

		public function blocked()
		{
			$this->load->view('auth/blocked');
		}

		public function forgotPassword() {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

			if ($this->form_validation->run() ==  false) {
				
				$data['title'] = 'Lupa Password';
				$this->load->view('templates/auth_header', $data);
				$this->load->view('auth/forgot-password');
				$this->load->view('templates/auth_footer');
			} else {


				# check user and karyawan
				$email = $this->input->post('email');
				$users  = $this->db->get_where('users', ['email' => $email, 'role_id' => 1])->row_array();
				$karyawan  = $this->db->get_where('karyawan', [ 'email_kar' => $email, 'role_id' => 2 ])->row_array();
				

				if($users){

				$email = $this->input->post('email');
				$user  = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();
				
					if ($user) {
						$token = base64_encode(random_bytes(32));
						$user_token = [
									'email'        => $email,
									'token' 	   => $token
									
									];

						
						$this->db->insert('user_token', $user_token);

						$this->_sendEmail($token, 'forgot');
						$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">
	 									 Cek Email anda untuk reset password!
	 									 !</div>');
						redirect('auth/forgotpassword');
					}else{
						$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
	 									 Email Tidak Terdaftar atau Belum Aktivasi!
	 									 !</div>');
						redirect('auth/forgotpassword');
					}
				} elseif ($karyawan) {

					$email = $this->input->post('email');
					$karyawan1  = $this->db->get_where('karyawan', ['email_kar' => $email])->row_array();
				
					if ($karyawan1) {
						$token = base64_encode(random_bytes(32));
						$user_token = [
									'email'        => $email ,
									'token' 	   => $token
									
									];

						
						$this->db->insert('user_token', $user_token);

						$this->_sendEmail($token, 'forgot_kar');
						$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">
	 									 Cek Email anda untuk reset password!
	 									 !</div>');
						redirect('auth/forgotpassword');
					}else{
						$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
	 									 Email Tidak Terdaftar atau Belum Aktivasi!
	 									 !</div>');
						redirect('auth/forgotpassword');
					}
				}
			}
		}

		public function resetPassword(){
			$email = $this->input->get('email');
			$token = $this->input->get('token');



			# check user and karyawan
			$users  = $this->db->get_where('users', ['email' => $email, 'role_id' => 1])->row_array();
			$karyawan  = $this->db->get_where('karyawan', [ 'email_kar' => $email, 'role_id' => 2 ])->row_array();
				

			if($users){

			$user = $this->db->get_where('users', ['email' => $email])->row_array();

				if ($user) {
					$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

					if ($user_token) {
						$this->session->set_userdata('reset_email', $email);
						$this->changePassword();
						
					}else{
						$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
	 									 Reset Password tidak berlaku!!
	 									 !</div>');
						redirect('auth');
					}
				}else{
				$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
	 									 Reset Password Gagal! Email Salah!
	 									 !</div>');
				redirect('auth');

				}
			}elseif ($karyawan) {
				$karyawan = $this->db->get_where('karyawan', ['email_kar' => $email])->row_array();

				if ($user) {
					$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

					if ($user_token) {
						$this->session->set_userdata('reset_email', $email);
						$this->changePassword();
						
					}else{
						$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
	 									 Reset Password tidak berlaku!!
	 									 !</div>');
						redirect('auth');
					}
				}else{
				$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">
	 									 Reset Password Gagal! Email Salah!
	 									 !</div>');
				redirect('auth');

				}			
			}
		}

		public function changePassword(){
			if (!$this->session->userdata('reset_email')) {
				redirect('auth');
			}



			$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
								'matches' => 'Password tidak sesuaiii',
								'min_length' => 'Password minimal 6 karakter'
							]);
			$this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');


			if ($this->form_validation->run() == false) {
			$data['title'] = 'Lupa Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');
			} else {
				$email1 = $this->session->userdata('reset_email');
				$users  = $this->db->get_where('users', ['email' => $email1, 'role_id' => 1])->row_array();
				$karyawan  = $this->db->get_where('karyawan', [ 'email_kar' => $email1, 'role_id' => 2 ])->row_array();
				if ($users) {
					
					$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
					$email    = $this->session->userdata('reset_email');

					$this->db->set('password', $password);
					$this->db->where('email', $email);
					$this->db->update('users');

					$this->db->delete('user_token', ['email', $email]);
					
					$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">
	 									 Reset Password Berhasil ! Silahkan Login !.
	 									 !</div>');
					redirect('auth');
				} elseif ($karyawan) {
					
					$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
					$email    = $this->session->userdata('reset_email');

					$this->db->set('password_kar', $password);
					$this->db->where('email_kar', $email);
					$this->db->update('karyawan');

					$this->db->delete('user_token', ['email', $email]);
					
					$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">
	 									 Reset Password Berhasil ! Silahkan Login !.
	 									 !</div>');
					redirect('auth');
				}
					
			}

		}
	}

	