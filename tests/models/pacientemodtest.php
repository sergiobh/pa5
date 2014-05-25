<?php
class pacientemodtest extends CIUnit_TestCase {

	private $PacienteMod;
	
	public function setUp() {
		$this->CI->load->model ( 'PacienteMod' );
		$this->PacienteMod = $this->CI->PacienteMod;
	}
	public function testsetMascaraCpf() {
		$Cpf = '01257303651';
		
		$this->assertEquals ( '012.573.036-51', $this->PacienteMod->setMascaraCpf($Cpf) );
	}
}
?>