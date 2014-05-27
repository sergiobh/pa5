<?php
class PrioridadeMod extends CI_Model {
	private $PrioridadeId;
	private $Permissao;
	private $Nivel;
	private $RestringePlanejada;
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
	public function getNivel() {
		return $this->Nivel;
	}
	public function setNivel($Nivel) {
		$this->Nivel = $Nivel;
	}
	public function getRestringePlanejada(){
		return $this->RestringePlanejada;
	}
	public function setRestringePlanejada($RestringePlanejada){
		$this->RestringePlanejada = $RestringePlanejada;
	}
	public function getPrioridades() {
		$columns = array();
		$where = '';
 
		if ($this->Permissao != NULL) {
			$where = $this->checkPermissao ();
		}
		else if($this->RestringePlanejada === true){
			$columns[] = 'TipoBotao';
			$where[] = "TP.PrioridadeId < 6 ";
		}
		
		$sql_columns = (count($columns) > 0) ? ','.implode(',', $columns) : '';
		
		$sql_where = (is_array ( $where )) ? ' WHERE ' . implode ( " AND ", $where ) : '';
		
		$sql = "
				SELECT
					TP.PrioridadeId
					,TP.Nome
					$sql_columns
				FROM
					ticket_prioridade TP
				" . $sql_where . "
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$retorno ['Prioridades'] = $dados;
			$retorno ['success'] = true;
		} else {
			$retorno ['success'] = false;
			$retorno ['Prioridades'] = false;
		}
		
		return json_encode ( $retorno );
	}
	private function checkPermissao() {
		$Opcoes = '';
		
		if ($this->Permissao == 'Solicitante' || $this->Permissao == 'Setor') {
			$Opcoes [] = 'TP.PrioridadeId = ' . $this->PrioridadeId;
		}
		
		return $Opcoes;
	}
}
?>