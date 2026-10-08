<?php

include_once(__DIR__ . "/../controller/envioController.php");

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];
// include_once(__DIR__ . "/../controller/controllerFornecedor.php");
// include_once(__DIR__ . "/../controller/controllerProduto.php");

if (isset($_POST['remover'])) {
    remocaoEnvio($_POST['id']);
    header('Location: listarEnvio.php');
    exit;
}

if (
    isset($_POST['guardar']) && !empty($_POST['id']) && !empty($_POST['dataEnvio'])
) {
    $envio = encontraEnvio($_POST['id']);
    if ($envio) {
        $envio->setDataEnvio($_POST['dataEnvio']);
        edicaoEnvio($envio);
    }
    header('Location: listarEnvio.php');
    exit;
}
$envios = listarEnvio();
$fornecedores = listarFornecedoresEnviados();
$produtos = listarProdutosEnviados();
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>LISTAR CLIENTE</title>
    <link rel='stylesheet' href='listarCaixa.css'>
</head>

<body>

    <div class="navbar">
        <div class="marca">
            <img src="logo.png" alt="Logo" class="marca-logo">
            <div class="titulo-marca">SISTEMA DE<br />GESTAO DE COMPRAS</div>
        </div>

        <nav class="navlinks">
            <a href="Dashboard.php"><span class="icone"></span>Inicio</a>
            <a href="CadastrarProduto.php"><span class="icone"></span>Produto</a>
            <a href="cadastrarFornecedor.php"><span class="icone"></span>Fornecedor</a>
            <a href="CadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php"><span class="icone"></span>Caixa</a>
            <a href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
            <a class="on" href="cadastarEnvio.php"><span class="icone"></span>Envio</a>
            <?php if ($perfil == 'ADMINISTRADOR') { ?>
                <a href="cadastarUtilizadores.php"><span class="icone"></span>Utilizadores</a>
            <?php } ?>
            <?php if ($perfil == 'AUDITOR') { ?>
                <a href="ListarLog.php"><span class="icone"></span>Envio</a>
            <?php } ?>
        </nav>

        <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <a href="cadastarEnvio.php" class="aba">CADASTRO DE ENVIOS</a>
                <div class="aba abaAtiva">LISTA DE ENVIOS</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de envios</strong></h1>
                </div>

                <div class="linha">
                    <div class="campo campoBusca">
                        <input type="text" name="pesquisa" class="input" placeholder="Pesquisar caixa">
                    </div>
                    <div class="campo">
                        <button type="button" class="botao">Listar</button>
                    </div>
                </div>

                <div class="tabela">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fornecedor</th>
                                <th>Produto</th>
                                <th>Data Envio</th>
                                <th>Acoes</th>
                            </tr>
                        </thead>

                        <?php if (count($envios) == 0) { ?>
                            <tr>
                                <td>SEM NENHUM ENVIO REGISTADO</td>
                            </tr>
                        <?php } else { ?>

                            <?php foreach ($envios as $envio) {  ?>
                                <tr>
                                    <td><?= $envio->getIdEnvia() ?></td>
                                    <td><?= $envio->getNomeFornecedor() ?></td>
                                    <td><?= $envio->getNomeProduto() ?></td>
                                    <td><?= $envio->getDataEnvio() ?></td>

                                    <td class="acoes">
                                        <?php if ($perfil == 'ADMINISTRADOR' || $perfil == 'AUDITOR' || $perfil == 'SUEPER OPERADOR') { ?>

                                            <a href="#editar-<?= $envio->getIdEnvia() ?>" class="botaoAtualizar"> Editar </a>
                                            <a href="#remover-<?= $envio->getIdEnvia() ?>" class="botaoRemover"> Remover </a>

                                        <?php } ?>

                                        <form method="post">
                                            <input type="hidden" name="id" value="<?= $envio->getIdEnvia() ?>">

                                        </form>

                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </table>

                    <?php foreach ($envios as $envio) { ?>
                        <!-- modal editar -->

                        <div class="modalFundo" id="editar-<?= $envio->getIdEnvia() ?>">
                            <a href="#" class="modalOverlay" aria-label="Fechar"></a>
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Editar Envio</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>
                                <form method="post">
                                    <div class="campo">
                                        <label class="label">
                                            <strong>FORNECEDOR</strong>
                                        </label>
                                        <select name="fornecedor" class="input">
                                            <?php foreach ($fornecedores as $fornecedor) { ?>
                                                <option
                                                    value="<?= $fornecedor['idFornecedor'] ?>"
                                                    <?= $fornecedor['idFornecedor'] == $envio->getIdFornecedor() ? 'selected' : '' ?>>
                                                    <?= $fornecedor['nomeFornecedor'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="campo">
                                        <label class="label">
                                            <strong>PRODUTO</strong>
                                        </label>
                                        <select name="produto" class="input">
                                            <?php foreach ($produtos as $produto) { ?>
                                                <option
                                                    value="<?= $produto['idProduto'] ?>"
                                                    <?= $produto['idProduto'] == $envio->getIdProduto() ? 'selected' : '' ?>>
                                                    <?= $produto['produto'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="campo">
                                        <label class="label">
                                            <strong>DATA ENVIO</strong>
                                        </label>

                                        <input type="date" name="dataEnvio" class="input" value="<?= $envio->getDataEnvio() ?>">
                                    </div>
                                    <input type="hidden" name="id" value="<?= $envio->getIdEnvia() ?>">
                                    <div class="acao">
                                        <button name="guardar" type="submit" class="botao"> Guardar </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- fim modal editar -->
                    <?php } ?>


                    <?php foreach ($envios as $envio) { ?>
                        <!-- modal remover -->

                        <div class="modalFundo" id="remover-<?= $envio->getIdEnvia() ?>">
                            <a href="#" class="modalOverlay" aria-label="Fechar"></a>
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Remover Envio</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>
                                <form method="post">
                                    <div class="campo">
                                        <label class="label">
                                            <strong>FORNECEDOR</strong>
                                        </label>
                                        <select name="fornecedor" class="input">
                                            <?php foreach ($fornecedores as $fornecedor) { ?>
                                                <option
                                                    value="<?= $fornecedor['idFornecedor'] ?>"
                                                    <?= $fornecedor['idFornecedor'] == $envio->getIdFornecedor() ? 'selected' : '' ?>>
                                                    <?= $fornecedor['nomeFornecedor'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="campo">
                                        <label class="label">
                                            <strong>PRODUTO</strong>
                                        </label>
                                        <select name="produto" class="input">
                                            <?php foreach ($produtos as $produto) { ?>
                                                <option
                                                    value="<?= $produto['idProduto'] ?>"
                                                    <?= $produto['idProduto'] == $envio->getIdProduto() ? 'selected' : '' ?>>
                                                    <?= $produto['produto'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="campo">
                                        <label class="label">
                                            <strong>DATA ENVIO</strong>
                                        </label>
                                        <input type="date" name="dataEnvio" class="input" value="<?= $envio->getDataEnvio() ?>">
                                    </div>
                                    <input type="hidden" name="id" value="<?= $envio->getIdEnvia() ?>">
                                    <div class="acao">
                                        <button name="remover" type="submit" class="botao"> remover </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- fim modal editar -->

                    <?php } ?>


                </div>

            </div>
        </div>

    </div>

    </div>

    </div>




</body>

</html>