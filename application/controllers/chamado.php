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

		$this->load->model("TicketMod");
		$this->TicketMod->setTipoId($TipoSolicitacaoId);
		$this->TicketMod->setDescricao($Descricao);
		
		echo $this->TicketMod->salvarCadastro();
	}
}
?>