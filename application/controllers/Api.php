<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {


	public function add(){
	    header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST");
		$request  = json_decode(file_get_contents('php://input'),true);
		$validate = $this->add_validation($request);
		$table    = $this->uri->segment(3);

		if($validate==false){
			$this->load->model('Api_model','mod_tugas');
			$this->mod_tugas->add($request,$table);
	
			echo $this->messages('200','Data berhasil disimpan');
		}else{
			echo $validate;
		}
		
	}

	public function get(){
	    header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST");
		$table		= $this->uri->segment(3);
		$validate = $this->get_validation($table);

		if($validate==false){
			$this->load->model('Api_model','mod_tugas');
			$data = $this->mod_tugas->get($table);
			echo $this->messages('200','',$data);
		}else{
			echo $validate;
		}

	}

	public function edit(){
	    header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST");
		$table 		= $this->uri->segment(3);
		$id 		= $this->uri->segment(4);
		$validate 	= $this->get_validation($table);

		if($validate==false){
			$this->load->model('Api_model','mod_api');
			$data = $this->mod_api->edit($table,$id);
			echo $this->messages('200','',$data);
		}else{
			echo $validate;
		}
	}

	public function delete(){
		$table		= $this->uri->segment(3);
		$request	= json_decode(file_get_contents('php://input'),true);

		$this->db->where($request);
		$res = $this->db->delete($table);
		if($res){
			echo $this->messages('200','Data berhasil Dihapus');
		}else{
			echo $this->messages('422','Data Gagal Dihapus');
		}
	}

	public function update(){
		$table		= $this->uri->segment(3);
		$request	= json_decode(file_get_contents('php://input'),true);

		$this->db->where('id',$request['id']);
		unset($request['id']);
		$data = $request;
		
		$res = $this->db->update($table,$data);
		if($res){
			echo $this->messages('200','Data berhasil Diupdate');
		}else{
			echo $this->messages('422','Data Gagal diupdate');
		}

	}


	private function get_validation($table='',$status=true,$messages =''){
		do{
			if($table==''){
				$messages="Url Table Salah, silakan periksa kembali alamat url";
				break;
			}

			$status = false;
		}while(false);
		if($status==true){
			return $this->messages('422',$messages);
		}else
			return false;
	}

	private function add_validation($request, $messages = '', $status=true){
		$messages 	='Invalid Post data Format';
		$table 	    = $this->uri->segment(3);
		$table_avl  = ['member'];
		do{
			if($table==''){
				$messages = 'No Segment table';
				break;
			}

			if(!in_array($table, $table_avl)){
				$messages = 'No Segment table found. '.$table;
				break;
			}

			if(is_null($request)){
				$messages="No data send";
				break;
			}

			$status = false;
		}while(false);

		if($status==true){
			return $this->messages('409',$messages);
		}else
			return false;
	}

	private function messages($stat,$msg,$data=[]){
		http_response_code($stat);
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		return json_encode([
			'status'=>$stat,
			'message'=>$msg,
			'data'=>$data
		]);
	}
}
