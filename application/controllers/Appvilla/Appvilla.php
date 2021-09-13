<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppVilla extends CI_Controller {
	
	public function index()
	{
		$datos['titulo'] = 'Appvilla';
        $datos['contenido'] = 'appvilla_view';
        $datos["modulo"] = "appvilla";
        $this->load->view('includes/plantilla', $datos);
	}



}
