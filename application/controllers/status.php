<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Status extends CI_Controller {
	public function getStatus() {
		$this->CheckLogado ();
		
		$StatusId = $this->input->get("StatusId");
		$Permissao = $this->input->get("Permissao");
		$Nivel = $this->input->get("Nivel");
	
		$this->load->model ( 'StatusTicketMod' );
		$this->StatusTicketMod->setStatusId($StatusId);
		$this->StatusTicketMod->setPermissao($Permissao);
		$this->StatusTicketMod->setNivel($Nivel);
		$Status = $this->StatusTicketMod->getStatusTicket ();
		
		$retorno ['success'] = true;
		$retorno ['Status'] = $Status;
		
		echo json_encode ( $retorno );
	}
}
?>