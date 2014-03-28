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
		// $config['max_width'] = '1024';
		// $config['max_height'] = '768';
		
		$this->load->library('upload', $config); 
		
		if (! $this->upload->do_upload ("ticketFile")) {
			$error = array (
					'error' => $this->upload->display_errors () 
			);
			
			$error = array (
					'error' => $this->upload->display_errors () 
			);
			
			echo "<pre>";
			print_r ( $error );
			
			// $this->load->view('upload_form', $error);
			echo "entrou no erro";
		} else {
		
			$data = array (
					'ticketFile' => $this->upload->data () 
			);
			
			// $this->load->view('upload_success', $data);
			
			echo "<pre>";
			foreach ( $data["ticketFile"] as $item => $value ) {
				echo $item . " : " . $value."<br/>";
			}
			
			/*
			 * file_name : teste3.xml
				file_type : text/xml
				file_path : D:/server_php/sghh/public/uploads/
				full_path : D:/server_php/sghh/public/uploads/teste3.xml
				raw_name : teste3
				orig_name : teste.xml
				client_name : teste.xml
				file_ext : .xml
				file_size : 0.01
				is_image : 
				image_width : 
				image_height : 
				image_type : 
				image_size_str : 
			 * */
		}
	}
}
?>