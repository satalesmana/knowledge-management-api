<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function cek(){
        header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST");
        
        $request  = json_decode(file_get_contents('php://input'),true);
        $data['satatus']=false;
        $data['token'] = '';
        
        if($request['username']=="admin" && $request['password']="admin"){
            $data['satatus']=true;
            $data['token'] = 'Welcome admin';
        }

        echo json_encode($data);
    }
}