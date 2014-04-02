<?php
class PrioridadeMod extends CI_Model{
	private $PrioridadeId;
	
	public function getPrioridades(){
		$sql = "
				SELECT
					TP.PrioridadeId
					,TP.Nome
				FROM
					ticket_prioridade TP
				";
		
		$query  = $this->db->query($sql);
		
		$dados = $query->result();
		
		if(count($dados) > 0){
			$retorno['Prioridades'] = $dados;
			$retorno['success'] = true;
			
			return json_encode($retorno);
		}
		else{
			$retorno['Prioridades'] = false;
			$retorno['success'] = true;
			
			return json_encode($retorno);
		}
	}
}
?>