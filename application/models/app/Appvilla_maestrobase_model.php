<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appvilla_maestrobase_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    var $tablebasic = 'tbbasicos';
    var $colum = array('id','codigo','sigla','nombre');
    var $order = array('codigo' => 'desc');

    private function _get_datatables_queryti() {
        $this->db->select('id,codigo,sigla, nombre');
        $this->db->from($this->tablebasic);
        $this->db->where('parentid', 1);
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
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_idti($id) {
        $this->db->set('fecha_del', gmdate("Y-m-d H:i:s", time() - 18000));
    $this->db->set('enabled', 0);
        $this->db->where('id', $id);
        $this->db->update($this->tablebasic);
        return $this->db->affected_rows();
    }

/*tipo comprobante*/

var $columtc = array('id','codigo','sigla','nombre');
var $ordertc = array('codigo' => 'desc');

private function _get_datatables_querytc() {
    $this->db->select('id,codigo,sigla, nombre');
    $this->db->from($this->tablebasic);
    $this->db->where('parentid', 12);
    $this->db->where('enabled', 1);
    $i = 0;
    foreach ($this->columtc as $item) {
        if ($_POST['search']['value'])
            ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
        $column[$i] = $item;
        $i++;
    }

    if (isset($_POST['order'])) {
        $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->ordertc)) {
        $order = $this->ordertc;
        $this->db->order_by(key($order), $order[key($order)]);
    }
}

function get_datatables_tc() {
    $this->_get_datatables_querytc();
    if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
}

function count_filteredtc() {
    $this->_get_datatables_querytc();
    $query = $this->db->get();
    return $query->num_rows();
}

public function count_alltc() {
    $this->db->from($this->tablebasic);
     $this->db->where('enabled', 1);
    return $this->db->count_all_results();
}

public function get_by_idtc($id) {
    $this->db->from($this->tablebasic);
    $this->db->where('id', $id);
    $query = $this->db->get();

    return $query->row();
}

public function savetc($data) {
    $this->db->insert($this->tablebasic, $data);
    return $this->db->insert_id();
}

public function updatetc($where, $data) {
    $this->db->update($this->tablebasic, $data, $where);
    return $this->db->affected_rows();
}

public function delete_by_idtc($id) {
    $this->db->set('fecha_del', gmdate("Y-m-d H:i:s", time() - 18000));
    $this->db->set('enabled', 0);
    $this->db->where('id', $id);
    $this->db->update($this->tablebasic);
    return $this->db->affected_rows();
}

/*Modalidad de Pago*/

var $colummp = array('id','codigo','sigla','nombre');
var $ordermp = array('codigo' => 'desc');

private function _get_datatables_querymp() {
    $this->db->select('id,codigo,sigla, nombre');
    $this->db->from($this->tablebasic);
    $this->db->where('parentid', 8);
    $this->db->where('enabled', 1);
    $i = 0;
    foreach ($this->colummp as $item) {
        if ($_POST['search']['value'])
            ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
        $colummp[$i] = $item;
        $i++;
    }

    if (isset($_POST['order'])) {
        $this->db->order_by($colummp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->ordermp)) {
        $order = $this->ordermp;
        $this->db->order_by(key($order), $order[key($order)]);
    }
}

function get_datatables_mp() {
    $this->_get_datatables_querymp();
    if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
}

function count_filteredmp() {
    $this->_get_datatables_querymp();
    $query = $this->db->get();
    return $query->num_rows();
}

public function count_allmp() {
    $this->db->from($this->tablebasic);
     $this->db->where('enabled', 1);
    return $this->db->count_all_results();
}

public function get_by_idmp($id) {
    $this->db->from($this->tablebasic);
    $this->db->where('id', $id);
    $query = $this->db->get();

    return $query->row();
}

public function savemp($data) {
    $this->db->insert($this->tablebasic, $data);
    return $this->db->insert_id();
}

public function updatemp($where, $data) {
    $this->db->update($this->tablebasic, $data, $where);
    return $this->db->affected_rows();
}

public function delete_by_idmp($id) {
    $this->db->set('fecha_del', gmdate("Y-m-d H:i:s", time() - 18000));
    $this->db->set('enabled', 0);
    $this->db->where('id', $id);
    $this->db->update($this->tablebasic);
    return $this->db->affected_rows();
}

/*Unidad de pago*/

var $columum = array('id','codigo','sigla','nombre');
var $orderum = array('codigo' => 'desc');

private function _get_datatables_queryum() {
    $this->db->select('id,codigo,sigla, nombre');
    $this->db->from($this->tablebasic);
    $this->db->where('parentid', 26);
    $this->db->where('enabled', 1);
    $i = 0;
    foreach ($this->columum as $item) {
        if ($_POST['search']['value'])
            ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
        $columum[$i] = $item;
        $i++;
    }

    if (isset($_POST['order'])) {
        $this->db->order_by($columum[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->orderum)) {
        $order = $this->orderum;
        $this->db->order_by(key($order), $order[key($order)]);
    }
}

function get_datatables_um() {
    $this->_get_datatables_queryum();
    if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
}

function count_filteredum() {
    $this->_get_datatables_queryum();
    $query = $this->db->get();
    return $query->num_rows();
}

public function count_allum() {
    $this->db->from($this->tablebasic);
     $this->db->where('enabled', 1);
    return $this->db->count_all_results();
}

public function get_by_idum($id) {
    $this->db->from($this->tablebasic);
    $this->db->where('id', $id);
    $query = $this->db->get();

    return $query->row();
}

public function saveum($data) {
    $this->db->insert($this->tablebasic, $data);
    return $this->db->insert_id();
}

public function updateum($where, $data) {
    $this->db->update($this->tablebasic, $data, $where);
    return $this->db->affected_rows();
}

public function delete_by_idum($id) {
    $this->db->set('fecha_del', gmdate("Y-m-d H:i:s", time() - 18000));
    $this->db->set('enabled', 0);
    $this->db->where('id', $id);
    $this->db->update($this->tablebasic);
    return $this->db->affected_rows();
}

}