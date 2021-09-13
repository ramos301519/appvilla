<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public $tablaclie = 'tbclientes';
    public $tablabasic = 'tbbasicos';

    public function get_find_cliente_word($dato)
    {
        $this->db->from($this->tablaclie);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('enabled', 1);
        $this->db->like('numero_identificacion', $dato, 'both');
        $this->db->or_like('razon_social', $dato, 'both');
        $this->db->or_like('nombres', $dato, 'both');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        } else {
            $result = false;
        }
        return $result;

    }
    public function get_find_cliente_id($id)
    {
        $this->db->from($this->tablaclie);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('enabled', 1);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = false;
        }
        return $result;

    }
    public function set_savecliente($data)
    {
        $this->db->insert($this->tablaclie, $data);
        return $this->db->insert_id();
    }
    public function get_existecliete($d)
    {
        $this->db->from($this->tablaclie);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('enabled', 1);
        $this->db->where('tipoidentificacion_id', $d['ti']);
        $this->db->where('numero_identificacion', $d['ni']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = false;
        }
        return $result;
    }

    public $colum = array('id', 'identificacion', 'numero_identificacion', 'razon_social', 'direccion', 'email');
    public $order = array('numero_identificacion' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select('a.id,b.sigla as identificacion,a.numero_identificacion,a.razon_social, a.direccion, a.email');
        $this->db->from($this->tablaclie . ' a');
        $this->db->join($this->tablabasic . ' b', 'a.tipoidentificacion_id=b.codigo');
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('b.parentid', 1);
        $this->db->where('b.enabled', 1);
        $this->db->where('a.enabled', 1);
        $i = 0;
        foreach ($this->colum as $item) {
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
        $this->db->from($this->tablaclie);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('enabled', 1);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->tablaclie);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('enabled', 1);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->tablaclie, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->tablaclie, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->set('enabled', 0);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('enabled', 1);
        $this->db->where('id', $id);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

}
