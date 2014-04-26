<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Categoria extends CI_Controller {
	public function cadastrar() {
		$this->CheckLogado ();
	
		$Dados ['View'] = 'categoria/cadastrar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function getCategorias() {
		$TicketId = $this->input->get("TicketId");
		$StatusId = $this->input->get("StatusId");
		$Permissao = $this->input->get("Permissao");
		
		$this->load->model ( 'CategoriaMod' );
		$this->CategoriaMod->setTicketId($TicketId);
		$this->CategoriaMod->setStatusId($StatusId);
		$this->CategoriaMod->setPermissao($Permissao);
		$Categorias = $this->CategoriaMod->getCategoria ();
		$Dados ["Categorias"] = $Categorias;
		
		$Dados ["success"] = true;
		echo json_encode ( $Dados );
	}
}
?>