<?php
class TipoTicketMod extends CI_Model {
	private $TipoId;
	private $Nome;
	private $CategoriaId;
	private $SetorId;
	private $PriodidadeId;
	private $SLA;
	private $erroBreak;
	private $erroMsg;
	public function TipoTicket() {
		$this->erroBreak = false;
	}
	private function populaTipoTicket($TipoId, $Nome, $CategoriaId, $SetorId, $PriodidadeId, $SLA) {
		$this->TipoId = $TipoId;
		$this->Nome = $Nome;
		$this->CategoriaId = $CategoriaId;
		$this->SetorId = $SetorId;
		$this->PriodidadeId = $PriodidadeId;
		$this->SLA = $SLA;
	}
	public function getTipoId() {
		return $this->TipoId;
	}
	public function setTipoId($TipoId) {
		$this->TipoId = $TipoId;
	}
	public function getNome() {
		return $this->Nome;
	}
	public function setNome($Nome) {
		$this->Nome = $Nome;
	}
	public function getCategoriaId() {
		return $this->CategoriaId;
	}
	public function setCategoriaId($CategoriaId) {
		$this->CategoriaId = $CategoriaId;
	}
	public function getSetorId() {
		return $this->SetorId;
	}
	public function setSetorId($SetorId) {
		$this->SetorId = $SetorId;
	}
	public function getPrioridadeId() {
		return $this->PriodidadeId;
	}
	public function setPrioridadeId($PrioridadeId) {
		$this->PrioridadeId = $PrioridadeId;
	}
	public function getSLA() {
		return $this->SLA;
	}
	public function setSLA($SLA) {
		$this->SLA = $SLA;
	}
	public function getTipoTicket($ReturnObject = true) {
		$select = array ();
		$order = array ();
		
		if ($this->TipoId != '') {
			$where [] = "tipoid = " . $this->TipoId;
		}
		if ($this->TipoId != '') {
			$where [] = "tipoid = " . $this->TipoId;
		}
		if ($this->Nome != '') {
			$where [] = "nome = '" . $this->Nome . "'";
		}
		if ($this->SetorId != '') {
			$where [] = "setorid = " . $this->SetorId;
		}
		if ($this->CategoriaId != '') {
			$select [] = "tipoid";
			$select [] = "nome";
			$where [] = "categoriaId = " . $this->CategoriaId;
			$order [] = "nome";
		}
		
		if ($where === '') {
			$this->erroBreak = true;
			$this->erroMsg = "Nenhum campo filtrado para Tipo ticket";
			return false;
		}
		
		$sql_select = implode ( ", ", $select );
		$sql_select = ($sql_select != '') ? $sql_select : '*';
		
		$sql_where = implode ( " AND ", $where );
		
		$sql_order = implode ( ", ", $order );
		$sql_order = ($sql_order != '') ? " ORDER BY " . $sql_order : '';
		
		$sql = "
				SELECT
					" . $sql_select . "
				FROM 
					ticket_tipo
				WHERE
					" . $sql_where . $sql_order;
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		$QtdRows = count ( $dados );
		
		if ($QtdRows == 1 && $ReturnObject) {
			$dado = $dados [0];
			$this->populaTipoTicket ( $dado->TipoId, $dado->Nome, $dado->CategoriaId, $dado->SetorId, $dado->PriodidadeId, $dado->SLA );
			
			return true;
		} else if ($QtdRows > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	
	/*
	 * public function setTipoTicket(){ $sql = " INSERT INTO ticket_tipo( ) VALUES( ) "; }
	 */
}
?>