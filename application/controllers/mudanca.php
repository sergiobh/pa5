<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mudanca extends CI_Controller {
	public function cadastrar() {
		$this->CheckLogado ();

		$Dados ['View'] = 'mudanca/cadastrar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function salvarCadastro() {
		$Nome = $this->input->post ( "Nome" );
		$Descricao = $this->input->post ( "Descricao" );
		$PrioridadeId = $this->input->post ( "PrioridadeId" );
		
		$this->load->model ( "MudancaMod" );
		$this->MudancaMod->setNome ( $Nome );
		$this->MudancaMod->setDescricao ( $Descricao );
		$this->MudancaMod->setPrioridadeId ( $PrioridadeId );
		
		echo $this->MudancaMod->setMudanca ();
	}
	public function listar() {
		$this->CheckLogado ();
		
		$this->load->model ( "StatusTicketMod" );
		$StatusTickets = $this->StatusTicketMod->getStatusTicket ();
		
		$Dados ['StatusTickets'] = $StatusTickets;
		
		$Dados ['View'] = 'mudanca/listar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function listarMudancas() {
		$this->CheckLogado ();
		
		$StatusId = $this->input->get ( "StatusId" );
		
		$this->load->model ( 'MudancaMod' );
		$this->MudancaMod->setStatusId ( $StatusId );
		$Mudancas = $this->MudancaMod->getTickets ();
		$Dados ["Mudancas"] = $Mudancas;
		
		$Dados ["success"] = true;
		
		echo json_encode ( $Dados );
	}
	public function editar() {
		$this->CheckLogado ();
		
		$TicketId = $this->uri->segment ( 3 );
		
		/*
		 * Verifica se possui get de arquivos para anexar
		 */
		if (isset ( $_FILES ['ticketFile'] )) {
			$Dados ['RespostaMsg'] = $this->salvaArquivos ( $TicketId );
		}
		
		$Dados ['TicketId'] = $TicketId;
		
		$Dados ['Script'] [] = 'jquery/bootstrap-filestyle.min.js';
		
		$Dados ['View'] = 'mudanca/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function carregaEditar() {
		$this->CheckLogado ();
	
		$TicketId = $this->input->get ( "TicketId" );
	
		$this->load->model ( "MudancaMod" );
	
		if (! $this->MudancaMod->setTicketId ( $TicketId )) {
			echo $this->MudancaMod->getErroMsg ();
			exit ();
		}
	
		echo $this->MudancaMod->getTicket ();
	}
	public function salvarEdicao() {
		$TicketId = $this->input->post ( 'TicketId' );
		$Nivel = $this->input->post ( 'Nivel' );
		$PrioridadeId = $this->input->post ( 'PrioridadeId' );
		$Resultado = $this->input->post ( 'Resultado' );
		$StatusId = $this->input->post ( 'StatusId' );
		$TipoId = $this->input->post ( 'TipoSolicitacaoId' );
	
		$this->load->model ( "MudancaMod" );
		$this->MudancaMod->setTicketId ( $TicketId );
		$this->MudancaMod->setTipo_Nivel ( $Nivel );
		$this->MudancaMod->setPrioridadeId ( $PrioridadeId );
		$this->MudancaMod->setResultado ( $Resultado );
		$this->MudancaMod->setStatusId ( $StatusId );
		$this->MudancaMod->setTipoId ( $TipoId );
	
		echo $this->MudancaMod->salvarEdicao ();
	}
	public function carregarHistorico() {
		$TicketId = $this->input->get ( 'TicketId' );
		$permissao = $this->input->get ( 'Permissao' );
	
		$this->load->model ( "HistoricoMod" );
		$this->HistoricoMod->setTicketId ( $TicketId );
		$this->HistoricoMod->setPermissao ( $permissao );
	
		$Historicos = $this->HistoricoMod->getHistoricos ();
	
		$Dados ["Historicos"] = $Historicos;
	
		$Dados ["success"] = true;
	
		echo json_encode ( $Dados );
	}
}
?>