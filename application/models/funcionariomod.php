<?php
class FuncionarioMod extends CI_Model {
	public $FuncionarioId;
	public $Nome;
	public $Cpf;
	public $Senha;
	public function setFuncionario($nome, $cpf, $senha) {
		$this->Nome = $nome;
		$this->Cpf = $cpf;
		$this->Senha = $senha;
	}
	public function getFuncionario($checkExistente = false) {
		$column = array ();
		$where = array ();
		
		if ($this->Cpf != "") {
			$column [] = "F.Senha";
			$where [] = "F.Cpf = " . $this->Cpf;
		}
		
		if ($this->FuncionarioId != "") {
			$condicao = ($checkExistente) ? ' != ' : ' = ';
			
			$where [] = "F.FuncionarioId " . $condicao . $this->FuncionarioId;
		}
		
		$sql_column = (count ( $column ) > 0) ? " ," . implode ( ",", $column ) : "";
		
		$sql_where = implode ( " AND ", $where );
		
		if ($sql_where == "") {
			return false;
		}
		
		$sql = "
                    SELECT
                        F.FuncionarioId
                        ,F.Nome
                        ,F.Cpf
                        $sql_column
                    FROM
                        funcionario F
                    WHERE
                       $sql_where
                    ";

		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function Listar() {
		$where = array();
		
		$FuncionarioIdSessao = $_SESSION ['Funcionario']->FuncionarioId; 
		
		if ($FuncionarioIdSessao != 1){
			$where[] = 'F.FuncionarioId = '.$FuncionarioIdSessao;
		}
		
		$sql_where = (count($where) > 0) ? ' WHERE '.implode(",", $where) : '';
		
		$sql = "
                    SELECT
                        F.FuncionarioId
                        ,F.Nome
                        ,F.Cpf
                    FROM
                        funcionario F
					$sql_where
                    ORDER BY
                        F.Nome
                    ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function SalvarCadastro() {
		if ($funcionario = $this->getFuncionario ()) {
			$Retorno = new stdClass();
			$Retorno->Status = false;
			$Retorno->Msg = "Funcionário já cadastrado!";
			$this->FuncionarioId = $Retorno->FuncionarioId = $funcionario->FuncionarioId;
			
			return $Retorno;
		}
		
		$this->load->library ( 'CriptografiaLib' );
		$this->Senha = $this->criptografialib->Gerar ( $this->Senha );
		
		$sql = "
                    INSERT INTO
                    funcionario(
                        Nome
                        ,Cpf
                        ,Senha
                    )
                    VALUES(
                        '" . $this->Nome . "'
                        ,'" . $this->Cpf . "'
                        ,'" . $this->Senha . "'
                    )";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			$Retorno->Status = true;
			$Retorno->Msg = "Funcionario cadastrado com sucesso!";
			$this->FuncionarioId = $Retorno->FuncionarioId = $this->db->insert_id ();
		} else {
			$Retorno->Status = false;
			$Retorno->Msg = "Favor recarregar a página!";
		}
		
		return $Retorno;
	}
	public function checkAcessoFuncionario() {

		if(! isset($_SESSION ['Funcionario']) ){
			return false;
		}
		
		$FuncionarioIdSessao = $_SESSION ['Funcionario']->FuncionarioId;
		
		if ($FuncionarioIdSessao == 1 || $FuncionarioIdSessao == $this->FuncionarioId) {
			$acesso = true;
		} else {
			$acesso = false;
		}
		
		return $acesso;
	}
	public function setEdicao() {
		if ( $this->getFuncionario (true)) {
			$retorno ['success'] = false;
			$retorno ['msg'] = "Cpf já cadastrado!";
			return json_encode ( $retorno );
		}
		
		$update = array();
		
		$update[] = 'Nome = "'.$this->Nome.'"';
		$update[] = 'Cpf = "'.$this->Cpf.'"';
		
		if($this->Senha != ""){
			$this->load->library ( 'CriptografiaLib' );
			$this->Senha = $this->criptografialib->Gerar ( $this->Senha );
			
			$update[] = 'Senha = "'.$this->Senha.'"';
		}
	
		$sql_update = implode(",", $update);
		
		$sql = "
				UPDATE
                	funcionario
				SET
                	$sql_update
				WHERE
					FuncionarioId = ".$this->FuncionarioId."
	            ";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			$retorno['success'] = true;
			$retorno['msg'] = "Dados salvos com sucesso!";
		} else {
			$retorno['success'] = true;
			$retorno['msg'] = "Nenhum campo foi alterado!";
		}
		
		return $retorno;
	}
}
?>