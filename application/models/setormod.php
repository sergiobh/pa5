<?php
class SetorMod extends CI_Model {
	private $SetorId;
	private $Nome;
	private $FuncionarioId;
	private $erroBreak;
	private $erroMsg;
	public function SetorMod() {
		$this->erroBreak = false;
	}
	public function setSetorId($setorId) {
		if (! is_numeric ( $setorId )) {
			$this->erroBreak = true;
			$this->erroMsg = "Campo setorId não é numérico!";
			return false;
		}
		$this->SetorId = $setorId;
		return true;
	}
	public function getSetorId(){
		return $this->SetorId;
	}
	public function setNome($nome) {
		if (strlen ( $nome ) < 1) {
			$this->erroBreak = true;
			$this->erroMsg = "Campo Origem inválido!";
			return false;
		}
		
		$this->Nome = $nome;
		
		return true;
	}
	public function getNome() {
		return $this->Nome;
	}
	public function getErroMsg() {
		return $this->erroMsg;
	}
	public function getSetor() {
		if (strlen ( $this->Nome ) < 1) {
			$this->erroBreak = true;
			$this->erroMsg = "Campo Origem não preenchido!";
			return false;
		}
		
		$sql = "
                    SELECT
                        S.*
                    FROM
                        setor S
                    WHERE
                        S.nome = '" . $this->Nome . "'
                    ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$this->SetorId = $dados [0]->SetorId;
			$this->Nome = $dados [0]->Nome;
			$this->FuncionarioId = $dados [0]->FuncionarioId;
			
			return true;
		} else {
			$this->erroBreak = true;
			$this->erroMsg = "Nenhum registro encontrado para o Setor!";
			return false;
		}
	}
}
?>