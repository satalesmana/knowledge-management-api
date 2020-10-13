<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ooptugas_model extends CI_Model
{
    public $table='oop_tugas';

    public function add($data){
        $res = $this->db->insert($this->table,$data);
        if($res)
            return true;
        else
            return false;
    }

    public function get(){
        $res = $this->db->get($this->table);
        return $res->result();
    }
    
}