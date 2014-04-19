<?php
class PrioridadeMod extends CI_Model {
	private $PrioridadeId;
	private $Permissao;
	private $Nivel;
	public function getPrioridadeId() {
		return $this->PrioridadeId;
	}
	public function setPrioridadeId($PrioridadeId) {
		$this->PrioridadeId = $PrioridadeId;
	}
	public function getPermissao() {
		return $this->Permissao;
	}
	public function setPermissao($Permissao) {
		$this->Permissao = $Permissao;
	}
	public function getNivel(){
		return $this->Nivel;
	}
	public function setNivel($Nivel){
		$this->Nivel = $Nivel;
	}
	public function getPrioridades() {
		$where = '';
		
		if ($this->Permissao != '') {
			$where = $this->checkPermissao ();
		}

		$sql_where = (is_array($where)) ? ' WHERE '.implode ( " AND ", $where ) : '';

		$sql = "
				SELECT
					TP.PrioridadeId
					,TP.Nome
				FROM
					ticket_prioridade TP
				".$sql_where."
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$retorno ['Prioridades'] = $dados;
			$retorno ['success'] = true;
			
			return json_encode ( $retorno );
		} else {
			$retorno ['Prioridades'] = false;
			$retorno ['success'] = true;
			
			return json_encode ( $retorno );
		}
	}
	private function checkPermissao() {
		$Opcoes = '';
		
		if ($this->Permissao == 'Solicitante' || $this->Nivel != 1) {
			$Opcoes[] = 'TP.PrioridadeId = ' . $this->PrioridadeId;
		}
		
		return $Opcoes;
	}
}
?>