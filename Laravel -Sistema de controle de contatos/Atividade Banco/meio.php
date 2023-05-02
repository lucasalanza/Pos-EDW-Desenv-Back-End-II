<?php
//require_once './classes/edw/Pessoa.php';
require_once './Autoloader.php';
use edw\Pessoa;

session_start();

/* @var $pessoa Pessoa */
$pessoa = $_SESSION['pessoa'] ?? null;
if (!isset($pessoa)) {
    header("Location: inicio.php?x=1");
    exit();
}
$lista = $_SESSION['lista'] ?? null;

if (filter_input(INPUT_POST, "continuar", FILTER_VALIDATE_BOOLEAN)) {
    $email = filter_input(INPUT_POST, "txtEmail");
    if (!$email) {
        $erro['txtEmail'] = ' is-invalid';
    }
    $endereco = filter_input(INPUT_POST, "txtEndereco");
    if (!$endereco) {
        $erro['txtEndereco'] = ' is-invalid';
    }
    if (!isset($erro)) {
        $pessoa->setEmail($email);
        $pessoa->setEndereco($endereco);
        $lista[] = $pessoa;
        
        $_SESSION['lista'] = $lista;
        $_SESSION['pessoa'] = null;
        header("Location: fim.php");
        exit();
    }
}
$titulo = "Cadastro de Pessoas - Endereços";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $titulo ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <h1><?= $titulo ?></h1>
        <form method="post">
            <div class="row">
                <div class="col">
                    <label for="txtEmail" class="form-label">E-mail</label>
                    <input type="text" id="txtEmail" name="txtEmail"
                           value="<?= $_POST['txtEmail'] ?? '' ?>"
                           class="form-control<?= $erro['txtEmail'] ?? '' ?>"/>
                    <div class="invalid-feedback">E-mail deve ser informado.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="txtEndereco" class="form-label">Endereço</label>
                    <input type="text" id="txtEndereco" name="txtEndereco"
                           value="<?= $_POST['txtEndereco'] ?? '' ?>"
                           class="form-control<?= $erro['txtEndereco'] ?? '' ?>"/>
                    <div class="invalid-feedback">Endereço deve ser informado.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="inicio.php" class="btn btn-secondary">Voltar</a>
                </div>
                <div class="col">
                    <button type="submit" name="continuar" value="true" class="btn btn-primary">Encerrar</button>
                </div>
            </div>
        </form>
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </body>
</html>
