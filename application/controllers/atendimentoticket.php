<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class AtendimentoTicket extends CI_Controller {
	public function listar() {
		$TicketId = $this->input->get ( "TicketId" );
		
		$Dados ['TicketId'] = $TicketId;
		
		$this->load->view ( 'atendimento/listar', $Dados );
	}
	public function montaGrid() {
		$this->CheckLogado ();
		
		$TicketId = $this->input->get ( "TicketId" );
		
		$this->load->model ( "Ticket_AtendimentoMod" );
		$this->Ticket_AtendimentoMod->setTicketId ( $TicketId );
		$Atendimentos = $this->Ticket_AtendimentoMod->getAtendimentos ();
		
		$retorno ['success'] = ($Atendimentos) ? true : false;
		$retorno ['Atendimentos'] = $Atendimentos;
		
		echo json_encode ( $retorno );
	}
	public function checkProximoAtendimento() {
		$TicketId = $this->input->get ( "TicketId" );
		$Nivel = $this->input->get ( "Nivel" );
		
		$this->load->model ( "Ticket_AtendimentoMod" );
		$this->Ticket_AtendimentoMod->setTicketId ( $TicketId );
		
		$transferencia = $this->Ticket_AtendimentoMod->checkTransferencia();
		echo '<pre>';var_dump($transferencia);exit;
		//$retorno['success'] = $this->Ticket_AtendimentoMod->checkProximoAtendimento ();  
		
		echo json_encode ( $retorno );
	}
}