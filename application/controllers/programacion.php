<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programacion extends CI_Controller {

	public function __construct(){
		parent::__construct();	
		// se controla la variable de Session	
		$this->load->model('model_comercial');
		$this->load->model('model_programacion');
		$this->load->model('model_gerencia');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));		
	}

	public function index(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre'));
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno'));
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			$data['listar_crudo']= $this->model_comercial->listarInfoCrudo_pendiente();
			$this->load->view('programacion/menu_programacion');
			$this->load->view('programacion/listar_informacion_crudo_pendiente', $data);
		}
	}

	public function gestion_programacion(){
		$nombre = $this->security->xss_clean($this->session->userdata('nombre'));
		$apellido = $this->security->xss_clean($this->session->userdata('apaterno'));
		if($nombre == "" AND $apellido == ""){
			$this->load->view('login');
		}else{
			$data['listar_crudo']= $this->model_comercial->listarInfoCrudo_pendiente();
			$this->load->view('programacion/menu_programacion');
			$this->load->view('programacion/listar_informacion_crudo_pendiente', $data);
		}
	}



















}