<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Appvilla_empresa_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('app/Appvilla_empresas_model', 'e');
        $this->load->model('User/User_model', 'u');
       // $this->load->helper('general_helpers');
    }
    public function index()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Appvilla';
            $datos['contenido'] = 'appvilla_empresa_view';
            $datos["modulo"] = "appvilla";
            $filejs=['ConfiguracionApp/appempresas'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

    public function ajax_list_emp()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->e->get_datatables_emp();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $emp) {
                $no++;
                //'numero_identificacion','razon_social','direccion','email','telefono','contacto','logo'
                $row = array();
                $row[] = ucfirst(strtolower($emp->numero_identificacion));
                $row[] = ucfirst(strtolower($emp->razon_social));
                $row[] = ucfirst(strtolower($emp->email));
                $row[] = ucfirst(strtolower($emp->telefono));
                $row[] = ucfirst(strtolower($emp->contacto));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_empresa(' . "'" . $emp->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_empresa(' . "'" . $emp->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->e->count_all(),
                "recordsFiltered" => $this->e->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        } else {
            redirect('salir');
        }
    }

    public function ajax_edit($id)
    {
        $data = $this->e->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add(){              
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nroidentificacione = $this->input->post('nroidentificacione');
            $data = array(
                'tipoidentificacion_code' => $this->input->post('tipoidentificacione'),
                'numero_identificacion' => $nroidentificacione,
                'razon_social' => $this->input->post('nombreempresae'),
                'direccion' => $this->input->post('direccione'),
                'email' => $this->input->post('correoe'),
                'telefono' => $this->input->post('telefonoe'),
                'contacto' => $this->input->post('contactoe'),
                'pais_code' => 'PE',
                'departamento_code' => $this->input->post('departamentoe'),
                'provincia_code' => $this->input->post('provinciae'),
                'distrito_code' => $this->input->post('distritoe'),
                'userid_on' => $this->session->userdata('userid'),
            );
            if (!empty($_FILES['logoe']['name'])) {
                $upload = $this->_do_upload();
                $data['logo'] = $upload;
            }
            $insert = $this->e->save($data);
          /*  $numcaract = $nroidentificacione;
            $pass = generatePassword($numcaract);
            $password = password_hash($pass, PASSWORD_BCRYPT);
            $remember_token = fRand(61);
            $regusr = array(
                'perfil_id' => 3,
                'name' => 'Manager',
                'correo' => $this->input->post('correoe'),
                'password' => $password,
                'remember_token' => $remember_token,
                'userid_on' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $insert = $this->u->save($regusr);
*/
            if ($insert > 0) {
                $dato = 'Correctamente,  Empresa : ' . $nroidentificacione;
            } else {
                $dato = 'Fallo!!!';
            }
            echo json_encode(array("status" => $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_update(){
       
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nroiden = $this->input->post('nroidentificacione');
            $data = array(
                'razon_social' => $this->input->post('nombreempresae'),
                'direccion' => $this->input->post('direccione'),
                'email' => $this->input->post('correoe'),
                'telefono' => $this->input->post('telefonoe'),
                'contacto' => $this->input->post('contactoe'),
                'departamento_code' => $this->input->post('departamentoe'),
                'provincia_code' => $this->input->post('provinciae'),
                'distrito_code' => $this->input->post('distritoe'),
                'userid_md' => $this->session->userdata('codiper'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            if (!empty($_FILES['logoe']['name'])) {
                $upload = $this->_do_upload();
                $empresa = $this->e->get_by_id($this->input->post('empresaid'));
                $path = "assest/multimedia/" . $nroiden . "/logo";
                if (file_exists($path . "/" . $empresa->logo) && $empresa->logo) {
                    unlink($path . "/" . $empresa->logo);
                }
                $data['logo'] = $upload;
            }
          /*  $pass = generatePassword($nroiden);
            $password = password_hash($pass, PASSWORD_BCRYPT);
            $remember_token = fRand(61);
            $regusr = array(
                'perfil_id' => 3,
                'name' => 'Manager',
                'correo' => $this->input->post('correoe'),
                'password' => $password,
                'remember_token' => $remember_token,
                'userid_on' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $insert = $this->u->update(array('correo' => $this->input->post('correoe')),$regusr);
           */
           $result = $this->e->update(array('id' => $this->input->post('empresaid')), $data);
            if ($result > 0) {
                $dato = 'Correctamente ' . $nroiden . ' ' . $result . ' Fila (s) Actualizado (s)';
            } else {
                $dato = 'Fallo!!!';
            }
            echo json_encode(array("status" => $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_delete($id)
    {
        $result = $this->e->delete_by_id($id);
        if ($result > 0) {
            $dato = 'Correctamente ' . $result . ' Fila (s) Anulado (s)';
        } else {
            $dato = 'Fallo!!!';
        }
        echo json_encode(array("status" => $dato));
    }
    private function _do_upload()
    {
        $nroiden = $this->input->post('nroidentificacione');
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

        if (!$this->upload->do_upload('logoe')) {
            $data['inputerror'][] = 'logoe';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', '');
            $data['status'] = false;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

}
