<?php
//require_once './classes/edw/Pessoa.php';
require_once './Autoloader.php';

use edw\Pessoa;

session_start();
$titulo = "Cadastro de Pessoas - Listagem";

if (!isset($_SESSION['lista'])) {
    header("Location: inicio.php");
    exit();
}
$lista = $_SESSION['lista'];

if (filter_input(INPUT_POST, "limpar", FILTER_VALIDATE_BOOLEAN)) {
    $_SESSION['lista'] = null;
    header("Location: inicio.php");
    exit();
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
        <?php
        if (isset($lista)) {
            ?>
            <table class="table table-striped">
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Data Nascimento</th>
                    <th>Email</th>
                    <th>Endereço</th>
                </tr>
                <?php
                foreach ($lista as $pessoa) {
                    /* @var $pessoa Pessoa */ //Anotação para permitir o autocompletar 
                    ?>
                    <tr>
                        <td><?= $pessoa->getId(); ?></td>
                        <td><?= $pessoa->getNome() ?></td>
                        <td><?= $pessoa->getDataNascimento() ?></td>
                        <td><?= $pessoa->getEmail() ?></td>
                        <td><?= $pessoa->getEndereco() ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        } else {
            ?>
            <p>Nenhuma pessoa cadastrada</p>
            <?php
        }
        ?>
        <form method="post">
            <div class="row">
                <div class="col">
                    <a href="inicio.php" class="btn btn-primary">Novo</a>
                </div>
                <div class="col">
                    <button type="submit" name="limpar" value="true" class="btn btn-danger">Limpar</button>
                </div>
            </div>
        </form>
        <p>
            <a href="limpar_sessao.php">Voltar</a>
        </p>
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </body>
</html>
