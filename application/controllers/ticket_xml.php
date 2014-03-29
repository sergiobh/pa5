<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Ticket_xml extends CI_Controller {
	public function importar() {
		$Dados ['Script'] [] = 'jquery/bootstrap-filestyle.min.js';
		
		$Dados ['View'] = 'ticket_xml/importar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function loadxml() {
		$config ['upload_path'] = './public/uploads/';
		$config ['allowed_types'] = 'xml';
		$config ['max_size'] = '1024';
		
		$this->load->library ( 'upload', $config );
		
		if (! $this->upload->do_upload ( "ticketFile" )) {
			echo 'ta dando erro antes de upload, provavel chegou a 100';exit;
			
			$data = array (
					'error' => $this->upload->display_errors () 
			);
			
			$Dados ['Script'] [] = 'jquery/bootstrap-filestyle.min.js';
			
			$Dados ['View'] = 'ticket_xml/importar';
			$this->load->view ( 'body/index', $Dados );
		} else {
			$config = $this->upload->data ( "ticketFile" );
			
			$file = $config ['full_path'];
			
			$ticketString = $this->getStringXml ( $file );
			
			$xml_objet = $this->converteXMLtoObject ( $ticketString );
			
			// echo '<pre>';print_r($xml_objet);exit;
			/*
			 * Xml Model -> Salvar Xml
			 */
			$this->load->model ( 'XmlMod' );
			$this->XmlMod->setXml ( $xml_objet );	
			$this->XmlMod->salvaXml ();
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
}

?>