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
		$this->load->model ( 'FuncionarioMod' );
		$this->load->model ( 'SetorMod' );
		$this->load->model ( 'SetorFuncionarioMod' );
		$this->load->model ( 'TipoTicketMod' );
		
		/*
		 * Instancia Origem
		 */
		if (! $this->SetorMod->setNome ( $this->xmlObject->origem )) {
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
		
		/*
		 * Instanciar Atendente
		 */
		$nome = $this->xmlObject->incidente->atendente->nome;
		$cpf = $this->xmlObject->incidente->atendente->cpf;
		$senha = 'sem acesso';
		$AtendenteSetorId = $this->SetorMod->getSetorId ();
		
		$this->FuncionarioMod->setFuncionario ( $nome, $cpf, $senha, $AtendenteSetorId );
		
		$RetornoSalvaCadastro = $this->FuncionarioMod->SalvarCadastro ();
		
		if (! isset ( $RetornoSalvaCadastro->FuncionarioId )) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $RetornoSalvaCadastro->Msg, array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		$AtendenteFuncionarioId = $this->FuncionarioMod->FuncionarioId;
		
		/*
		 * Grava Vinculo Funcionario e Setor
		 */
		if (! $this->SetorFuncionarioMod->setSetorId ( $AtendenteSetorId )) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $this->SetorFuncionarioMod->getErroMsg (), array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		if (! $this->SetorFuncionarioMod->setFuncionarioId ( $AtendenteFuncionarioId )) {
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
		
		/*
		 * Instanciar Solicitante
		 */
		$nome = $this->xmlObject->incidente->solicitante->nome;
		$cpf = $this->xmlObject->incidente->solicitante->cpf;
		$senha = 'sem acesso';
		$SolicitanteSetorId = 12;
		
		$this->FuncionarioMod->setFuncionario ( $nome, $cpf, $senha, $SolicitanteSetorId );
		$RetornoSalvaCadastro = $this->FuncionarioMod->SalvarCadastro ();
		
		if (isset ( $RetornoSalvaCadastro->FuncionarioId )) {
			$SolicitanteFuncionarioId = $RetornoSalvaCadastro->FuncionarioId;
		} else {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $RetornoSalvaCadastro->Msg, array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		/*
		 * Buscar Tipo de ticket
		 */
		$this->TipoTicketMod->setNome ( "Outros " . $this->xmlObject->origem );
		$this->TipoTicketMod->setSetorId ( $AtendenteSetorId );
		
		if (! $RetornoTipoTicket = $this->TipoTicketMod->getTipoTicket ()) {
			$this->xmlBreak = true;
			$this->criaMsgErro ( $RetornoTipoTicket->erroMsg, array () );
			// Força a parada do sistema e imprime o erro
			$this->getXmlErro ();
		}
		
		$TipoId = $this->TipoTicketMod->getTipoId ();
		$PrioridadeId = $this->TipoTicketMod->getPrioridadeId ();
		
		/*
		 * Instanciar Ticket
		 */
		$Descricao = $this->xmlObject->incidente->titulo . " " . $this->xmlObject->incidente->descricao;
	
		$DH_Abertura = date ( 'Y-m-d H:i:s', (string)$this->xmlObject->incidente->abertura );
		
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