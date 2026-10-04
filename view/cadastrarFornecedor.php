<?php
include_once(__DIR__ . "/../controller/controllerFornecedor.php");
include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];

$fornedores = listarFornecedor();


if (isset($_POST['gravar'])) {
    if (!empty($_POST['nomeFornecedor']) && !empty($_POST['contacto']) && !empty($_POST['endereco']) && !empty($_POST['email'])) {
        $fornecedor = new Fornecedor(null, $_POST['nomeFornecedor'], $_POST['contacto'], $_POST['endereco'], $_POST['email']);
        criacao($fornecedor);
    }
}


?>




<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>CADASTRAR FORNECEDOR</title>
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
            <a href="CadastrarProduto.php"><span class="icone"></span>Produto</a>
            <a class="on" href="cadastrarFornecedor.php"><span class="icone"></span>Fornecedor</a>
            <a href="CadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php"><span class="icone"></span>Caixa</a>
            <a href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
            <a href="cadastarEnvio.php"><span class="icone"></span>Envio</a>
            <?php if ($perfil == 'ADMINISTRADOR') { ?>

                <a href="cadastarUtilizadores.php">
                    <span class="icone"></span>Utilizadores
                </a>

            <?php } ?>
        </nav>

         <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <div class="aba abaAtiva">CADASTRO DE FORNECEDORES</div>
                <a href="listarFornecedores.php" class="aba">LISTA DE FORNECEDORES</a>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">
                <form method="post">

                    <div class="topo">
                        <h1 class="titulo"><strong>Novo fornecedor</strong></h1>
                    </div>

                    <div class="campo">
                        <div class="campoTipo">
                            <label class="label"><strong>Nome do Fornecedor</strong></label>
                        </div>
                        <input type="text" name="nomeFornecedor" class="input">
                    </div>

                    <div class="linha">
                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Contacto</strong></label>
                            </div>
                            <input type="number" name="contacto" class="input" required>
                        </div>

                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Endereco</strong></label>
                            </div>
                            <input type="text" name="endereco" class="input" required>
                        </div>

                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Email</strong></label>
                            </div>
                            <input type="email" name="email" class="input" required>
                        </div>

                    </div>

                    <div class="acao">
                        <button type="submit" name="gravar" class="botao">Cadastrar fornecedor</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>

</html>