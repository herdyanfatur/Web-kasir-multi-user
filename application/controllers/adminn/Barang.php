<?php
class Barang extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('m_kategori');
		$this->load->model('m_barang');


		#set admin and prevent employees to access this feature

		if($_SESSION['role_id'] != 1){
			
			redirect('auth/blocked');
		}
	}

	function index(){

		$data = [
			'title' => 'Data Barang',
			'data' => $this->m_barang->tampil_barang(),
			'kat' => $this->m_kategori->tampil_kategori()
		];



		$this->load->view('templates/dashboard_header',$data );
		$this->load->view('templates/dashboard_sidebar' );
		$this->load->view('templates/dashboard_topbar' );
		$this->load->view('admin/v_barang',$data);
		$this->load->view('templates/dashboard_footer');

		

	}

	function tambah_barang(){



		$this->session->userdata('id');
		$kobar=$this->m_barang->get_kobar();
		$nabar=$this->input->post('nabar');
		$kat=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$harpok=str_replace(',', '', $this->input->post('harpok'));
		$harjul=str_replace(',', '', $this->input->post('harjul'));
		$stok=$this->input->post('stok');
		$min_stok=$this->input->post('min_stok');

		$this->m_barang->simpan_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$stok,$min_stok);

		redirect('adminn/barang');

	}
	function edit_barang(){

	
		
		$kobar=$this->input->post('kobar');
		$nabar=$this->input->post('nabar');
		$kat=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$harpok=str_replace(',', '', $this->input->post('harpok'));
		$harjul=str_replace(',', '', $this->input->post('harjul'));
		$harjul_grosir=str_replace(',', '', $this->input->post('harjul_grosir'));
		$stok=$this->input->post('stok');
		$min_stok=$this->input->post('min_stok');
		$this->m_barang->update_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$stok,$min_stok);
		redirect('adminn/barang');


	}
	function hapus_barang(){


		$kode=$this->input->post('kode');
		$this->m_barang->hapus_barang($kode);
		redirect('adminn/barang');


	}
}