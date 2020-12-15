<?php
class M_karyawan extends CI_Model{

	// function cekadmin($email_kar,$password_kar){
 //        $hasil=$this->db->query("select*from karyawan where email_kar='$email_kar'and password_kar= '$password_kar");
 //        return $hasil;
 //    }

	function simpan_karyawan($nama,$email,$password,$image,$is_active,$role_id){
		$users_id=$_SESSION['users_id'];
		$hsl=$this->db->query("INSERT INTO karyawan(
			name_kar,
			email_kar,
			image_kar,
			is_active,
			password_kar,
			karyawan_users_id,
			role_id)
			 VALUES (
			'$nama',
			'$email',
			'$image',
			'$is_active',
			'$password',
			'$users_id',
			'$role_id'
			)");
		return $hsl;
	}
	function tampil_karyawan(){
		$users_id=$_SESSION['users_id'];
		$hsl=$this->db->query("select * from karyawan WHERE karyawan_users_id = '$users_id' order by id_kar desc");
		return $hsl;
	}
	
	
	function update_karyawan( $nama,$email,$new_image){
		$id=$_SESSION['users_id'];
		
		$hsl=$this->db->query("UPDATE karyawan SET name_kar='$nama', email_kar='$email', image_kar='$new_image' WHERE id_kar='$id'");
		return $hsl;
	}
	function tampil_data_kar(){
		$id=$_SESSION['users_id'];
		$hsl=$this->db->query("select * from karyawan WHERE id_kar = '$id' ");
		return $hsl;
	}
	function hapus_karyawan($kode){
		$hsl=$this->db->query("DELETE FROM karyawan where id_kar='$kode'");
		return $hsl;
	}
	function update_password( $email,$password){
		
		$hsl=$this->db->query("UPDATE karyawan SET password_kar='$password' WHERE email_kar='$email'");
		return $hsl;
	}
	function update_status($kode,$is_active){
		$hsl=$this->db->query("UPDATE karyawan SET is_active='$is_active' WHERE id_kar='$kode'");
		return $hsl;
	}
}