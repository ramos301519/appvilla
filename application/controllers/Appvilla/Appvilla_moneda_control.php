<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Appvilla_moneda_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('App/Appvilla_moneda_model', 'mda');
    }

    public function index()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Monedas';
            $datos['contenido'] = 'appvilla_monedas_view';
            $datos["modulo"] = "appvilla";
            $filejs=['Configuracionbase/monedas'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }
    public function ajax_list()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->mda->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $mda) {
                $no++;
                $row = array();
                $row[] = ucfirst(strtoupper($mda->nombre));
                $row[] = ucfirst(strtoupper($mda->sigla));
                $row[] = ucfirst(strtoupper($mda->codigo));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_mda(' . "'" . $mda->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_mda(' . "'" . $mda->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mda->count_all(),
                "recordsFiltered" => $this->mda->count_filtered(),
                "data" => $data,
            );
            //header('Content-type: application/json; charset=utf-8');
            // echo json_encode($datas, JSON_FORCE_OBJECT);
            //echo json_encode($datas);
            //echo json_encode($datas, JSON_UNESCAPED_UNICODE);
            // header('Content-Type: application/json');
            //header("Access-Control-Allow-Origin: *");
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($output);
        } else {
            redirect('salir');
        }
    }

    public function ajax_edit($id)
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->mda->get_by_id($id);
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
//'nombre','sigla','codigo','principal'
    public function ajax_add()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nommda = $this->input->post('nommda');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nommda', 'Nombre de Moneda', 'required|min_length[3]|max_length[145]');
            $this->form_validation->set_rules('sglamda', 'Sigla de moneda', 'required|min_length[1]|max_length[5]');
            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos en el formulario!!!';
            } else {

                $codimda = $this->input->post('codimda');
                $existe = $this->mda->get_moneda_existe($codimda, $nommda);
                if ($existe != false) {
                    $dato = 'Ya existe ' . $nommda;
                    $status = false;
                } else {
                    $data = array(
                        'empresa_id' => $this->session->userdata('ciaid'),
                        'nombre' => $nommda,
                        'sigla' => $this->input->post('sglamda'),
                        'codigo' => $this->input->post('codimda'),
                        'enabled' => 1,
                        'userid_on' => $this->session->userdata('userid'),
                        'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                    );
                    $insert = $this->mda->save($data);
                    if ($insert > 0) {
                        $dato = 'Correctamente, Moneda : ' . $nommda;
                        $status = true;
                    } else {
                        $dato = 'Fallo!!!';
                        $status = false;
                    }
                }
            }
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_update()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nommda = $this->input->post('nommda');
            $codimda = $this->input->post('codimda');
            $id = $this->input->post('id');
            $data = array(
                'nombre' => $nommda,
                'sigla' => $this->input->post('sglamda'),
                'codigo' => $this->input->post('codimda'),
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $id,
                'empresa_id' => $this->session->userdata('ciaid'),
                'enabled' => 1,
            );

            $dato = "";
            $status = false;
            $existe = $this->mda->get_moneda_existe($codimda, $nommda);
            $datoexist = $this->mda->get_principal_codigo();
            if (($datoexist->id == $id) && ($datoexist->icodigod == $codimda)) {
                $result = $this->mda->update($wre, $data);
                if ($result > 0) {
                    $dato = 'Correctamente ' . $nommda . ' ' . $result . ' Fila (s) Actualizado (s)';
                    $status = true;
                } else {
                    $dato = 'Fallo!!! ' . $result;
                    $status = false;
                }
               
            } else if (($datoexist->id == $id) && ($datoexist->icodigod == $codimda)) {
                $result = $this->mda->update($wre, $data);
                if ($result > 0) {
                    $dato = 'Correctamente ' . $nommda . ' ' . $result . ' Fila (s) Actualizado (s)';
                    $status = true;
                } else {
                    $dato = 'Fallo!!! ' . $result;
                    $status = false;
                }
            }else if (($datoexist->id == $id) && ($datoexist->icodigod != $codimda)) {
                $dato = 'El Codigo no es el mismo!!! ' ;
                $status = false;
            }
          
            echo json_encode(array("status" => $status, "info" => $dato));

        } else {
            redirect('salir');
        }
    }

    public function ajax_delete()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('id', true));
            $result = $this->mda->delete_by_id($id);
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
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->mda->get_by_all();
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
