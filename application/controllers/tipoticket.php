<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class TipoTicket extends CI_Controller {
	public function getTipoTicket() {
		$TicketId = $this->input->get ( "TicketId" );
		$StatusId = $this->input->get ( "StatusId" );
		$CategoriaId = $this->input->get ( "CategoriaId" );
		
		$this->load->model ( 'TipoTicketMod' );
		$this->TipoTicketMod->setTicketId ( $TicketId );
		$this->TipoTicketMod->setStatusId ( $StatusId );
		$this->TipoTicketMod->setCategoriaId ( $CategoriaId );
		$this->TipoTicketMod->setReturnObject ( false );
		$TipoTicket = $this->TipoTicketMod->getTipoTicket ();
		$Dados ['TipoTicket'] = $TipoTicket;
		
		$Dados ['success'] = true;
		
		echo json_encode ( $Dados );
	}
	public function cadastrar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'tipoticket/cadastrar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function salvarCadastro() {
		$this->CheckLogado ();
		
		$Nome = $this->input->post ( "Nome" );
		$CategoriaId = $this->input->post ( "CategoriaId" );
		$SetorId = $this->input->post ( "SetorId" );
		$PrioridadeId = $this->input->post ( "PrioridadeId" );
		$SLA = $this->input->post ( "SLA" );
		
		$this->load->model ( "TipoTicketMod" );
		$this->TipoTicketMod->setNome ( $Nome );
		$this->TipoTicketMod->setCategoriaId ( $CategoriaId );
		$this->TipoTicketMod->setSetorId ( $SetorId );
		$this->TipoTicketMod->setPrioridadeId ( $PrioridadeId );
		$this->TipoTicketMod->setSLA ( $SLA );
		
		echo json_encode ( $this->TipoTicketMod->setTipoTicket () );
	}
	public function listar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'tipoticket/listar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function montaGrid() {
		$this->CheckLogado ();
		
		$this->load->model ( "TipoTicketMod" );
		$TipoTickets = $this->TipoTicketMod->getTipoTickets ();
		
		$retorno ['success'] = ($TipoTickets) ? true : false;
		$retorno ['TipoTickets'] = $TipoTickets;
		
		echo json_encode ( $retorno );
	}
}
?>