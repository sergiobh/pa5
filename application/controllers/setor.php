<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Setor extends CI_Controller {
	public function cadastrar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'setor/cadastrar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function listar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'Setor/listar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function getListar() {
		$this->CheckLogado ();
		
		$this->load->model ( 'SetorMod' );
		$Setores = $this->SetorMod->Listar ();
		$Dados ['Setoress'] = $Setores;
		
		$Dados ['success'] = true;
		
		echo json_encode ( $Dados );
	}
	public function salvarCadastro() {
		$this->CheckLogado ();
		
		$Nome = $this->input->post ( "Nome" );
		$GestorId = $this->input->post ( "GestorId" );
		
		$this->load->model ( "SetorMod" );
		$this->SetorMod->setNome ( $Nome );
		$this->SetorMod->setFuncionarioId ( $GestorId );
		echo json_encode ( $this->SetorMod->setSetor () );
	}
	public function editar() {
		$this->CheckLogado ();
		
		$SetorId = $this->uri->segment ( 3 );
		$Dados ['SetorId'] = $SetorId;
		
		$Dados ['View'] = 'setor/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function getEditar() {
		$this->CheckLogado ();
		
		$SetorId = $this->input->get ( "SetorId" );
		
		$this->load->model ( "SetorMod" );
		$this->SetorMod->setSetorId ( $SetorId );
		$this->SetorMod->setTipoRetorno ( 'Obj' );
		
		$Dados ['Setor'] = $this->SetorMod->getSetor ();
		$Dados ['msg'] = $this->SetorMod->getErroMsg ();
		$Dados ['success'] = true;
		
		echo json_encode ( $Dados );
	}
	public function salvarEdicao() {
		$this->CheckLogado ();
		
		$SetorId = $this->input->post ( "SetorId" );
		$Nome = $this->input->post ( "Nome" );
		$GestorId = $this->input->post ( "GestorId" );
		
		$this->load->model ( "SetorMod" );
		$this->SetorMod->setSetorId ( $SetorId );
		$this->SetorMod->setNome ( $Nome );
		$this->SetorMod->setFuncionarioId ( $GestorId );
		
		echo json_encode ( $this->SetorMod->setEdicao () );
	}
	public function montaGrid() {
		$this->CheckLogado ();
		
		$this->load->model ( "SetorMod" );
		echo json_encode ( $this->SetorMod->getSetores () );
	}
}
