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
	public function listar(){
		$this->CheckLogado ();
		
		$TipoId = $this->uri->segment ( 3 );
		
		$Dados ['TipoId'] = $TipoId;
		
		$Dados ['View'] = 'tiponivel/listar';
		$this->load->view ( 'body/index', $Dados );
	}
}
?>