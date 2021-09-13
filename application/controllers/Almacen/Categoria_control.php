<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categoria_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Almacen/categoria_model', 'ctg');
    }

    public function index()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Generar Ventas';
            $datos['contenido'] = 'Almacen_categorias_view';
            $datos["modulo"] = "almacen";
            $filejs=['Almacen/categorias'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

    public function ajax_list()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->ctg->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $ctg) {
                $no++;
                $row = array();
                $color = '<svg width="10" height="10" viewBox="0 0 3 2">
                <rect width="4" height="8" x="0" fill="' . $ctg->color . '" />
              </svg>';
                $row[] = ucfirst(strtoupper($ctg->nombre));
                $row[] = ucfirst(strtoupper($ctg->descripcion));
                $row[] = ucfirst(strtolower('<p>' . $color . '</p>'));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_ctg(' . "'" . $ctg->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_ctg(' . "'" . $ctg->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->ctg->count_all(),
                "recordsFiltered" => $this->ctg->count_filtered(),
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
            $data = $this->ctg->get_by_id($id);
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
            $nomctg = $this->input->post('nomctg');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nomctg', 'Nombre de Categoria', 'required|min_length[3]|max_length[145]');

            if ($this->form_validation->run() == false) {
                $status = false;
                $dato = 'Complete los datos requeridos!!!';
            } else {
                $data = array(
                    'descripcion' => $this->input->post('desctg'),
                    'nombre' => $nomctg,
                    'color' => $this->input->post('colctg'),
                    'empresa_id'=>$this->session->userdata('ciaid'),
                    'userid_on' => $this->session->userdata('userid'),
                    'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $insert = $this->ctg->save($data);
                if ($insert > 0) {
                    $dato = 'Correctamente,  Categoria : ' . $nomctg;
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
            $nomctg = $this->input->post('nomctg');
            $data = array(
                'color' => $this->input->post('colctg'),
                'descripcion' => $this->input->post('desctg'),
                'nombre' => $nomctg,
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('id'),
                'empresa_id'=> $this->session->userdata('ciaid'),
                'enabled' => 1,
            );

            $result = $this->ctg->update($wre, $data);
            if ($result > 0) {
                $dato = 'Correctamente ' . $nomctg . ' ' . $result . ' Fila (s) Actualizado (s)';
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
            $result = $this->ctg->delete_by_id($id);
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
    
    public function categ_ajax_all()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->ctg->get_by_all();
            if ($data != false) {
                $json = array();
                $dato = array();
                $num = count($data);
                if ($num > 0) {
                    for ($g = 0; $g < $num; $g++) {
                        $cad = $data[$g];
                        $id = $cad['id'];
                        $nombre = $cad['nombre'];
                        $dato[] = $id . '#$#' . $nombre;
                    }
                    $json['lista'] = implode("&&&", $dato);
                } else {
                    $json['lista'] = 0;
                }

                $dato = $json;
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
