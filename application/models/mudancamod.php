<?php
class MudancaMod extends CI_Model {
	private $MudancaId;
	private $Nome;
	private $Descricao;
	private $PrioridadeId;
	private $DH_Solicitacao;
	private $UsuarioId;
	private $Autorizacoes;
	public function getMudancaId() {
		return $this->MudancaId;
	}
	public function setMudancaId($MudancaId) {
		$this->MudancaId = $MudancaId;
	}
	public function getNome() {
		return $this->Nome;
	}
	public function setNome($Nome) {
		$this->Nome = $Nome;
	}
	public function getDescricao() {
		return $this->Descricao;
	}
	public function setDescricao($Descricao) {
		$this->Descricao = $Descricao;
	}
	public function getPrioridadeId() {
		return $this->PrioridadeId;
	}
	public function setPrioridadeId($PrioridadeId) {
		$this->PrioridadeId = $PrioridadeId;
	}
	public function getDH_Solicitacao() {
		return $this->DH_Solicitacao;
	}
	public function setDH_Solicitacao($DH_Solicitacao) {
		$this->DH_Solicitacao = $DH_Solicitacao;
	}
	public function getUsuarioId() {
		return $this->UsuarioId;
	}
	public function setUsuarioId($UsuarioId) {
		$this->UsuarioId = $UsuarioId;
	}
	public function criarDH_Solicitacao() {
		$this->DH_Solicitacao = date ( 'Y-m-d H:i:s' );
	}
	public function getAutorizacoes(){
		return $this->Autorizacoes;
	}
	public function setAutorizacoes(){
		$Autorizacao = new stdClass();
		$Autorizacao->AutorizacaoId = 0;
		$Autorizacao->Nome = 'Aguardando';
	
		$this->Autorizacoes[] = $Autorizacao;
	
		$Autorizacao = new stdClass();
		$Autorizacao->AutorizacaoId = 1;
		$Autorizacao->Nome = 'Autorizado';
	
		$this->Autorizacoes[] = $Autorizacao;
	}
	public function setMudanca() {
		$this->criarDH_Solicitacao ();
		
		$this->setUsuarioId ( $_SESSION ['Funcionario']->FuncionarioId );
		
		$this->load->model ( "TransactionMod" );
		$this->TransactionMod->Start ();
		
		$sql = "
				INSERT INTO
					mudanca (
						Nome,
						Descricao,
						UsuarioId,
						PrioridadeId,
						DH_Solicitacao
				)
				VALUES (
					'" . $this->Nome . "',
					'" . $this->Descricao . "',
					$this->UsuarioId,
					$this->PrioridadeId,
					'" . $this->DH_Solicitacao . "'
				)";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			$this->TransactionMod->Commit ();
			echo '{"success": true, "msg": "Dados salvos com sucesso!" }';
		} else {
			$this->TransactionMod->Rollback ();
			echo '{"success": false, "msg": "Ocorreu um erro ao salvar, tente novamente!" }';
		}
	}
	public function getMudancas() {				
		$sql = "
				SELECT
					M.MudancaId
					,M.Nome
					,TP.Nome AS Prioridade
					,CASE M.AutorizacaoDesenvolvimento
						WHEN 1 THEN 'Autorizado'
						ELSE 'Aguardando'
					END AS Autorizacao
					,IF(M.AutorizacaoDesenvolvimento = 1,
						CASE M.Avaliacao
							WHEN 0 THEN 'Reprovado'
							ELSE 'Aprovado'
						END,
						'-'
					)AS Avaliacao 
					,DATE_FORMAT(
						M.DH_Solicitacao,
						'%d/%m/%Y %H:%i:%s'
					) AS DH_Solicitacao
				FROM
					mudanca M
					INNER JOIN ticket_prioridade TP ON TP.PrioridadeId = M.PrioridadeId
				WHERE
					M.PrioridadeId = ".$this->PrioridadeId."
				";

		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function getMudanca(){
		$sql = "
				SELECT
					M.MudancaId
					,M.Nome
					,M.Descricao
					,M.PrioridadeId
					,M.AutorizacaoDesenvolvimento
					,DATE_FORMAT(
						M.DH_Solicitacao,
						'%d/%m/%Y %H:%i:%s'
					) AS DH_Solicitacao
					,F.Nome AS Usuario
				FROM
					mudanca M
					INNER JOIN funcionario F ON F.FuncionarioId = M.UsuarioId
				WHERE
					M.MudancaId = ".$this->MudancaId."
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados[0];
		} else {
			return false;
		}
	}
}
?>