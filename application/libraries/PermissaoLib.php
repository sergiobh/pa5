<?php
class PermissaoLib {
	public static function checkAdmin() {
		$FuncionarioIdSessao = $_SESSION ['Funcionario']->FuncionarioId;
		
		if ($FuncionarioIdSessao == 1) {
			return true;
		} else {
			return false;
		}
	}
}
?>