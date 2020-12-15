<?php
class Karyawan extends CI_Controller{
	function __construct(){
		parent::__construct();
		 $this->load->library('form_validation');
		 if($_SESSION['role_id'] != 1){
			
			redirect('auth/blocked');
		}
        
		$this->load->model('m_karyawan');
		
       
	}
	function index(){

		$data = [
			'title' => 'Data Karyawan',
			'data' => $this->m_karyawan->tampil_karyawan()
			
		];

		$data['data']=$this->m_karyawan->tampil_karyawan();
		$this->load->view('templates/dashboard_header', $data);
		$this->load->view('templates/dashboard_sidebar', $data);
		$this->load->view('templates/dashboard_topbar', $data);
		$this->load->view('admin/v_karyawan',$data);
		$this->load->view('templates/dashboard_footer');

	}



	function tambah_karyawan(){

		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[karyawan.email_kar]', ['is_unique' => 'Email sudah terdaftar!']);
		$this->form_validation->set_rules('password', 'Pasword', 'required|trim|min_length[6]|matches[password2]', [
								'matches' => 'Password tidak sesuai',
								'min_length' => 'Password minimal 6 karakter'
							]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');
			if( $this->form_validation->run() == false){
			$data['title'] = 'Tambah Karyawan';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();


			
			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/v_tambah_karyawan',$data);
			$this->load->view('templates/dashboard_footer');
			} else {
				$nama = htmlspecialchars($this->input->post('nama', true));
				$email = $this->input->post('email', true);
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				$is_active = $this->input->post('is_active');
				
				$role_id = 2;
				// cek jika ada gambar yang akan di upload
				$upload_image = $_FILES['image'];
				if ($upload_image) {
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']      = '2048';
					$config['upload_path']   = './assets/img/profile/';
					// $new_file_name = $data['karyawan']['id_kar'].'__'.$upload_image;
					// $config['file_name'] = $new_file_name;
					$config['encrypt_name']	 = TRUE;

					$this->load->library('upload', $config);
				
				if ($this->upload->do_upload('image'))  {


						$new_image = $this->upload->data('file_name');
						

					} else {
						echo $this->upload->display_errors();
					}
					}

				

						$this->m_karyawan->simpan_karyawan($nama,$email,$password,$new_image,$is_active,$role_id);
						redirect('adminn/karyawan');
					}
	
	}
	function edit_karyawan(){
		$users= $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();


		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		// $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[karyawan.email_kar]', ['is_unique' => 'Email sudah terdaftar!']);
		// $this->form_validation->set_rules('password', 'Pasword', 'required|trim|min_length[6]|matches[password2]', [
		// 						'matches' => 'Password tidak sesuai',
		// 						'min_length' => 'Password minimal 6 karakter'
		// 					]);
		// $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');


	if ($this->form_validation->run() == true) {

		
		$nama=$this->input->post('nama');
		$email=$this->input->post('email');
		$data['karyawan'] = $this->db->get_where('karyawan', ["email_kar" => $email])->row_array();

		$upload_image = $_FILES['image']['name'];
				if ($upload_image) {
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']      = '2048';
					$config['upload_path']   = './assets/img/profile/';
					// $config['encrypt_name'] = TRUE;
					$new_file_name = $data['karyawan']['id_kar'].'__'.$upload_image;
					$config['file_name'] = $new_file_name;

					$this->load->library('upload', $config);
				
					if ($this->upload->do_upload('image'))  {

							$old_image = $data['karyawan']['image_kar'];
							if ($old_image != 'defaultimage.jpg') {
								unlink(FCPATH . './assets/img/profile/' . $old_image);
							}

						$new_image = $this->upload->data('file_name');
						$this->db->set('image', $new_image);
						
						$this->m_karyawan->update_karyawan($nama,$email, $new_image);
						echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">karyawan Berhasil diupdate</div>');
						redirect('adminn/karyawan');


					} else {
						echo $this->upload->display_errors();
					}

				}

		
	}	

	}
	
	function hapus_karyawan(){
		$kode=$this->input->post('kode');
		$this->m_karyawan->hapus_karyawan($kode);
		redirect('adminn/karyawan');
	}
	function statuskaryawan(){
		
		$kode=$this->input->post('kode');
		$status=$this->input->post('is_active');
		$this->m_karyawan->update_status($kode,$status);
		redirect('adminn/karyawan');

	
		
		
	}

}