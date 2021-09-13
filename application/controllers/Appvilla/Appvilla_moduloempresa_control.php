<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appvilla_moduloempresa_control extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('app/Empresas_model', 'e');
    }
	public function index()
	{
		$valid = $this->session->userdata('validated');
        if ($valid == true) {
		$datos['titulo'] = 'Modulos Empresa';
        $datos['contenido'] = 'appvilla_modulosempresa_view';
        $datos["modulo"] = "appvilla";
        $this->load->view('includes/plantilla', $datos);
	} else {
		redirect('salir');
	}
	
	}



}
