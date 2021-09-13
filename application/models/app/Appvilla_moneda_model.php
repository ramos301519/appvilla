<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Appvilla_moneda_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public $table = 'tbmonedas';
    public $column = array('nombre', 'sigla', 'codigo');
    public $order = array('nombre' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select('a.id,a.nombre,a.sigla,a.codigo');
        $this->db->from($this->table . ' a');
        $this->db->where('a.enabled', 1);
        $i = 0;
        foreach ($this->column as $item) {
            if ($_POST['search']['value']) {
                ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            }
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

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('enabled', 1);
        return $this->db->count_all_results();
    }
    public function get_moneda_existe($codigo,$nombre)
    {
        $this->db->from($this->table);
        $this->db->where('codigo', $codigo);
        $this->db->where('nombre', $nombre);        
        $this->db->where('enabled', 1);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0) {
            $result = $consulta->row();
        } else {
            $result = false;
        }
        return $result;
    }
   
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
        
    }

    public function delete_by_id($id)
    {
        $this->db->set('enabled', 0);
        $this->db->set('fecha_del', gmdate("Y-m-d H:i:s", time() - 18000));
        $this->db->where('id', $id);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }
    public function get_by_all()
    {
        $this->db->select('id,sigla,nombre');
        $this->db->from($this->table);
        $this->db->where('enabled', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_for_Tipocambio()
    {
        $this->db->select('id,sigla,codigo,nombre');
        $this->db->from($this->table);
        $this->db->where('enabled', 1);
        $this->db->where('codigo<>', 'PEN');
        $query = $this->db->get();
        return $query->result();
    }

}
