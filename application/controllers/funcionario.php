<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Funcionario extends CI_Controller {
	public function cadastrar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'funcionario/cadastrar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function listar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'funcionario/listar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function processar() {
		$this->CheckLogado ();
		
		$Dados ['View'] = 'funcionario/processar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function salvarCadastro() {
		$Nome = $this->input->post ( 'Nome' );
		$Cpf = $this->input->post ( 'Cpf' );
		$Senha = $this->input->post ( 'Senha' );
		
		$this->load->model ( 'FuncionarioMod' );
		$this->FuncionarioMod->Nome = $Nome;
		$this->FuncionarioMod->Cpf = $Cpf;
		$this->FuncionarioMod->Senha = $Senha;
		$Gravado = $this->FuncionarioMod->SalvarCadastro ();
		
		$Retorno ['success'] = true;
		$Retorno ['status'] = $Gravado->Status;
		$Retorno ['msg'] = $Gravado->Msg;
		
		echo json_encode ( $Retorno );
	}
	public function montaGrid() {
		$this->load->model ( 'FuncionarioMod' );
		$Funcionarios = $this->FuncionarioMod->Listar ();
		$Dados ['Funcionarios'] = $Funcionarios;
		
		$Dados ['success'] = ($Dados ['Funcionarios']) ? true : false;
		
		echo json_encode ( $Dados );
	}
	public function Logar() {
		if (! isset ( $_POST ['Cpf'] ) || ! isset ( $_POST ['Senha'] )) {
			echo '{success: false}';
			exit ();
		}
		
		$Cpf = $_POST ['Cpf'];
		$Senha = $_POST ['Senha'];
		
		$this->load->model ( 'FuncionarioMod' );
		$this->FuncionarioMod->Cpf = $Cpf;
		$Usuario = $this->FuncionarioMod->getFuncionario ();
		
		if (is_object ( $Usuario )) {
			$this->load->library ( 'CriptografiaLib' );
			// Validação da senha
			if ($Usuario->Senha === $this->criptografialib->Gerar ( $Senha )) {
				// Insere os dados do usuário na sessão
				$_SESSION ['Funcionario'] = $Usuario;
				
				echo '{"success": true}';
			} else {
				echo '{"success": false}';
			}
		} else {
			echo '{"success": false}';
		}
	}
	public function deslogar() {
		unset ( $_SESSION ['Funcionario'] );
		
		header ( 'Location: ' . BASE_URL . '/funcionario/login' );
	}
	public function login() {
		$Dados ['Script'] [] = 'jquery/jquery.alerts.js';
		$Dados ['Script'] [] = 'jquery/jquery.ui.draggable.js';
		
		$Dados ['Css'] [] = 'jquery.alerts.css';
		
		$Dados ['View'] = 'funcionario/login';
		$this->load->view ( 'body/basico', $Dados );
	}
	public function editar() {
		$this->CheckLogado ();
		
		$FuncionarioId = $this->uri->segment ( 3 );
		
		$Dados ['FuncionarioId'] = $FuncionarioId;
		$Dados ['View'] = 'funcionario/editar';
		$this->load->view ( 'body/index', $Dados );
	}
	public function getFuncionario() {
		$this->CheckLogado ();
		
		$FuncionarioId = $this->input->post ( "FuncionarioId" );
		
		$this->load->model ( "FuncionarioMod" );
		$this->FuncionarioMod->FuncionarioId = $FuncionarioId;
		
		if (! $this->FuncionarioMod->checkAcessoFuncionario ()) {
			$retorno ['success'] = false;
			$retorno ['msg'] = 'Usuário sem permissão!';
			echo json_encode ( $retorno );
			exit ();
		}
		
		$Funcionario = $this->FuncionarioMod->getFuncionario ();
		
		$retorno ['success'] = true;
		$retorno ['Funcionario'] = $Funcionario;
		
		echo json_encode ( $retorno );
	}
	public function salvarEdicao() {
		$this->CheckLogado ();
		
		$funcionarioId = $this->input->post ( "FuncionarioId" );
		$nome = $this->input->post ( "Nome" );
		$cpf = $this->input->post ( "Cpf" );
		$senha = $this->input->post ( "Senha" );
		
		$this->load->model ( "FuncionarioMod" );
		$this->FuncionarioMod->FuncionarioId = $funcionarioId;
		$this->FuncionarioMod->setFuncionario ( $nome, $cpf, $senha );
		
		echo json_encode ( $this->FuncionarioMod->setEdicao () );
	}
}