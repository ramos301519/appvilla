<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Productos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public $tablepro = 'tbproductos';
    public $tablemar = 'tbmarca';
    public $tableproalm = 'tbproductoalmacen';
    public $tablecat = 'tbcategoria';
    public $tablescat = 'tbsubcategoria';
    public $tablepre = 'tbpresentacion';
    public $tableimg = 'tbproductoimanges';
    public $tablemda = 'tbmonedas';
    public $tablealm = 'tbalmacen';
    public $tableproven = 'tbproductovendedor';

    public function get_find_producto_word($dato)
    {
        $this->db->select('a.id,a.sku,a.nombre,a.descripcion,a.caracteristicas,a.precio_venta as precio,a.precio_oferta,c.nombre as marca,d.nombre as categoria,e.nombre as subcategoria,f.nombre as um,g.imagen,h.sigla');
        $this->db->from($this->tablepro . ' a');
        $this->db->join($this->tableproalm . ' b', 'a.id=b.producto_id');
        $this->db->join($this->tablemar . ' c', 'a.marca_id=c.id');
        $this->db->join($this->tablecat . ' d', 'a.categoria_id=d.id');
        $this->db->join($this->tablescat . ' e', 'd.id=e.categoria_id');
        $this->db->join($this->tablepre . ' f', 'a.unidadmedida_id=f.id');
        $this->db->join($this->tableimg . ' g', 'a.id=g.producto_id', 'left outer');
        $this->db->join($this->tablemda . ' h', 'a.moneda_id=h.id');
        $this->db->like('a.sku', $dato, 'both');
        $this->db->or_like('a.nombre', $dato, 'both');
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('b.almacen_id', $this->session->userdata('local_id'));
        $this->db->where('a.enabled', 1);
        $this->db->where('g.flag', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        } else {
            $result = false;
        }
        return $result;

    }
    public function get_find_producto_id($id)
    {
        $this->db->select('a.id,a.sku,a.nombre,a.descripcion,a.caracteristicas,a.precio_venta as precio,a.precio_oferta,c.nombre as marca,d.nombre as categoria,e.nombre as subcategoria,f.nombre as um,g.imagen,h.sigla,b.stock');
        $this->db->from($this->tablepro . ' a');
        $this->db->join($this->tableproalm . ' b', 'a.id=b.producto_id');
        $this->db->join($this->tablemar . ' c', 'a.marca_id=c.id');
        $this->db->join($this->tablecat . ' d', 'a.categoria_id=d.id');
        $this->db->join($this->tablescat . ' e', 'd.id=e.categoria_id');
        $this->db->join($this->tablepre . ' f', 'a.unidadmedida_id=f.id');
        $this->db->join($this->tableimg . ' g', 'a.id=g.producto_id', 'left outer');
        $this->db->join($this->tablemda . ' h', 'a.moneda_id=h.id');
        $this->db->where('a.id', $id);
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('b.almacen_id', $this->session->userdata('local_id'));
        $this->db->where('a.enabled', 1);
        $this->db->where('g.flag', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = false;
        }
        return $result;
    }
    public function get_producto_storage_id($id)
    {
        $this->db->select('a.id,a.sku,a.nombre,a.descripcion,a.caracteristicas,a.precio_venta as precio,a.precio_oferta,c.nombre as marca,d.nombre as categoria,e.nombre as subcategoria,f.nombre as um,g.imagen,h.sigla,b.stock,i.nombre as almacen');
        $this->db->from($this->tablepro . ' a');
        $this->db->join($this->tableproalm . ' b', 'a.id=b.producto_id');
        $this->db->join($this->tablemar . ' c', 'a.marca_id=c.id');
        $this->db->join($this->tablecat . ' d', 'a.categoria_id=d.id');
        $this->db->join($this->tablescat . ' e', 'd.id=e.categoria_id');
        $this->db->join($this->tablepre . ' f', 'a.unidadmedida_id=f.id');
        $this->db->join($this->tableimg . ' g', 'a.id=g.producto_id', 'left outer');
        $this->db->join($this->tablemda . ' h', 'a.moneda_id=h.id');
        $this->db->join($this->tablealm . ' i', 'b.almacen_id=i.id');
        $this->db->where('a.id', $id);
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('b.almacen_id <>', $this->session->userdata('local_id'));
        $this->db->where('a.enabled', 1);
        $this->db->where('g.flag', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        } else {
            $result = false;
        }
        return $result;
    }

    public function get_stock_categoria()
    {
        $this->db->select('c.nombre as categoria,sum(b.stock) as stock,c.color');
        $this->db->from($this->tablepro . ' a');
        $this->db->join($this->tableproalm . ' b', 'a.id=b.producto_id');
        $this->db->join($this->tablecat . ' c', 'a.categoria_id=c.id');
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('b.almacen_id', $this->session->userdata('local_id'));
        $this->db->where('a.enabled', 1);
        $this->db->group_by('c.nombre');
        $this->db->order_by('b.stock', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        } else {
            $result = false;
        }
        return $result;
    }
    public function get_productovendedor()
    {
        $this->db->select('a.id,a.producto_id,a.color,b.nombre,c.stock');
        $this->db->from($this->tableproven . ' a');
        $this->db->join($this->tablepro . ' b', 'a.producto_id=b.id');
        $this->db->join($this->tableproalm . ' c', 'a.almacen_id=c.almacen_id and a.producto_id=c.producto_id');
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('a.almacen_id', $this->session->userdata('local_id'));
        $this->db->where('a.user_id', $this->session->userdata('userid'));
        $this->db->where('a.enabled', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        } else {
            $result = false;
        }
        return $result;
    }
    public function get_productovendedor_id($id)
    {
        $this->db->select('a.id,a.producto_id,a.color');
        $this->db->from($this->tableproven . ' a');
        $this->db->where('a.producto_id', $id);
        $this->db->where('a.empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('a.almacen_id', $this->session->userdata('local_id'));
        $this->db->where('a.user_id', $this->session->userdata('userid'));
        $this->db->where('a.enabled', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = false;
        }
        return $result;
    }
    public function get_productovendedor_show()
    {
       
        $sql = "select j.id,a.id as producto_id, a.sku, a.nombre, a.descripcion, a.caracteristicas, a.precio_venta as precio, a.precio_oferta, c.nombre as marca, d.nombre as categoria, e.nombre as subcategoria, f.nombre as um, g.imagen, h.sigla, b.stock, i.nombre as almacen,(case when a.id=j.producto_id and j.enabled=0 then 'A' when a.id=j.producto_id and j.enabled=1 then 'I' else 'A' end) AS favorito FROM tbproductos a JOIN tbproductoalmacen b ON a.id=b.producto_id JOIN tbmarca c ON a.marca_id=c.id JOIN tbcategoria d ON a.categoria_id=d.id JOIN tbsubcategoria e ON d.id=e.categoria_id JOIN tbpresentacion f ON a.unidadmedida_id=f.id LEFT OUTER JOIN tbproductoimanges g ON a.id=g.producto_id JOIN tbmonedas h ON a.moneda_id=h.`id` JOIN `tbalmacen` `i` ON `b`.`almacen_id`=`i`.`id` left JOIN tbproductovendedor j on a.id=j.producto_id WHERE a.empresa_id =".$this->session->userdata('ciaid')." AND b.almacen_id = ".$this->session->userdata('local_id')." AND a.enabled = 1 AND g.flag = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        } else {
            $result = false;
        }
        return $result;
    }

    public function save_productovendedor($id)
    {
        $this->db->set('empresa_id', $this->session->userdata('ciaid'));
        $this->db->set('almacen_id', $this->session->userdata('local_id'));
        $this->db->set('user_id', $this->session->userdata('userid'));
        $this->db->set('producto_id', $id);
        $this->db->set('userid_on', $this->session->userdata('userid'));
        $this->db->set('fecha_on', gmdate("Y-m-d H:i:s", time() - 18000));
        $result = $this->db->insert($this->tableproven);
        if ($result > 0) {
            $result = $this->db->insert_id();
        } else {
            $result = false;
        }
        return $result;
    }
    public function delete_productovendedor($id)
    {
        $this->db->set('enabled', 0);
        $this->db->set('fecha_del', gmdate("Y-m-d H:i:s", time() - 18000));
        $this->db->where('id', $id);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('almacen_id', $this->session->userdata('local_id'));
        $this->db->where('user_id', $this->session->userdata('userid'));
        $this->db->where('enabled', 1);
        $this->db->update($this->tableproven);
        $id = $this->db->affected_rows();
        if ($id > 0) {
            $result = $id;
        } else {
            $result = false;
        }
        return $result;
    }
    public function update_productovendedor($id)
    {
        $this->db->set('enabled', 1);
        $this->db->set('userid_md', $this->session->userdata('userid'));
        $this->db->set('fecha_md', gmdate("Y-m-d H:i:s", time() - 18000));
        $this->db->where('id', $id);
        $this->db->where('empresa_id', $this->session->userdata('ciaid'));
        $this->db->where('almacen_id', $this->session->userdata('local_id'));
        $this->db->where('user_id', $this->session->userdata('userid'));
        $this->db->where('enabled', 0);
        $this->db->update($this->tableproven);
        $id = $this->db->affected_rows();
        if ($id > 0) {
            $result = $id;
        } else {
            $result = false;
        }
        return $result;
    }

}
