<?php

namespace edw\persistencia;

require_once './classes/edw/util/Erros.php';

use edw\util\Erros;
use PDO;
use PDOException;

/**
 * Classe para a manipulação do banco de dados
 * 
 * @author Aluno
 */
class Conexao extends Erros {

    private PDO $conn;
    private $comandoSQL;
    private $aberto;

    public function __construct() {
        parent::__construct();
        $dsn = "mysql:host=localhost;dbname=test;charset=utf8";
        try {
            $this->conn = new PDO($dsn, "root", ""); //Instancia objeto de conexão/manipulação com a base de dados
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Configura o objeto para lançar execessões quando ocorrer erros
            $this->aberto = true;
        } catch (PDOException $e) {
            $this->conn = null;
            $this->aberto = false;
        }
    }

    public function __destruct() {
        $this->fechar();
    }

    public function fechar() {
        $this->comandoSQL = null;
        unset($this->conn);
        $this->aberto = false;
    }

    public function getComandoSQL() {
        return $this->comandoSQL;
    }

    public function setComandoSQL($comandoSQL) {
        $this->comandoSQL = $comandoSQL;
    }

    private function isOK() {
        return $this->aberto && $this->comandoSQL != "";
    }

    public function executa() {
        if ($this->isOK()) {
            try {
                return $this->conn->exec($this->comandoSQL);
            } catch (PDOException $e) {
                print $e->getMessage();
                $this->addErro('Erro executando modificações.');
                return false;
            }
        }
        return false;
    }

    public function executaPrep($parametros) {
        if ($this->isOK()) {
            try {
                $stmt = $this->conn->prepare($this->comandoSQL);
                foreach ($parametros as $chave => $valor) {
                    $stmt->bindParam($chave, $valor);
                }
                return $stmt->execute();
            } catch (PDOException $e) {
                print $e->getMessage();
                $this->addErro('Erro executando modificações.');
                return false;
            }
        }
        return false;
    }

    public function consulta() {
        if ($this->isOK()) {
            try {
                $stmt = $this->conn->query($this->comandoSQL);
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                $this->addErro("Erro buscando registros.");
                return false;
            }
        }
        return false;
    }

    public function consultaPrep($params, $class = null) {
        if ($this->isOK()) {
            try {
                $stmt = $this->conn->prepare($this->comandoSQL);
                foreach ($params as $chave => $valor) {
                    $stmt->bindParam($chave, $valor);
                }
                if ($stmt->execute()) {
                    if ($class == null) {
                        return $stmt->fetchAll();
                    } else {
                        return $stmt->fetchall(PDO::FETCH_CLASS, $class);
                    }
                }
            } catch (PDOException $e) {
                $this->addErro("Erro buscando registros.");
                return false;
            }
        }
        return false;
    }

}
