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
		
		$SetorId = $this->uri->segment ( 3 );
		
		$this->load->model ( "SetorMod" );
		$this->SetorMod->SetorId = $SetorId;
		$Setor = $this->SetorMod->getSetor ();
		
		$Status = (isset ( $Setor->Status )) ? $Setor->Status : 0;
		
		$Status = $this->SetorMod->getStatusAll ( $Status );
		
		$Dados ['Setor'] = $Setor;
		$Dados ['Status'] = $Status;
		
		$Dados ['success'] = true;
		
		echo json_encode ( $Dados );
	}
	public function salvarEdicao() {
		$this->CheckLogado ();
		
		$SetorId = $this->input->post ( "SetorId" );
		$QuartoId = $this->input->post ( "QuartoId" );
		$Identificacao = $this->input->post ( "Identificacao" );
		$Status = $this->input->post ( "Status" );
		
		$this->load->model ( "SetorMod" );
		$this->SetorMod->SetorId = $SetorId;
		$this->SetorMod->QuartoId = $QuartoId;
		$this->SetorMod->Identificacao = $Identificacao;
		$this->SetorMod->Status = $Status;
		$this->SetorMod->setEdicao ();
	}
	public function montaGrid() {
		$this->CheckLogado ();
		
		$this->load->model ( "SetorMod" );
		echo json_encode ( $this->SetorMod->getSetores () );
	}
}
