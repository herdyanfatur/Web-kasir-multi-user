<?php
class Pembelian extends CI_Controller{
	function __construct(){
		parent::__construct();
		// if($this->session->userdata('masuk') !=TRUE){

		// 	$users_id = $this->db->get_where('users',['id'])->row_array();
		// $this->session->set_userdata($users_id);

  //           $url=base_url();
  //           redirect($url);
  //       };
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_supplier');
		$this->load->model('m_pembelian');


		if($_SESSION['role_id'] != 1){
			$this->session->set_flashdata('aa', '<div class="alert alert-danger" role="alert">Anda tidak punya akses</div>');
			redirect('admin');
		}
	}
	
	function index(){

		$data = [
			'title'=> 'Pembelian',
			'sup'=>$this->m_supplier->tampil_supplier()
		];
		
		

		$this->load->view('templates/dashboard_header',$data );
		$this->load->view('templates/dashboard_sidebar' );
		$this->load->view('templates/dashboard_topbar' );		
		$this->load->view('admin/v_pembelian',$data);
		$this->load->view('templates/dashboard_footer');

	}
	function get_barang(){

		
		$kobar=$this->input->post('kode_brg');
		$x['brg']=$this->m_barang->get_barang($kobar);
		$this->load->view('admin/v_detail_barang_beli',$x);

	}
	function add_to_cart(){

		
		$nofak=$this->input->post('nofak');
		$tgl=$this->input->post('tgl');
		$supplier=$this->input->post('supplier');
		$this->session->set_userdata('nofak',$nofak);
		$this->session->set_userdata('tglfak',$tgl);
		$this->session->set_userdata('supplier',$supplier);

		$kobar=$this->input->post('kode_brg');
		$produk=$this->m_barang->get_barang($kobar);
		$i=$produk->row_array();
		$data = array(
               'id'       => $i['barang_id'],
               'name'     => $i['barang_nama'],
               'satuan'   => $i['barang_satuan'],
               'price'    => $this->input->post('harpok'),
               'harga'    => $this->input->post('harjul'),
               'qty'      => $this->input->post('jumlah')
            );

		$this->cart->insert($data); 
		redirect('adminn/pembelian');
	

	}
	function remove(){


		$row_id=$this->uri->segment(4);
		$this->cart->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
		redirect('adminn/pembelian');
	

	}
	function simpan_pembelian(){


		$nofak=$this->session->userdata('nofak');
		$tglfak=$this->session->userdata('tglfak');
		$supplier=$this->session->userdata('supplier');
		if(!empty($nofak) && !empty($tglfak) && !empty($supplier)){
			// $beli_kode=$this->m_pembelian->get_kobel();
			// $order_proses=$this->m_pembelian->simpan_pembelian($nofak,$tglfak,$supplier,$beli_kode);
			$order_proses=$this->m_pembelian->simpan_pembelian($nofak,$tglfak,$supplier);
			if($order_proses){
				$this->cart->destroy();
				$this->session->unset_userdata('nofak');
				$this->session->unset_userdata('tglfak');
				$this->session->unset_userdata('supplier');
				echo $this->session->set_flashdata('msg','<label class="label label-success">Pembelian Berhasil di Simpan ke Database</label>');
				redirect('adminn/pembelian');	
			}else{
				redirect('adminn/pembelian');
			}
		}else{
			echo $this->session->set_flashdata('msg','<label class="label label-danger">Pembelian Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
			redirect('adminn/pembelian');
		}

}
}

