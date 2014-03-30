<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Categoria extends CI_Controller {
	public function getCategorias() {
		$this->load->model ( 'CategoriaMod' );
		$Categorias = $this->CategoriaMod->getCategoria ();
		$Dados ["Categorias"] = $Categorias;
		
		$Dados ["success"] = true;
		echo json_encode ( $Dados );
	}
}
?>