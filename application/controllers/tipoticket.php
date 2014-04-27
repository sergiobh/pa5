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
	public function editar() {
		$this->CheckLogado ();
		
		$TipoId = $this->uri->segment ( 3 );
		
		$Dados ['TipoId'] = $TipoId;
		
		$Dados ['View'] = 'tipoticket/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function getEditar() {
		$this->CheckLogado ();
		
		$TipoId = $this->input->get ( "TipoId" );
		
		$this->load->model ( "TipoTicketMod" );
		$this->TipoTicketMod->setTipoId ( $TipoId );
		$this->TipoTicketMod->setReturnObject ( false );
		$TipoTicket = $this->TipoTicketMod->getTipoTicket ( true );
		
		$retorno ['success'] = ($TipoTicket) ? true : false;
		$retorno ['TipoTicket'] = (isset ( $TipoTicket [0] )) ? $TipoTicket [0] : false;
		
		echo json_encode ( $retorno );
	}
	public function salvarEdicao() {
		$this->CheckLogado ();
		
		$TipoId = $this->input->post ( "TipoId" );
		$PrioridadeId = $this->input->post ( "PrioridadeId" );
		$SLA = $this->input->post ( "SLA" );
		$Ativo = $this->input->post ( "Ativo" );
		
		$this->load->model ( "TipoTicketMod" );
		$this->TipoTicketMod->setTipoId ( $TipoId );
		$this->TipoTicketMod->setPrioridadeId ( $PrioridadeId );
		$this->TipoTicketMod->setSLA ( $SLA );
		$this->TipoTicketMod->setAtivo ( $Ativo );
		
		echo json_encode ( $this->TipoTicketMod->setEdicao () );
	}
}
?>