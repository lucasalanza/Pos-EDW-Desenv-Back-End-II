<?php
session_start();
$titulo = "Exercício 4 - Inverte Ordem Fases";

if (filter_input(INPUT_POST, "limpar", FILTER_VALIDATE_BOOLEAN)) {
    unset($_SESSION["quantidade"]);
}
if (isset($_SESSION["quantidade"])) {
    $totalCampos = $_SESSION["quantidade"];
}

if (filter_input(INPUT_POST, "enviar", FILTER_VALIDATE_BOOLEAN)) {
    if (!isset($totalCampos)) {
        $totalCampos = filter_input(INPUT_POST, "qtd", FILTER_VALIDATE_INT, ["options" => ['min_range' => 1, 'max_range' => 50]]);
        if ($totalCampos === false) {
            unset($totalCampos);
            $erro = ' is-invalid';
        } else {
            $_SESSION["quantidade"] = $totalCampos;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $titulo ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <h1><?= $titulo ?></h1>
        <form method="post">
            <?php
            if (isset($totalCampos)) {
                $k = $totalCampos;
                for ($indice = 1; $indice <= $totalCampos; $indice++) {
                    $valor = filter_input(INPUT_POST, "campo" . $k--);
                    ?>
                    <div class="row">
                        <div class="col">
                            <label for="campo<?= $indice ?>" class="form-label">Campo <?= $indice ?></label>
                            <input type="text" id="campo<?= $indice ?>" name="campo<?= $indice ?>"
                                   value="<?= $valor !== false ? $valor : '' ?>"
                                   class="form-control" placeholder="Valor <?= $indice ?>" aria-label="Valor <?= $indice ?>"/>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="row">
                    <div class="col">
                        <label for="cqtd" class="form-label">Quantos campos?</label>
                        <input type="text" id="qtd" name="qtd" value="" class="form-control<?= $erro ?? '' ?>" />
                        <div class="invalid-feedback">
                            Quantidade de campos deve ser informada e deve ser um inteiro entre 0 e 50.
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row text-center">
                <div class="col">
                    <button name="enviar" value="true" type="submit" class="btn btn-primary"><?= isset($totalCampos) ? "Inverter" : "Continuar" ?></button>
                </div>
                <div class="col">
                    <button name="limpar" value="true" type="submit" class="btn btn-primary">Recomeçar</button>
                </div>
            </div>
        </form>
        <p>
            <a href="limpar_sessao.php">Voltar</a>
        </p>
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </body>
</html>
