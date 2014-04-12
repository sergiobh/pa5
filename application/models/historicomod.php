<?php
class HistoricoMod extends CI_Model {
	private $HistoricoId;
	private $TicketId;
	private $Texto;
	private $HistoricoTipoId;
	private $UsuarioId;
	private $DH_Cadastro;
	private $erroBreak;
	private $erroMsg;
	public function getHistoricoId() {
		return $this->HistoricoId;
	}
	public function setHistoricoId($HistoricoId) {
		$this->HistoricoId = $HistoricoId;
	}
	public function getTicketId() {
		return $this->TicketId;
	}
	public function setTicketId($TicketId) {
		$this->TicketId = $TicketId;
	}
	public function getTexto() {
		return $this->Texto;
	}
	public function setTexto($Texto) {
		$this->Texto = $Texto;
	}
	public function getHistoricoTipoId() {
		return $this->HistoricoTipoId;
	}
	public function setHistoricoTipoId($HistoricoTipoId) {
		$this->HistoricoTipoId = $HistoricoTipoId;
	}
	public function getUsuarioId() {
		return $this->UsuarioId;
	}
	public function setUsuarioId($UsuarioId) {
		$this->UsuarioId = $UsuarioId;
	}
	public function getDH_Cadastro() {
		return $this->DH_Cadastro;
	}
	public function setDH_Cadastro($DH_Cadastro) {
		$this->DH_Cadastro = $DH_Cadastro;
	}
	public function getErroMsg() {
		return $this->erroMsg;
	}
	public function getErroBreak() {
		return $this->erroBreak;
	}
	public function setHistorico() {
		$sql = "
				INSERT INTO
					ticket_historico(
						TicketId
						,Texto
						,HistoricoTipoId
						,UsuarioId
						,DH_Cadastro
					)
				VALUES(
					$this->TicketId
					,'" . $this->Texto . "'
					,$this->HistoricoTipoId
					,$this->UsuarioId
					,'" . $this->DH_Cadastro . "'
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
	public function getHistoricos(){		
		$sql = "
				SELECT
					THT.Nome AS Ocorrencia
					,TH.Texto AS Descricao
					,TH.HistoricoTipoId
					,CASE
						WHEN (TH.HistoricoTipoId = 1 OR TH.HistoricoTipoId = 3 ) THEN FS.Nome
						ELSE FA.Nome
					END AS Usuario
					,DATE_FORMAT( TH.DH_Cadastro , '%d/%m/%Y %H:%i:%s' ) AS DH_Cadastro
					,CASE
						WHEN (TH.HistoricoTipoId < 3 ) THEN ''
						ELSE CONCAT('/historico/anexo/', TH.HistoricoId) 
					END AS Url
				FROM
					ticket_historico TH
					INNER JOIN ticket_histoticotipo THT ON THT.HistoticoTipoId = TH.HistoricoTipoId
					INNER JOIN Funcionario FS ON FS.FuncionarioId = TH.UsuarioId
					LEFT JOIN Funcionario FA ON FA.FuncionarioId = TH.UsuarioId
				WHERE
					TH.TicketId = ".$this->TicketId."
				";

		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function getUrl(){
		$sql = "
				SELECT
					TH.Texto AS nameFile
					,CONCAT('/public/anexos/', TH.TicketId, '/') AS diretorio
				FROM
					ticket_historico TH
				WHERE
					TH.HistoricoId = ".$this->HistoricoId."
				";
		
		$query  = $this->db->query($sql);
		
		$dados = $query->row();
		
		if(is_object($dados)){
			return $dados;
		}
		else{
			return false;
		}
	}
}
?>