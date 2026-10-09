<?php
include_once __DIR__ . '/../controller/controllerCompra.php';
include_once __DIR__ . '/../controller/controllerProduto.php';
include_once __DIR__ . '/../controller/clienteController.php';

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
$perfil = $_SESSION['perfil'];

$compras = listarCompra();
$produtos = listarProduto();
$cliente = listarCliente();

if (isset($_POST['remover'])) {
    global $conexao;
    removerCompra($_POST['id']);
    header('Location: ListarCompra.php');
}

if (
    isset($_POST['guardar']) && !empty($_POST['id']) &&
    !empty($_POST['idproduto']) && !empty($_POST['idcliente'])
    && !empty($_POST['quantidade']) && !empty($_POST['dataCompra'])
) {
    $compra = encontraCompra($_POST['id']);

    if ($compra) {
        $compra->setIdproduto($_POST['idproduto']);
        $compra->setIdcliente($_POST['idcliente']);
        $compra->setQuantidade($_POST['quantidade']);
        $compra->setDataCompra($_POST['dataCompra']);
        actualizarCompra($compra);
    }
    header('Location: ListarCompra.php#');
}

$pesquisa = $_GET['pesquisa'] ?? '';
$compras = $pesquisa !== '' ? pesquisarCompra($pesquisa) : listarCompra();

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>LISTAR COMPRA</title>
    <link rel='stylesheet' href='ListarCompra.css'>
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
            <a class="on" href="CadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php"><span class="icone"></span>Caixa</a>
            <a href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
            <a href="cadastarEnvio.php"><span class="icone"></span>Envio</a>
            <?php if ($perfil == 'ADMINISTRADOR') { ?>

                <a href="cadastarUtilizadores.php">
                    <span class="icone"></span>Utilizadores
                </a>

            <?php } ?>
            <?php if ($perfil == 'AUDITOR') { ?>
                <a href="ListarLog.php"><span class="icone"></span>Log</a>
            <?php } ?>
        </nav>
        <div style="margin: 15px;">
            <p>Olá, <?= isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>!</p>
            <p>Perfil: <?= isset($_SESSION['perfil']) ? $_SESSION['perfil'] : ''; ?></p>
        </div>
        <a href="alterarSenha.php" class="sair">Alterar Senha</a>
        <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <a href="CadastrarCompra.php" class="aba">CADASTRO DE COMPRA</a>
                <div class="aba abaAtiva">LISTA DE COMPRAS</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de Compras</strong></h1>
                </div>

                <form method="get">
                    <div class="linha">
                        <div class="campo campoBusca">
                            <input type="text" name="pesquisa" class="input" placeholder="Pesquisar " value="<?= $pesquisa ?>">
                        </div>
                        <div class="campo">
                            <button type="submit" class="botao">Pesquisar</button>
                        </div>
                    </div>
                </form>
                <div class="tabela">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome do Produto</th>
                                <th>Nome do Cliente</th>
                                <th>Preco Unitario</th>
                                <th>Quantidade</th>
                                <th>Data de Compra</th>
                                <th>Preco Total</th>
                                <th>Acao</th>
                            </tr>
                        </thead>

                        <?php if (count($compras) == 0) { ?>
                            <tr>
                                <td>SEM NENHUMA COMPRA REGISTADA</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($compras as $dadosCompra) {
                                $compra = $dadosCompra['compra']; ?>

                                <tr>
                                    <td><?= $compra->getIdcompra() ?></td>
                                    <td><?= $dadosCompra['nomeProduto'] ?></td>
                                    <td><?= $dadosCompra['nomeCliente'] ?></td>
                                    <td><?= $dadosCompra['precoProduto'] ?></td>
                                    <td><?= $compra->getQuantidade() ?></td>
                                    <td><?= $compra->getDataCompra() ?></td>
                                    <td><?= $compra->getQuantidade() * $dadosCompra['precoProduto'] ?></td>

                                    <td>
                                        <div class="acoes">


                                            <form method="post">

                                                <?php if ($perfil == 'ADMINISTRADOR' || $perfil == 'AUDITOR' || $perfil == 'SUPER OPERADOR') { ?>
                                                    <input type="hidden" name="id" value="<?= $compra->getIdcompra() ?>">
                                                    <a href="#editar-<?= $compra->getIdcompra() ?>" class="botaoAtualizar"> Editar </a>
                                                    <a href="#remover-<?= $compra->getIdcompra() ?>" class="botaoRemover"> Remover </a>
                                                <?php } ?>

                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </table>

                    <?php foreach ($compras as $linha) {
                        $compra = $linha['compra']; ?>
                        <!-- MODAL-->
                        <div class="modalFundo" id="editar-<?= $compra->getIdcompra() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Editar Compra</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $compra->getIdcompra() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome do produto</strong></label>
                                        </div>
                                        <select name="idproduto" class="input">
                                            <?php foreach ($produtos as $produto) { ?>
                                                <option value="<?= $produto->getIdproduto() ?>"
                                                    <?= $produto->getIdproduto() == $compra->getIdproduto() ?>>
                                                    <?= $produto->getProduto() ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="linha">
                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Nome do Cliente</strong></label>
                                            </div>
                                            <select name="idcliente" class="input">
                                                <?php foreach ($cliente as $clientes) { ?>
                                                    <option value="<?= $clientes->getIdcliente() ?>"
                                                        <?= $clientes->getIdcliente() == $compra->getIdcliente() ?>>
                                                        <?= $clientes->getNomeCliente() ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Quantidade</strong></label>
                                            </div>
                                            <input type="text" name="quantidade" class="input" value="<?= $compra->getQuantidade() ?>">
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Data da compra</strong></label>
                                            </div>
                                            <input type="date" name="dataCompra" class="input" value="<?= $compra->getDataCompra() ?>">
                                        </div>
                                    </div>

                                    <div class="acao">
                                        <button type="submit" name="guardar" class="botao">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- fim da modal -->
                    <?php } ?>

                    <?php foreach ($compras as $linha) {
                        $compra = $linha['compra']; ?>
                        <!-- MODAL-->
                        <div class="modalFundo" id="remover-<?= $compra->getIdcompra() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Remover Compra</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $compra->getIdcompra() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome do produto</strong></label>
                                        </div>
                                        <select name="idproduto" class="input">
                                            <?php foreach ($produtos as $produto) { ?>
                                                <option value="<?= $produto->getIdproduto() ?>"
                                                    <?= $produto->getIdproduto() == $compra->getIdproduto() ?>>
                                                    <?= $produto->getProduto() ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="linha">
                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Nome do Cliente</strong></label>
                                            </div>
                                            <select name="idcliente" class="input">
                                                <?php foreach ($cliente as $clientes) { ?>
                                                    <option value="<?= $clientes->getIdcliente() ?>"
                                                        <?= $clientes->getIdcliente() == $compra->getIdcliente() ?>>
                                                        <?= $clientes->getNomeCliente() ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Quantidade</strong></label>
                                            </div>
                                            <input type="text" name="quantidade" class="input" value="<?= $compra->getQuantidade() ?>">
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Data da compra</strong></label>
                                            </div>
                                            <input type="date" name="dataCompra" class="input" value="<?= $compra->getDataCompra() ?>">
                                        </div>
                                    </div>

                                    <div class="acao">
                                        <button type="submit" name="remover" class="botao">Remover</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- fim da modal -->
                    <?php } ?>

                </div>

            </div>
        </div>

    </div>

</body>

</html>