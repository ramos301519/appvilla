<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subcategoria_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Almacen/Subcategoria_model', 'sbctg');
    }

    public function index()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Sub Categorias';
            $datos['contenido'] = 'Almacen_subcategorias_view';
            $datos["modulo"] = "almacen";
            $filejs=['Almacen/subcategorias'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

    public function ajax_list()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->sbctg->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $sbctg) {
                $no++;
                $row = array();
                $row[] = ucfirst(strtoupper($sbctg->categoria));
                $row[] = ucfirst(strtoupper($sbctg->nombre));
                $row[] = ucfirst(strtoupper($sbctg->descripcion));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_sbctg(' . "'" . $sbctg->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_sbctg(' . "'" . $sbctg->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->sbctg->count_all(),
                "recordsFiltered" => $this->sbctg->count_filtered(),
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
            $data = $this->sbctg->get_by_id($id);
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
            $nomsbctg = $this->input->post('nomsbctg');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('selctg', 'Categoria', 'required');
            $this->form_validation->set_rules('nomsbctg', 'Nombre de Sub Categoria', 'required|min_length[3]|max_length[145]');

            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {
                $data = array(
                    'empresa_id' => $this->session->userdata('ciaid'),
                    'categoria_id' => $this->input->post('selctg'),
                    'nombre' => $nomsbctg,
                    'descripcion' => $this->input->post('descsbctg'),
                    'userid_on' => $this->session->userdata('userid'),
                    'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $insert = $this->sbctg->save($data);
                if ($insert > 0) {
                    $dato = 'Correctamente, Sub Categoria : ' . $nomsbctg;
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
            $nomsbctg = $this->input->post('nomsbctg');
            $data = array(
                'categoria_id' => $this->input->post('selctg'),
                'descripcion' => $this->input->post('descsbctg'),
                'nombre' => $nomsbctg,
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('id'),
                'empresa_id' => $this->session->userdata('ciaid'),
                'enabled' => 1,
            );
            $result = $this->sbctg->update($wre, $data);
            if ($result > 0) {
                $dato = 'Correctamente ' . $nomsbctg . ' ' . $result . ' Fila (s) Actualizado (s)';
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
            $result = $this->sbctg->delete_by_id($id);
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
            $idctg = 0;
            $data = $this->sbctg->get_by_all($idctg);
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
