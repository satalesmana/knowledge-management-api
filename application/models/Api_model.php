<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model
{
    public $table='oop_tugas';

    public function add($data,$table=''){
        if($table !='')
            $this->table = $table;

        $res = $this->db->insert($this->table,$data);
        if($res)
            return true;
        else
            return false;
    }

    public function get($table=''){
        if($table !='')
            $this->table = $table;

        $res = $this->db->get($this->table);
        return $res->result();
    }

    public function edit($table='',$id=0){
        if($table !='')
            $this->table = $table;
        
            $this->db->where('id',$id);
            $res =  $this->db->get($this->table);
            return $res->result();
    }

    public function get_trans($table,$filds=array(),$joins,$filter=array(),$group=''){
        $this->db->select($filds)
                    ->from($table);

        if(count($joins)> 0){
            foreach($joins as $join){
                $this->db->join($join['table'],$join['key']);
            }
        }

        if(count($filter)>0){
            $this->db->where($filter);
        }

        if($group !='')
            $this->db->group_by($group);

        $row = $this->db->get();
        
        return $row->result();
        
    }

    
    
}