<?php

namespace edw;

//require_once './classes/edw/DadosPessoais.php';
//require_once 'DadosPessoais.php';

use edw\DadosPessoais;

/**
 * Description of Pessoa
 *
 * @author Caetano
 */
class Pessoa implements DadosPessoais {

    private $id;
    private $nome;
    private $dataNascimento;
    private $endereco;
    private $email;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setDataNascimento($dataNascimento): void {
        
        $this->dataNascimento = $dataNascimento;
     //   print_r($dataNascimento);
    }

    public function setEndereco($endereco): void {
        $this->endereco = $endereco;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

}
