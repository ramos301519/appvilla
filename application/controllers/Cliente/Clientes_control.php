<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cliente/cliente_model', 'c');
    }

    public function index()
    { $valid = $this->session->userdata('validated');
        if ($valid == true) {
        $datos['titulo'] = 'Clientes';
        $datos['contenido'] = 'clientes_view';
        $datos["modulo"] = "clientes";
        $filejs=['Clientes/clientedata'];
        $datos['filesjs'] = $filejs;
        $this->load->view('includes/plantilla', $datos);
    } else {
        redirect('salir');
    }
    }

    public function buscarcliente($id)
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->c->get_find_cliente_word($id);
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
    public function savecliente()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $tipoidenc = $this->security->xss_clean($this->input->post('tipoidenc', true));
            $nrotipoidenc= $this->security->xss_clean($this->input->post('nrotipoidenc', true));
            if ($tipoidenc == '1') {
                $razon_social = $this->security->xss_clean($this->input->post('apellidosc', true)) . '' . $this->security->xss_clean($this->input->post('nombresc', true));
            } else {
                $razon_social = $this->security->xss_clean($this->input->post('razonsocc', true));
            }
            $data = array(
                'empresa_id' => $this->session->userdata('ciaid'),
                'tipoidentificacion_id' => $tipoidenc,
                'numero_identificacion' =>$nrotipoidenc,
                'razon_social' => $razon_social,
                'nombres' => $this->security->xss_clean($this->input->post('nombresc', true)),
                'apellidos' => $this->security->xss_clean($this->input->post('apellidosc', true)),
                'direccion' => $this->security->xss_clean($this->input->post('direccionc', true)),
                'email' => $this->security->xss_clean($this->input->post('correoc', true)),
                'telefono' => $this->security->xss_clean($this->input->post('telefonoc', true)),
                'contacto' => $this->security->xss_clean($this->input->post('contactoc', true)),
                'pais_code'=>'PE',
                'departamento_code' => $this->security->xss_clean($this->input->post('departamentoc', true)),
                'provincia_code' => $this->security->xss_clean($this->input->post('provinciac', true)),
                'distrito_code' => $this->security->xss_clean($this->input->post('contactoc', true)),
                //'enabled' => '1',
                'userid_on' => $this->session->userdata('userid')
                //'fecha_on'=> gmdate("Y-m-d H:i:s", time() - 18000)
            );
            $data = $this->c->set_savecliente($data);
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'Se Presento error '.$data;
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function get_existecliete()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $dat['ti']= $this->security->xss_clean($this->input->post('tipoidenc', true));
            $dat['ni']= $this->security->xss_clean($this->input->post('nrotipoidenc', true));
            $data = $this->c->get_existecliete($dat);
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

    
    public function ajax_list() {
        $list = $this->c->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cliente) {
            $no++;
            $row = array();
            $row[] = ucfirst(strtoupper($cliente->identificacion));
            $row[] = ucfirst($cliente->numero_identificacion);
            $row[] = ucfirst(strtolower($cliente->razon_social));
            $row[] = ucfirst(strtolower($cliente->direccion));
            $row[] = ucfirst(strtolower($cliente->email));
            $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_person(' . "'" . $cliente->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_person(' . "'" . $cliente->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->c->count_all(),
            "recordsFiltered" => $this->c->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->cn_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
       $nomacc= $this->input->post('nomsuc');
        $data = array(
            'nomcn' => $nomacc,
            'usucrcn' => $this->session->userdata('codiper'),
        );
        $insert = $this->cn_model->save($data);
         if ($insert > 0) {
            $dato = 'Correctamente,  Sucursal : ' . $nomacc;
        } else {
            $dato = 'Fallo!!!';
        }
        echo json_encode(array("status" => $dato));
    }

    public function ajax_update() {
       $datmd= $this->input->post('nomsuc');
        $data = array(
            'nomcn' => $datmd,
            'usumdcn' => $this->session->userdata('codiper'),
            'fmdcn' => gmdate("Y-m-d H:i:s", time() - 18000),
        );
        $result = $this->cn_model->update(array('codcn' => $this->input->post('codsuc')), $data);
        if ($result >0) {
            $dato = 'Correctamente '.$datmd.' '.$result.' Fila (s) Actualizado (s)';
        } else {
            $dato = 'Fallo!!!';
        }
        echo json_encode(array("status" => $dato));
    }

    public function ajax_delete($id) {
      $result=  $this->cn_model->delete_by_id($id);
          if ($result>0) {
            $dato = 'Correctamente '.$result.' Fila (s) Anulado (s)';
        } else {
            $dato = 'Fallo!!!';
        }
        echo json_encode(array("status" => $dato));
    }


}
