<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Appvilla_tipoimpuestos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    var $tablebasic = 'tbbasicos';
    var $colum = array('id','codigo','sigla','nombre');
    var $order = array('codigo' => 'desc');

    private function _get_datatables_queryti() {
        $this->db->select('id,codigo,sigla, nombre');
        $this->db->from($this->tablebasic);
        $this->db->where('parentid', 33);
        $this->db->where('enabled', 1);
        $i = 0;
        foreach ($this->colum as $item) {
            if ($_POST['search']['value'])
                ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_ti() {
        $this->_get_datatables_queryti();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filteredti() {
        $this->_get_datatables_queryti();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_allti() {
        $this->db->from($this->tablebasic);
         $this->db->where('enabled', 1);
        return $this->db->count_all_results();
    }

    public function get_by_idti($id) {
        $this->db->from($this->tablebasic);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function saveti($data) {
        $this->db->insert($this->tablebasic, $data);
        return $this->db->insert_id();
    }

    public function updateti($where, $data) {
        $this->db->update($this->tablebasic, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_idti($id) {
        $this->db->set('fecha_del', gmdate("Y-m-d H:i:s", time() - 18000));
    $this->db->set('enabled', 0);
        $this->db->where('id', $id);
        $this->db->update($this->tablebasic);
        return $this->db->affected_rows();
    }
    public function get_by_all_ti() {       
        $this->db->select('codigo,sigla, nombre');
        $this->db->from($this->tablebasic); 
        $this->db->where('parentid', 33);
        $this->db->where('enabled', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_by_all_ti_cat() {       
        $this->db->select('codigo,nombre');
        $this->db->from($this->tablebasic); 
        $this->db->where('parentid', 42);
        $this->db->where('enabled', 1);
        $this->db->where('codigo !=', 99);
        $query = $this->db->get();
        return $query->result();
    }

}
