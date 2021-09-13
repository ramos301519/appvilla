<?php
$this->load->view('includes/header');
$modulo=$modulo;
if($modulo==''){
    $this->load->view('front_end/'.$contenido);
}else{
    $this->load->view('front_end/'.$modulo.'/'.$contenido);
}
$this->load->view('includes/footer');

?>