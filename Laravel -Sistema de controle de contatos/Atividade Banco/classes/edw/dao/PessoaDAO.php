<?php

namespace edw\dao;

require_once './classes/edw/persistencia/Conexao.php';
require_once './classes/edw/Pessoa.php';

use edw\Pessoa;
use edw\persistencia\Conexao;

/**
 *
 * @author Usuario
 */
class PessoaDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    private function criaObjeto($linha) {
        $j = new Pessoa();
        $j->setId($linha['id']);
        $j->setNome($linha['nome']);
        $j->setEmail($linha['email']);
        $j->setEndereco($linha['endereco']);
        $j->setDataNascimento($linha['dataNascimento']);
        return $j;
    }

    public function buscar($id) {
        $sql = "select id, nome, email, endereco, data_nascimento as dataNascimento from pessoa where id = " . $id;
        $this->conexao->setComandoSQL($sql);
        $resultado = $this->conexao->consulta();
        if ($resultado === false || empty($resultado)) {
            return null;
        }
        return $this->criaObjeto($resultado[0]);
    }

    public function buscarPrep($id) {
        $sql = "select id, nome, email, endereco, data_nascimento as dataNascimento from pessoa where id = :$id";
        $this->conexao->setComandoSQL($sql);
        $resultado = $this->conexao->consultaPrep(['id' => $id]);
        if ($resultado === false || empty($resultado)) {
            return null;
        }

        return $this->criaObjeto($resultado[0]);
    }

    public function listar($nome) {
        $sql = "select id, nome, email, endereco, data_nascimento  as dataNascimento from pessoa where nome like '$nome%' order by nome";
        $this->conexao->setComandoSQL($sql);
        $resultado = $this->conexao->consulta();
        if ($resultado === false || empty($resultado)) {
            return null;
        }
        foreach ($resultado as $linha) {
            $resp[] = $this->criaObjeto($linha);
        }
        return $resp;
    }

    public function listarPrep($nome) {
        $sql = "select id, nome, email, endereco, data_nascimento as dataNascimento from pessoa where nome like :nome order by nome";

        $this->conexao->setComandoSQL($sql);
        $resultado = $this->conexao->consultaPrep(["nome" => "$nome%"], 'edw\Pessoa');
        if ($resultado === false || empty($resultado)) {
            return null;
        }
        return $resultado;
    }

    public function excluir($id) {
        $sql = "delete from pessoa where id = $id";
        $this->conexao->setComandoSQL($sql);
        return ($this->conexao->executa() != 0);
    }

    public function excluirPrep($id) {
        $sql = "delete from pessoa where id = :id";
        $this->conexao->setComandoSQL($sql);
        $v['id'] = $id;
        return $this->conexao->executaPrep($v);
    }

    public function inserir(Pessoa $pessoa) {

        if ($this->buscar($pessoa->getId())) {
            //buscou e achou algo
            $sql = "UPDATE pessoa SET nome = '{$pessoa->getNome()}', email = '{$pessoa->getEmail()}',"
                    . " endereco = '{$pessoa->getEndereco()}', data_nascimento = '{$pessoa->getDataNascimento()}' WHERE id = {$pessoa->getId()}";
        } else {

            $sql = "insert into pessoa (id, nome, email, endereco, data_nascimento) "
                    . "values ({$pessoa->getId()}, '{$pessoa->getNome()}', '{$pessoa->getEmail()}', '{$pessoa->getEndereco()}', '{$pessoa->getDataNascimento()}')";
        }

        print $sql;

        $this->conexao->setComandoSQL($sql);
        $resp = $this->conexao->executa();
        print $resp;
        if ($resp !== false)
            return $resp == 1;
        else {
            print_r($this->conexao->getErros());
            return false;
        }
    }

public function inserirPrep(Pessoa $pessoa) {
    $sql = "INSERT INTO pessoa (id, nome, email, endereco, data_nascimento) "
         . "VALUES (:id, :nome, :email, :endereco, :data_nascimento) "
         . "ON DUPLICATE KEY UPDATE nome = VALUES(nome), email = VALUES(email), endereco = VALUES(endereco), data_nascimento = VALUES(data_nascimento)";

        $resultado = $this->conexao->consultaPrep([
        ':id' => $pessoa->getId(),
        ':nome' => $pessoa->getNome(),
        ':email' => $pessoa->getEmail(),
        ':endereco' => $pessoa->getEndereco(),
        ':data_nascimento' => $pessoa->getDataNascimento(),
    ], 'edw\Pessoa');

    return $resultado;
}


}
