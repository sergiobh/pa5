<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Prioridade extends CI_Controller{
	public function getPrioridades(){
		$this->CheckLogado();
		
		$this->load->model('PrioridadeMod');
		echo $this->PrioridadeMod->getPrioridades();
	}
	
}
?>