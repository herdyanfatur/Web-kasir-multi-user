<?php
class M_pembelian extends CI_Model{

	function simpan_pembelian($nofak,$tglfak,$supplier){
		$users_id=$_SESSION['users_id'];
		$beli_kode = $this->generateCode($tglfak);
		$this->db->query("INSERT INTO beli (beli_nofak,beli_tanggal,beli_supplier_id,beli_users_id,beli_kode) VALUES ('$nofak','$tglfak','$supplier','$users_id','$beli_kode')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_beli_nofak' 		=>	$nofak,
				'd_beli_barang_id'	=>	$item['id'],
				'd_beli_harga'		=>	$item['price'],
				'd_beli_jumlah'		=>	$item['qty'],
				'd_beli_total'		=>	$item['subtotal'],
				'd_beli_kode'		=>	$beli_kode,
				'd_beli_users_id'	=>	$users_id
			);
			$this->db->insert('detail_beli',$data);
			$this->db->query("update barang set barang_stok=barang_stok+'$item[qty]',barang_harpok='$item[price]',barang_harjul='$item[harga]' where barang_id='$item[id]'");
		}
		return true;
	}

	// kode belanja
	// BL20191202 000001
	function get_kobel(){
		$q = $this->db->query("SELECT MAX(RIGHT(beli_kode,6)) AS kd_max FROM beli WHERE DATE(beli_tanggal)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "BL".date('dmy').$kd;
	}

	function generateCode($beliTanggal){
		$q = $this->db->query("SELECT MAX(RIGHT(beli_kode,6)) AS kd_max FROM beli WHERE beli_tanggal = '$beliTanggal'"); 
        $code = "";
        if($q->num_rows()>0){
        	var_dump($q->result());
            foreach($q->result() as $k){
            	// var_dump($k);
                $tmp = ((int)$k->kd_max)+1;
                $code = sprintf("%06s", $tmp);
            }
        }else{
            $code = "000001";
        }

        return "BL".date("ymd", strtotime($beliTanggal)).$code;
	}
}