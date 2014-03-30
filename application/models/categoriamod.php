<?php
class CategoriaMod extends CI_Model {
	public function getCategoria() {
		$sql = "
                    SELECT
						*
					FROM
						ticket_categoria
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