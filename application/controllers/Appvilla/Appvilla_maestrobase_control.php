<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Appvilla_maestrobase_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('App/Appvilla_maestrobase_model', 'mb');
    }
    public function index()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Tipos de identificacion';
            $datos['contenido'] = 'appvilla_maestrobase_tipoident_view';
            $datos["modulo"] = "appvilla";
            $filejs=['Configuracionbase/tipoidentificacion'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

    public function ajax_listti()
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
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_tipoiden(' . "'" . $tipoiden->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_tipoiden(' . "'" . $tipoiden->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mb->count_allti(),
                "recordsFiltered" => $this->mb->count_filteredti(),
                "data" => $data,
            );
            echo json_encode($output);
        } else {
            redirect('salir');
        }
    }

    public function ajax_editti($id)
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
        echo json_encode(array("status" => $status, "info" => $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_addti()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nomti = $this->input->post('nomti');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nomti', 'Nombre de Identificacion', 'required|min_length[6]|max_length[45]');
			$this->form_validation->set_rules('codeti', 'Codigo', 'required|min_length[1]|max_length[2]');
			 
			if ($this->form_validation->run() == FALSE) {
				$dato = 'Complete los datos requeridos!!!';           
            echo json_encode(array("status" => false,"info"=> $dato));
			}else{
            $data = array(
				'parentid'=>1,
                'codigo' => $this->input->post('codeti'),
                'sigla' => $this->input->post('siglati'),
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
        }
            echo json_encode(array("status" => $status,"info"=> $dato));
        } else {
            redirect('salir');
        }
    }

    public function ajax_updateti()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nomti = $this->input->post('nomti');
            $data = array(
                'codigo' => $this->input->post('codeti'),
                'sigla' => $this->input->post('siglati'),
                'nombre' => $nomti,
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('idti'),
                'parentid' => 1,
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
            echo json_encode(array("status" => $status, "info" => $dato));         
        } else {
            redirect('salir');
        }
    }

    public function ajax_deleteti($id)
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
            echo json_encode(array("status" => $status, "info" => $dato));            
        } else {
            redirect('salir');
        }
    }
/*
tipos de comprobante
 */
    public function tiposcomprobante()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Tipo de Comprobante';
            $datos['contenido'] = 'appvilla_maestrobase_tipocompro_view';
            $datos["modulo"] = "appvilla";
            $filejs=['Configuracionbase/tipocomprobante'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }
    public function ajax_listtc()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $list = $this->mb->get_datatables_tc();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $tipoiden) {
                $no++;
                $row = array();
                $row[] = ucfirst(strtoupper($tipoiden->codigo));
                $row[] = ucfirst(strtoupper($tipoiden->sigla));
                $row[] = ucfirst(strtolower($tipoiden->nombre));
                $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_tipocompro(' . "'" . $tipoiden->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    <a href="javascript:void()" title="Anular" onclick="delete_tipocompro(' . "'" . $tipoiden->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mb->count_alltc(),
                "recordsFiltered" => $this->mb->count_filteredtc(),
                "data" => $data,
            );
            echo json_encode($output);
        } else {
            redirect('salir');
        }
    }

    public function ajax_edittc($id)
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->mb->get_by_idtc($id);
            if ($data!=false) {
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

    public function ajax_addtc()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nomtc = $this->input->post('nomtc');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nomtc', 'Nombre de comprobante', 'required|min_length[4]|max_length[45]');
            $this->form_validation->set_rules('codetc', 'Codigo', 'required|min_length[1]|max_length[2]');

            if ($this->form_validation->run() == false) {
                $dato = 'Complete los datos requeridos!!!';
                echo json_encode(array("status" => false, "info" => $dato));
            } else {
                $data = array(
                    'parentid' => 12,
                    'codigo' => $this->input->post('codetc'),
                    'sigla' => $this->input->post('siglatc'),
                    'nombre' => $nomtc,
                    'userid_on' => $this->session->userdata('userid'),
                    'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
                );
                $insert = $this->mb->savetc($data);
                if ($insert > 0) {
                    $dato = 'Correctamente,  tipo de comprobante : ' . $nomtc;
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

    public function ajax_updatetc()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $nomtc = $this->input->post('nomtc');
            $data = array(
                'codigo' => $this->input->post('codetc'),
                'sigla' => $this->input->post('siglatc'),
                'nombre' => $nomtc,
                'userid_md' => $this->session->userdata('userid'),
                'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $wre = array(
                'id' => $this->input->post('idtc'),
                'parentid' => 12,
                'enabled' => 1,
            );

            $result = $this->mb->updatetc($wre, $data);
            if ($result > 0) {
                $dato = 'Correctamente ' . $nomtc . ' ' . $result . ' Fila (s) Actualizado (s)';
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

    public function ajax_deletetc()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('id', true));
            $result = $this->mb->delete_by_idtc($id);
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


/*
Modalidad de pago
 */
public function modalidadpago()
{
    $valid = $this->session->userdata('validated');
    if ($valid == true) {
        $datos['titulo'] = 'Modalidad Pago';
        $datos['contenido'] = 'appvilla_maestrobase_modalidadpago_view';
        $datos["modulo"] = "appvilla";
        $filejs=['Configuracionbase/modalidadpago'];
            $datos['filesjs'] = $filejs;
        $this->load->view('includes/plantilla', $datos);
    } else {
        redirect('salir');
    }
}
public function ajax_listmp()
{$valid = $this->session->userdata('validated');
    if ($valid == true) {
        $list = $this->mb->get_datatables_mp();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mdopgo) {
            $no++;
            $row = array();
            $row[] = ucfirst(strtoupper($mdopgo->codigo));
            $row[] = ucfirst(strtoupper($mdopgo->sigla));
            $row[] = ucfirst(strtolower($mdopgo->nombre));
            $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_mdopgo(' . "'" . $mdopgo->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                <a href="javascript:void()" title="Anular" onclick="delete_mdopgo(' . "'" . $mdopgo->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mb->count_allmp(),
            "recordsFiltered" => $this->mb->count_filteredmp(),
            "data" => $data,
        );
        echo json_encode($output);
    } else {
        redirect('salir');
    }
}

public function ajax_editmp($id)
{$valid = $this->session->userdata('validated');
    if ($valid == true) {
        $data = $this->mb->get_by_idmp($id);
        if ($data!=false) {
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

public function ajax_addmp()
{$valid = $this->session->userdata('validated');
    if ($valid == true) {
        $nommp = $this->input->post('nommp');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nommp', 'Nombre de comprobante', 'required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('codemp', 'Codigo', 'required|min_length[1]|max_length[2]');

        if ($this->form_validation->run() == false) {
            $dato = 'Complete los datos requeridos!!!';
            echo json_encode(array("status" => false, "info" => $dato));
        } else {
            $data = array(
                'parentid' => 8,
                'codigo' => $this->input->post('codemp'),
                'sigla' => $this->input->post('siglamp'),
                'nombre' => $nommp,
                'userid_on' => $this->session->userdata('userid'),
                'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $insert = $this->mb->savemp($data);
            if ($insert > 0) {
                $dato = 'Correctamente,  tipo de comprobante : ' . $nommp;
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

public function ajax_updatemp()
{
    $valid = $this->session->userdata('validated');
    if ($valid == true) {
        $nommp = $this->input->post('nommp');
        $data = array(
            'codigo' => $this->input->post('codemp'),
            'sigla' => $this->input->post('siglamp'),
            'nombre' => $nommp,
            'userid_md' => $this->session->userdata('userid'),
            'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
        );
        $wre = array(
            'id' => $this->input->post('idtc'),
            'parentid' => 8,
            'enabled' => 1,
        );

        $result = $this->mb->updatemp($wre, $data);
        if ($result > 0) {
            $dato = 'Correctamente ' . $nommp . ' ' . $result . ' Fila (s) Actualizado (s)';
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

public function ajax_deletemp()
{
    $valid = $this->session->userdata('validated');
    if ($valid == true) {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $result = $this->mb->delete_by_idmp($id);
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


/*
Unidad de Medida
 */
public function unidadmedida()
{
    $valid = $this->session->userdata('validated');
    if ($valid == true) {
        $datos['titulo'] = 'Unidad de medida';
        $datos['contenido'] = 'appvilla_maestrobase_unidadmedida_view';
        $datos["modulo"] = "appvilla";
        $filejs=['Configuracionbase/unidadmedida'];
            $datos['filesjs'] = $filejs;
        $this->load->view('includes/plantilla', $datos);
    } else {
        redirect('salir');
    }
}
public function ajax_listum()
{$valid = $this->session->userdata('validated');
    if ($valid == true) {
        $list = $this->mb->get_datatables_um();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $unimda) {
            $no++;
            $row = array();
            $row[] = ucfirst(strtoupper($unimda->codigo));
            $row[] = ucfirst(strtoupper($unimda->sigla));
            $row[] = ucfirst(strtolower($unimda->nombre));
            $row[] = '<a href="javascript:void()" title="Editar" onclick="edit_unimda(' . "'" . $unimda->id . "'" . ')"><span class="label label-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>
                <a href="javascript:void()" title="Anular" onclick="delete_unimda(' . "'" . $unimda->id . "'" . ')"><span class="label label-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mb->count_allum(),
            "recordsFiltered" => $this->mb->count_filteredum(),
            "data" => $data,
        );
        echo json_encode($output);
    } else {
        redirect('salir');
    }
}

public function ajax_editum($id)
{$valid = $this->session->userdata('validated');
    if ($valid == true) {
        $data = $this->mb->get_by_idum($id);
        if ($data!=false) {
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

public function ajax_addum()
{$valid = $this->session->userdata('validated');
    if ($valid == true) {
        $nomum = $this->input->post('nomum');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nomum', 'Nombre de comprobante', 'required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('siglaum', 'Sigla', 'required|min_length[1]|max_length[5]');

        if ($this->form_validation->run() == false) {
            $dato = 'Complete los datos requeridos!!!';
            echo json_encode(array("status" => false, "info" => $dato));
        } else {
            $data = array(
                'parentid' => 26,
                'codigo' => $this->input->post('codeum'),
                'sigla' => $this->input->post('siglaum'),
                'nombre' => $nomum,
                'userid_on' => $this->session->userdata('userid'),
                'fecha_on' => gmdate("Y-m-d H:i:s", time() - 18000),
            );
            $insert = $this->mb->saveum($data);
            if ($insert > 0) {
                $dato = 'Correctamente,  tipo de comprobante : ' . $nomum;
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

public function ajax_updateum()
{
    $valid = $this->session->userdata('validated');
    if ($valid == true) {
        $nomum = $this->input->post('nomum');
        $data = array(
            'codigo' => $this->input->post('codeum'),
            'sigla' => $this->input->post('siglaum'),
            'nombre' => $nomum,
            'userid_md' => $this->session->userdata('userid'),
            'fecha_md' => gmdate("Y-m-d H:i:s", time() - 18000),
        );
        $wre = array(
            'id' => $this->input->post('idum'),
            'parentid' => 26,
            'enabled' => 1,
        );

        $result = $this->mb->updateum($wre, $data);
        if ($result > 0) {
            $dato = 'Correctamente ' . $nomum . ' ' . $result . ' Fila (s) Actualizado (s)';
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

public function ajax_deleteum()
{
    $valid = $this->session->userdata('validated');
    if ($valid == true) {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $result = $this->mb->delete_by_idum($id);
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


}