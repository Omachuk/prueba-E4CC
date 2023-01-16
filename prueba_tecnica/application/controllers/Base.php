<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Controller{ 

	function __construct(){
		parent::__construct();
		$this->load->database();//para usar la bdd
		$this->load->helper('form');
		$this->load->library('encryption');//libreria para el uso de encriptacion
		$this->load->helper('url');
		$this->load->library('form_validation'); //libreria de validacion
   		$this->load->library('session');//para sesiones
		$this->load->model('Inicio_model');//modelo de empleados
	}

	function verificar_acceso(){
		if (isset($_SESSION['login'])) {//verificamos si existe una session
        	
        }else{
            redirect(base_url()."index.php/Inicio");
        }
	}

}//fin class Base extends CI_Controller