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
}