<?php

namespace edw;

/**
 *
 * @author Caetano
 */
interface DadosPessoais {

    public function getNome();

    public function getEmail();

    public function setNome($nome): void;

    public function setEmail($email): void;
}
