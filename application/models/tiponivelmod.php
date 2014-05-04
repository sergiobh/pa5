<?php
class TipoNivelMod extends CI_Model {
	private $TipoNivelId;
	private $TipoId;
	private $Nivel;
	private $SetorId;
	public function getTipoNivelId() {
		return $this->TipoNivelId;
	}
	public function setTipoNivelId($TipoNivelId) {
		$this->TipoNivelId = $TipoNivelId;
	}
	public function getTipoId() {
		return $this->TipoId;
	}
	public function setTipoId($TipoId) {
		$this->TipoId = $TipoId;
	}
	public function getNivel() {
		return $this->Nivel;
	}
	public function setNivel($Nivel) {
		$this->Nivel = $Nivel;
	}
	public function getSetorId() {
		return $this->SetorId;
	}
	public function setSetorId($SetorId) {
		$this->SetorId = $SetorId;
	}
	public function setTipoNivel() {
		$sql = "
 				INSERT INTO
 				ticket_tiponivel(
					TipoId
 					,Nivel
 					,SetorId
				)
 				VALUES(
					" . $this->TipoId . "
					," . $this->Nivel . "
					," . $this->SetorId . "
				)
 				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			
			$this->setTipoNivelId ( $this->db->insert_id () );
			
			return true;
		} else {
			return false;
		}
	}
	public function getTipoNivel() {
		$sql = "
				SELECT
					TT.TipoId
					,TT.Nivel
					,T.Nome AS Setor
				FROM
					ticket_tiponivel TT
					INNER JOIN setor T ON T.SetorId = TT.SetorId 
				WHERE
					TipoId = " . $this->TipoId . "
				ORDER BY
					TT.TipoId
					,TT.Nivel
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$retorno ['success'] = true;
			$retorno ['TipoNivels'] = $dados;
		} else {
			$retorno ['success'] = false;
			$retorno ['TipoNivels'] = false;
		}
		
		return $retorno;
	}
	/*
	 * Busca o ultimo nivel existente para acrescentar
	 */
	public function setNovoNivel() {
		$MaxNivel = $this->getMaxNivel ();
		
		if (! $MaxNivel) {
			return false;
		}
		
		$this->setNivel ( $MaxNivel + 1 );
		
		return $this->setTipoNivel ();
	}
	public function getMaxNivel() {
		$sql = "
				SELECT
					MAX(TT.Nivel) AS Nivel
				FROM
					ticket_tiponivel TT
				WHERE
					TT.TipoId = " . $this->TipoId . "
				";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (is_object ( $dados )) {
			return $dados->Nivel;
		} else {
			return false;
		}
	}
	public function removeNivel() {
		/*
		 * Barra exclusão do primeiro nível
		 */
		if ($this->Nivel == 1) {
			$retorno ['success'] = false;
			$retorno ['msg'] = 'Permissão negada para exclusão do primeiro nível!';
			
			return $retorno;
		}
		
		$MaxNivel = $this->getMaxNivel ();
		
		if ($MaxNivel != $this->Nivel) {
			$retorno ['success'] = false;
			$retorno ['msg'] = 'Existe um nível acima do solicitado! Favor recarregar a página!';
			
			return $retorno;
		}
		
		/*
		 * Verifica se existe algum chamado em aberto que não podemos excluir o Nivel
		 */
		$this->load->model ( "Ticket_AtendimentoMod" );
		// Necessário decremento pois metodo nátivo já incrementa 1
		$this->Ticket_AtendimentoMod->setTipo_Nivel ( ($this->Nivel - 1) );
		$PossuiAtendimento = $this->Ticket_AtendimentoMod->possuiProximoAtendimento ( true );
		
		if ($PossuiAtendimento) {
			$retorno ['success'] = false;
			$retorno ['msg'] = 'Permissão negada!</br>Existe um chamado Em Aberto com o nível solicitado!';
		} else if (! $this->deleteNivel ()) {
			$retorno ['success'] = false;
			$retorno ['msg'] = 'Ocorreu um erro ao excluir o nível solicitado!</br>Favor recarregar a página!';
		} else {
			$retorno ['success'] = true;
			$retorno ['msg'] = 'Nível excluído com sucesso!';
		}
		
		return $retorno;
	}
	private function deleteNivel() {
		$sql = "
				DELETE
				FROM
					ticket_tiponivel
				WHERE
					TipoId = " . $this->TipoId . "
					AND Nivel = " . $this->Nivel . "				
				";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>