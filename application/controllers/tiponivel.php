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
}
?>