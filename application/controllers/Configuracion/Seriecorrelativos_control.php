<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seriecorrelativos_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Configuracion/Seriecorrelativos_model', 'dto');
    }

    public function index()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Serie Correlativo';
            $datos['contenido'] = 'Seriecorrelativos_view';
            $datos["modulo"] = "Configuracion";
            $filejs = ['Configuracion/seriecorrelativo'];
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
                $row[] = ucfirst(strtoupper($info->comprobante));
                $row[] = ucfirst(strtoupper($info->serie));
                $row[] = ucfirst(strtoupper($info->number_digit));
                $row[] = ucfirst(strtoupper($info->ser_inicia));
                $row[] = ucfirst(strtoupper($info->ser_actual));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_srco(' . "'" . $info->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_srco(' . "'" . $info->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
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
            $nom = $this->input->post('ser_srco');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ser_srco', 'Serie no cumple con los datos requeridos', 'required|min_length[4]|max_length[199]');
            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {

                $data = array(
                    'empresa_id' => $this->session->userdata('ciaid'),
                    'tipocomprobante_id' => $this->input->post('typevoucher_srco'),
                    'serie' => $nom,
                    'number_digit' => $this->input->post('digit_srco'),
                    'ser_inicia' => $this->input->post('start_srco'),
                    'ser_actual' => $this->input->post('last_srco'),
                    'next_number' => $this->input->post('next_srco'),
                    'userid_on' => $this->session->userdata('userid'),
                    'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $insert = $this->dto->save($data);
                if ($insert > 0) {
                    $dato = 'Correctamente, Almacen ';
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

            $nom = $this->input->post('ser_srco');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ser_srco', 'Serie no cumple con los datos requeridos', 'required|min_length[4]|max_length[199]');
            
            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {
                $data = array(
                    'tipocomprobante_id' => $this->input->post('moneda_tcmb'),
                    'serie' => $nom,
                    'number_digit' => $this->input->post('digit_srco'),
                    'ser_inicia' => $this->input->post('start_srco'),
                    'ser_actual' => $this->input->post('last_srco'),
                    'next_number' => $this->input->post('next_srco'),
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
                    $dato = 'Se Actualizo Correctamente';
                    $status = true;
                } else {
                    $dato = 'Fallo!!! ' . $result;
                    $status = false;
                }
                echo json_encode(array("status" => $status, "info" => $dato));
            }
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
    function ajax_all_tipocomprobante()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->dto->get_by_tipocomprobante();
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

    public function get_serco_exist()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos = $this->input->post('dat');
            $data = $this->dto->get_serco_exist($datos);
            if ($data != false) {
                $dato = $data;
                $status = true;
            } else {
                $dato = 'No existe Dato!';
                $status = false;
            }
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }

}
