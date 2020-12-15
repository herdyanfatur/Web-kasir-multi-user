<?php
class M_barang extends CI_Model{


	function hapus_barang($kode){
		$hsl=$this->db->query("DELETE FROM barang where barang_id='$kode'");
		return $hsl;
	}

	function update_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$stok,$min_stok){
		$users_id=$this->session->userdata('user_id');
		$hsl=$this->db->query("UPDATE barang SET barang_nama='$nabar',barang_satuan='$satuan',barang_harpok='$harpok',barang_harjul='$harjul',barang_stok='$stok',barang_min_stok='$min_stok',barang_tgl_last_updated=NOW(),barang_kategori_id='$kat',barang_users_id='$users_id' WHERE barang_id='$kobar'");
		return $hsl;
	}

	function tampil_barang(){
		$users_id=$this->session->userdata('user_id');
		$hsl=$this->db->query("SELECT barang_id,barang_nama,barang_satuan,barang_harpok,barang_harjul,barang_stok,barang_min_stok,barang_kategori_id,kategori_nama FROM barang JOIN kategori ON barang_kategori_id=kategori_id 
			where barang_users_id = '$users_id'");
		return $hsl;
	}

	function simpan_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$stok,$min_stok){
		$users_id=$this->session->userdata('user_id');
		$hsl=$this->db->query("INSERT INTO barang (barang_id,
			barang_nama,
			barang_satuan,
			barang_harpok,
			barang_harjul,
			barang_stok,
			barang_min_stok,
			barang_kategori_id,
			barang_users_id) 
			VALUES ('$kobar','$nabar','$satuan','$harpok','$harjul','$stok','$min_stok','$kat','$users_id')");
		return $hsl;
	}


	function get_barang($kobar){
		$hsl=$this->db->query("SELECT * FROM barang where barang_id='$kobar'");
		return $hsl;
	}

	function get_kobar(){
		$q = $this->db->query("SELECT MAX(RIGHT(barang_id,6)) AS kd_max FROM barang");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "BR".$kd;
	}

}