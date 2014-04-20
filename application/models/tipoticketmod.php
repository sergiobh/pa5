<?php
class TipoTicketMod extends CI_Model {
	private $TipoId;
	private $Nivel;
	private $Nome;
	private $CategoriaId;
	private $SetorId;
	private $PrioridadeId;
	private $SLA;
	private $erroBreak;
	private $erroMsg;
	private $ReturnObject;
	private $TicketId;
	private $StatusId;
	public function TipoTicketMod() {
		$this->erroBreak = false;
		
		// Nivel padrao se não for alterado!
		$this->Nivel = 1;
		
		$this->ReturnObject = true;
	}
	private function populaTipoTicket($TipoId, $Nome, $CategoriaId, $SetorId, $PrioridadeId, $SLA) {
		$this->TipoId = $TipoId;
		$this->Nome = $Nome;
		$this->CategoriaId = $CategoriaId;
		$this->SetorId = $SetorId;
		$this->PrioridadeId = $PrioridadeId;
		$this->SLA = $SLA;
	}
	public function getTipoId() {
		return $this->TipoId;
	}
	public function setTipoId($TipoId) {
		$this->TipoId = $TipoId;
	}
	public function getNivel() {
		return $this->Nivel;
	}
	public function setNivel($Nivel) {
		$this->Nivel = $Nivel;
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
		return $this->PrioridadeId;
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
	public function setReturnObject($ReturnObject) {
		$this->ReturnObject = $ReturnObject;
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
	public function getTipoTicket() {
		$select = array ();
		$from = array ();
		$where = array ();
		$order = array ();
		
		$select [] = "TT.TipoId";
		$select [] = "TT.Nome";
		
		if ($this->CategoriaId != '') {
			
			// Filtra por tipo de StatusId
			// Caso Fechado, Cancelado ou Indeferido não se altera Tipo de Ticket
			if ($this->StatusId != '' && $this->StatusId >= 5 && is_numeric ( $this->TicketId )) {
				
				$from [] = 'INNER JOIN ticket T ON T.TicketId = ' . $this->TicketId;
				$sql_from = implode ( " ", $from );
				
				$where [] = 'TT.TipoId = T.TipoId';
			}
			
			$where [] = "TT.CategoriaId = " . $this->CategoriaId;
			$order [] = "TT.Nome";
		} else {
			
			if ($this->TipoId != '') {
				$where [] = "TT.TipoId = " . $this->TipoId;
			}
			if ($this->Nome != '') {
				$where [] = "TT.Nome = '" . $this->Nome . "'";
			}
			if ($this->SetorId != '') {
				$where [] = "TTN.SetorId = " . $this->SetorId;
			}
			
			$select [] = "TT.CategoriaId";
			$select [] = "TT.PrioridadeId";
			$select [] = "TT.SLA";
			$select [] = "TTN.SetorId";
			$select [] = "TTN.Nivel";
			
			$where [] = "TTN.Nivel = " . $this->Nivel;
			
			$from [] = 'INNER JOIN ticket_tiponivel TTN ON TTN.TipoId = TT.TipoId';
		}
		
		if ($where === '') {
			$this->erroBreak = true;
			$this->erroMsg = "Nenhum campo filtrado para Tipo ticket";
			return false;
		}
		
		$sql_select = implode ( ", ", $select );
		
		$sql_from = implode ( " AND ", $from );
		
		$sql_where = implode ( " AND ", $where );
		
		$sql_order = implode ( ", ", $order );
		$sql_order = ($sql_order != '') ? " ORDER BY " . $sql_order : '';
		
		$sql = "
				SELECT					
					" . $sql_select . "
				FROM 
					ticket_tipo TT
					" . $sql_from . "
				WHERE
					" . $sql_where . $sql_order;

		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		$QtdRows = count ( $dados );
		
		if ($QtdRows == 1 && $this->ReturnObject) {
			$dado = $dados [0];
			$this->populaTipoTicket ( $dado->TipoId, $dado->Nome, $dado->CategoriaId, $dado->SetorId, $dado->PrioridadeId, $dado->SLA );
			
			return true;
		} else if ($QtdRows > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function buscaSla() {
		$sql = "
				SELECT
					Sla
				FROM
					ticket_tipo
				WHERE
					TipoId = " . $this->TipoId . "
				";
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados )) {
			return $dados [0]->Sla;
		} else {
			echo 'Query para buscar SLA falhou!!!';
			exit ();
		}
	}
}
?>