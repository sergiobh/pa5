<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Ticket_xml extends CI_Controller {
	public function importar() {
		$this->CheckLogado ();
		
		$Dados ['Script'] [] = 'jquery/bootstrap-filestyle.min.js';
		
		$Dados ['View'] = 'ticket_xml/importar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function loadxml() {
		$this->CheckLogado ();
		
		$config ['upload_path'] = './public/uploads/';
		$config ['allowed_types'] = 'xml|XML';
		$config ['max_size'] = '1024';
		
		$this->load->library ( 'upload', $config );
		
		if (! $this->upload->do_upload ( "ticketFile" )) {
			
			$Dados = array (
					'RespostaMsg' => $this->upload->display_errors () 
			);
			
			$Dados ['Script'] [] = 'jquery/bootstrap-filestyle.min.js';
			
			$Dados ['View'] = 'ticket_xml/importar';
			$this->load->view ( 'body/index', $Dados );
		} else {
			$config = $this->upload->data ( "ticketFile" );
			
			$file = $config ['full_path'];
			
			$ticketString = $this->getStringXml ( $file );
			
			$xml_objet = $this->converteXMLtoObject ( $ticketString );
			
			/*
			 * Xml Model -> Salvar Xml
			 */
			$this->load->model ( 'XmlMod' );
			$this->XmlMod->setXml ( $xml_objet );
			$Dados['RespostaXml'] = $this->XmlMod->salvaXml ();
			
			$this->removeFile ( $file );
				
			$Dados ['Script'] [] = 'jquery/bootstrap-filestyle.min.js';
				
			$Dados ['View'] = 'ticket_xml/importar';
			$this->load->view ( 'body/index', $Dados );
		}
	}
	private function converteXMLtoObject($xml) {
		try {
			$xml_object = new SimpleXMLElement ( $xml );
			if ($xml_object == false) {
				return false;
			}
		} catch ( Exception $e ) {
			return false;
		}
		
		return $xml_object;
	}
	private function getStringXml($file) {
		$this->load->helper ( 'file' );
		
		$string = read_file ( $file );
		
		return $string;
	}
	private function removeFile($url) {
		@unlink ( $url );
	}
	public function exportar() {
		$this->CheckLogado ();
		
		$TicketId = $this->uri->segment ( 3 );
		
		$this->load->model ( "XmlMod" );
		
		$this->XmlMod->setTicketId ( $TicketId );
		$Xml = $this->XmlMod->getTicket ();
		
		if (! $Xml) {
			echo '<h2>Xml inválido!!!</h2>';
			exit ();
		}
		
		$this->load->helper ( 'download' );
		
		$nameFile = 'xml_CORP_' . $TicketId . '.xml';
		
		force_download ( $nameFile, $Xml );
	}
}
?>