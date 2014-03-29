<?php
class OrigemMod extends CI_Model{
	
	/*
	 * Siglas:
	* BI
	* SO
	* CORP = NOSSO
	* BD
	* */
	private $origens;
	
	public function OrigemMod(){
		$this->origens = array(
			"BI"
			,"SO"
			,"CORP"
			,"DB"
		);
	}
	
	public function validaOrigem($origemParams){
		$validacao = false;
		
		foreach ($this->origens as $origem){
			if($origem === $origemParams){
				$validacao = true;
				break;
			}
		}
		
		return $validacao;
	}	
}  
?>