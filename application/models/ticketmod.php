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
	public function setTicketId($TicketId) {
		if (! is_numeric ( $TicketId ) || empty ( $TicketId )) {
			$this->erroBreak = true;
			$this->erroMsg = "TicketId inválido!";
			return false;
		}
		
		$this->TicketId = $TicketId;
		return true;
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
	public function getErroMsg() {
		return $this->erroMsg;
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
	public function getTickets() {
		$this->setFuncionarioId ( $_SESSION ['Funcionario']->FuncionarioId );
		$this->setAtendenteId ( $_SESSION ['Funcionario']->FuncionarioId );
		
		$sql = "
				SELECT
					T.TicketId
					,TC.Nome AS Categoria
					,TT.Nome AS TipoSolicitacao
					,DATE_FORMAT( T.DH_Solicitacao , '%d/%m/%Y %H:%i:%s' ) AS DH_Solicitacao
					,T.Descricao
					,IF(ISNULL(T.DH_Previsao), '-', T.DH_Previsao) AS DH_Previsao
					,TP.Nome AS Prioridade
				FROM 
					ticket T
					INNER JOIN ticket_tipo TT on TT.TipoId = T.TipoId
					INNER JOIN ticket_categoria TC ON TC.CategoriaId = TT.CategoriaId
					INNER JOIN ticket_prioridade TP on TP.PrioridadeId = T.PrioridadeId
				WHERE
					T.StatusId = $this->StatusId
					AND (
						T.FuncionarioId = " . $this->getFuncionarioId () . "
						OR T.AtendenteId = " . $this->getAtendenteId () . "
					) 
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function getTicket() {
		$this->setFuncionarioId ( $_SESSION ['Funcionario']->FuncionarioId );
		$this->setAtendenteId ( $_SESSION ['Funcionario']->FuncionarioId );
		
		$sql = "
				SELECT
					T.TicketId
					,TT.CategoriaId
					,T.TipoId
					,FS.Nome AS Solicitente
					,IF(ISNULL(FA.Nome), '-', FA.Nome ) AS Atendente
					,T.StatusId
					,T.Descricao
					,T.Resultado
					,T.PrioridadeId
					,T.SetorId
					,DATE_FORMAT( T.DH_Solicitacao , '%d/%m/%Y %H:%i:%s' ) AS DH_Solicitacao
					,IF(ISNULL(T.DH_Previsao), '-', DATE_FORMAT( T.DH_Previsao , '%d/%m/%Y %H:%i:%s' )) AS DH_Previsao
					,IF(ISNULL(T.DH_Baixa), '-', DATE_FORMAT( T.DH_Baixa , '%d/%m/%Y %H:%i:%s' )) AS DH_Baixa
				FROM
					ticket T
					INNER JOIN Funcionario FS ON FS.FuncionarioId = T.FuncionarioId
					INNER JOIN ticket_tipo TT ON TT.TipoId = T.TipoId
					LEFT JOIN Funcionario FA ON FA.FuncionarioId = T.AtendenteId
				WHERE
					T.ticketId = " . $this->getTicketId () . "
					AND (
							T.FuncionarioId = " . $this->getFuncionarioId () . "
							OR T.AtendenteId = " . $this->getAtendenteId () . "
					)
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (is_object ( $dados )) {
			
			$retorno['Ticket'] = $dados;
			$retorno['success'] = true;
			
			return json_encode($retorno);
		} else {
			return false;
		}
	}
}
?>