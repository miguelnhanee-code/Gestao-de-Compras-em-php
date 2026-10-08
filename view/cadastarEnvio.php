<?php
include_once(__DIR__ . "/../controller/envioController.php");
include_once(__DIR__ . "/../controller/ControllerFornecedor.php");
include_once(__DIR__ . "/../controller/controllerProduto.php");
include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];

$fornecedores = listarFornecedor();
$produtos = listarProduto();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>CADASTRAR ENVIO</title>
    <link rel='stylesheet' href='cadastrarCaixa.css'>
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

                <a href="cadastarUtilizadores.php">
                    <span class="icone"></span>Utilizadores
                </a>

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
                <div class="aba abaAtiva">CADASTRO DE ENVIO</div>
                <a href="listarEnvio.php" class="aba">LISTA DE ENVIOS</a>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">
                <form method="post">

                    <div class="topo">
                        <h1 class="titulo"><strong>Novo envio</strong></h1>
                    </div>

                    <div class="campo">
                        <div class="campoTipo">
                            <label class="label"><strong>Data de envio</strong></label>
                        </div>
                        <input type="date" name="dataEnvio" class="input">
                    </div>

                    <div class="campo">
                        <label class="label"> <strong>Nome do fornecedor</strong></label>
                        <select name="fornecedor" class="input">
                            <option value="">Selecione um fornecedor</option>
                            <?php foreach ($fornecedores as $fornecedor) { ?>
                                <option value="<?php echo $fornecedor->getIdFornecedor(); ?>">
                                    <?php echo $fornecedor->getNomeFornecedor(); ?>
                                </option>
                            <?php } ?>
                        </select>

                        <div class="campo">
                            <label class="label"> <strong>Nome do produto</strong></label>
                            <select name="produto" class="input">
                                <option value="">Selecione um produto</option>
                                <?php foreach ($produtos as $produto) { ?>
                                    <option value="<?php echo $produto->getIdProduto(); ?>">
                                        <?php echo $produto->getProduto(); ?>
                                    </option>

                                <?php } ?>
                            </select>


                            <div class="acao">
                                <button type="submit" name="gravar" class="botao">Cadastrar envio</button>
                            </div>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['gravar'])) {
        if (!empty($_POST['dataEnvio']) && !empty($_POST['fornecedor']) && !empty($_POST['produto'])) {
            $envio = new Envio(null, $_POST['fornecedor'], $_POST['produto'], $_POST['dataEnvio'], $_POST['dataEnvio'], $_POST['dataEnvio'],);

            criacaoEnvio($envio);
        } else {
            // echo "Preencha todos os campos";
        }
    }

    ?>
</body>

</html>