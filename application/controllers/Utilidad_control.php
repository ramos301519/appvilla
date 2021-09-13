<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utilidad_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utilidad_model', 'u');
    }

    public function get_TipoIdentificacion()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->u->get_find_TipoIdentificacion();
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function get_departamentos()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->u->get_departamentos();
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function get_provincias()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $depaid = $this->input->post('depaid', true);
            $depid = $this->security->xss_clean($depaid);
            $data = $this->u->get_provincias($depid);
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function get_distritos()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $depaid = $this->input->post('depaid', true);
            $depid = $this->security->xss_clean($depaid);
            $provid = $this->input->post('provid', true);
            $prvid = $this->security->xss_clean($provid);
            $data = $this->u->get_distritos($depid,$prvid);
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }


}