<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
require_once APPPATH."/third_party/Classes/PHPExcel.php";
require_once APPPATH."/third_party/Classes/PHPExcel/Reader/Excel2007.php";
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}

?>

