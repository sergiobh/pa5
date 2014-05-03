<?php
class Ticket_AtendimentoMod extends CI_Model {
	private $AtendimentoId;
	private $TicketId;
	private $Tipo_Nivel;
	private $StatusId;
	private $AtendenteId;
	private $DH_Solicitacao;
	private $Ativo;
	public function getAtendimentoId() {
		return $this->AtendimentoId;
	}
	public function setAtendimentoId($AtendimentoId) {
		$this->AtendimentoId = $AtendimentoId;
	}
	public function getTicketId() {
		return $this->TicketId;
	}
	public function setTicketId($TicketId) {
		$this->TicketId = $TicketId;
	}
	public function getTipo_Nivel() {
		return $this->Tipo_Nivel;
	}
	public function setTipo_Nivel($Tipo_Nivel) {
		$this->Tipo_Nivel = $Tipo_Nivel;
	}
	public function getStatusId() {
		return $this->StatusId;
	}
	public function setStatusId($StatusId) {
		$this->StatusId = $StatusId;
	}
	public function getAtendenteId() {
		return $this->AtendenteId;
	}
	public function setAtendenteId($AtendenteId) {
		$this->AtendenteId = $AtendenteId;
	}
	public function getDH_Solicitacao() {
		return $this->DH_Solicitacao;
	}
	public function setDH_Solicitacao($DH_Solicitacao) {
		$this->DH_Solicitacao = $DH_Solicitacao;
	}
	public function getAtivo() {
		return $this->Ativo;
	}
	public function setAtivo($Ativo) {
		$this->Ativo = $Ativo;
	}
	public function criarDH_Solicitacao() {
		$this->DH_Solicitacao = date ( 'Y-m-d H:i:s' );
	}
	public function setAtendimento() {
		$columnAtendente = ($this->AtendenteId != NULL) ? ',AtendenteId' : '';
		$valueAtendente = ($this->AtendenteId != NULL) ? ',' . $this->AtendenteId : '';
		
		$sql = "
				INSERT INTO
					ticket_atendimento (
						TicketId
						,Tipo_Nivel
						,StatusId
						" . $columnAtendente . "
						,DH_Solicitacao
						,Ativo
				)
				VALUES (
					" . $this->TicketId . "
					," . $this->Tipo_Nivel . "					
					," . $this->StatusId . "
					" . $valueAtendente . "
					,'" . $this->DH_Solicitacao . "'
					," . $this->Ativo . "
				)		
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			$this->setAtendimentoId ( $this->db->insert_id () );
			
			return true;
		} else {
			return false;
		}
	}
	public function setNovoNivel() {
		if ($Tipo_Nivel = $this->checkTransferencia ()) {
			$this->setTipo_Nivel ( $Tipo_Nivel );
			$this->setStatusId ( 1 );
			$this->setAtendenteId ( NULL );
			$this->criarDH_Solicitacao ();
			$this->setAtivo ( 1 );
			
			return $this->setAtendimento ();
		}
	}
	public function possuiProximoAtendimento($RestringeExistente = false) {
		$ProximoNivel = $this->Tipo_Nivel + 1;
		
		$where = array ();
		
		if ($RestringeExistente) {
			$where [] = 'TA.StatusId <= 4';
		}
		
		$sql_where = (count ( $where ) > 0) ? ' AND ' . implode ( ' AND ', $where ) : '';
		
		$sql = "
				SELECT
					TA.AtendimentoId
				FROM
					ticket_atendimento TA
				WHERE
					TA.TicketId = " . $this->TicketId . "
					AND TA.Tipo_Nivel = " . $ProximoNivel . "
					AND TA.Ativo = 1
					" . $sql_where . "
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (is_object ( $dados )) {
			$this->AtendimentoId = $dados->AtendimentoId;
			
			return true;
		} else {
			return false;
		}
	}
	public function checkProximoAtendimento() {
		$ProximoNivel = $this->Tipo_Nivel + 1;
		
		$sql = "
				SELECT
					TTN.TipoNivelId
				FROM
					ticket T
					INNER JOIN ticket_tiponivel TTN ON TTN.TipoId = T.TipoId
				WHERE
					T.TicketId = " . $this->TicketId . "
					AND TTN.Nivel = " . $ProximoNivel . "
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (is_object ( $dados )) {
			return true;
		} else {
			return false;
		}
	}
	public function checkTransferencia() {
		$AtendimentoExistente = $this->possuiProximoAtendimento ( true );
		
		$Possibilidade = $this->checkProximoAtendimento ();
		
		if ($Possibilidade && ! $AtendimentoExistente) {
			return $this->Tipo_Nivel + 1;
		} else {
			return false;
		}
	}
	public function setDesativarAtendimentos() {
		$sql = "
				UPDATE
					ticket_atendimento
				SET
					Ativo = 0
				WHERE
					TicketId = " . $this->TicketId . "				
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function updateAtendimento() {
		$sql = "
				UPDATE
					ticket_atendimento
				SET
					StatusId = " . $this->StatusId . "
					,AtendenteId = " . $this->AtendenteId . "
				WHERE
					TicketId = " . $this->TicketId . "
					AND Tipo_Nivel = " . $this->Tipo_Nivel . "
					AND Ativo = 1
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function getAtendimentos() {
		$sql = "
				SELECT
					TA.AtendimentoId
					,TA.Tipo_Nivel
					,TS.Nome AS Status
					,IF( F.Nome IS NULL, '-', F.Nome ) AS Atendente
					,DATE_FORMAT( TA.DH_Solicitacao , '%d/%m/%Y %H:%i:%s' ) AS DH_Solicitacao
					,IF(TA.Ativo = 1, 'Sim', 'Não' ) AS Ativo
				FROM
					ticket_atendimento TA
					INNER JOIN ticket_status TS ON TS.StatusId = TA.StatusId
					LEFT JOIN funcionario F ON F.FuncionarioId = TA.AtendenteId
				WHERE
					TA.TicketId = " . $this->TicketId . "
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
}