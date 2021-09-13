<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seriecorrelativos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    var $table = 'tbseriecorrelativo';
    var $tableb = 'tbbasicos';
    var $column = array('comprobante','serie','number_digit','ser_inicia','ser_actual');
    var $order = array('comprobante'=>'asc');

    private function _get_datatables_query() {
        $this->db->select('a.id,b.nombre as comprobante,a.serie,a.number_digit,a.ser_inicia,a.ser_actual');
        $this->db->from($this->table.' a'); 
        $this->db->join($this->tableb . ' b', 'a.tipocomprobante_id=b.codigo');      
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('a.enabled', 1);
        $this->db->where('b.parentid', 12);
        $this->db->order_by('b.nombre', 'DESC');
        $i = 0;
        foreach ($this->column as $item) {
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

    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->table);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
         $this->db->where('enabled', 1);
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        $this->db->from($this->table);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('id', $id);
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
    public function get_serco_exist($dat) {
        $this->db->from($this->table);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('enabled', 1);
        $this->db->where('tipocomprobante_id', $dat['tcomp_id']);
        $this->db->where('serie', $dat['serie']);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete_by_id($id) {
        $this->db->set('enabled', 0);
        $this->db->set('fecha_del',gmdate("Y-m-d H:i:s", time() - 18000));
        $this->db->where('id', $id);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }
    public function get_by_tipocomprobante() {
        $this->db->select('id,codigo,sigla,nombre');
        $this->db->from($this->tableb);
        $this->db->where('parentid', 12);
        $this->db->where('enabled', 1);
        $query = $this->db->get();
        return $query->result();
    }
 

}
?>