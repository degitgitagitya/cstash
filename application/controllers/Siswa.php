<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

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
	
	
    public function load_data($id=null){
    	//$this->Apimodel->submitProblem(1,'1-4.cpp');
	 	//$data=$this->Apimodel->getSub($id);//submiss,soal
	 	// $data['problem']=$this->Apimodel->getProblem();
	 	$ids = $this->Apimodel->submitProblem(1,'1-4.cpp');
	 	echo('<pre>');
		print_r($ids);
		echo('</pre>');


	}

	public function index()
	{
		$data['sesi'] = $this->Lmodel->getSesi()->result();
		$data['judul'] = 'Dashboard';
		$data['topik'] = $this->Lmodel->getTopik()->result();
		$dashboard = $this->LUser->dashboard()->result();
		$dashboard = $dashboard['0'];
		// echo('<pre>');
		// print_r($dashboard);
		// echo('</pre>');
		
		$this->load->view('siswa/mainheader',$data);
		$this->load->view('siswa/dashboard',$dashboard);
		$this->load->view('siswa/mainfooter');
	}
	public function csesi()
	{	
		$sesi = $this->input->get('namaSesi');
		$data['sesi'] = $this->Lmodel->getSesi()->result();
		$data['judul'] = 'Dashboard';
		$sdata=$data;
		$data['topik'] = $this->Lmodel->getTopik()->result();
		// echo('<pre>');
		// print_r($data);
		// echo('</pre>');
		
		$this->load->view('siswa/mainheader',$data);
		$this->load->view('siswa/dashboard',$sdata);
		$this->load->view('siswa/mainfooter');
		$this->load->view('siswa/mdashboard');
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
			$this->load->view('siswa/mainheader',$data);
			$this->load->view('siswa/csesi',$sdata);
			$this->load->view('siswa/mainfooter');
			$this->load->view('siswa/csesimodal',$sdata);
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
			$this->load->view('siswa/mainheader',$data);
			$this->load->view('siswa/ctopik',$konten);
			$this->load->view('siswa/konten_footer');
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
			$this->load->view('siswa/mainheader',$data);
			$this->load->view('siswa/ctopik',$konten);
			$this->load->view('siswa/konten_footer');
		}
		else{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	function load_konten($id,$page,$side)
	{	
		$data=$this->LAdmin->get_spec_konten($id,$page)->row_array();
		switch ($side) {
			case '1':
				$konten['judul']=$data['judul1'];
				$konten['isi']=$data['konten1'];
				$konten['tugas']=$this->Lmodel->getTugas($data['id_konten'])->result();
				$this->load->view('siswa/konten',$konten);
				if ($konten['tugas']!=null) {
					foreach ($konten['tugas'] as $key) {
						$result=$this->Lmodel->getJawabanTugas($key->id_tugas,$this->session->userdata('id'))->row_array();
							// echo "<pre> ini";
							// print_r($result);
							// echo "</pre>";
						if ($result!=null) {
							if ($result['st']=='1'||$result['st']=='nodata') {
								if ($result['st']!='nodata') {
									$ids = $this->Apimodel->submitProblem($key->id_problem,$result['file_jawaban']);
									$getapi=$this->Apimodel->getSub($ids);
								}else{
									$getapi=$this->Apimodel->getSub($result['id_submission']);
									$ids=$result['id_submission'];
								}
								if ($getapi!='nodata') {
									$query = array('id_submission' => $ids,
												'st' =>$getapi['judgement_type_id'] );
									$this->LUser->update_jTugas($result['id_jawaban_tugas'],$query);
									$result=$this->Lmodel->getJawabanTugas($key->id_tugas,$this->session->userdata('id'))->row_array();
								}else{
									$query = array('id_submission' => $ids,
												'st' =>'nodata' );
									$this->LUser->update_jTugas($result['id_jawaban_tugas'],$query);
									$result=$this->Lmodel->getJawabanTugas($key->id_tugas,$this->session->userdata('id'))->row_array();
								}
							// 	echo "<pre><br> ini";
							// // print_r($ids);
							// // echo ($ids);
							// echo "</pre>";
								
							}
							$key->jawaban_tugas=$result;
							// echo "<pre>";
							// print_r($result);
							// echo "</pre>";
							$result=null;
						}else{
							$key->jawaban_tugas=null;
						}
					}
				}
				// echo "<pre>";
				// print_r($konten);
				// echo "</pre>";
				$this->load->view('siswa/mKonten',$konten);
				break;
			case '2':
				$konten['judul']=$data['judul2'];
				$konten['isi']=$data['konten2'];
				$this->load->view('siswa/konten',$konten);
				break;
			case '3':
				$konten['judul']=$data['judul3'];
				$konten['isi']=$data['konten3'];
				$this->load->view('siswa/konten',$konten);
				break;
			default:
				# code...
				break;
		}	
	}
	public function konten()
	{
		$this->load->view('siswa/header');
		$this->load->view('siswa/csesi');
		$this->load->view('siswa/footer');
	}
	public function jawab_tugas($id_jawaban_tugas=null)
	{
		$file_tugas = $_FILES['file']['name'];
			$tfile=substr($file_tugas, -4);
			if ($tfile=='.cpp') {
				if ($this->input->post('namafile')!=null) {
					$namafile = $this->input->post('namafile'); //untuk edit tugas
				}else{
					$namafile=$this->input->post('id_tugas');
					$namafile.='-'; 
					$namafile.= $this->session->userdata('id');
					$namafile.= '.cpp';
				}
				$config['file_name'] 		= $namafile;
				$config['upload_path']		= './jawaban_tugas/';
				$config['allowed_types']	= '*';
				$config['overwrite']	    = true;

				$this->load->library('upload', 'url');
				$this->upload->initialize($config);

				if(!$this->upload->do_upload('file')){
				 	echo $this->upload->display_errors();
				 }else{
				 	
				 		if ($id_jawaban_tugas!=null) { //untuk edit tugas
				 			$data = $this->upload->data();
					 		$query = array(
					 		'id_submission' => null,
					 		'st' => '1',
					 		);
				 			$this->LUser->update_jTugas($id_jawaban_tugas,$query);
				 		}else{
				 			$data = $this->upload->data();
					 		$query = array(
					 		'file_jawaban' => $namafile,
					 		'id_submission' => null,
					 		'st' => '1',
					 		'id_tugas' => $this->input->post('id_tugas'),
					 		'id_siswa' => $this->session->userdata('id'),
					 		);
				 			$this->LUser->insert_jTugas($query);
				 		}
				 	}
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			echo "Format tidak didukung";
			echo '<a onclick="window.history.go(-1);" style="cursor:pointer;" >Kembali</a>';
		}
	}
	public function konten_sub1()
	{
		$this->load->view('siswa/konten1');
	}
	public function konten_sub2()
	{
		$this->load->view('siswa/konten2');
	}
	public function konten_sub3()
	{
		$this->load->view('siswa/konten3');
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
					if ($wad->tugas!=null) {
						$result=$this->Lmodel->getJawabanTugas($wad->tugas['id_tugas'],$this->session->userdata('id'))->row_array();
						if ($result!=null) {
							$wad->tugas['jawaban'] = $result;
						}else{
							$wad->tugas['jawaban'] = null;
						}
					}
				}
			}
		}
		// echo('<pre>');
		// print_r($dashboard);
		// echo('</pre>');
		$this->load->view('siswa/mainheader',$data);
		$this->load->view('siswa/daftar_tugas',$sdata);
		$this->load->view('siswa/mainfooter');
	}
}
