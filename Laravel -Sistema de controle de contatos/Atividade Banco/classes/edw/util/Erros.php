<?php

namespace edw\util;

/**
 * Description of Erros
 *
 * @author Usuario
 */
class Erros {

    private $erros;

    public function __construct() {
        $this->erros = array();
    }

    public function possuiErros($pos = null) {
        return $pos !== null
                ? isset($this->erros[$pos])
                : count($this->erros) > 0;
    }

    public final function getErro($posicao) {
        return $this->erros[$posicao] ?? null;
    }

    public final function getErros() {
        return $this->erros;
    }

    public final function addErro($mensagem, $posicao = null) {
        if ($posicao != null) {
            $this->erros[$posicao] = $mensagem;
        } else {
            $this->erros[] = $mensagem;
        }
    }

}
