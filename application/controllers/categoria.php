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
	public function salvarCadastro(){
		$this->CheckLogado ();
		
		$Nome = $this->input->post ( "Nome" );
		
		$this->load->model ( "CategoriaMod" );
		$this->CategoriaMod->setNome ( $Nome );
		echo json_encode ( $this->CategoriaMod->setCategoria () );
	}
	public function listar(){
		$this->CheckLogado ();
		
		$Dados ['View'] = 'categoria/listar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function montaGrid(){
		$this->CheckLogado ();
		
		$this->load->model ( "CategoriaMod" );
		$Categorias = $this->CategoriaMod->getCategoria();
		
		$retorno['success'] = ($Categorias) ? true : false;
		$retorno['Categorias'] = $Categorias; 
		
		echo json_encode($retorno);
	}
	public function editar(){
		$this->CheckLogado ();
		
		$CategoriaId = $this->uri->segment ( 3 );
		
		$Dados['CategoriaId'] = $CategoriaId;
		
		$Dados ['View'] = 'categoria/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function getEditar(){
		$this->CheckLogado ();
		
		$CategoriaId = $this->input->get("CategoriaId");
		
		$this->load->model ( "CategoriaMod" );
		$this->CategoriaMod->setCategoriaId($CategoriaId);
		$Categoria = $this->CategoriaMod->getCategoria();
		
		$retorno['success'] = ($Categoria) ? true : false;
		$retorno['Categoria'] = (isset($Categoria[0])) ? $Categoria[0] : '';
		
		echo json_encode($retorno);
	}
	public function salvarEdicao(){
		$this->CheckLogado ();
		
		$CategoriaId = $this->input->post("CategoriaId");
		$Nome = $this->input->post("Nome");

		$this->load->model ( "CategoriaMod" );
		$this->CategoriaMod->setCategoriaId($CategoriaId);
		$this->CategoriaMod->setNome($Nome);
		$retorno = $this->CategoriaMod->setEdicao();
		
		echo json_encode($retorno);
	}
}
?>