<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$data['sesi'] = $this->Lmodel->getSesi()->result();
		$data['judul'] = 'Dashboard';
		$sdata=$data;
		$data['topik'] = $this->Lmodel->getTopik()->result();
		// echo('<pre>');
		// print_r($data);
		// echo('</pre>');
		
		$this->load->view('admin/mainheader',$data);
		$this->load->view('admin/dashboard',$sdata);
		$this->load->view('admin/mainfooter');
		$this->load->view('admin/mdashboard');
		$this->load->view('admin/mHeader',$sdata);
	}
	public function csesi()
	{	
		$sesi = $this->input->get('namaSesi');
		$data['sesi'] = $this->Lmodel->getSesi()->result();
		$data['judul'] = 'Dashboard';
		$sdata['topik'] = $this->Lmodel->getTopik()->result();
		// echo('<pre>');
		// print_r($data);
		// echo('</pre>');
		
		$this->load->view('admin/mainheader',$data);
		$this->load->view('admin/dashboard',$sdata);
		$this->load->view('admin/mainfooter');
		// $this->load->view('admin/mdashboard');
	}
	function addSesi(){
		$query = array(
				'nama_sesi' => $this->input->post('namaSesi'),
				'id_icon' => $this->input->post('namaIkon')
				);
		$this->LAdmin->insert_sesi($query);
		redirect($_SERVER['HTTP_REFERER']);
	}

	
	public function Sesi($sesi=null,$topik=null,$page=null)
	{
	
		if($sesi!=null && $topik==null){
			$sdata['topik']=$this->Lmodel->getsTopik($sesi)->result();
			$data['sesi'] = $this->Lmodel->getSesi()->result();
			$data['judul'] = $sesi;
			$data['topik'] = $this->Lmodel->getTopik()->result();
			$sdata['nama_sesi'] = $sesi;
			$this->load->view('admin/mainheader',$data);
			$this->load->view('admin/csesi',$sdata);
			$this->load->view('admin/mainfooter');
			$this->load->view('admin/csesimodal',$sdata);
			$this->load->view('admin/mHeader',$sdata);
		}else if($sesi!=null && $topik!=null && $page==null){
			$sdata['topik']=$this->Lmodel->getsTopik($sesi)->result();
			$data['sesi'] = $this->Lmodel->getSesi()->result();
			$data['judul'] = $sesi. ' ' . $topik;
			$data['topik'] = $this->Lmodel->getTopik()->result();
			$info =$this->LAdmin->GetIdTopikFN($sesi,$topik)->row_array();
			$id_topik = $info['id_topik'];
			$info =$this->LAdmin->Get_total_data($id_topik)->row_array();
			$info2=$this->LAdmin->get_spec_konten($id_topik,1)->row_array();
			$konten=$info2;
			$konten['page']=1;
			$konten['total_page']=$info['total_page'];
			$konten['id_topik']=$id_topik;
			$konten['nama_topik']=$topik;
			$konten['nama_sesi']=$sesi;
			// $konten['data']=$this->LAdmin->get_spec_konten($id_topik,1)->row_array();
			// echo "<pre>";
			// print_r($info);
			// print_r($konten);
			// echo "</pre>";
			$this->load->view('admin/mainheader',$data);
	 		$konten['problem']=$this->Apimodel->getProblem();
			// // $this->load->view('admin/csesi',$sdata);
			$this->load->view('admin/ctopik',$konten);
			$this->load->view('admin/konten_footer');
			$this->load->view('admin/mHeader',$sdata);
		}else if ($sesi!=null && $topik!=null && $page!=null) {
			$sdata['topik']=$this->Lmodel->getsTopik($sesi)->result();
			$data['sesi'] = $this->Lmodel->getSesi()->result();
			$data['judul'] = $sesi. ' ' . $topik;
			$data['topik'] = $this->Lmodel->getTopik()->result();
			$info =$this->LAdmin->GetIdTopikFN($sesi,$topik)->row_array();
			$id_topik = $info['id_topik'];
			$info =$this->LAdmin->Get_total_data($id_topik)->row_array();
			$info2=$this->LAdmin->get_spec_konten($id_topik,$page)->row_array();
			$konten=$info2;
			$konten['page']=$page;
			$konten['total_page']=$info['total_page'];
			$konten['id_topik']=$id_topik;
			$konten['nama_topik']=$topik;
			$konten['nama_sesi']=$sesi;
			$this->load->view('admin/mainheader',$data);
			// $this->load->view('admin/csesi',$sdata);

	 		$konten['problem']=$this->Apimodel->getProblem();
	 	// 	echo "<pre>";
			// print_r($konten);
			// echo "</pre>";
			$this->load->view('admin/ctopik',$konten);
			$this->load->view('admin/konten_footer');
			$this->load->view('admin/mHeader',$sdata);
		}
		else{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function eTopik()
	{
		$query = array(
				'nama_topik' => $this->input->post('nama_topik'),
				);
		$id=$this->input->post('id_topik');
		$this->LAdmin->update_topik($id,$query);
		$custom= $this->input->post('mode');
		if ($custom==1) {
			$sesi=$this->input->post('nama_sesi');
			$topik=$this->input->post('nama_topik');
			$page=$this->input->post('page');
			redirect(site_url("Admin/sesi/$sesi/$topik/$page"));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function tambah_topik(){
		$nama_topik = $this->input->post('nama_topik');
		$query = array(
				'id_sesi' => $this->input->post('id_sesi'),
				'nama_topik' => $nama_topik
				);
		$this->LAdmin->insert_topik($query);
		$id_topik = $this->LAdmin->getIdTopik($this->input->post('id_sesi'),$this->input->post('nama_topik'));
		$id_topik = $id_topik->row_array();
		$id_topik = $id_topik['id_topik'];

		$konten = array(
				'id_topik' => $id_topik,
				'judul1' => $nama_topik,
				'judul2' => 'Code',
				'judul3' => 'Output',
				'konten1' => $nama_topik,
				'konten2' => $nama_topik,
				'konten3' => $nama_topik
				);
		$this->LAdmin->insert_konten($konten);
		$nama_sesi=$this->input->post('nama_sesi');
		redirect(site_url("Admin/sesi/$nama_sesi/$nama_topik"));
	}
	public function tambah_tugas($id_konten,$page,$id_topik){
		if ($this->input->post('nama_file')!=null){
			$file_tugas = $_FILES['file']['name'];
			$nama_sesi= $this->input->post('nama_sesi');
			$tfile=substr($file_tugas, -4);
			// echo '<pre>';
			// print_r($tfile);
			// echo '</pre>';
			$namafile= $this->input->post('nama_file');
			if ($tfile[0]=='.') {
				$namafile.=$tfile;
			}else{
				$namafile.='.';
				$namafile.=$tfile;
			}
			$namafile = str_replace(" ","_",$namafile);
			// echo "$namafile";
			$config['file_name'] 		= $namafile;
			$config['upload_path']		= './tugas/';
			$config['allowed_types']	= '*';
			$config['overwrite']	    = true;

			$this->load->library('upload', 'url');
			$this->upload->initialize($config);

			if(!$this->upload->do_upload('file')){
			 	echo $this->upload->display_errors();
			}else{
				$data = $this->upload->data();
					$query = array(
						'file' => $namafile,
						'isi_tugas' => $this->input->post('isi_tugas'),
						'id_konten' => $id_konten,
						'id_problem' => $this->input->post('id_problem'),
						);
					$this->LAdmin->insert_tugas($query);
			$nama_topik = $this->LAdmin->getTopik($id_topik);
			$nama_topik = $nama_topik->row_array();
			$nama_topik = $nama_topik['nama_topik'];
			redirect(site_url("Admin/sesi/$nama_sesi/$nama_topik/$page"));
			}
		}else{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function tambah_konten(){
		$id_topik=$this->input->post('id_topik');
		$konten = array(
				'id_topik' => $id_topik,
				'judul1' => $this->input->post('judul1'),
				'judul2' => $this->input->post('judul2'),
				'judul3' => $this->input->post('judul3'),
				'konten1' => $this->input->post('konten1'),
				'konten2' => $this->input->post('konten2'),
				'konten3' => $this->input->post('konten3'),
				);
		$this->LAdmin->insert_konten($konten);
		$info =$this->LAdmin->Get_total_data($id_topik)->row_array();
		$page=$info['total_page'];
		$nama_topik=$this->input->post('nama_topik');
		$nama_sesi=$this->input->post('nama_sesi');
		if ($this->input->post('nama_file')!=null){
			$file_tugas = $_FILES['file']['name'];
			$tfile=substr($file_tugas, -4);
			// echo '<pre>';
			// print_r($tfile);
			// echo '</pre>';
			$konten=$this->LAdmin->get_spec_konten($id_topik,$page)->row_array();
			$id_konten=$konten['id_konten'];
			$namafile= $this->input->post('nama_file');
			if ($tfile[0]=='.') {
				$namafile.=$tfile;
			}else{
				$namafile.='.';
				$namafile.=$tfile;
			}
			// echo "$namafile";
			$config['file_name'] 		= $namafile;
			$config['upload_path']		= './tugas/';
			$config['allowed_types']	= '*';
			$config['overwrite']	    = true;

			$this->load->library('upload', 'url');
			$this->upload->initialize($config);

			if(!$this->upload->do_upload('file')){
			 	echo $this->upload->display_errors();
			}else{
				$data = $this->upload->data();
					$query = array(
						'file' => $namafile,
						'isi_tugas' => $this->input->post('isi_tugas'),
						'id_konten' => $id_konten,
						'id_problem' => $this->input->post('id_problem'),
						);
					$this->LAdmin->insert_tugas($query);
			$nama_topik = $this->LAdmin->getTopik($id_topik);
			$nama_topik = $nama_topik->row_array();
			$nama_topik = $nama_topik['nama_topik'];
			redirect(site_url("Admin/sesi/$nama_sesi/$nama_topik/$page"));
			}
		}else{
			redirect(site_url("Admin/sesi/$nama_sesi/$nama_topik/$page"));
		}
	}
	function eKonten(){
		$id=$this->input->post('id_konten');
		$query = array(
				'judul1' => $this->input->post('judul1'),
				'judul2' => $this->input->post('judul2'),
				'judul3' => $this->input->post('judul3'),
				'konten1' => $this->input->post('konten1'),
				'konten2' => $this->input->post('konten2'),
				'konten3' => $this->input->post('konten3')
				);
		// echo "<pre>";
			// print_r($info);
		// 	print_r($query);
		// echo "</pre>";
		$this->LAdmin->update_konten($id,$query);
		redirect($_SERVER['HTTP_REFERER']);
	}
	function hapus_konten($idm,$opsi=null){
		if ($opsi=='all') {
			$this->LAdmin->deleteAll_konten($idm);
		}else if ($opsi=='tugas') {
			$this->LAdmin->deleteTugas($idm);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->LAdmin->deleteTugas($idm);
			$this->LAdmin->delete_konten($idm);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	function hapus_topik(){
		$id_topik = $this->input->post('id_topik');
		$this->hapus_konten($id_topik,'all');
		$this->LAdmin->remove_topik($id_topik);
		redirect($_SERVER['HTTP_REFERER']);
	}
	function load_konten($id,$page,$side)
	{	
		$data=$this->LAdmin->get_spec_konten($id,$page)->row_array();
		switch ($side) {
			case '1':
				$konten['judul']=$data['judul1'];
				$konten['isi']=$data['konten1'];
				$konten['tugas']=$this->Lmodel->getTugas($data['id_konten'])->result();
				$this->load->view('admin/konten',$konten);
				break;
			case '2':
				$konten['judul']=$data['judul2'];
				$konten['isi']=$data['konten2'];
				$this->load->view('admin/konten',$konten);
				break;
			case '3':
				$konten['judul']=$data['judul3'];
				$konten['isi']=$data['konten3'];
				$this->load->view('admin/konten',$konten);
				break;
			default:
				# code...
				break;
		}
		
	}
	public function daftar_tugas(){
		$data['sesi'] = $this->Lmodel->getSesi()->result();
		$data['judul'] = 'Daftar Tugas';
		$data['topik'] = $this->Lmodel->getTopik()->result();
		
		//$tugas = $this->Lmodel->getAllTugas()->result();
		
		$sdata['sesi'] = $data['sesi'];
		foreach ($sdata['sesi'] as $key) {
			$key->topik = $this->Lmodel->getsTopik($key->nama_sesi)->result();
			foreach ($key->topik as $val) {
				$val->konten = $this->Lmodel->getsKonten($val->id_topik)->result();
				foreach ($val->konten as $wad) {
					$wad->tugas = $this->Lmodel->getTugas($wad->id_konten)->row_array();
				}
			}
		}
		// echo('<pre>');
		// print_r($dashboard);
		// echo('</pre>');
		$this->load->view('admin/mainheader',$data);
		$this->load->view('admin/daftar_tugas',$sdata);
		$this->load->view('admin/mainfooter');
	}
	function detail_tugas($id=null){
		if ($id == null) {
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data['problem']=$this->Apimodel->getProblem();
			$data['tugas'] = $this->Lmodel->getDetailTugas($id)->row_array();
			$data['jawaban_siswa'] = $this->Lmodel->getJawabanTugasDt($id)->result();
			$this->load->view('admin/detail_tugas',$data);
		}
		
	}
	function edit_tugas($id_tugas){
		if ($this->input->post('nama_file')!=null){
			$file_tugas = $_FILES['file']['name'];
			$tfile=substr($file_tugas, -4);
			// echo '<pre>';
			// print_r($tfile);
			// echo '</pre>';
			$namafile= $this->input->post('nama_file');
			if ($tfile[0]=='.') {
				$namafile.=$tfile;
			}else{
				$namafile.='.';
				$namafile.=$tfile;
			}
			$namafile = str_replace(" ","_",$namafile);
			// echo "$namafile";
			$config['file_name'] 		= $namafile;
			$config['upload_path']		= './tugas/';
			$config['allowed_types']	= '*';
			$config['overwrite']	    = true;

			$this->load->library('upload', 'url');
			$this->upload->initialize($config);

			if(!$this->upload->do_upload('file')){
			 	echo $this->upload->display_errors();
			}else{
				$data = $this->upload->data();
					$query = array(
						'file' => $namafile,
						'isi_tugas' => $this->input->post('isi_tugas'),
						'id_problem' => $this->input->post('id_problem'),
						);
					$this->LAdmin->update_tugas($id_tugas,$query);
			redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}