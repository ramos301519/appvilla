<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empresa_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Configuracion/Empresas_model', 'em');
    }

    public function index()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Empresa';
            $datos['contenido'] = 'empresa_view';
            $datos["modulo"] = "Configuracion";
            $filejs=['Configuracion/empresas'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }
    public function ajax_edit()
    {$valid = $this->session->userdata('validated');
        $id = $this->session->userdata('ciaid');
        if ($valid == true) {
            $data = $this->em->get_by_id($id);
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

    public function ajax_update(){
       
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nroiden = $this->input->post('nroidentificacionv');
            $data = array(
                'razon_social' => $this->input->post('nombreempresav'),
                'direccion' => $this->input->post('direccionv'),
                'email' => $this->input->post('correov'),
                'telefono' => $this->input->post('telefonov'),
                'contacto' => $this->input->post('contactov'),
                'departamento_code' => $this->input->post('departamentovce'),
                'provincia_code' => $this->input->post('provinciavce'),
                'distrito_code' => $this->input->post('distritovce'),
                'userid_md' => $this->session->userdata('codiper'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            if (!empty($_FILES['logoev']['name'])) {
                $upload = $this->_do_upload();
                $empresa = $this->em->get_by_id($this->input->post('empresavid'));
                $path = "assest/multimedia/" . $nroiden . "/logo";
                if (file_exists($path . "/" . $empresa->logo) && $empresa->logo) {
                    unlink($path . "/" . $empresa->logo);
                }
                $data['logo'] = $upload;
            }
        
           $result = $this->em->update(array('id' => $this->input->post('empresavid')), $data);
            if ($result > 0) {
                $data = 'Correctamente ' . $nroiden . ' ' . $result . ' Fila (s) Actualizado (s)';
                $dato = $data;
                $status = true;
            } else {
                $dato = 'No se realizo la actualizacion!!!';                
                $status = false;
            }          
            echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }
   

    private function _do_upload()
    {
        $nroiden = $this->input->post('nroidentificacionv');
        $path = "assest/multimedia/" . $nroiden . "/logo";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $config['upload_path'] = $path . '/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;

        $config['file_name'] = round(microtime(true) * 1000);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('logoev')) {
            $data['inputerror'][] = 'logoe';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', '');
            $data['status'] = false;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }


}
