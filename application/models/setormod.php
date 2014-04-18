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
	public function getSetorId() {
		return $this->SetorId;
	}
	public function setNome($nome) {
		if (strlen ( $nome ) < 1) {
			$this->erroBreak = true;
			$this->erroMsg = "Campo Setor/Origem inválido!";
			return false;
		}
		
		$this->Nome = $nome;
		
		return true;
	}
	public function getNome() {
		return $this->Nome;
	}
	public function getFuncionarioId() {
		return $this->FuncionarioId;
	}
	public function setFuncionarioId($FuncionarioId) {
		$this->FuncionarioId = $FuncionarioId;
	}
	public function getErroMsg() {
		return $this->erroMsg;
	}
	public function getSetor() {
		if (strlen ( $this->Nome ) < 1) {
			$this->erroBreak = true;
			$this->erroMsg = "Campo Setor/Origem não preenchido!";
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
	public function setSetor() {
		if ($this->getSetor ()) {
			$retorno ['success'] = false;
			$retorno ['msg'] = 'Setor já cadastrado!';
			
			return $retorno;
		}
		
		$sql = "
				INSERT INTO
					setor(
						Nome
						,FuncionarioId
					)
				VALUES(
					'" . $this->Nome . "'
					," . $this->FuncionarioId . "
				)
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			
			$this->setSetorId ( $this->db->insert_id () );
			
			$retorno ['success'] = true;
			$retorno ['msg'] = 'Setor cadastrado com sucesso!';
		} else {
			$retorno ['success'] = false;
			$retorno ['msg'] = "Favor recarregar a página!";
		}
		
		return $retorno;
	}
	
	public function getSetores(){
		$sql = '
				SELECT
					S.SetorId
					,S.Nome
					,F.Nome AS "Gestor"
				FROM
					setor S
					INNER JOIN funcionario F ON F.FuncionarioId = S.FuncionarioId
				ORDER BY
					S.Nome
				';
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$retorno['success'] = true;
			$retorno['Setores'] = $dados;
		}
		else{
			$retorno['success'] = false;
			$retorno['Setores'] = false;
		}

		return $retorno;
	}
}
?>