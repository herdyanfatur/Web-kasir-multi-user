<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Supplier extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			// is_logged_in();
			if($_SESSION['role_id'] != 1){
			$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Anda tidak punya akses</div>');
			redirect('admin');
		}
			$this->load->model('m_supplier');

		}

		public function index()
		{					
			$data['title'] = 'Supplier';
			$data['users'] = $this->db->get_where('users',['email' =>
			$this->session->userdata('email')])->row_array();


			
			$dataa['data']=$this->m_supplier->tampil_supplier();

			$this->load->view('templates/dashboard_header', $data);
			$this->load->view('templates/dashboard_sidebar', $data);
			$this->load->view('templates/dashboard_topbar', $data);
			$this->load->view('admin/v_supplier', $dataa);
			$this->load->view('templates/dashboard_footer');

	}
	function tambah_supplier(){

		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$deskripsi=$this->input->post('deskripsi');
		$this->m_supplier->simpan_supplier($nama,$alamat,$notelp,$deskripsi);
		redirect('adminn/supplier');

	}
	function edit_supplier(){

		$kode=$this->input->post('kode');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$deskripsi=$this->input->post('deskripsi');
		$this->m_supplier->update_supplier($kode,$nama,$alamat,$notelp,$deskripsi);
		redirect('adminn/supplier');

	}
	function hapus_supplier(){

		$kode=$this->input->post('kode');
		$this->m_supplier->hapus_supplier($kode);
		redirect('adminn/supplier');

	}

}