<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Impuestos_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Configuracion/Impuestos_model', 'dto');

        $this->load->model('App/Appvilla_tipoimpuestos_model', 'tim');
    }

    public function index()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Impuestos';
            $datos['contenido'] = 'Impuestos_view';
            $datos["modulo"] = "Configuracion";
            $filejs = ['Configuracion/impuestos'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

    public function ajax_list()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->dto->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $info) {
                $no++;
                $row = array();
                $row[] = $info->impuesto;
                $row[] = ucfirst(strtoupper($info->sigla));
                $row[] = ucfirst(strtolower($info->nombretimp));
                $row[] = ucfirst(strtoupper($info->nombrecatimp));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_imp(' . "'" . $info->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_imp(' . "'" . $info->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->dto->count_all(),
                "recordsFiltered" => $this->dto->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        } else {
            redirect('salir');
        }
    }

    public function ajax_edit($id)
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->dto->get_by_id($id);
            if ($data != false) {
                $dato = $data;
                $status = true;
            } else {
                $dato = 'Fallo!!!';
                $status = false;
            }
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_add()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nom = $this->input->post('porcimp');
            $cattipimp = $this->input->post('cate_imp');
            $cattimp = $cattipimp == "" ? '99' : $cattipimp;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('porcimp', 'El Porcentaje', array('trim','required','min_length[1]','regex_match[/(^\d+|^\d+[.]\d+)+$/]'));

            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {
                $data = array(
                    'empresa_id' => $this->session->userdata('ciaid'),
                    'tipoimpuesto_id' => $this->input->post('tipoimpuesto'),
                    'categoria_impuesto_id' => $cattimp,
                    'impuesto' => $nom,
                    'fecha_at' => $this->input->post('impfeact'),
                    'userid_on' => $this->session->userdata('userid'),
                    'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $insert = $this->dto->save($data);
                if ($insert > 0) {
                    $dato = 'Correctamente registrado';
                    $status = true;
                } else {
                    $dato = 'Fallo!!!';
                    $status = false;
                }
            }
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_update()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nom = $this->input->post('porcimp');
            $cattipimp = $this->input->post('cate_imp');
            $cattimp = $cattipimp == "" ? '99' : $cattipimp;

            $data = array(
                'tipoimpuesto_id' => $this->input->post('tipoimpuesto'),
                'categoria_impuesto_id' => $cattimp,
                'impuesto' => $nom,
                'fecha_at' => $this->input->post('impfeact'),
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('id'),
                'empresa_id' => $this->session->userdata('ciaid'),
                'enabled' => 1,
            );

            $result = $this->dto->update($wre, $data);
            if ($result > 0) {
                $dato = 'Correctamente Actualizado ';
                $status = true;
            } else {
                $dato = 'Fallo!!! ' . $result;
                $status = false;
            }
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_delete()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('id', true));
            $result = $this->dto->delete_by_id($id);
            if ($result > 0) {
                $dato = 'Correctamente ' . $result . ' Fila (s) Anulado (s)';
                $status = true;
            } else {
                $dato = 'Fallo!!! ' . $result;
                $status = false;
            }
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }
    public function ajax_all()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->dto->get_by_all();
            if ($data != false) {
                $dato = $data;
                $status = true;
            } else {
                $dato = 'Fallo!!!';
                $status = false;
            }
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }
    public function ajax_all_tim()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->tim->get_by_all_ti();
            if ($data != false) {
                $dato = $data;
                $status = true;
            } else {
                $dato = 'Fallo!!!';
                $status = false;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }
    public function ajax_all_tim_cat()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->tim->get_by_all_ti_cat();
            if ($data != false) {
                $dato = $data;
                $status = true;
            } else {
                $dato = 'Fallo!!!';
                $status = false;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }
}
