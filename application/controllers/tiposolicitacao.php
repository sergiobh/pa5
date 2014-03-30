<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class TipoSolicitacao extends CI_Controller {
	public function getTipoSolicitacao() {
		$CategoriaId = $this->input->get ( "CategoriaId" );
		
		$this->load->model ( 'TipoTicketMod' );
		$this->TipoTicketMod->setCategoriaId($CategoriaId);
		$TipoSolicitacao = $this->TipoTicketMod->getTipoTicket (false);
		$Dados ['TipoSolicitacao'] = $TipoSolicitacao;
		
		$Dados ['success'] = true;
		
		echo json_encode ( $Dados );
	}
}
?>