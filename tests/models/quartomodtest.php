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
//echo print_r($this->QuartoMod);exit;
		
		$this->assertTrue( method_exists($this->QuartoMod, 'getStatusAll'));
		
		//$this->assertEquals ( $this->QuartoMod->getStatusAll(), $this->montaGetStatusAll() );
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