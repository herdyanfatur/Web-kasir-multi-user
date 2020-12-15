<?php
class Penjualan extends CI_Controller{
	function __construct(){
		parent::__construct();

		// if($this->session->userdata('masuk') !=TRUE){

		// 	$users_id = $this->db->get_where('users',['id'])->row_array();
		// $this->session->set_userdata($users_id);
  //           $url=base_url();
  //           redirect($url);
  //       };
		// is_logged_in();
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_supplier');
		$this->load->model('m_penjualan');

	}
	function index(){
			$data = [
			'title' => 'Penjualan',
			'data' => $this->m_barang->tampil_barang()
		];
		

		$this->load->view('templates/dashboard_header',$data );
		$this->load->view('templates/dashboard_sidebar' );
		$this->load->view('templates/dashboard_topbar' );
		$this->load->view('admin/v_penjualan',$data);
		$this->load->view('templates/dashboard_footer');

	}
	function get_barang(){


		$users_id = $_SESSION['users_id'];
		$kobar=$this->input->post('kode_brg');
		$x['brg']=$this->m_barang->get_barang($kobar);

		$this->load->view('admin/v_detail_barang_jual',$x);
		

	}
	function add_to_cart(){

		$kobar=$this->input->post('kode_brg');
		$produk=$this->m_barang->get_barang($kobar);
		$i=$produk->row_array();
		$data = array(
               'id'       => $i['barang_id'],
               'name'     => $i['barang_nama'],
               'satuan'   => $i['barang_satuan'],
               'harpok'   => $i['barang_harpok'],
               'price'    => str_replace(",", "", $this->input->post('harjul'))-$this->input->post('diskon'),
               'disc'     => $this->input->post('diskon'),
               'qty'      => $this->input->post('qty'),
               'amount'	  => str_replace(",", "", $this->input->post('harjul'))
            );
	if(!empty($this->cart->total_items())){
		foreach ($this->cart->contents() as $items){
			$id=$items['id'];
			$qtylama=$items['qty'];
			$rowid=$items['rowid'];
			$kobar=$this->input->post('kode_brg');
			$qty=$this->input->post('qty');
			if($id==$kobar){
				$up=array(
					'rowid'=> $rowid,
					'qty'=>$qtylama+$qty
					);
				$this->cart->update($up);
			}else{
				$this->cart->insert($data);
			}
		}
	}else{
		$this->cart->insert($data);
	}

		redirect('adminn/penjualan');
	}
	function remove(){
		$row_id=$this->uri->segment(4);
		$this->cart->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
		redirect('adminn/penjualan');

	}
	function simpan_penjualan(){

		$users_id=$_SESSION['users_id'];
		$total=$this->input->post('total');
		$jml_uang=str_replace(",", "", $this->input->post('jml_uang'));
		$kembalian=$jml_uang-$total;
		if(!empty($total) && !empty($jml_uang)){
			if($jml_uang < $total){
				echo $this->session->set_flashdata('msg','<label class="label label-danger">Jumlah Uang yang anda masukan Kurang</label>');
				redirect('adminn/penjualan');
			}else{
				$nofak=$this->m_penjualan->get_nofak();
				$this->session->set_userdata('nofak',$nofak);
				$order_proses=$this->m_penjualan->simpan_penjualan($nofak,$total,$jml_uang,$kembalian,$users_id);
				if($order_proses){
					$this->cart->destroy();
					
					$this->session->unset_userdata('tglfak');
					$this->session->unset_userdata('supplier');
					$this->load->view('alert/alert_sukses');	
				}else{
					redirect('adminn/penjualan');
				}
			}
			
		}else{
			echo $this->session->set_flashdata('msg','<label class="label label-danger">Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
			redirect('adminn/penjualan');
		}


	}

	function cetak_faktur(){
		$x['data']=$this->m_penjualan->cetak_faktur();
		$this->load->view('laporan/v_faktur',$x);
		//$this->session->unset_userdata('nofak');
	}


}