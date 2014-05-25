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
		
		$this->load->model ( "PrioridadeMod" );
		$this->PrioridadeMod->setRestringePlanejada ( true );
		$Prioridades = json_decode ( $this->PrioridadeMod->getPrioridades () );
		
		$Dados ['Prioridades'] = $Prioridades->Prioridades;
		
		$Dados ['View'] = 'mudanca/listar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function listarMudancas() {
		$this->CheckLogado ();
		
		$PrioridadeId = $this->input->get ( "PrioridadeId" );
		
		$this->load->model ( 'MudancaMod' );
		$this->MudancaMod->setPrioridadeId ( $PrioridadeId );
		$Mudancas = $this->MudancaMod->getMudancas ();
		$Dados ["Mudancas"] = $Mudancas;
		
		$Dados ["success"] = true;
		
		echo json_encode ( $Dados );
	}
	public function editar() {
		$this->CheckLogado ();
		
		$MudancaId = $this->uri->segment ( 3 );
		
		$Dados ['MudancaId'] = $MudancaId;
		
		$Dados ['View'] = 'mudanca/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function carregaEditar() {
		$this->CheckLogado ();
		
		$MudancaId = $this->input->get ( "MudancaId" );
		
		$this->load->model ( "MudancaMod" );
		$this->MudancaMod->setMudancaId ( $MudancaId );
		
		$Mudanca = $this->MudancaMod->getMudanca ();
		
		if ($Mudanca) {
			$dados ['success'] = true;
			$dados ['Mudanca'] = $Mudanca;
		} else {
			$dados ['success'] = false;
		}
		
		echo json_encode ( $dados );
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
	public function getAutorizacoes() {
		$this->load->model ( "MudancaMod" );		
		$this->MudancaMod->setAutorizacoes();
		
		$dados ['success'] = true;
		$dados ['Autorizacoes'] = $this->MudancaMod->getAutorizacoes ();

		echo json_encode ( $dados );
	}
	public function getAvaliacoes(){

		$AutorizacaoId = $this->input->post ( 'AutorizacaoId' );
		
		if($AutorizacaoId == 0){
			$dados ['success'] = false;
		}
		else{
			$this->load->model ( "MudancaMod" );
			$this->MudancaMod->setAvaliacoes();
			
			$dados ['success'] = true;
			$dados ['Avaliacoes'] = $this->MudancaMod->getAvaliacoes ();
		}
		
		echo json_encode ( $dados );
	}
}
?>