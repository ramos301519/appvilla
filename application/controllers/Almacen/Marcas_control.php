<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marcas_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Almacen/Marcas_model', 'mk');
    }

    public function index()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Marcas';
            $datos['contenido'] = 'Almacen_marcas_view';
            $datos["modulo"] = "almacen";
            $filejs=['Almacen/marcas'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

    public function ajax_list()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->mk->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $mk) {
                $no++;
                $row = array();
                $row[] = ucfirst(strtoupper($mk->nombre));
                $row[] = ucfirst(strtoupper($mk->descripcion));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_mk(' . "'" . $mk->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_mk(' . "'" . $mk->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mk->count_all(),
                "recordsFiltered" => $this->mk->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        } else {
            redirect('salir');
        }
    }

    public function ajax_edit($id)
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->mk->get_by_id($id);
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
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nommk = $this->input->post('nommk');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nommk', 'Nombre de marca', 'required|min_length[3]|max_length[145]');

            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {
                $data = array(
                    'empresa_id' => $this->session->userdata('ciaid'),
                    'nombre' => $nommk,
                    'descripcion' => $this->input->post('descmk'),
                    'userid_on' => $this->session->userdata('userid'),
                    'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $insert = $this->mk->save($data);
                if ($insert > 0) {
                    $dato = 'Correctamente, Marcas : ' . $nommk;
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
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nommk = $this->input->post('nommk');
            $data = array(                
                'nombre' => $nommk,
                'descripcion' => $this->input->post('descmk'),
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('id'),
                'empresa_id' => $this->session->userdata('ciaid'),
                'enabled' => 1,
            );

            $result = $this->mk->update($wre, $data);
            if ($result > 0) {
                $dato = 'Correctamente ' . $nommk . ' ' . $result . ' Fila (s) Actualizado (s)';
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
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('id', true));
            $result = $this->mk->delete_by_id($id);
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
            $data = $this->mk->get_by_all();
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
