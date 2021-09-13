<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tiposcambio_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Configuracion/Tiposcambio_model', 'dto');
    }

    public function index()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Tipos Cambio';
            $datos['contenido'] = 'Tiposcambio_view';
            $datos["modulo"] = "Configuracion";
            $filejs = ['Configuracion/tiposcambio'];
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
            foreach ($list as $alm) {
                $no++;
                $row = array();
                $row[] = ucfirst(strtoupper($alm->fecha_at));
                $row[] = ucfirst(strtoupper($alm->moneda));
                $row[] = ucfirst(strtoupper($alm->venta));
                $row[] = ucfirst(strtoupper($alm->compra));
                $row[] = ucfirst(strtoupper($alm->promedio));
                if($alm->activo==1){
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_tcmb(' . "'" . $alm->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_tcmb(' . "'" . $alm->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                }else{
                    $row[] = '<a href="javascript:void()" title="Visualizar" onclick="view_tcmb(' . "'" . $alm->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-oye-open" aria-hidden="true"></span>';   
                }
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
            $nomv = $this->input->post('venta_tcmb');
            $nomc = $this->input->post('compra_tcmb');
            $tcprom = ($nomv + $nomc) / 2;
            $tcprm = number_format($tcprom, 3, "d", "@");
            $this->load->library('form_validation');
            $this->form_validation->set_rules('venta_tcmb', 'Tipo cambio venta', array('trim', 'required', 'min_length[1]', 'regex_match[/(^\d+|^\d+[.]\d+)+$/]'));
            $this->form_validation->set_rules('compra_tcmb', 'Tipo cambio compra', array('trim', 'required', 'min_length[1]', 'regex_match[/(^\d+|^\d+[.]\d+)+$/]'));

            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {
                $datau = array(
                    'activo' => 0,
                    'userid_md' => $this->session->userdata('userid'),
                    'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $wre = array(
                    'moneda_id' => $this->input->post('moneda_tcmb'),
                    'empresa_id' => $this->session->userdata('ciaid'),
                    'enabled' => 1,
                    'activo' => 1,
                );
                $this->dto->update_activa($wre, $datau);
                $data = array(
                    'empresa_id' => $this->session->userdata('ciaid'),
                    'moneda_id' => $this->input->post('moneda_tcmb'),
                    'venta' => $nomv,
                    'compra' => $nomc,
                    'promedio' => $tcprm,
                    'fechatc' => $this->input->post('fecha_tcmb'),
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

            $nomv = $this->input->post('venta_tcmb');
            $nomc = $this->input->post('compra_tcmb');
            $tcprom = ($nomv + $nomc) / 2;
            $tcprm = number_format($tcprom, 3, "d", "@");
            $this->load->library('form_validation');
            $this->form_validation->set_rules('venta_tcmb', 'Tipo cambio venta', array('trim', 'required', 'min_length[1]', 'regex_match[/(^\d+|^\d+[.]\d+)+$/]'));
            $this->form_validation->set_rules('compra_tcmb', 'Tipo cambio compra', array('trim', 'required', 'min_length[1]', 'regex_match[/(^\d+|^\d+[.]\d+)+$/]'));

            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {

                $data = array(
                    'moneda_id' => $this->input->post('moneda_tcmb'),
                    'venta' => $nomv,
                    'compra' => $nomc,
                    'promedio' => $tcprm,
                    'fechatc' => $this->input->post('fecha_tcmb'),
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
    function ajax_all_monedas()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $this->load->model('app/Appvilla_moneda_model', 'mda');
            $data = $this->mda->get_for_Tipocambio();
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
}
