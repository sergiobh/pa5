<?php
class CategoriaMod extends CI_Model {
	private $TicketId;
	private $StatusId;
	private $Permissao;
	public function getTicketId() {
		return $this->TicketId;
	}
	public function setTicketId($TicketId) {
		$this->TicketId = $TicketId;
	}
	public function getStatusId() {
		return $this->StatusId;
	}
	public function setStatusId($StatusId) {
		$this->StatusId = $StatusId;
	}
	public function getPermissao(){
		return $this->Permissao;
	}
	public function setPermissao($Permissao){
		$this->Permissao = $Permissao;
	}
	public function getCategoria() {
		$sql_from = '';
		$sql_where = '';
		
		// Filtra por tipo de StatusId
		// Caso Fechado, Cancelado ou Indeferido não se altera Categoria
		if ($this->StatusId != '' && $this->StatusId >= 5 && is_numeric($this->TicketId) && $this->TicketId != '' || $this->Permissao == 'Solicitante') {
			$from = array ();			
			$from [] = 'INNER JOIN ticket T ON T.TicketId = ' . $this->TicketId;
			$from [] = 'INNER JOIN ticket_tipo TT ON TT.TipoId = T.TipoId';			
			$sql_from = implode ( " ", $from );
			
			$where = array ();
			$where [] = 'TT.CategoriaId = TC.CategoriaId';
			$sql_where = ' WHERE ' . implode ( " ", $where );
		}
		
		$sql = "
                    SELECT
						TC.CategoriaId
						,TC.Nome
					FROM
						ticket_categoria TC
						" . $sql_from . "
					".$sql_where."
					ORDER BY
                        nome
                    ";

		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
}
?>