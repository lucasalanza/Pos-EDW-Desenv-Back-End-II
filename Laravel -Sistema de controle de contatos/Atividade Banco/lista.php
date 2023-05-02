<?php
//require_once './classes/edw/dao/PessoaDAO.php';
//require_once './classes/edw/Pessoa.php';
require_once './Autoloader.php';

use edw\Pessoa;
use edw\dao\PessoaDAO;
$titulo = "lista de Pessoas - Banco de dados";
$dao = new PessoaDAO();
$pessoas = $dao->listarPrep("");


if (filter_input(INPUT_POST, "limpar", FILTER_VALIDATE_BOOLEAN)) {
    $pessoas = $dao->listarPrep("");
    $nomeBusca = "";
}
if (filter_input(INPUT_POST, "btnBusca", FILTER_VALIDATE_BOOLEAN)) {
    $nomeBusca = filter_input(INPUT_POST, "txtNomeBusca", FILTER_SANITIZE_STRING);
    $pessoas = $dao->listarPrep($nomeBusca);
}

//unset($dao); //destroi objeto de persistência, fechando concexão com o banco;
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
            <br/>
            <h2>Pessoas cadastradas</h2>
            <br/>
            <form method="post" action="lista.php">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="inputBusca" class="col-form-label">Buscar</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" name="txtNomeBusca" id="txtNomeBusca" class="form-control" placeholder="nome" aria-describedby="text">
                    </div>  
                    <div class="col-auto">
                        <button type="submit" name="btnBusca" value="true" class="btn btn-primary">Buscar</button>  
                        <button type="submit" name="limpar" value="true" class="btn btn-secondary">Limpar</button>
             </div>  

                </div>           
            </form>
            <br/>
            <div class="row">
                <?php
                if (isset($pessoas) && count($pessoas) > 0) {
                    ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Data Nascimento</th>
                            <th>Email</th>
                            <th>Endereço</th>
                            <th>-</th>  
                            <th>-</th>

                        </tr>
                        <?php
                        foreach ($pessoas as $pessoa) {
                            ?>
                            <tr>
                                <td><?= $pessoa->getId(); ?></td>
                                <td><?= $pessoa->getNome() ?></td>
                                <td><?= date("d/m/Y", strtotime($pessoa->getDataNascimento())) ?></td>
                                <td><?= $pessoa->getEmail() ?></td>
                                <td><?= $pessoa->getEndereco() ?></td>
                                <td>
                                    <a href="cadastro.php?excluir=<?= $pessoa->getId() ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Deseja excluiro <?= $pessoa->getNome() ?>?')">excluir</a>
                                </td> 
                                <td>
                                    <a href="cadastro.php?alterar=<?= $pessoa->getId() ?>"
                                       class="btn btn-info"
                                       >Alterar</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                } else {
                    print "<p>Nenhum registro cadastrado</p>";
                }
                ?>
            </div>  
            <p>
                <a href="index.php">Voltar</a>
            </p>  </div>
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </body>
</html>
