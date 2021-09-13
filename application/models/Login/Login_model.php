<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public $tableuser = 'tbusuarios';
    public $tableuseremp = 'tbusuario_empresa';
    public $tableemp = 'tbempresas';
    public $tablecolab = 'tbcolaboradores';
    public $tabletda = 'tbtienda';
    public $tabletc = 'tbtiposcambio';
    public $tablemon = 'tbmonedas';
    public $tablemonemp = 'tbempresamonedas';

    public function validaLoguin($emailusua, $password)
    {
        $rpt = '';
        $data = '';
        $this->db->from($this->tableuser);
        $this->db->where('correo', trim($emailusua));
        $this->db->where('password', trim($password));
        $this->db->where('enabled', 1);
        $query = $this->db->get();
        $numrows = $query->num_rows();
        if ($numrows == 1) {
            $row = $query->row();

            if ($row->flag == 1) {
                //Empresa y usuario
                $this->db->select('b.id,b.razon_social,numero_identificacion,logo');
                $this->db->from($this->tableuseremp . ' a');
                $this->db->join($this->tableemp . ' b', 'a.empresa_id=b.id');
                $this->db->where('a.usuario_id', $row->id);
                $this->db->where('b.enabled', 1);
                $query1 = $this->db->get();
                $row1 = $query1->row();
//perfil y colaborador
                $this->db->select('c.cargo_id,x.nombre,c.local_id');
                $this->db->from($this->tablecolab . ' c');
                $this->db->join($this->tabletda . ' x', 'c.local_id=x.id');
                $this->db->where('c.empresa_id', $row1->id);
                $this->db->where('c.user_id', $row->id);
                $query2 = $this->db->get();
                $row2 = $query2->row();
                $numrows = $query2->num_rows();
                //tipocambio
                $this->db->select('venta as tipocambio');
                $this->db->from($this->tabletc);
                $this->db->where('empresa_id', $row1->id);
                $this->db->where('fechatc<=', gmdate("Y-m-d", time() - 18000));
                $this->db->where('enabled', 1);
                $this->db->order_by('venta', 'desc');
                $this->db->limit(1);
                $query3 = $this->db->get();
                $row3 = $query3->row();
                //moneda
                $this->db->select('m.id as moneda_id,sigla,m.codigo,m.nombre');
                $this->db->from($this->tablemon . ' m');
                $this->db->join($this->tablemonemp . ' e', 'm.id=e.moneda_id');
                $this->db->where('e.empresa_id', $row1->id);
                $this->db->where('e.principal', 1);
                $this->db->where('e.enabled', 1);
                $query4 = $this->db->get();
                $row4 = $query4->row();

                $local_id = 0;
                $local_nom = null;
                if ($numrows == 1) {
                    $local_id = $row2->local_id;
                    $local_nom = $row2->nombre;
                }
                $moneda = ["moneda_id" => $row4->moneda_id, "moneda_sigla" => $row4->sigla, "moneda_codigo" => $row4->codigo, "moneda_nombre" => $row4->nombre];
                $data = array(
                    'flag' => $row->flag,
                    'userid' => $row->id,
                    'usuaper' => $row->name,
                    'ciaid' => $row1->id,
                    'ciaiden' => $row1->numero_identificacion,
                    'cianom' => $row1->razon_social,
                    'cialogo' => $row1->logo,
                    'local_id' => $local_id,
                    'local_nom' => $local_nom,
                    'perfil' => 1,
                    'validated' => true,
                    'tipocambio' => $row3->tipocambio,
                    'moneda' => $moneda,
                );

            } else {
                $data = array(
                    'flag' => $row->flag,
                    'userid' => $row->id,
                    'usuaper' => $row->name,
                    'perfil' => 1,
                    'validated' => true,

                );

            }
            $this->session->set_userdata($data);
            $rpt = true;
        } else {
            $rpt = false;
        }
        return $rpt;
    }

}
