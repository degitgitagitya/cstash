<?php 
class Apimodel extends CI_Model {
 var $API ="";
 var $id_contest ="";
 function __construct() {
        parent::__construct();
       	$api_data=$this->db->query("select * from api_link;")->row_array();
        $this->API=$api_data['link'];
        $this->id_contest = $api_data['contest'];
    }
 function getSub($id_summission){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_PORT => "12345",
		CURLOPT_URL => $this->API.'/api/v4/contests/'.$this->id_contest.'/judgements?cid=/'.$this->id_contest.'&submission_id='.$id_summission,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_POSTFIELDS => "",
		CURLOPT_HTTPHEADER => array(
			"Authorization: Basic dXNlcjp1c2Vy",
			"cid: ".$this->id_contest,
			"id: ".$id_summission
		),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	$err = json_decode($err);
	$isi=json_decode($response, true);
	if ($isi==null) {
		return('nodata');
	}else{
		return($isi['0']);
	}
	
 }
 function submitProblem($id_problem,$file){

require "vendor/autoload.php";

// use GuzzleHttp\Client;

$client = new GuzzleHttp\Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://domserver.cstash.tech:12345/api/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

$response = $client->request('POST',  "v4/contests/4/submissions", [
    'headers' => [
        "Authorization" => "Basic dXNlcjp1c2Vy",
        "Accept" => "multipart/form-data"
    ],
    'multipart' => [
        [
            'name'     => 'cid',
            'contents' => $this->id_contest,
        ],
        [
            'name'     => 'language',
            'contents' => 'cpp',

        ],
        [
            'name'     => 'problem',
            'contents' => $id_problem,

        ],
        [
            'name'     => 'code',
            'contents' => fopen("/var/www/html/jawaban_tugas/$file", 'r'),
            'headers'  => [
                'Content-Type' => 'text/x-c'
            ]
        ]
    ]
]);

// print_r($response->getBody()->getContents());
return($response->getBody()->getContents());
  }
  function getProblem()
  {

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "12345",
	  CURLOPT_URL => $this->API."/api/v4/contests/4/problems?cid=4",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_POSTFIELDS => "",
	  CURLOPT_HTTPHEADER => array(
	    "Postman-Token: f0e9df3b-c35e-4c12-aec6-ce20790ff4c4",
	    "cache-control: no-cache"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	$isi=json_decode($response, true);
	if ($err) {
		 return($err);
	}else {
		 return($isi);
	}
  }
}
?>