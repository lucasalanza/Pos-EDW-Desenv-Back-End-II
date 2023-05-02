<?php
//require_once './classes/edw/dao/PessoaDAO.php';
//require_once './classes/edw/Pessoa.php';
require_once './Autoloader.php';

use edw\Pessoa;
use edw\dao\PessoaDAO;
use edw\util\Erros;

$titulo = "Cadastro de Pessoas - Banco de dados";
$dao = new PessoaDAO();
$erro = new Erros();

date_default_timezone_set('UTC');
$codigoParaAlterar = filter_input(INPUT_GET, 'alterar', FILTER_VALIDATE_INT);

if ($codigoParaAlterar != false) {
//preenche campos do form 
    $pessoaAlterando = $dao->buscar($codigoParaAlterar);
    $_POST['txtCodigo'] = $pessoaAlterando->getId();
    $_POST['txtNome'] = $pessoaAlterando->getNome();

    $data = date('d/m/Y', strtotime($pessoaAlterando->getDataNascimento()));

    $_POST['txtData'] = $data;
    $_POST['txtEmail'] = $pessoaAlterando->getEmail();
    $_POST['txtEndereco'] = $pessoaAlterando->getEndereco();
}
if (filter_input(INPUT_POST, "inserir", FILTER_VALIDATE_BOOLEAN)) {
    $id = filter_input(INPUT_POST, "txtCodigo", FILTER_VALIDATE_INT, ["options" => ['min_range' => 1]]);
    if (!$id) {
        $erro->addErro(' is-invalid', 'txtCodigo');
    }
    $nome = filter_input(INPUT_POST, "txtNome");
    if (!$nome) {
        $erro->addErro(' is-invalid', 'txtNome');
    }
    $data = filter_input(INPUT_POST, "txtData");
    if (!$data) {
        $erro->addErro(' is-invalid', 'txtData');
    }
    $email = filter_input(INPUT_POST, "txtEmail", FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $erro->addErro(' is-invalid', 'txtEmail');
    }
    $endereco = filter_input(INPUT_POST, "txtEndereco");
    if (!$endereco) {
        $erro->addErro(' is-invalid', 'txtEndereco');
    }

    if (!$erro->possuiErros()) {
        $pessoa = new Pessoa();
        $pessoa->setId($id);
        $pessoa->setNome($nome);
        $timestamp = strtotime($data);
        $pessoa->setDataNascimento($timestamp);
        $pessoa->setEmail($email);
        $pessoa->setEndereco($endereco);
        if (!$dao->inserirPrep($pessoa)) {
            $erro->addErro("Erro inserindo registro. Tente mais tarde.", 'inserir');
        } else {
            unset($codigoParaAlterar);
            unset($_POST);
        }
    }
} else {
    $codigoParaExcluir = filter_input(INPUT_GET, 'excluir', FILTER_VALIDATE_INT);
    if ($codigoParaExcluir != false) {
        if (!$dao->excluirPrep($codigoParaExcluir)) {
            $erro->addErro("Erro excluindo registro.", "excluir");
        }
    }
}
if (filter_input(INPUT_POST, "limpar", FILTER_VALIDATE_BOOLEAN)) {
    unset($codigoParaAlterar);
    unset($_POST);
}

$pessoas = $dao->listarPrep("");
// Do stuff with $_POST['my_var']
unset($dao); //destroi objeto de persistência, fechando concexão com o banco;
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
        <div class="container">
            <h1><?= $titulo ?></h1>
            <?php
            if ($erro->getErro('inserir') || $erro->getErro('excluir')) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <h2 class="alert-heading">Erros:</h2>
                    <ul>
                        <?php
                        foreach ($erro->getErros() as $e) {
                            print "<li>$e</li>";
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
            ?>
            <form method="post" action="cadastro.php">
                <div class="row">
                    <div class="col">
                        <label for="txtCodigo" class="form-label">Código</label>
                        <input type="text" id="txtNome" name="txtCodigo"
                               value="<?= $_POST['txtCodigo'] ?? '' ?>"
                               class="form-control<?= $erro->getErro('txtCodigo') ?? '' ?>"/>
                        <div class="invalid-feedback">Código deve ser informado.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="txtNome" class="form-label">Nome</label>
                        <input type="text" id="txtNome" name="txtNome"
                               value="<?= $_POST['txtNome'] ?? '' ?>"
                               class="form-control<?= $erro->getErro('txtNome') ?? '' ?>"/>
                        <div class="invalid-feedback">Nome deve ser informado.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="txtData" class="form-label">Data Nascimento</label>
                        <input type="text" id="txtData" name="txtData"
                               value="<?= $_POST['txtData'] ?? '' ?>"
                               class="form-control<?= $erro->getErro('txtData') ?? '' ?>"/>
                        <div class="invalid-feedback">Data de Nascimento deve ser informada.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="txtEmail" class="form-label">E-mail</label>
                        <input type="text" id="txtEmail" name="txtEmail"
                               value="<?= $_POST['txtEmail'] ?? '' ?>"
                               class="form-control<?= $erro->getErro('txtEmail') ?? '' ?>"/>
                        <div class="invalid-feedback">E-mail deve ser informado.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="txtEndereco" class="form-label">Endereço</label>
                        <input type="text" id="txtEndereco" name="txtEndereco"
                               value="<?= $_POST['txtEndereco'] ?? '' ?>"
                               class="form-control<?= $erro->getErro('txtEndereco') ?? '' ?>"/>
                        <div class="invalid-feedback">Endereço deve ser informado.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" name="inserir" value="true" class="btn btn-primary">Inserir</button>
                        <button type="submit" name="limpar" value="true" class="btn btn-secondary">limpar</button>
                    </div>
                </div>
            </form>

<!--           <h2>Pessoas cadastradas</h2>

            <div class="row">
                <? php
                if (isset($pessoas) && count($pessoas) > 0) {
                    ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Data Nascimento</th>
                            <th>Email</th>
                            <th>Endereço</th>
                            <th>-</th>                        <th>-</th>

                        </tr>
                        <? php
                        foreach ($pessoas as $pessoa) {
                            ?>
                            <tr>
                                <td><? = $pessoa->getId(); ?></td>
                                <td>< ?= $pessoa->getNome() ?></td>
                                <td><? = date("d/m/Y", strtotime($pessoa->getDataNascimento())) ?></td>
                                <td><? = $pessoa->getEmail() ?></td>
                                <td><? = $pessoa->getEndereco() ?></td>
                                <td>
                                    <a href="cadastro.php?excluir=<? = $pessoa->getId() ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Deseja excluiro <? = $pessoa->getNome() ?>?')">excluir</a>
                                </td> 
                                <td>
                                    <a href="cadastro.php?alterar=< ?= $pessoa->getId() ?>"
                                       class="btn btn-info"
                                       >Alterar</a>
                                </td>
                            </tr>
                            <? php
                        }
                        ?>
                    </table>
                    <? php
                } else {
                    print "<p>Nenhum registro cadastrado</p>";
                }
                ?>
            </div> -->
            <p>
                <a href="index.php">Voltar</a>
            </p>  </div>
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </body>
</html>
