<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	
	public function dashtickets(){
		$this->CheckLogado();

		$Dados['View'] 					= 'dashboard/dashtickets';
		$this->load->view('body/index', $Dados);
		
	}
	
	
	public function dashMudanca(){
		$this->CheckLogado();

		$Dados['View'] 					= 'dashboard/dashMudanca';
		$this->load->view('body/index', $Dados);
		
	}
	
	
	
	
}
?>