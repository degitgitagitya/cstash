<?php


class Lmodel extends CI_model
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

	public function insertSiswa($data){
	  	$this->db->insert('siswa',$data);
	}

	public function getSesi(){
		$this->db->select('*');
		$this->db->from('sesi');
	 	return $this->db->get();
	}
	public function getTugas($id){
		$this->db->select('*');
		$this->db->from('tugas');
		$this->db->where('id_konten',$id);
	 	return $this->db->get();
	}
	public function getDetailTugas($id){
		$this->db->select('*');
		$this->db->from('get_tugas');
		$this->db->where('id_tugas',$id);
		return $this->db->get();
	}
	public function getTopik(){
		$this->db->select('*');
		$this->db->from('topik');
	 	return $this->db->get();
	}
	public function getJawabanTugas($idt,$ids){
		$this->db->select('*');
		$this->db->from('jawaban_tugas');
		$this->db->where('id_tugas',$idt);
		$this->db->where('id_siswa',$ids);
	 	return $this->db->get();
	}
	public function getsTopik($nama){
		$this->db->select('id_topik');
		$this->db->select('nama_topik');
		// $this->db->select('*');

		$this->db->from('topik');
		$this->db->join('sesi','topik.id_sesi=sesi.id_sesi');
		$this->db->where('sesi.nama_sesi',$nama);
	 	return $this->db->get();
	}
	public function getsKonten($id){
		$this->db->select('id_konten');
		$this->db->from('konten');
		$this->db->join('topik','topik.id_topik=konten.id_topik');
		$this->db->where('topik.id_topik',$id);
	 	return $this->db->get();
	}
	function getJawabanTugasDt($id){
		$this->db->select('*');
		$this->db->from('v_jawaban_tugas');
		$this->db->where('id_tugas',$id);
	 	return $this->db->get();
	}
}
?>