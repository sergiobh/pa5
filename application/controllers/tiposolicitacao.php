<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class TipoSolicitacao extends CI_Controller {
	public function getTipoSolicitacao() {
		$TicketId = $this->input->get("TicketId");
		$StatusId = $this->input->get("StatusId");
		$CategoriaId = $this->input->get ( "CategoriaId" );
		
		$this->load->model ( 'TipoTicketMod' );
		$this->TipoTicketMod->setTicketId($TicketId);
		$this->TipoTicketMod->setStatusId($StatusId);
		$this->TipoTicketMod->setCategoriaId($CategoriaId);
		$this->TipoTicketMod->setReturnObject(false);
		$TipoSolicitacao = $this->TipoTicketMod->getTipoTicket ();
		$Dados ['TipoSolicitacao'] = $TipoSolicitacao;
		
		$Dados ['success'] = true;
		
		echo json_encode ( $Dados );
	}
}
?>