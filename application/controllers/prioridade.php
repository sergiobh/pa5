<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Prioridade extends CI_Controller{
	public function getPrioridades(){
		$this->CheckLogado();
		
		$PrioridadeId = $this->input->get("PrioridadeId");
		$Permissao = $this->input->get("Permissao");
		$Nivel = $this->input->get("Nivel");
		
		$this->load->model('PrioridadeMod');
		$this->PrioridadeMod->setPrioridadeId($PrioridadeId);
		$this->PrioridadeMod->setPermissao($Permissao);
		$this->PrioridadeMod->setNivel($Nivel);
		echo $this->PrioridadeMod->getPrioridades();
	}
	
}
?>