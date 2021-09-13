<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login/login_model', 'l');
    }
    public function index($msg = null)
    {
        $dat['mensaje'] = $msg;
        $dat['titulo']= "Appvilla";
        $this->load->view('index_login', $dat);
    }

    public function process()
    {   $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('clave'));      
        $result = $this->l->validaLoguin($email, $password);
        if($result==true){
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $flag = $this->session->userdata('flag');
            if($flag==0){
                redirect('appvilla');
            }else{
                redirect('venta');
            }            
        } else {
            $mensaje ='<div class="alert alert-danger alert-dismissible " role="alert">            
            <strong>Usuario y/o Password Incorrectos!</strong> '.$result.'
          </div>';
            $this->index($mensaje);
        }
    }else{
        $mensaje ='<div class="alert alert-danger alert-dismissible " role="alert">            
        <strong>Usuario y/o Password Incorrectos!</strong> '.$result.'
      </div>';
        $this->index($mensaje);   
    }

    }
    public function home_principal()
    {
        redirect('principal');
    }

    public function do_logout()
    {
        $this->session->sess_destroy();
        redirect('login_control');
    }

}
