<?php
class functionariomodtest extends CIUnit_TestCase {
	
	private $FuncionarioMod;
	
	public function setUp() {
		$this->CI->load->model ( 'FuncionarioMod' );
		$this->FuncionarioMod = $this->CI->FuncionarioMod;
	}
	public function testcheckAcessoFuncionario() {
		$this->assertEquals ( $this->FuncionarioMod->checkAcessoFuncionario (), false );
	}
}
?>