<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    var $table = 'tbempresas';
    var $tableb = 'tbbasicos';
 
    public function get_by_id($id) {
        $this->db->select('a.id,b.sigla as tipoidentificacion,a.numero_identificacion,a.razon_social,a.direccion,a.email,a.telefono,a.departamento_code,a.provincia_code,a.distrito_code,a.contacto,a.logo');
        $this->db->from($this->table.' a');
        $this->db->join($this->tableb . ' b', 'a.tipoidentificacion_code=b.codigo');
        $this->db->where('a.id', $id);
        $this->db->where('a.enabled', 1);
        $this->db->where('b.parentid', 1);
        $this->db->where('b.enabled', 1);
        $query = $this->db->get();
        return $query->row();
    }

    public function save($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data) {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

}