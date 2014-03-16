<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->CheckLogado();

		$Dados['Script'][]				= 'jquery/jquery.mobile-1.3.2.js';
		
		$Dados['Css'][]					= 'mobile/jquery.mobile-1.3.2.min.css';
		$Dados['Css'][]					= 'mobile/principal.css';	
		
		$Dados['View'] 					= 'home/home';
		$this->load->view('body/index', $Dados);
	}

	public function montaIndex(){
		// Rotina para buscar o status dos leitos
		$this->load->model('LeitoMod');
		$Leitos = $this->LeitoMod->statusLeitos();
		$Dados['Leitos'] 				= $Leitos;

		$Dados['success']				= ($Dados['Leitos']) ? true : false;

		echo json_encode($Dados);
	}
}