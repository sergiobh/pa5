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
		$Descricao = $this->input->post ( 'Descricao' );
		
		/*
		 * Buscar Permissao
		 * */
		$this->load->model("TicketMod");
		$this->TicketMod->setTicketId( $TicketId );
		$TicketJson = $this->TicketMod->getTicket ();
		$TicketObj = json_decode($TicketJson);
			
		if(! $TicketObj->Ticket){
			$Resposta['success'] = true;
			$Resposta['msg'] = 'Usuário sem permissão para o ticket!';
			echo json_encode($Resposta);
			exit;
		}
			
		$HistoricoTipoId = ($TicketObj->Ticket->Permissao == 'Solicitante') ? 1 : 2;

		$FuncionarioId = $_SESSION ['Funcionario']->FuncionarioId;
		$DH_Solicitacao = date ( 'Y-m-d H:i:s' );
		
		$this->load->model ( "HistoricoMod" );
		$this->HistoricoMod->setTicketId( $TicketId );
		$this->HistoricoMod->setTexto ( $Descricao );
		$this->HistoricoMod->setHistoricoTipoId ( $HistoricoTipoId ); // Anexo do Solicitante ou Atendente
		$this->HistoricoMod->setUsuarioId ( $FuncionarioId );
		$this->HistoricoMod->setDH_Cadastro ( $DH_Solicitacao );

		$Resposta['success'] = true;
		$Resposta['msg'] = ($this->HistoricoMod->setHistorico ()) ? 'Observação salva com sucesso!' : $this->HistoricoMod->getErroMsg();

		echo json_encode($Resposta);
		exit;
	}
}
?>