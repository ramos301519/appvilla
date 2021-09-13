<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tiendas_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Configuracion/Tiendas_model', 't');
    }

    public function index()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Tiendas';
            $datos['contenido'] = 'Tiendas_view';
            $datos["modulo"] = "Configuracion";
            $filejs = ['Configuracion/tiendas'];
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
            $list = $this->t->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $td) {
                $no++;
                $row = array();
                $row[] = ucfirst(strtoupper($td->nombre));
                $row[] = ucfirst(strtoupper($td->direccion));
                $row[] = ucfirst(strtoupper($td->telefono));
                $row[] = ucfirst(strtoupper($td->email));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_tda(' . "'" . $td->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_tda(' . "'" . $td->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->t->count_all(),
                "recordsFiltered" => $this->t->count_filtered(),
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
            $data = $this->t->get_by_id($id);
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
            $nom = $this->input->post('nomtda');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nomtda', 'Nombre de Tienda', 'required|min_length[4]|max_length[199]');

            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {
                $data = array(
                    'empresa_id' => $this->session->userdata('ciaid'),
                    'nombre' => $nom,
                    'direccion' => $this->input->post('diretda'),
                    'telefono' => $this->input->post('telftda'),
                    'email' => $this->input->post('emailtda'),
                    'userid_on' => $this->session->userdata('userid'),
                    'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $insert = $this->t->save($data);
                if ($insert > 0) {
                    $dato = 'Correctamente, Tienda : ' . $nom;
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
            $nommk = $this->input->post('nomtda');
            $data = array(
                'nombre' => $nommk,
                'direccion' => $this->input->post('diretda'),
                'telefono' => $this->input->post('telftda'),
                'email' => $this->input->post('emailtda'),
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('id'),
                'empresa_id' => $this->session->userdata('ciaid'),
                'enabled' => 1,
            );

            $result = $this->t->update($wre, $data);
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
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('id', true));
            $result = $this->t->delete_by_id($id);
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
            $data = $this->t->get_by_all();
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
