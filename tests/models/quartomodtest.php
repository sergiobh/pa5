<?php
class quartomodtest extends CIUnit_TestCase {
	public function setUp()
	{
		//parent::tearDown();
		//parent::setUp();
	
		/*
			* this is an example of how you would load a product model,
		* load fixture data into the test database (assuming you have the fixture yaml files filled with data for your tables),
		* and use the fixture instance variable
	
		$this->CI->load->model('Product_model', 'pm');
		$this->pm=$this->CI->pm;
		$this->dbfixt('users', 'products')
	
		the fixtures are now available in the database and so:
		$this->users_fixt;
		$this->products_fixt;
		*/
		
		$this->CI->load->model('QuartoMod');
		$this->QuartoMod = 		$this->CI->QuartoMod;
	}
		
	public function testgetStatusAll() {
		$this->assertEquals ( $this->QuartoMod->getStatusAll(), $this->montaGetStatusAll() );
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