<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Utilidad_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    var $tablebasic = 'tbbasicos';
    
   
    function get_find_TipoIdentificacion(){
        $this->db->select('codigo,sigla,nombre');
        $this->db->from($this->tablebasic);   
        $this->db->where('parentid', 1);
        $this->db->where('enabled', 1);
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            $result= $query->result_array();
        } else {
            $result=false;
        }
        return $result;    
       }
       var $tabledepa = 'tbdepartamentos';
       function get_departamentos(){
        $this->db->select('id,name');
        $this->db->from($this->tabledepa);
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            $result= $query->result_array();
        } else {
            $result=false;
        }
        return $result;    
       }

var $tablprovi = 'tbprovincias';
       function get_provincias($id){
        $this->db->select('id,name');
        $this->db->from($this->tablprovi);
        $this->db->where('departamento_id', $id);
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            $result= $query->result_array();
        } else {
            $result=false;
        }
        return $result;    
       }
       var $tabldist = 'tbdistritos';
       function get_distritos($idd,$idp){
        $this->db->select('id,name');
        $this->db->from($this->tabldist);
        $this->db->where('provincia_id', $idp);
        $this->db->where('departamento_id', $idd);
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            $result= $query->result_array();
        } else {
            $result=false;
        }
        return $result;    
       }

}