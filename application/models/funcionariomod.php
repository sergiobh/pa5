<?php
class FuncionarioMod extends CI_Model{
    
    public $FuncionarioId;
    public $Nome;
    public $Cpf;
    public $Senha;
    public $SetorId;

    public function setFuncionario($nome, $cpf, $senha, $setorId){
    	$this->Nome = $nome;
    	$this->Cpf = $cpf;
    	$this->Senha = $senha;
    	$this->SetorId = $setorId;
    }
    
    public function getFuncionario(){

        $sql    = "
                    SELECT
                        F.*
                    FROM
                        funcionario F
                    WHERE
                        F.Cpf = ".$this->Cpf."
                    ";

        $query  = $this->db->query($sql);

        $dados = $query->result();

        if(count($dados) > 0){
            return $dados[0];
        }
        else{
            return false;
        }
    }


    public function Listar(){
        $sql    = "
                    SELECT
                        F.FuncionarioId
                        ,F.Nome
                        ,F.Cpf
                        ,G.nome AS Grupo
                    FROM
                        funcionario F
                        INNER JOIN grupo G ON G.GrupoId = F.GrupoId
                    ORDER BY
                        F.Nome
                    ";

        $query  = $this->db->query($sql);

        $dados = $query->result();

        if(count($dados) > 0){
            return $dados;
        }
        else{
            return false;
        }
    }

    public function SalvarCadastro(){
        if($funcionario = $this->getFuncionario()){
            $Retorno->Status = false;
            $Retorno->Msg    = "Funcionario já cadastrado!";
            $this->FuncionarioId = $Retorno->FuncionarioId = $funcionario->FuncionarioId;
            
            return $Retorno;
        }

        $sql    = "
                    INSERT INTO
                    funcionario(
                        Nome
                        ,Cpf
                        ,Senha
                        ,SetorId
                    )
                    VALUES(
                        '".$this->Nome."'
                        ,'".$this->Cpf."'
                        ,'".$this->Senha."'
                        ,'".$this->SetorId."'
                    )";

        $this->db->query($sql);

        if($this->db->affected_rows() > 0){
            $Retorno->Status = true;
            $Retorno->Msg    = "Funcionario cadastrado!";
            $this->FuncionarioId = $Retorno->FuncionarioId = $this->db->insert_id();
        }
        else{
            $Retorno->Status = false;
            $Retorno->Msg    = "Favor recarregar a página!";
        }

        return $Retorno;
    }
}
?>