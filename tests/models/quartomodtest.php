<?php
class quartomodtest extends CIUnit_TestCase {

	private $QuartoMod;
	
	public function setUp()
	{
		parent::tearDown();
		parent::setUp();
				
		$this->CI->load->model('QuartoMod');	
		$this->QuartoMod = $this->CI->QuartoMod;
	}
		
	public function testgetStatusAll() {
		$this->assertTrue( method_exists($this->QuartoMod, 'getStatusAll'));
	}

	private function montaGetStatusAll(){
		$Item->Status   = 0;
		$Item->Nome     = 'Desativado';
		$Status[]       = $Item;
		
		unset($Item);
		$Item->Status   = 1;
		$Item->Nome     = 'Ativo';
		$Status[]       = $Item;
		
		return $Status;
	}
}
?>