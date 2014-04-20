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
		
		$this->load->model ( "StatusTicketMod" );
		$StatusTickets = $this->StatusTicketMod->getStatusTicket ();
		
		$Dados ['StatusTickets'] = $StatusTickets;
		
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
		
		echo json_encode ( $Dados );
	}
	public function editar() {
		$this->CheckLogado ();
		
		$TicketId = $this->uri->segment ( 3 );
		
		/*
		 * Verifica se possui get de arquivos para anexar
		 */
		if (isset ( $_FILES ['ticketFile'] )) {
			$Dados ['RespostaMsg'] = $this->salvaArquivos ($TicketId);
		}
		
		$Dados ['TicketId'] = $TicketId;
		
		$Dados ['Script'] [] = 'jquery/bootstrap-filestyle.min.js';
		
		$Dados ['View'] = 'chamado/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	private function salvaArquivos($TicketId) {
		$config ['upload_path'] = './public/anexos/'.$TicketId.'/';
		$config ['allowed_types'] = '*';
		$config ['max_size'] = '10240';

		$this->load->library ( 'upload', $config );

		if (!is_dir($config ['upload_path'])) {
			mkdir($config ['upload_path'], 0777, TRUE);
		}
		
		if (! $this->upload->do_upload ( "ticketFile" )) {
			
			$Resposta = $this->upload->display_errors ();
		} else {
			$this->load->model ( "TicketMod" );
			
			if (! $this->TicketMod->setTicketId ( $TicketId )) {
				$Dados ['msg'] = $this->TicketMod->getErroMsg ();
				return $Dados;
			}
			
			$TicketJson = $this->TicketMod->getTicket ();  
			$TicketObj = json_decode($TicketJson);
			
			if(! $TicketObj->Ticket){
				$Resposta = 'Usuário sem permissão para o ticket!';
				return $Resposta;
			}
			
			$HistoricoTipoId = ($TicketObj->Ticket->Permissao == 'Solicitante') ? 3 : 4; 

			/*
			 * Upload do arquivo
			 * */
			$config = $this->upload->data ( "ticketFile" );
			
			$file = $config ['file_name'];
			$FuncionarioId = $_SESSION ['Funcionario']->FuncionarioId;
			$DH_Solicitacao = date ( 'Y-m-d H:i:s' );
			
			$this->load->model ( "HistoricoMod" );
			$this->HistoricoMod->setTicketId ( $TicketId );
			$this->HistoricoMod->setTexto ( $file );
			$this->HistoricoMod->setHistoricoTipoId ( $HistoricoTipoId ); // Anexo do Solicitante ou Atendente
			$this->HistoricoMod->setUsuarioId ( $FuncionarioId );
			$this->HistoricoMod->setDH_Cadastro ( $DH_Solicitacao );
			
			$Resposta = ($this->HistoricoMod->setHistorico ()) ? 'Anexo salvo com sucesso!' : 'Ocorreu um erro ao salvar, tente novamente!';
		}
		
		return $Resposta;
	}
	public function carregaEditar() {
		$this->CheckLogado ();
		
		$TicketId = $this->input->get ( "TicketId" );
		
		$this->load->model ( "TicketMod" );
		
		if (! $this->TicketMod->setTicketId ( $TicketId )) {
			echo $this->TicketMod->getErroMsg ();
			exit ();
		}
		
		echo $this->TicketMod->getTicket ();
	}
	public function salvarEdicao() {
		$TicketId = $this->input->post ( 'TicketId' );
		$Nivel = $this->input->post ( 'Nivel' );
		$PrioridadeId = $this->input->post ( 'PrioridadeId' );
		$Resultado = $this->input->post ( 'Resultado' );
		$StatusId = $this->input->post ( 'StatusId' );
		$TipoSolicitacaoId = $this->input->post ( 'TipoSolicitacaoId' );
		
		$this->load->model ( "TicketMod" );
		$this->TicketMod->setTicketId ( $TicketId );
		$this->TicketMod->setTipo_Nivel($Nivel);
		$this->TicketMod->setPrioridadeId ( $PrioridadeId );
		$this->TicketMod->setResultado ( $Resultado );
		$this->TicketMod->setStatusId ( $StatusId );
		$this->TicketMod->setTipoId ( $TipoSolicitacaoId );
		
		echo $this->TicketMod->salvarEdicao ();
	}
	public function carregarHistorico() {
		$TicketId = $this->input->get ( 'TicketId' );
		
		$this->load->model ( "HistoricoMod" );
		$this->HistoricoMod->setTicketId ( $TicketId );
		
		$Historicos = $this->HistoricoMod->getHistoricos ();
		
		$Dados ["Historicos"] = $Historicos;
		
		$Dados ["success"] = true;
		
		echo json_encode ( $Dados );
	}
}
?>