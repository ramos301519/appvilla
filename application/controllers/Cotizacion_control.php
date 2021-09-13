<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizacion_control extends CI_Controller {
	
	public function index()
	{
		$datos['titulo'] = 'Cotizaciones';
        $datos['contenido'] = 'cotizaciones_view';
        $datos["modulo"] = "ventas";
        $this->load->view('includes/plantilla', $datos);
	}



}
