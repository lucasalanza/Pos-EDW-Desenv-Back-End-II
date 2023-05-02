<?php

namespace edw;

//require_once 'DadosPessoais.php';

use edw\DadosPessoais;

/**
 * Representa um Usuario
 *
 * @author Caetano
 */
class Usuario implements DadosPessoais
{

    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __construct($id = null, $nome = null, $email = null, $senha = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setSenha($senha): void
    {
        $this->senha = $senha;
    }

}