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


$produtos = listarProduto();
$cliente = listarCliente();

if (isset($_POST['gravar'])) {

    if (!empty($_POST['idproduto']) && !empty($_POST['idcliente']) && !empty($_POST['quantidade']) && !empty($_POST['dataCompra'])) {
        $compra = new Compra(null, $_POST['quantidade'], $_POST['dataCompra'], $_POST['idproduto'], $_POST['idcliente']);
        cadastrarCompra($compra);
    }
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>CADASTRAR COMPRA</title>
    <link rel='stylesheet' href='CadastrarCompra.css'>
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
                <div class="aba abaAtiva">CADASTRO DE COMPRA</div>
                <a href="ListarCompra.php" class="aba">LISTA DE COMPRAS</a>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">
                <form method="post">

                    <div class="topo">
                        <h1 class="titulo"><strong>Nova compra</strong></h1>
                    </div>

                    <div class="campo">
                        <div class="campoTipo">
                            <label class="label"><strong>Produto</strong></label>
                        </div>
                        <select name="idproduto" class="input">
                            <option value="">Selecione um produto</option>
                            <?php foreach ($produtos as $produto) { ?>
                                <option value="<?= $produto->getIdproduto() ?>"><?= $produto->getProduto() ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="linha">
                        <div class="campo campoFlex">

                            <div class="campoTipo">
                                <label class="label"><strong>Nome do Cliente</strong></label>
                            </div>
                            <select name="idcliente" class="input">
                                <option value="">Selecione um Cliente</option>
                                <?php foreach ($cliente as $cliente) { ?>
                                    <option value="<?= $cliente->getIdcliente() ?>"><?= $cliente->getNomeCliente() ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Quantidade da compra</strong></label>
                            </div>
                            <input type="text" name="quantidade" class="input">
                        </div>

                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Data da compra</strong></label>
                            </div>
                            <input type="date" name="dataCompra" class="input">
                        </div>
                    </div>

                    <div class="acao">
                        <button type="submit" name="gravar" class="botao">Cadastrar compra</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>

</html>