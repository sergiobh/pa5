<?php
class TicketMod extends CI_Model {
	private $TicketId;
	private $TipoId;
	private $FuncionarioId;
	private $StatusId;
	private $DH_Solicitacao;
	private $Descricao;
	private $DH_Previsao;
	private $DH_Baixa;
	private $Resultado;
	private $SetorId;
	private $AtendenteId;
	private $PrioridadeId;
	private $erroBreak;
	private $erroMsg;
	public function TicketMod() {
		$this->erroBreak = false;
	}
	public function getTicketId() {
		return $this->TicketId;
	}
	private function setTicketId($TicketId) {
		$this->TicketId = $TicketId;
	}
	public function getTipoId() {
		return $this->TipoId;
	}
	public function setTipoId($TipoId) {
		$this->TipoId = $TipoId;
	}
	public function getFuncionarioId() {
		return $this->FuncionarioId;
	}
	public function setFuncionarioId($FuncionarioId) {
		$this->FuncionarioId = $FuncionarioId;
	}
	public function getStatusId() {
		return $this->StatusId;
	}
	public function setStatusId($StatusId) {
		$this->StatusId = $StatusId;
	}
	public function getDH_Solicitacao() {
		return $this->DH_Solicitacao;
	}
	public function setDH_Solicitacao($DH_Solicitacao) {
		$this->DH_Solicitacao = $DH_Solicitacao;
	}
	public function getDescricao() {
		return $this->Descricao;
	}
	public function setDescricao($Descricao) {
		$this->Descricao = $Descricao;
	}
	public function getSetorId() {
		return $this->SetorId;
	}
	public function setSetorId($SetorId) {
		$this->SetorId = $SetorId;
	}
	public function getAtendenteId() {
		return $this->AtendenteId;
	}
	public function setAtendenteId($AtendenteId) {
		$this->AtendenteId = $AtendenteId;
	}
	public function getPrioridadeId() {
		return $this->PrioridadeId;
	}
	public function setPrioridadeId($PrioridadeId) {
		$this->PrioridadeId = $PrioridadeId;
	}
	public function setTicket() {
		$columnAtendenteId = ($this->AtendenteId != '') ? ',AtendenteId' : '';
		$valueAtendenteId = ($this->AtendenteId != '') ? ',' . $this->AtendenteId : '';
		
		$sql = "
				INSERT INTO
				ticket(
					TipoId
					,FuncionarioId
					,StatusId
					,DH_Solicitacao
					,Descricao
					,SetorId
					$columnAtendenteId
					,PrioridadeId
				)
				VALUES(
					$this->TipoId
					,$this->FuncionarioId
					,$this->StatusId
					,'" . $this->DH_Solicitacao . "'
					,'" . $this->Descricao . "'
					,$this->SetorId
					$valueAtendenteId
					,$this->PrioridadeId
				)
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			return true;
		} else {
			$this->erroBreak = true;
			$this->erroMsg = "Favor recarregar a página!";
			
			return false;
		}
	}
	public function salvarCadastro() {
		$this->setFuncionarioId ( $_SESSION ['Funcionario']->FuncionarioId );
		$this->setStatusId ( 1 );
		$this->setDH_Solicitacao ( date ( 'Y-m-d H:i:s' ) );
		
		$this->load->model ( "TipoTicketMod" );
		$this->TipoTicketMod->setTipoId ( $this->TipoId );
		$this->TipoTicketMod->getTipoTicket ();
		$this->setSetorId ( $this->TipoTicketMod->getSetorId () );
		$this->setPrioridadeId ( $this->TipoTicketMod->getPrioridadeId () );
		
		$dados ['msg'] = ($this->setTicket ()) ? 'Dados salvos com sucesso!' : 'Ocorreu um erro ao salvar, tente novamente!';
		$dados ['success'] = true;
		
		return json_encode ( $dados );
	}
}
?>