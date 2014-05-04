<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class TipoNivel extends CI_Controller {
	public function montaGrid() {
		$TipoId = $this->input->get ( "TipoId" );
		
		$this->load->model ( "TipoNivelMod" );
		$this->TipoNivelMod->setTipoId ( $TipoId );
		
		echo json_encode ( $this->TipoNivelMod->getTipoNivel () );
	}
	public function cadastrar() {
		$this->CheckLogado ();
		
		$TipoId = $this->uri->segment ( 3 );
		
		$Dados ['TipoId'] = $TipoId;
		
		$Dados ['View'] = 'tiponivel/cadastrar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function salvarCadastro() {
		$this->CheckLogado ();
		
		$TipoId = $this->input->post ( "TipoId" );
		$SetorId = $this->input->post ( "SetorId" );
		
		$this->load->model ( "TipoNivelMod" );
		$this->TipoNivelMod->setTipoId ( $TipoId );
		$this->TipoNivelMod->setSetorId ( $SetorId );
		
		$Cadastro = $this->TipoNivelMod->setNovoNivel ();
		
		$retorno ['success'] = ($Cadastro) ? true : false;
		$retorno ['msg'] = ($Cadastro) ? 'Cadastro do Nível salvo com sucesso!' : 'Ocorreu um erro ao salvar o cadastro, recarregando!';
		
		echo json_encode ( $retorno );
	}
	public function getMaxNivel(){
		$this->CheckLogado ();
		
		$TipoId = $this->input->get ( "TipoId" );
		
		$this->load->model ( "TipoNivelMod" );
		$this->TipoNivelMod->setTipoId ( $TipoId );
		
		$MaxNivel = $this->TipoNivelMod->getMaxNivel ();
		
		$retorno ['success'] = ($MaxNivel) ? true : false;
		$retorno['MaxNivel'] = $MaxNivel;
		
		echo json_encode ( $retorno );
	}
	public function remover(){
		$TipoId = $this->input->post ( "TipoId" );
		$Nivel = $this->input->post ( "Nivel" );
		
		$this->load->model ( "TipoNivelMod" );
		$this->TipoNivelMod->setTipoId ( $TipoId );
		$this->TipoNivelMod->setNivel ( $Nivel );
		
		$retorno = $this->TipoNivelMod->removeNivel ();
		
		echo json_encode($retorno);
	}
}
?>