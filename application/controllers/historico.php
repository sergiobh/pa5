<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Historico extends CI_Controller {
	public function anexo() {
		$this->CheckLogado ();
		
		$HistoricoId = $TicketId = $this->uri->segment ( 3 );
		
		$this->load->model ( "HistoricoMod" );
		$this->HistoricoMod->setHistoricoId ( $HistoricoId );
		
		$Url = $this->HistoricoMod->getUrl ();
		
		if (! $Url) {
			echo 'Você não possui permissão para acessar este arquivo!';
			exit ();
		}
		
		$this->load->helper ( 'download' );
		
		$diretorio = BASE_URL . $Url->diretorio;
		$nameFile = $Url->nameFile;
		
		$data = file_get_contents ( $diretorio . $nameFile );
		
		force_download ( $nameFile, $data );
	}
	public function salvarObservacao() {
		$this->CheckLogado ();
		
		$TicketId = $this->input->post ( 'TicketId' );
		$TipoObservacao = $this->input->post ( 'TipoObservacao' );
		$Descricao = $this->input->post ( 'Descricao' );
		$Nivel = $this->input->post ( 'Nivel' );
		
		/*
		 * Buscar Permissao
		 */
		$this->load->model ( "TicketMod" );
		$this->TicketMod->setTicketId ( $TicketId );
		$TicketJson = $this->TicketMod->getTicket ();
		$TicketObj = json_decode ( $TicketJson );
		
		if (! $TicketObj->Ticket) {
			$Resposta ['success'] = true;
			$Resposta ['msg'] = 'Usuário sem permissão para o ticket!';
			echo json_encode ( $Resposta );
			exit ();
		}
		
		$FuncionarioId = $_SESSION ['Funcionario']->FuncionarioId;
		
		$this->load->model ( "TransactionMod" );
		$this->TransactionMod->Start ();
		
		if ($TipoObservacao == 1) {
			$HistoricoTipoId = ($TicketObj->Ticket->Permissao == 'Solicitante') ? 1 : 2;
		} else if ($TipoObservacao == 2) {
			$HistoricoTipoId = 5;
		} else if ($TipoObservacao == 3) {
			/*
			 * Elevação de Nível do Suporte
			 */
			$this->load->model ( "Ticket_AtendimentoMod" );
			$this->Ticket_AtendimentoMod->setTicketId ( $TicketId );
			$this->Ticket_AtendimentoMod->setTipo_Nivel ( $Nivel );
			$this->Ticket_AtendimentoMod->setAtendenteId ( $FuncionarioId );
			$this->Ticket_AtendimentoMod->setNovoNivel ();
			
			$HistoricoTipoId = 6;
		}
		
		$this->load->model ( "HistoricoMod" );
		$this->HistoricoMod->setTicketId ( $TicketId );
		$this->HistoricoMod->setTexto ( $Descricao );
		// Anexo do Solicitante ou Atendente
		$this->HistoricoMod->setHistoricoTipoId ( $HistoricoTipoId );
		$this->HistoricoMod->setUsuarioId ( $FuncionarioId );
		$this->HistoricoMod->criarDH_Cadastro ();
		
		$Resposta ['success'] = true;
		
		if ($this->HistoricoMod->setHistorico ()) {
			$Resposta ['msg'] = 'Observação salva com sucesso!';
			
			$this->TransactionMod->Commit ();
		} else {
			$Resposta ['msg'] = $this->HistoricoMod->getErroMsg ();
			$this->TransactionMod->Rollback ();
		}
		
		echo json_encode ( $Resposta );
	}
}
?>