<?php
class LeitoMod extends CI_Model {
	public $LeitoId;
	public $QuartoId;
	public $Identificacao;
	public $Status;
	public function statusLeitos() {
		$sql = "
                    SELECT
                        L.LeitoId
                        ,Q.Andar                
                        ,Q.Identificacao AS Quarto        
                        ,L.Identificacao AS Leito
                        ,IF(L.Status = '2', 'Arrumacao', IF(O.LeitoId IS NULL, 'Liberado', 'Ocupado') ) AS Status
                    FROM
                        leito L
                        INNER JOIN quarto Q ON Q.QuartoId = L.QuartoId
                        LEFT JOIN ocupacao O ON O.LeitoId = L.LeitoId AND O.FuncBaixa IS NULL
                    WHERE
                        L.Status != 0
                        AND Q.Status = 1
                    ORDER BY
                        Q.Andar
                        ,Q.Identificacao
                        ,L.Identificacao
                    ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function Listar() {
		$sql = "
                    SELECT
                        L.LeitoId
                        ,Q.Andar                
                        ,Q.Identificacao AS Quarto        
                        ,L.Identificacao AS Leito
                        ,IF(L.Status = '0', 'Desativado',  IF(L.Status = '2', 'Arrumacao', IF(O.LeitoId IS NULL, 'Liberado', 'Ocupado') ) ) AS Status
                    FROM
                        leito L
                        INNER JOIN quarto Q ON Q.QuartoId = L.QuartoId
                        LEFT JOIN ocupacao O ON O.LeitoId = L.LeitoId AND O.FuncBaixa IS NULL
                    WHERE
                        Q.Status = 1
                    ORDER BY
                        Q.Andar
                        ,Q.Identificacao
                        ,L.Identificacao
                    ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			return $dados;
		} else {
			return false;
		}
	}
	public function existLeito() {
		if (! is_numeric ( $this->QuartoId ) || $this->Identificacao == '') {
			return false;
		}
		
		$sql_where = '';
		
		if (is_numeric ( $this->LeitoId ) && $this->LeitoId != '') {
			$sql_where = 'AND L.LeitoId != ' . $this->LeitoId;
		}
		
		$sql = "
                SELECT
                    LeitoId
                FROM
                    leito L
                WHERE
                    L.Identificacao = '" . $this->Identificacao . "'
                    AND L.QuartoId = " . $this->QuartoId . "
                    " . $sql_where . "
                ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (is_object ( $dados )) {
			return true;
		} else {
			return false;
		}
	}
	public function getLeito() {
		if (! is_numeric ( $this->LeitoId )) {
			return false;
		}
		
		$sql = "
                SELECT
                    L.*
                    ,Q.Identificacao AS Quarto
                    ,Q.QuartoId
                    ,IF(L.Status = '1', IF(O.LeitoId IS NULL, '1', '3'), L.Status ) AS Status
                FROM
                    leito L
                    INNER JOIN quarto Q ON Q.QuartoId = L.QuartoId
                    LEFT JOIN ocupacao O ON O.LeitoId = L.LeitoId AND O.FuncBaixa IS NULL
                WHERE
                    L.LeitoId = " . $this->LeitoId . "
                ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->row ();
		
		if (is_object ( $dados )) {
			return $dados;
		} else {
			return false;
		}
	}
	public function setLeito() {
		if (! is_numeric ( $this->QuartoId )) {
			echo '{"success": false, "msg": "Favor recarregar a página!"}';
			exit ();
		}
		
		$this->Identificacao = trim ( $this->Identificacao );
		
		if ($this->Identificacao == '') {
			echo '{"success": false, "msg": "Favor recarregar a página!"}';
			exit ();
		}
		
		// Se não existir poderá ser adicionado
		if (! $this->existLeito ()) {
			
			$sql = "
                            INSERT INTO
                            leito (
                                QuartoId
                                ,Identificacao
                            )
                            VALUES(
                                " . $this->QuartoId . "
                                ,'" . $this->Identificacao . "'
                            )";
			
			$this->db->query ( $sql );
			
			if ($this->db->affected_rows () > 0) {
				echo '{"success": true, "msg": "Dados salvos com sucesso!" }';
			} else {
				echo '{"success": false, "msg": "Ocorreu um erro ao salvar, tente novamente!" }';
			}
		} else {
			echo '{"success": false, "msg": "Leito existente para este quarto!" }';
			exit ();
		}
	}
	public function setEdicao() {
		if (! is_numeric ( $this->LeitoId )) {
			echo '{"success": false, "msg": "Favor recarregar a página!"}';
			exit ();
		}
		
		$this->Identificacao = trim ( $this->Identificacao );
		
		if ($this->Identificacao == '') {
			echo '{"success": false, "msg": "Favor recarregar a página!"}';
			exit ();
		}
		
		// Se não existir poderá ser adicionado
		if (! $this->existLeito ()) {
			
			$sql = "
                            UPDATE 
                                leito 
                            SET
                                Identificacao = '" . $this->Identificacao . "'
                                ,Status = " . $this->Status . "
                            WHERE
                                LeitoId = " . $this->LeitoId . "
                                AND QuartoId = " . $this->QuartoId . "
                            ";
			
			$this->db->query ( $sql );
			
			if ($this->db->affected_rows () > 0) {
				echo '{"success": true, "msg": "Dados salvos com sucesso!" }';
			} else {
				echo '{"success": false, "msg": "Altere pelo menos um dos campos!" }';
			}
		} else {
			echo '{"success": false, "msg": "Leito existente para este quarto!" }';
			exit ();
		}
	}
	public function getLeitos() {
		if ($this->QuartoId == '') {
			echo '{"success": false, "msg": "Nenhum leito disponível!" }';
			exit ();
		}
		
		$sql = "
                        SELECT
                                L.LeitoId
                                ,L.Identificacao AS Leito
                                ,COUNT(L.LeitoId) AS QtdLeitos
                        FROM
                                quarto Q
                                INNER JOIN leito L ON L.QuartoId = Q.QuartoId
                                LEFT JOIN ocupacao O ON O.LeitoId = L.LeitoId AND O.FuncBaixa IS NULL
                        WHERE
                                Q.Status = 1
                                AND L.Status != 0
                                AND L.QuartoId = '" . $this->QuartoId . "'
                        ORDER BY
                                Leito
                        ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$Leitos = json_encode ( $dados );
			
			echo '{"success": true, "leitos": ' . $Leitos . ' }';
		} else {
			echo '{"success": false, "msg": "Nenhum leito disponível!" }';
		}
	}
	public function getLeitosOcupacao() {
		if ($this->QuartoId == '') {
			echo '{"success": false, "msg": "Nenhum leito disponível!" }';
			exit ();
		}
		
		$this->load->model ( 'PacienteMod' );
		$this->PacienteMod->PacienteId = $this->PacienteId;
		$Paciente = $this->PacienteMod->getDadosPaciente ();
		
		if (! $Paciente) {
			return false;
		}
		
		$sql_where = '';
		$sql_having = '';
		
		// Apartamento
		if ($Paciente->Tipo == 1) {
			$sql_having = "
   							AND QtdOcupado = 0
   							AND QtdLeitos = 1
   							";
		}
		else{
			$sql_where = "
							AND L.Ocupado = 0
							";
		}
		
		$sql = "
                    SELECT
						Q.QuartoId	
						,Q.Andar
						,Q.Identificacao AS Quarto
						,L.Identificacao AS Leito
						,L.Status	
						,L.Ocupado AS Ocupado
						,SUM(L.Ocupado) AS QtdOcupado
						,COUNT(L.LeitoId) AS QtdLeitos
                    FROM
						quarto Q
						INNER JOIN leito L ON L.QuartoId = Q.QuartoId
                    WHERE 
                       	L.QuartoId  ='" . $this->QuartoId . "' 
                        AND Q.Status = 1
						AND L.Status != 0
						".$sql_where."
                    GROUP BY
						Q.Andar
						,Q.QuartoId
					HAVING
						L.Status = 1
						AND Ocupado = 0
                   		" . $sql_having . "
                    ORDER BY
						Q.Andar
						,Q.Identificacao
						,L.Identificacao
                    ";
		
		$query = $this->db->query ( $sql );
		
		$dados = $query->result ();
		
		if (count ( $dados ) > 0) {
			$Leitos = json_encode ( $dados );
			
			echo '{"success": true, "leitos": ' . $Leitos . ' }';
		} else {
			echo '{"success": false, "msg": "Nenhum leito disponível!" }';
		}
	}
	public function getStatusAll($Status = 0) {
		if ($Status == 3) {
			$Item->Status = 3;
			$Item->Nome = 'Ocupado';
			$ListStatus [] = $Item;
		} else {
			$Item->Status = 0;
			$Item->Nome = 'Desativado';
			$ListStatus [] = $Item;
			
			unset ( $Item );
			$Item->Status = 1;
			$Item->Nome = 'Ativo';
			$ListStatus [] = $Item;
			
			unset ( $Item );
			$Item->Status = 2;
			$Item->Nome = 'Arrumação';
			$ListStatus [] = $Item;
		}
		
		return $ListStatus;
	}
	public function setOcupacao() {
		$sql = "
                            UPDATE
                                leito
                            SET
                                Ocupado = 1
                            WHERE
                                LeitoId = " . $this->LeitoId . "
                               	AND Ocupado = 0
                            ";
		
		$this->db->query ( $sql );
		
		if ($this->db->affected_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function setDesocupacao() {
		$sql = "
                            UPDATE
                                leito
                            SET
                                Ocupado = 0
                            WHERE
                                LeitoId = " . $this->LeitoId . "
                               	AND Ocupado = 1
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