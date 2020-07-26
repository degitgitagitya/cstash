<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('login');
	}
	function login(){
		$username = $this->input->post('username');
        $password = $this->input->post('password');
        $cek_admin = $this->Lmodel->Ladmin($username,$password);
        if($cek_admin->num_rows() > 0){
            $data = $cek_admin->row_array();
            // print_r($data);
            $this->session->set_userdata('login',TRUE);
            $this->session->set_userdata('akses','admin');
            $this->session->set_userdata('username',$data['username']);
            redirect(site_url('Admin'));
		}else{
			$cek_siswa = $this->Lmodel->Lsiswa($username,$password);
			if($cek_siswa->num_rows() > 0){
				$data = $cek_siswa->row_array();
				$this->session->set_userdata('login',TRUE);
	            $this->session->set_userdata('akses','siswa');
	            $this->session->set_userdata('id',$data['id_siswa']);
	            $this->session->set_userdata('nama',$data['nama']);
	            $this->session->set_userdata('nis',$data['nis']);
	            redirect(site_url('Siswa'));
			}else{
				echo $this->session->set_flashdata('msg','Username atau Pasword salah!');
                redirect(base_url());
			}
			
		}
	}
	function Logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }
    function addSiswa(){
		
		$query = array(
					'nis' => $this->input->post('nis'),
					'nama' => $this->input->post('nama'),
					'pass' => md5($this->input->post('pass')),
					'status' => 'reg',
					'id_kelompok' => '-1',
					'email' => $this->input->post('email'),
					);
		
		$this->Lmodel->insertSiswa($query);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	// public function konten()
	// {
	// 	$this->load->view('user/konten');
	// }
	// public function konten_sub1()
	// {
	// 	$this->load->view('user/konten1');
	// }
	// public function konten_sub2()
	// {
	// 	$this->load->view('user/konten2');
	// }
	// public function konten_sub3s()
	// {
	// 	$this->load->view('user/konten3');
	// }
}
