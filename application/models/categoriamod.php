<?php
class CategoriaMod extends CI_Model {
	private $CategoriaId;
	private $TicketId;
	private $StatusId;
	private $Permissao;
	private $Nome;
	public function getCategoriaId(){
		return $this->CategoriaId;
	}
	public function setCategoriaId($CategoriaId){
		$this->CategoriaId = $CategoriaId;
	}
	public function getTicketId() {
		return $this->TicketId;
	}
	public function setTicketId($TicketId) {
		$this->TicketId = $TicketId;
	}
	public function getStatusId() {
		return $this->StatusId;
	}
	public function setStatusId($StatusId) {
		$this->StatusId = $StatusId;
	}
	public function getNome(){
		return $this->Nome;
	}
	public function setNome($Nome){
		$this->Nome = $Nome;
	}
	public function getPermissao(){
		return $this->Permissao;
	}
	public function setPermissao($Permissao){
		$this->Permissao = $Permissao;
	}
	public function getCategoria() {
		$sql_from = '';
		$sql_where = '';
		
		// Filtra por tipo de StatusId
		// Caso Fechado, Cancelado ou Indeferido não se altera Categoria
		if ($this->StatusId != '' && $this->StatusId >= 5 && is_numeric($this->TicketId) && $this->TicketId != '' || $this->Permissao == 'Solicitante') {
			$from = array ();			
			$from [] = 'INNER JOIN ticket T ON T.TicketId = ' . $this->TicketId;
			$from [] = 'INNER JOIN ticket_tipo TT ON TT.TipoId = T.TipoId';			
			$sql_from = implode ( " ", $from );
			
			$where = array ();
			$where [] = 'TT.CategoriaId = TC.CategoriaId';

		}
		
		if($this->Nome != ''){
			$where [] = "TC.Nome = '".$this->Nome."'";
		}

		$sql_where = ($where != '') ? ' WHERE ' . implode ( " ", $where ) : '';
		
		$sql = "
                    SELECT
						TC.CategoriaId
						,TC.Nome
					FROM
						ticket_categoria TC
						" . $sql_from . "
					".$sql_where."
					ORDER BY
                        nome
                    ";

		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function setCategoria (){
		if($this->getCategoria()){
			$retorno['success'] = false;
			$retorno['msg'] = 'Categoria já cadastrada!';
			return $retorno;
		}

		$sql = "
				INSERT INTO
				ticket_categoria(
					Nome
				)
				VALUES(
					'".$this->Nome."'
				)			
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
				
			$this->setCategoriaId ( $this->db->insert_id () );
				
			$retorno ['success'] = true;
			$retorno ['msg'] = 'Categoria cadastrado com sucesso!';
		} else {
			$retorno ['success'] = false;
			$retorno ['msg'] = "Favor recarregar a página!";
		}
		
		return $retorno;
	}
}
?>