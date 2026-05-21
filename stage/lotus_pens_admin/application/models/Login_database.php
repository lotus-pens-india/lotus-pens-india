<?php

class Login_Database extends CI_Model {

//Read Admin data using username and password
public function check_admin_login($username, $password){
	$condition = array(
		'username' => $username,
		'password' => md5($password),

	);
	$query = $this->db->select('*')
		->from('vg_login')
		->where($condition)
		->get();
	if ($query->num_rows() > 0) {
	  return TRUE;

	} else {
	   return false;
	}
}

//Get Admin data by username
public function get_admin_data($username){
return $query = $this->db->select('*')
	->from('vg_login')
	->where('username', $username)
	->get()
	->row();
}





}

?>
