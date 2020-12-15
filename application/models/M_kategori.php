<?php
class M_kategori extends CI_Model{

	function hapus_kategori($kode){
		$hsl=$this->db->query("DELETE FROM kategori where kategori_id='$kode'");
		return $hsl;
	}

	function update_kategori($kode,$kat){
		$hsl=$this->db->query("UPDATE kategori set kategori_nama='$kat' where kategori_id='$kode'");
		return $hsl;
	}

	function tampil_kategori(){
		$users_id=$this->session->userdata('user_id');
		$hsl=$this->db->query("select * from kategori  where kategori_users_id = '$users_id' order by kategori_id desc");
		return $hsl;
	}

	function simpan_kategori($kat){
		$users_id=$this->session->userdata('user_id');
		$hsl=$this->db->query("INSERT INTO kategori(kategori_nama, kategori_users_id) VALUES ('$kat','$users_id')");
		return $hsl;
	}

}