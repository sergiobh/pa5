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
	private $Permissao;
	private $TicketGravado;
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
	public function getResultado() {
		return $this->Resultado;
	}
	public function setResultado($Resultado) {
		$this->Resultado = $Resultado;
	}
	public function getErroMsg() {
		return $this->erroMsg;
	}
	public function getErroBreak() {
		return $this->erroBreak;
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
					,SetorId
					$columnAtendenteId
					,PrioridadeId
				)
				VALUES(
					$this->TipoId
					,$this->FuncionarioId
					,$this->StatusId
					,'" . $this->DH_Solicitacao . "'
					,$this->SetorId
					$valueAtendenteId
					,$this->PrioridadeId
				)
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			
			$this->setTicketId ( $this->db->insert_id () );
			
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
		
		if (! $this->setTicket ()) {
			$dados ['msg'] = 'Ocorreu um erro ao salvar, tente novamente!';
		} else {
			$this->load->model ( "HistoricoMod" );
			$this->HistoricoMod->setTicketId ( $this->getTicketId () );
			$this->HistoricoMod->setTexto ( $this->getDescricao () );
			$this->HistoricoMod->setHistoricoTipoId ( 1 ); // Mensagem do Solicitante
			$this->HistoricoMod->setUsuarioId ( $this->getFuncionarioId () );
			$this->HistoricoMod->setDH_Cadastro ( $this->getDH_Solicitacao () );
			
			$dados ['msg'] = ($this->HistoricoMod->setHistorico ()) ? 'Dados salvos com sucesso!' : 'Ocorreu um erro ao salvar, tente novamente!';
		}
		
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
					,TH.Texto AS Descricao
					,IF(ISNULL(T.DH_Previsao), '-', T.DH_Previsao) AS DH_Previsao
					,TP.Nome AS Prioridade
				FROM 
					ticket T
					INNER JOIN ticket_tipo TT ON TT.TipoId = T.TipoId
					INNER JOIN ticket_categoria TC ON TC.CategoriaId = TT.CategoriaId
					INNER JOIN ticket_prioridade TP ON TP.PrioridadeId = T.PrioridadeId
					INNER JOIN ticket_historico TH ON TH.TicketId = T.TicketId						
					INNER JOIN Funcionario FS ON FS.FuncionarioId = T.FuncionarioId
					LEFT JOIN Funcionario FA ON FA.FuncionarioId = T.AtendenteId					
					LEFT JOIN setor S ON S.SetorId = T.SetorId AND S.FuncionarioId = " . $this->getFuncionarioId () . "
					LEFT JOIN setorfuncionario SF ON SF.SetorId = T.SetorId AND SF.FuncionarioId = " . $this->getFuncionarioId () . "
				WHERE
					T.StatusId = $this->StatusId
					AND TH.HistoricoTipoId = 1
					AND (
						T.FuncionarioId = " . $this->getFuncionarioId () . "
						OR T.AtendenteId = " . $this->getAtendenteId () . "
						OR S.FuncionarioId IS NOT NULL
						OR SF.SetorFuncionarioId IS NOT NULL
					) 
				GROUP BY
					TH.TicketId
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
					,T.PrioridadeId
					,T.SetorId
					,DATE_FORMAT( T.DH_Solicitacao , '%d/%m/%Y %H:%i:%s' ) AS DH_Solicitacao
					,IF(ISNULL(T.DH_Aceite), '-', DATE_FORMAT( T.DH_Aceite , '%d/%m/%Y %H:%i:%s' )) AS DH_Aceite
					,IF(ISNULL(T.DH_Previsao), '-', DATE_FORMAT( T.DH_Previsao , '%d/%m/%Y %H:%i:%s' )) AS DH_Previsao
					,IF(ISNULL(T.DH_Baixa), '-', DATE_FORMAT( T.DH_Baixa , '%d/%m/%Y %H:%i:%s' )) AS DH_Baixa
					,CASE
						WHEN S.FuncionarioId IS NOT NULL THEN 'Chefe'
						WHEN T.AtendenteId = " . $this->getFuncionarioId () . " THEN 'Atendente'
						WHEN SF.SetorFuncionarioId IS NOT NULL THEN 'Setor'
						WHEN T.FuncionarioId = " . $this->getFuncionarioId () . " THEN 'Solicitante'
					END AS Permissao
				FROM
					ticket T
					INNER JOIN ticket_tipo TT ON TT.TipoId = T.TipoId
					INNER JOIN Funcionario FS ON FS.FuncionarioId = T.FuncionarioId
					LEFT JOIN Funcionario FA ON FA.FuncionarioId = T.AtendenteId					
					LEFT JOIN setor S ON S.SetorId = T.SetorId AND S.FuncionarioId = " . $this->getFuncionarioId () . "
					LEFT JOIN setorfuncionario SF ON SF.SetorId = T.SetorId AND SF.FuncionarioId = " . $this->getFuncionarioId () . "
				WHERE
					T.ticketId = " . $this->getTicketId () . "
					AND (
						T.FuncionarioId = " . $this->getFuncionarioId () . "
						OR T.AtendenteId = " . $this->getAtendenteId () . "
						OR S.FuncionarioId IS NOT NULL
						OR SF.SetorFuncionarioId IS NOT NULL
					)
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (is_object ( $dados )) {
			
			$retorno ['Ticket'] = $dados;
			$retorno ['success'] = true;
			
			return json_encode ( $retorno );
		} else {
			$retorno ['Ticket'] = false;
			$retorno ['success'] = true;
			
			return json_encode ( $retorno );
		}
	}
	public function salvarEdicao() {
		
		// $this->Permissao = $this->getPermissao();
		$TicketGravado = json_decode ( $this->getTicket () );
		$this->TicketGravado = $TicketGravado->Ticket;
		
		$this->load->model ( "TipoTicketMod" );
		$this->TipoTicketMod->setTipoId ( $this->TipoId );
		$this->TipoTicketMod->getTipoTicket ();
		$this->setSetorId ( $this->TipoTicketMod->getSetorId () );
		
		$sql_set = $this->montaSetUpdate ();
		
		$sql = "
				UPDATE
					ticket
				SET
					" . $sql_set . "
				WHERE
					TicketId = " . $this->TicketId . "
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			$retorno ["msg"] = "Dados salvos com sucesso!";
		} else {
			$retorno ["msg"] = "Altere pelo menos um dos campos!";
		}
		
		$retorno ['success'] = true;
		
		return json_encode ( $retorno );
	}
	private function montaSetUpdate() {
		$setUpdate = array ();
		
		if ($this->TicketGravado->Permissao == 'Chefe' || $this->TicketGravado->Permissao == 'Atendente') {
			
			// Se Aberto, Respondido ou Em Manutenção
			if (in_array ( $this->TicketGravado->StatusId, array (
					1,
					3,
					4 
			) )) {
				$setUpdate [] = "TipoId = " . $this->TipoId;
				$setUpdate [] = "StatusId = " . $this->StatusId;
			}
			
			// Se Em Manutenção
			if (in_array ( $this->StatusId, array (
					4 
			) )) {
				$setUpdate [] = "DH_Previsao = '" . $this->criaDH_Previsao () . "'";
			}
			
			// Fechado
			if (in_array ( $this->StatusId, array (
					5 
			) )) {
				$setUpdate [] = "DH_Baixa = '" . date ( 'Y-m-d H:i:s' ) . "'";
			}
			
			// Em Aberto ou Em Manutenção
			if (in_array ( $this->StatusId, array (
					1,
					4 
			) ) && $this->Resultado != '') {
				$this->StatusId = 2; // Recebe Aguardando Resposta
			}
			
			$setUpdate [] = "Resultado = '" . $this->Resultado . "'";
			$setUpdate [] = "SetorId = " . $this->SetorId;
			$setUpdate [] = "AtendenteId = " . $this->AtendenteId;
			$setUpdate [] = "PrioridadeId = " . $this->PrioridadeId;
		} else if ($this->TicketGravado->Permissao == 'Setor') {
			if (in_array ( $this->TicketGravado->StatusId, array (
					1 
			) )) {
				$setUpdate [] = "TipoId = " . $this->TipoId;
				$setUpdate [] = "StatusId = " . $this->StatusId;
			}
			
			// Se o Setor selecionar o Ticket para Em Manutenção, Cancelado, Indeferido
			if (in_array ( $this->StatusId, array (
					4 
			) )) {
				$this->setFuncionarioId ( $_SESSION ['Funcionario']->FuncionarioId );
				
				$setUpdate [] = "TipoId = " . $this->TipoId;
				$setUpdate [] = "StatusId = " . $this->StatusId;
				$setUpdate [] = "Resultado = '" . $this->Resultado . "'";
				$setUpdate [] = "SetorId = " . $this->SetorId;
				$setUpdate [] = "AtendenteId = " . $this->getFuncionarioId ();
				$setUpdate [] = "PrioridadeId = " . $this->PrioridadeId;
			}
		} else if ($this->TicketGravado->Permissao == 'Solicitante') {
			$setUpdate [] = "Descricao = '" . $this->Descricao . "'";
			
			// Se em aberto pode trocar Categoria e Tipo
			if ($this->TicketGravado->StatusId == 1) {
				$setUpdate [] = "TipoId = " . $this->TipoId;
			}
		}
		
		return implode ( ", ", $setUpdate );
	}
	public function getPermissao() {
		$this->setFuncionarioId ( $_SESSION ['Funcionario']->FuncionarioId );
		$this->setAtendenteId ( $_SESSION ['Funcionario']->FuncionarioId );
		
		$sql = "
				SELECT
					T.TicketId
					,CASE
						WHEN S.FuncionarioId IS NOT NULL THEN 'Chefe'
						WHEN T.AtendenteId = " . $this->getFuncionarioId () . " THEN 'Atendente'
						WHEN SF.SetorFuncionarioId IS NOT NULL THEN 'Setor'
						WHEN T.FuncionarioId = " . $this->getFuncionarioId () . " THEN 'Solicitante'
					END AS Permissao		
				FROM
					ticket T
					LEFT JOIN Funcionario FA ON FA.FuncionarioId = T.AtendenteId					
					LEFT JOIN setor S ON S.SetorId = T.SetorId AND S.FuncionarioId = " . $this->getFuncionarioId () . "
					LEFT JOIN setorfuncionario SF ON SF.SetorId = T.SetorId AND SF.FuncionarioId = " . $this->getFuncionarioId () . "
				WHERE
					T.ticketId = " . $this->getTicketId () . "
					AND (
						T.FuncionarioId = " . $this->getFuncionarioId () . "
						OR T.AtendenteId = " . $this->getAtendenteId () . "
						OR S.FuncionarioId IS NOT NULL
						OR SF.SetorFuncionarioId IS NOT NULL
					)		
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados [0]->Permissao;
		} else {
			return false;
		}
	}
	private function criaDH_Previsao() {
		$this->load->model ( "TipoTicketMod" );
		$this->TipoTicketMod->setTipoId ( $this->TipoId );
		
		$SLA = $this->TipoTicketMod->buscaSla ();
		
		$mktime = mktime ( date ( "H" ) + $SLA, date ( "i" ), date ( "s" ), date ( "m" ), date ( "d" ), date ( "Y" ) );
		
		$this->DH_Previsao = date ( 'Y-m-d H:i:s', $mktime );
		
		return $this->DH_Previsao;
	}
}
?>