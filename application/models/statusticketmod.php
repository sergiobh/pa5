<?php
class StatusTicketMod extends CI_Model {
	private $StatusId;
	private $Permissao;
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
	public function setPermissao($Permissao) {
		$this->Permissao = $Permissao;
	}
	public function getStatusTicket() {
		$where = '';
		
		if ($this->StatusId != '' && is_numeric ( $this->StatusId )) {
			$where[] = $this->checkPermissao ();
		}
		
		$sql_where = ($where != '') ? ' WHERE '.implode ( " AND ", $where ) : '';
		
		$sql = "
				SELECT
					*
				FROM
					ticket_status
				" . $sql_where . "
				";

		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	private function checkPermissao() {
		$Opcoes = '';
		
		if ($this->Permissao == 'Solicitante') {
			$Opcoes = $this->StatusId;
		} else if ($this->Permissao == 'Setor') {
			if ($this->StatusId == 1) {
				$Opcoes = '1,4,6,7';
			} else {
				$Opcoes = $this->StatusId;
			}
		} else if ($this->Permissao == 'Chefe' || $this->Permissao == 'Atendente') {
			$Opcoes = '';
			
			if ($this->StatusId < 4) {
				$Opcoes = $this->StatusId . ',4,6,7';
			} else if ($this->StatusId == 4) {
				$Opcoes = '4,6,7';
			} else {
				$Opcoes = $this->StatusId;
			}
		}
		return 'StatusId IN (' . $Opcoes . ')';
	}
}
?>