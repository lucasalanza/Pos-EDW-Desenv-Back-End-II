<?php
//require_once './classes/edw/Pessoa.php';
require_once './Autoloader.php';

use edw\Pessoa;
//use edw2\Pessoa as P2;
//$s = new P2();

session_start();



$titulo = "Cadastro de Pessoas - Inicio";

$lista = $_SESSION['lista'] ?? null;
$id = isset($lista) ? count($lista) : 0;

if (filter_input(INPUT_POST, "iniciar", FILTER_VALIDATE_BOOLEAN)) {
    $nome = filter_input(INPUT_POST, "txtNome");
    if (!$nome) {
        $erro['txtNome'] = ' is-invalid';
    }
    $data = filter_input(INPUT_POST, "txtData");
    if (!$data) {
        $erro['txtData'] = ' is-invalid';
    }
    if (!isset($erro)) {
        $pessoa = new Pessoa();
        $pessoa->setId($id + 1);
        $pessoa->setNome($nome);
        $pessoa->setDataNascimento($data);
        $_SESSION['pessoa'] = $pessoa;

        header("Location: meio.php");
        exit();
    } 

}
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
                    <label for="txtNome" class="form-label">Nome</label>
                    <input type="text" id="txtNome" name="txtNome"
                           value="<?= $_POST['txtNome'] ?? '' ?>"
                           class="form-control<?= $erro['txtNome'] ?? '' ?>"/>
                    <div class="invalid-feedback">Nome deve ser informado.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="txtData" class="form-label">Data Nascimento</label>
                    <input type="text" id="txtData" name="txtData"
                           value="<?= $_POST['txtData'] ?? '' ?>"
                           class="form-control<?= $erro['txtData'] ?? '' ?>"/>
                    <div class="invalid-feedback">Data de Nascimento deve ser informada.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" name="iniciar" value="true" class="btn btn-primary">Iniciar cadastro</button>
                </div>
                <div class="col">
                    <a href="fim.php" class="btn btn-secondary">Listar</a>
                </div>
            </div>
        </form>
        <p>
            <a href="limpar_sessao.php">Voltar</a>
        </p>
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </body>
</html>
