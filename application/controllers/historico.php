<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Historico extends CI_Controller {
	public function anexo() {
		$this->CheckLogado ();
		
		$HistoricoId = $TicketId = $this->uri->segment ( 3 );
		
		$this->load->model ( "HistoricoMod" );
		$this->HistoricoMod->setHistoricoId ( $HistoricoId );
		
		$Url = $this->HistoricoMod->getUrl ();
		
		if (! $Url) {
			echo 'Você não possui permissão para acessar este arquivo!';
			exit ();
		}
		
		$this->load->helper ( 'download' );
		
		$diretorio = BASE_URL.$Url->diretorio;
		$nameFile = $Url->nameFile;
		
		$data = file_get_contents ( $diretorio . $nameFile );
		
		force_download ( $nameFile, $data );
	}
}
?>