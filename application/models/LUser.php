<?php


class LUser extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function Ladmin($username, $pwd){
	  $pwd = md5($pwd);
	  $this->db->select('*');
	  $this->db->from('admin');
	  $this->db->where('username', $username);
	  $this->db->where('pass', $pwd);
	  return $this->db->get();
	 }

	 public function Lsiswa($username, $pwd){
	  $pwd = md5($pwd);
	  $this->db->select('*');
	  $this->db->from('siswa');
	  $this->db->where('nis', $username);
	  $this->db->where('pass', $pwd);
	  $this->db->where('status', 'reg');
	  return $this->db->get();
	 }

	 public function dashboard()
	 {
	 	$this->db->select('*');
		$this->db->from('dashboard');
		return $this->db->get();
	 }
	  public function insert_jTugas($data)
	 {
	 	// print_r($data);
	 	$this->db->insert('jawaban_tugas', $data);
	 }
	 public function update_jTugas($id,$data)
	 {
	 	// print_r($data);
	 	$this->db->where('id_jawaban_tugas', $id);
		$this->db->update('jawaban_tugas', $data);
	 }

}

?>