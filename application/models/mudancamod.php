<?php
class MudancaMod extends CI_Model {
	private $MudancaId;
	private $Nome;
	private $Descricao;
	private $PrioridadeId;
	private $DH_Solicitacao;
	private $UsuarioId;
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
}
?>