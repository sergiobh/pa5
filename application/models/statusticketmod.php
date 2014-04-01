<?php
class StatusTicketMod extends CI_Model {
	private $StatusId;
	private $Nome;
	private $TipoBotao;
	public function getStatusId() {
		return $this->StatusId;
	}
	public function setStatusId($StatusId) {
		$this->StatusId = $StatusId;
	}
	public function getNome() {
		return $this->Nome;
	}
	public function setNome($Nome) {
		$this->Nome = $Nome;
	}
	public function getTipoBotao() {
		return $this->TipoBotao;
	}
	public function setTipoBotao($TipoBotao) {
		$this->TipoBotao = $TipoBotao;
	}
	public function getStatusTicket() {
		$sql = "
				SELECT
					*
				FROM
					ticket_status
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
?>