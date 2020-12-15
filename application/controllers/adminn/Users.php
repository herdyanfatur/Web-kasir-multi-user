<?php
class Users extends CI_Controller{
	function __construct(){
		parent::__construct();
		 $this->load->library('form_validation');
		 if($_SESSION['role_id'] != 3){
			
			redirect('auth/blocked');
		}
        
		$this->load->model('m_users');
		
       
	}
	function index(){

		$data = [
			'title' => 'Data Users',
			'data' => $this->m_users->tampil_users()
			
		];

		$data['data']=$this->m_users->tampil_users();
		$this->load->view('templates/dashboard_header', $data);
		$this->load->view('templates/dashboard_sidebar', $data);
		$this->load->view('templates/dashboard_topbar', $data);
		$this->load->view('admin/v_users',$data);
		$this->load->view('templates/dashboard_footer');

	}


	function tambah_users(){

		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', ['is_unique' => 'Email sudah terdaftar!']);
		$this->form_validation->set_rules('password', 'Pasword', 'required|trim|min_length[6]|matches[password2]', [
								'matches' => 'Password tidak sesuai',
								'min_length' => 'Password minimal 6 karakter'
							]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');
			if( $this->form_validation->run() == false){
			$data['title'] = 'Tambah Users';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();


			
			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/v_tambah_users',$data);
			$this->load->view('templates/dashboard_footer');
			} else {
				$nama = htmlspecialchars($this->input->post('nama', true));
				$email = $this->input->post('email', true);
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				
				$role_id = 1;
				// cek jika ada gambar yang akan di upload
				$upload_image = $_FILES['image'];
				if ($upload_image) {
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']      = '2048';
					$config['upload_path']   = './assets/img/profile/';
					$new_file_name = $data['users']['id'].'__'.$upload_image;
					$config['file_name'] = $new_file_name;

					$this->load->library('upload', $config);
				
				if ($this->upload->do_upload('image'))  {


						$new_image = $this->upload->data('file_name');
						echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">users Berhasil ditambahkan</div>');
							$this->m_users->simpan_users($nama,$email,$password,$new_image,$role_id);
						redirect('adminn/users');
					} else {
						echo $this->upload->display_errors();
					}
					}

				

						
					}
	}
	// function edit_users(){
		


	// 	$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
	// 	// $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email_kar]', ['is_unique' => 'Email sudah terdaftar!']);
	// 	// $this->form_validation->set_rules('password', 'Pasword', 'required|trim|min_length[6]|matches[password2]', [
	// 	// 						'matches' => 'Password tidak sesuai',
	// 	// 						'min_length' => 'Password minimal 6 karakter'
	// 	// 					]);
	// 	// $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');


	// if ($this->form_validation->run() == true) {

		
	// 	$nama=$this->input->post('nama');
	// 	$email=$this->input->post('email');
	// 	$data['users'] = $this->db->get_where('users', ["email" => $email])->row_array();

	// 	$upload_image = $_FILES['image']['name'];
	// 			if ($upload_image) {
	// 				$config['allowed_types'] = 'gif|jpg|png';
	// 				$config['max_size']      = '2048';
	// 				$config['upload_path']   = './assets/img/profile/';
	// 				$new_file_name = $data['users']['id'].'__'.$upload_image;
	// 				$config['file_name'] = $new_file_name;

	// 				$this->load->library('upload', $config);
				
	// 				if ($this->upload->do_upload('image'))  {

	// 						$old_image = $data['users']['image'];
	// 						if ($old_image != 'defaultimage.jpg') {
	// 							unlink(FCPATH . 'assets/img/profile/' . $old_image);
	// 						}

	// 					$new_image = $this->upload->data('file_name');
	// 					$this->db->set('image', $new_image);
						
						


	// 				} else {
	// 					echo $this->upload->display_errors();
	// 				}


	// 			}
	// 					$this->m_users->update_users($nama,$email, $new_image);
	// 					echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">users Berhasil diupdate</div>');
	// 					redirect('adminn/users');
		
	// }	

	// }
	
	function hapus_users(){

		$kode=$this->input->post('kode');
		$this->m_users->hapus_users($kode);
		redirect('adminn/users');

	}
}