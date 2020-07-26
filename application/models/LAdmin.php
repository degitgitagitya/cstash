<?php


class LAdmin extends CI_model
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

	 public function insert_sesi($data){
		$this->db->insert('sesi', $data);
	}
	public function insert_konten($data){
		$this->db->insert('konten', $data);
	}
	public function deleteAll_konten($id){
		$this->db->from('topik');
		$this->db->where('id_topik', $id);
		$this->db->delete('konten');
	}
	public function delete_konten($id){
		$this->db->from('konten');
		$this->db->where('id_konten', $id);
		$this->db->delete('konten');
	}
	public function insert_topik($data){
		$this->db->insert('topik', $data);
	}
	public function insert_tugas($data){
		$this->db->insert('tugas', $data);
	}
	public function GetIdTopik($id_sesi,$nama_topik){
		$this->db->from('topik');
		$this->db->select('id_topik');
	 	$this->db->where('id_sesi', $id_sesi);
		$this->db->where('nama_topik', $nama_topik);
		return $this->db->get();
	}
	public function GetTopik($id){
		$this->db->select('*');
	 	$this->db->from('topik');
		$this->db->where('id_topik', $id);
		return $this->db->get();
	}
	public function deleteTugas($id){
		$this->db->from('tugas');
		$this->db->where('id_konten', $id);
		$this->db->delete('tugas');
	}
	public function GetIdTopikFN($nama_sesi,$nama_topik){
		$this->db->from('get_id_topik');
		$this->db->select('*');
	 	$this->db->where('nama_sesi', $nama_sesi);
		$this->db->where('nama_topik', $nama_topik);
		return $this->db->get();
	}
	public function update_topik($id,$data){
		$this->db->where('id_topik', $id);
		$this->db->update('topik', $data);
	}
	public function update_tugas($id,$data){
		$this->db->where('id_tugas', $id);
		$this->db->update('tugas', $data);
	}
	public function update_konten($id,$data){
		$this->db->where('id_konten', $id);
		$this->db->update('konten', $data);
	}
	public function remove_topik($id){
		$this->db->where('id_topik', $id);
		$this->db->delete('topik');
	}
	public function Get_total_data($id){
		$this->db->from('konten');
		$this->db->select('count(*) as total_page');
	 	$this->db->where('id_topik', $id);
	 	return $this->db->get();
	}
	public function get_spec_konten($id_topik,$page){
		$this->db->select('*');
		$this->db->from('konten');
	 	$this->db->where('id_topik', $id_topik);
	 	$page--;
	 	$this->db->limit(1,$page);
	 	return $this->db->get();
	}
}

?>