<?php
class SetorFuncionarioMod extends CI_Model {
	private $SetorId;
	private $FuncionarId;
	private $erroBreak;
	private $erroMsg;
	public function SetorFuncionarioMod() {
		$this->erroBreak = false;
	}
	public function setSetorId($SetorId) {
		if (! is_numeric ( $SetorId )) {
			$this->erroBreak = true;
			$this->erroMsg = "Campo SetorId não é numérico!";
			return false;
		}
		$this->SetorId = $SetorId;
		return true;
	}
	public function setFuncionarioId($FuncionarioId) {
		if (! is_numeric ( $FuncionarioId )) {
			$this->erroBreak = true;
			$this->erroMsg = "Campo FuncionarioId não é numérico!";
			return false;
		}
		$this->FuncionarioId = $FuncionarioId;
		return true;
	}
	public function getErroMsg() {
		return $this->erroMsg;
	}
	public function getSetorFuncionario() {
		$sql = "
				SELECT
					*
				FROM
					setorfuncionario
				WHERE
					SetorId = " . $this->SetorId . " 
					AND FuncionarioId = " . $this->FuncionarioId . " 
				";
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$this->SetorId = $dados [0]->SetorId;
			$this->FuncionarId = $dados [0]->FuncionarioId;
			
			return true;
		} else {
			return false;
		}
	}
	public function setVinculo() {
		if($this->getSetorFuncionario()){
			return true;
		}
		
		$sql = "
                    INSERT INTO
                    setorfuncionario(
                        SetorId
						,FuncionarioId
                    )
                    VALUES(
                        " . $this->SetorId . "
                        ," . $this->FuncionarioId . "
                    )";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			return true;
		} else {
			$this->erroBreak = true;
			$this->erroMsg = "Favor recarregar a página!";
			
			return false;
		}
	}
}
?>