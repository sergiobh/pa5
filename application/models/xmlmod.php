<?php
class XmlMod extends CI_Model {
	public $xmlObject;
	private $xmlBreak;
	private $xmlErro;
	public function XmlMod() {
		$this->xmlBreak = false;
	}
	private function getXmlErro() {
		if ($this->xmlBreak) {
			echo $this->xmlErro;
			exit ();
		}
	}
	public function setXml($object) {
		$this->xmlObject = $object;
		
		/*
		 * Valida XML
		 */
		$this->validaXml ();
	}
	public function salvaXml() {
		$this->load->model ( 'TicketMod' );
		$this->load->model ( 'SetorFuncionarioMod' );
		$this->load->model ( 'TipoTicketMod' );
		
		/*
		 * Instancia Origem
		 */
		$SetorId = $this->getSetorId ( $this->xmlObject->origem );
		
		/*
		 * Instanciar Atendente
		 */
		$AtendenteNome = $this->xmlObject->incidente->atendente->nome;
		$AtendenteCpf = $this->xmlObject->incidente->atendente->cpf;
		$AtendenteSetorId = $SetorId;
		$AtendenteFuncionarioId = $this->getFuncionarioId ( $AtendenteNome, $AtendenteCpf, $AtendenteSetorId );
		
		/*
		 * Grava Vinculo Funcionario e Setor
		 */
		$this->setSetorFuncionario ( $AtendenteSetorId, $AtendenteFuncionarioId );
		
		/*
		 * Instanciar Solicitante
		 */
		$SolicitanteNome = $this->xmlObject->incidente->solicitante->nome;
		$SolicitanteCpf = $this->xmlObject->incidente->solicitante->cpf;
		$SolicitanteSetorId = 12;
		$SolicitanteFuncionarioId = $this->getFuncionarioId ( $SolicitanteNome, $SolicitanteCpf, $SolicitanteSetorId );
		
		/*
		 * Buscar Tipo de ticket
		 */
		$TipoTicketMod = $this->getTipoTicket ( $AtendenteSetorId );
		
		/*
		 * Instanciar Ticket
		 */
		$TipoId = $TipoTicketMod->getTipoId ();
		$PrioridadeId = $TipoTicketMod->getPrioridadeId ();
		$Descricao = $this->xmlObject->incidente->titulo . " " . $this->xmlObject->incidente->descricao;
		$DH_Abertura = date ( 'Y-m-d H:i:s', ( string ) $this->xmlObject->incidente->abertura );
		
		$this->TicketMod->setTipoId ( $TipoId );
		$this->TicketMod->setFuncionarioId ( $SolicitanteFuncionarioId );
		$this->TicketMod->setStatusId ( 1 );
		$this->TicketMod->setDH_Solicitacao ( $DH_Abertura );
		$this->TicketMod->setDescricao ( $Descricao );
		$this->TicketMod->setSetorId ( $AtendenteSetorId );
		$this->TicketMod->setAtendenteId ( $AtendenteFuncionarioId );
		$this->TicketMod->setPrioridadeId ( $PrioridadeId );
		
		if (! $this->TicketMod->setTipoTicket ()) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $this->TicketMod->erroMsg, array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		echo 'Ticket gravado com sucesso!!!';
	}
	private function getSetorId($Origem) {
		$this->load->model ( 'SetorMod' );
		
		if (! $this->SetorMod->setNome ( $Origem )) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $this->SetorMod->getErroMsg (), array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		if (! $this->SetorMod->getSetor ()) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $this->SetorMod->getErroMsg (), array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		return $this->SetorMod->getSetorId ();
	}
	private function getFuncionarioId($Nome, $Cpf, $SetorId) {
		$this->load->model ( 'FuncionarioMod' );
		$Senha = 'sem acesso';
		
		$this->FuncionarioMod->setFuncionario ( $Nome, $Cpf, $Senha, $SetorId );
		
		$RetornoSalvaCadastro = $this->FuncionarioMod->SalvarCadastro ();
		
		if (! isset ( $RetornoSalvaCadastro->FuncionarioId )) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $RetornoSalvaCadastro->Msg, array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		return $this->FuncionarioMod->FuncionarioId;
	}
	private function setSetorFuncionario($SetorId, $FuncionarioId) {
		if (! $this->SetorFuncionarioMod->setSetorId ( $SetorId )) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $this->SetorFuncionarioMod->getErroMsg (), array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		if (! $this->SetorFuncionarioMod->setFuncionarioId ( $FuncionarioId )) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $this->SetorFuncionarioMod->getErroMsg (), array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		if (! $this->SetorFuncionarioMod->setVinculo ()) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $this->SetorFuncionarioMod->getErroMsg (), array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
	}
	private function getTipoTicket($AtendenteSetorId) {
		$this->TipoTicketMod->setNome ( "Outros " . $this->xmlObject->origem );
		$this->TipoTicketMod->setSetorId ( $AtendenteSetorId );
		
		if (! $RetornoTipoTicket = $this->TipoTicketMod->getTipoTicket ()) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $RetornoTipoTicket->erroMsg, array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		return $this->TipoTicketMod;
	}
	private function validaXml() {
		$msg = array ();
		$fimDeString = '<br>';
		
		if (! isset ( $this->xmlObject->origem )) {
			$this->xmlBreak = true;
			$msg [] = "Origem";
		}
		
		if (! isset ( $this->xmlObject->incidente )) {
			$this->xmlBreak = true;
			$msg [] = "Incidente";
		} else {
			if (! isset ( $this->xmlObject->incidente->atendente )) {
				$this->xmlBreak = true;
				$msg [] = "Atendente";
			} else {
				if (! isset ( $this->xmlObject->incidente->atendente->cpf )) {
					$this->xmlBreak = true;
					$msg [] = "CPF do Atendente";
				}
				
				if (! isset ( $this->xmlObject->incidente->atendente->nome )) {
					$this->xmlBreak = true;
					$msg [] = "Nome do Atendente";
				}
			}
			if (! isset ( $this->xmlObject->incidente->solicitante )) {
				$this->xmlBreak = true;
				$msg [] = "Solicitante";
			} else {
				if (! isset ( $this->xmlObject->incidente->solicitante->cpf )) {
					$this->xmlBreak = true;
					$msg [] = "CPF do Solicitante";
				}
				
				if (! isset ( $this->xmlObject->incidente->solicitante->nome )) {
					$this->xmlBreak = true;
					$msg [] = "Nome do Solicitante";
				}
			}
			if (! isset ( $this->xmlObject->incidente->descricao )) {
				$this->xmlBreak = true;
				$msg [] = "Descrição";
			}
			if (! isset ( $this->xmlObject->incidente->titulo )) {
				$this->xmlBreak = true;
				$msg [] = "Título";
			}
			if (! isset ( $this->xmlObject->incidente->abertura )) {
				$this->xmlBreak = true;
				$msg [] = "Abertura";
			}
		}
		
		if ($this->xmlBreak) {
			$msgErro = $this->criaMsgErro ( "Xml inválido, campos incompatíveis: ", $msg );
		}
	}
	private function criaMsgErro($textoErro, $erros) {
		$msgErro = $textoErro . implode ( ", ", $erros );
		
		$jsonArray = array (
				"success" => true,
				"xmlValido" => false,
				"msg" => $msgErro 
		);
		
		$this->xmlErro = json_encode ( $jsonArray );
		
		// Força a parada do sistema e imprime o erro
		$this->getXmlErro ();
	}
}
?>