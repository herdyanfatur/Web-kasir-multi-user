<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
	{
		// public function __construct()
		// {
		// 	parent::__construct();
		// 	is_logged_in();

		// }

		public function index()
		{
			$data['title'] = 'My Profile';
			$data['karyawan'] = $this->db->get_where('karyawan',['email_kar' =>
			$this->session->userdata('email_kar')])->row_array();

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('user/index', $data);
			$this->load->view('templates/dashboard_footer');
		}

		public function edit()
		{
			$data['title'] = 'Edit Profile';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();

			$this->form_validation->set_rules('name', 'Full Name', 'required|trim');

			if ($this->form_validation->run() == false) {

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/dashboard_footer');
			}else{
				$name = $this->input->post('name');
				$email = $this->input->post('email');

				// cek jika ada gambar yang akan di upload
				$upload_image = $_FILES['image']['name'];

				if ($upload_image) {
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']     = '2048';
					$config['upload_path']  = './assets/img/profile/';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('image'))  {

						$old_image = $data['users']['image'];
						if ($old_image != 'default.jpg') {
							unlink(FCPATH . 'assets/img/profile/' . $old_image);
						}

						$new_image = $this->upload->data('file_name');
						$this->db->set('image', $new_image);

					} else {
						echo $this->upload->display_errors();
					}
				}

				$this->db->set('name', $name);
				$this->db->where('email', $email);
				$this->db->update('users');

				$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Profile berhasil diubah</div>');
						redirect('user');
			}
		}


		public function changePassword()
		{
			$data['title'] = 'Ubah Password';
			$data['users'] = $this->db->get_where('users', ['email' =>
			$this->session->userdata('email')])->row_array();

			$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');

			$this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]');
			$this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[6]|matches[new_password1]');
			// validasi error

			if ($this->form_validation->run() == false) {
				
				$this->load->view('templates/dashboard_header', $data);
				$this->load->view('templates/dashboard_sidebar', $data);
				$this->load->view('templates/dashboard_topbar', $data);
				$this->load->view('user/changepassword', $data);
				$this->load->view('templates/dashboard_footer');
			} else {
				$current_password = $this->input->post('current_password');
				$new_password 	  = $this->input->post('new_password1');

				if (!password_verify($current_password, $data['users']['password']))  {
							$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password yang anda masukkan salah</div>');
								redirect('user/changepassword');
						} else {
							if ($current_password == $new_password) {
								$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Password sama dengan yang lama !!</div>');
								redirect('user/changepassword');
							} else{
								// password baru yang sudah ok
								$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

								$this->db->set('password', $password_hash);
								$this->db->where('email', $this->session->userdata('email'));
								$this->db->update('users');

								$this->session->set_flashdata('aa', '<div class="alert alert-success" role="alert">Password berhasil diubah !!</div>');
								redirect('user/changepassword');
							}
						}
			}

			
		}
	}