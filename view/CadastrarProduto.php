<?php
include_once __DIR__ . '/../controller/controllerProduto.php';
include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];

if (isset($_POST['gravar'])) {
    if (!empty($_POST['produto']) && !empty($_POST['precoUnitario']) && !empty($_POST['dataConfeccao']) && !empty($_POST['dataValidade'])) {

        $produto = new Produto(null, $_POST['produto'], $_POST['precoUnitario'], $_POST['dataValidade'], $_POST['dataConfeccao']);

        cadastrarProduto($produto);
    }
}
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>CADASTRAR PRODUTO</title>
    <link rel='stylesheet' href='CadstrarProduto.css'>
</head>

<body>

    <div class="navbar">
        <div class="marca">
            <img src="logo.png" alt="Logo" class="marca-logo">
            <div class="titulo-marca">SISTEMA DE<br />GESTAO DE COMPRAS</div>
        </div>

        <nav class="navlinks">
            <a href="Dashboard.php"><span class="icone"></span>Inicio</a>
            <a class="on" href="CadastrarProduto.php"><span class="icone"></span>Produto</a>
            <a href="cadastrarFornecedor.php"><span class="icone"></span>Fornecedor</a>
            <a href="CadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php"><span class="icone"></span>Caixa</a>
            <a href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
            <a href="cadastarEnvio.php"><span class="icone"></span>Envio</a>
            <?php if ($perfil == 'ADMINISTRADOR') { ?>

                <a href="cadastarUtilizadores.php">
                    <span class="icone"></span>Utilizadores
                </a>

            <?php } ?>

            <?php if ($perfil == 'AUDITOR') { ?>
                <a href="ListarLog.php"><span class="icone"></span>Envio</a>
            <?php } ?>
        </nav>
        </nav>

        <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <div class="aba abaAtiva">CADASTRO DE PRODUTO</div>
                <a href="ListarProduto.php" class="aba">LISTA DE PRODUTOS</a>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">
                <form method="post">

                    <div class="topo">
                        <h1 class="titulo"><strong>Novo produto</strong></h1>
                    </div>

                    <div class="campo">
                        <div class="campoTipo">
                            <label class="label"><strong>Nome do produto</strong></label>
                        </div>
                        <input type="text" name="produto" class="input">
                    </div>

                    <div class="linha">
                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Preco unitario</strong></label>
                            </div>
                            <input type="text" name="precoUnitario" class="input" value="0.00">
                        </div>

                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Data de Confeccao</strong></label>
                            </div>
                            <input type="date" name="dataConfeccao" class="input">
                        </div>

                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Data de Validade</strong></label>
                            </div>
                            <input type="date" name="dataValidade" class="input">
                        </div>

                    </div>

                    <div class="acao">
                        <button type="submit" name="gravar" class="botao">Cadastrar produto</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>

</html>