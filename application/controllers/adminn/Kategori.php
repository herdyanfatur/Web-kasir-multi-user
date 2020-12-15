<?php
class Kategori extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($_SESSION['role_id'] != 1){
			
			redirect('auth/blocked');
		}


		$this->load->model('m_kategori');
	}
	function index(){

		$data = [
			'title' => 'Kategori',
			'data' => $this->m_kategori->tampil_kategori()
		];







		$this->load->view('templates/dashboard_header',$data );
		$this->load->view('templates/dashboard_sidebar' );
		$this->load->view('templates/dashboard_topbar' );
		$this->load->view('admin/v_kategori',$data);
		
		$this->load->view('templates/dashboard_footer');


	}
	function tambah_kategori(){
		

		$this->session->userdata('id');
		$kat=$this->input->post('kategori');
		$this->m_kategori->simpan_kategori($kat);
		redirect('adminn/kategori');
		

	}
	function edit_kategori(){
		

		$kode=$this->input->post('kode');
		$kat=$this->input->post('kategori');
		$this->m_kategori->update_kategori($kode,$kat);
		redirect('adminn/kategori');
		

	}
	function hapus_kategori(){
		

		$kode=$this->input->post('kode');
		$this->m_kategori->hapus_kategori($kode);
		redirect('adminn/kategori');

		
	}
}
