<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Appvilla_tipoimpuestos_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('App/Appvilla_tipoimpuestos_model', 'mb');
    }

    
    public function index()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Tipos de impuestos';
            $datos['contenido'] = 'appvilla_maestrobase_tipoimpuestos_view';
            $datos["modulo"] = "appvilla";
            $filejs=['Configuracionbase/tipoimpuestos'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

    public function ajax_list()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->mb->get_datatables_ti();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $tipoiden) {
                $no++;
                $row = array();
                $row[] = ucfirst(strtoupper($tipoiden->codigo));
                $row[] = ucfirst(strtoupper($tipoiden->sigla));
                $row[] = ucfirst(strtolower($tipoiden->nombre));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_tpoimp(' . "'" . $tipoiden->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_tpoimp(' . "'" . $tipoiden->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mb->count_allti(),
                "recordsFiltered" => $this->mb->count_filteredti(),
                "data" => $data,
            );
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($output,JSON_UNESCAPED_UNICODE);
        } else {
            redirect('salir');
        }
    }

    public function ajax_edit($id)
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->mb->get_by_idti($id);
            if ($data!=false) {
                $dato = $data;
                $status = true;
            } else {
                $dato = 'Fallo!!!';
                $status = false;
            }
            header('Content-type: application/json; charset=utf-8');        
        echo json_encode(array("status" => $status, "info" => $dato),JSON_UNESCAPED_UNICODE);
        } else {
            redirect('salir');
        }
    }

    public function ajax_add()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nomti = $this->input->post('nomtim');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nomtim', 'Nombre tipo impuesto', 'required|min_length[6]|max_length[45]');
			 
			if ($this->form_validation->run() == FALSE) {
				$dato = 'Complete los datos requeridos!!!';           
            echo json_encode(array("status" => false,"info"=> $dato));
			}else{
            $data = array(
				'parentid'=>33,
                'codigo' => $this->input->post('codetim'),
                'sigla' => $this->input->post('siglatim'),
                'nombre' => $nomti,
                'userid_on' => $this->session->userdata('userid'),
                'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $insert = $this->mb->saveti($data);
            if ($insert > 0) {
                $dato = 'Correctamente,  tipo de identificacion : ' . $nomti;
				$status=true;
            } else {
                $dato = 'Fallo!!!';
				$status=false;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array("status" => $status,"info"=> $dato));
    }
        } else {
            redirect('salir');
        }
    }

    public function ajax_update()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nomti = $this->input->post('nomtim');
            $data = array(
                'codigo' => $this->input->post('codetim'),
                'sigla' => $this->input->post('siglatim'),
                'nombre' => $nomti,
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('idtim'),
                'parentid' => 33,
                'enabled' => 1,
            );

            $result = $this->mb->updateti($wre, $data);
            if ($result > 0) {
                $dato = 'Correctamente ' . $nomti . ' ' . $result . ' Fila (s) Actualizado (s)';
                $status = true;
            } else {
                $dato = 'Fallo!!! ' . $result;
                $status = false;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array("status" => $status, "info" => $dato));         
        } else {
            redirect('salir');
        }
    }

    public function ajax_delete($id)
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('id', true));
            $result = $this->mb->delete_by_idti($id);
            if ($result > 0) {
                $dato = 'Correctamente ' . $result . ' Fila (s) Anulado (s)';
                $status = true;
            } else {
                $dato = 'Fallo!!! ' . $result;
                $status = false;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array("status" => $status, "info" => $dato));            
        } else {
            redirect('salir');
        }
    }

}
