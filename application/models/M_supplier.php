<?php
class M_supplier extends CI_Model{

	function hapus_supplier($kode){
		$hsl=$this->db->query("DELETE FROM supplier where supplier_id='$kode'");
		return $hsl;
	}

	function update_supplier($kode,$nama,$alamat,$notelp,$deskripsi){
		$users_id=$this->session->userdata('users_id');
		$hsl=$this->db->query("UPDATE supplier set 
			name='$nama'
			,address='$alamat'
			,phone='$notelp'
			,description = '$deskripsi'
			,updated = '$updated'
			,supplier_users_id = '$users_id'
			  where supplier_id='$kode'");
		return $hsl;
	}

	function tampil_supplier(){
		$users_id = $_SESSION['user_id'];
		$sql = "select * from supplier where supplier_users_id = '$users_id' order by supplier_id desc";
		$hsl = $this->db->query($sql);
		return $hsl;
	}

	function simpan_supplier($nama,$alamat,$notelp,$deskripsi){
		$users_id = $_SESSION['user_id'];
		$hsl=$this->db->query("INSERT INTO supplier(name,address,phone,description,supplier_users_id) VALUES ('$nama','$alamat','$notelp','$deskripsi','$users_id')");
		return $hsl;
	}

}