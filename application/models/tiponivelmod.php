<?php
class TipoNivelMod extends CI_Model {
	private $TipoNivelId;
	private $TipoId;
	private $Nivel;
	private $SetorId;
	public function getTipoNivelId() {
		return $this->TipoNivelId;
	}
	public function setTipoNivelId($TipoNivelId) {
		$this->TipoNivelId = $TipoNivelId;
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
	public function getSetorId() {
		return $this->SetorId;
	}
	public function setSetorId($SetorId) {
		$this->SetorId = $SetorId;
	}
	public function setTipoNivel() {
		$sql = "
 				INSERT INTO
 				ticket_tiponivel(
					TipoId
 					,Nivel
 					,SetorId
				)
 				VALUES(
					" . $this->TipoId . "
					," . $this->Nivel . "
					," . $this->SetorId . "
				)
 				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			
			$this->setTipoNivelId ( $this->db->insert_id () );
			
			return true;
		} else {
			return false;
		}
	}
}
?>