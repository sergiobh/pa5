<?php
class TransactionMod extends CI_Model {
	public function Start() {
		$sql = "START TRANSACTION";
		
		$this->db->query ( $sql );
	}
	public function Commit() {
		$sql = "COMMIT";
		
		$this->db->query ( $sql );
	}
	public function Rollback() {
		$sql = "ROLLBACK";
		
		$this->db->query ( $sql );
	}
}
?>