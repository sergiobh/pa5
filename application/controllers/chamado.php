<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Chamado extends CI_Controller {
	public function cadastrar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'chamado/cadastrar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function salvarCadastro() {
		$TipoSolicitacaoId = $this->input->post ( "TipoSolicitacaoId" );
		$Descricao = $this->input->post ( "Descricao" );
		
		$this->load->model ( "TicketMod" );
		$this->TicketMod->setTipoId ( $TipoSolicitacaoId );
		$this->TicketMod->setDescricao ( $Descricao );
		
		echo $this->TicketMod->salvarCadastro ();
	}
	public function listar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'chamado/listar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function listarChamados() {
		$this->CheckLogado ();
		
		$StatusId = $this->input->get ( "StatusId" );
		
		$this->load->model ( 'TicketMod' );
		$this->TicketMod->setStatusId ( $StatusId );
		$Chamados = $this->TicketMod->getTickets ();
		$Dados ["Chamados"] = $Chamados;
		
		$Dados ["success"] = true;
		
		// $this->load->view('quarto/selectAndar', $Dados);
		echo json_encode ( $Dados );
	}
	public function editar() {
		$this->CheckLogado ();
		
		$TicketId = $this->uri->segment ( 3 );
				
		$Dados['TicketId'] = $TicketId; 
		
		$Dados ['View'] = 'chamado/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	
	public function carregaEditar(){
		$this->CheckLogado ();
		
		$TicketId = $this->input->get ( "TicketId" );
		
		$this->load->model ( "TicketMod" );
				
		if (! $this->TicketMod->setTicketId ( $TicketId )) {
			echo $this->TicketMod->getErroMsg();
			exit;
		}
		
		echo $this->TicketMod->getTicket();
	}
}
?>