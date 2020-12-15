<?php
class M_users extends CI_Model{

	// function cekadmin($email_kar,$password_kar){
 //        $hasil=$this->db->query("select*from users where email_kar='$email_kar'and password_kar= '$password_kar");
 //        return $hasil;
 //    }

	function simpan_users($nama,$email,$password,$new_image,$role_id){
		$hsl=$this->db->query("INSERT INTO users(
			name,
			email,
			image,
			password,
			role_id)
			 VALUES (
			'$nama',
			'$email',
			'$new_image',
			'$password',
			'$role_id'
			)");
		return $hsl;
	}
	function tampil_users(){
		$hsl=$this->db->query("select * from users WHERE role_id = '1' order by id desc");
		return $hsl;
	}
	function tampil_data_users(){
		$id=$_SESSION['users_id'];
		$hsl=$this->db->query("select * from users WHERE id = '$id' ");
		return $hsl;
	}
	function hapus_users($kode){
		$hsl=$this->db->query("DELETE FROM users where id='$kode'");
		return $hsl;
	}
	
	function update_users( $nama,$email,$new_image){
		$users_id=$_SESSION['users_id'];
		
		$hsl=$this->db->query("UPDATE users SET name='$nama', email='$email' , image='$new_image' WHERE id='$users_id'");
		return $hsl;
	}
	function update_password( $email,$password){
		
		$hsl=$this->db->query("UPDATE users SET password='$password' WHERE email='$email'");
		return $hsl;
	}
	
	// function update_status($kode){
	// 	$hsl=$this->db->query("UPDATE users SET user_status='0' WHERE user_id='$kode'");
	// 	return $hsl;
	// }
}