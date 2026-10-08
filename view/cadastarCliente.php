<?php
include_once(__DIR__ . "/../controller/clienteController.php");

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];

$caixas = listarCaixas();


if (isset($_POST['gravar'])) {
    if (!empty($_POST['nomeCliente']) && !empty($_POST['apelidoCliente']) && !empty($_POST['nome_Caixa'])) {
        $cliente = new Cliente(null, $_POST['nomeCliente'], $_POST['apelidoCliente'], $_POST['nome_Caixa']);
        criacao($cliente);
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
            <a href="CadastrarProduto.php"><span class="icone"></span>Produto</a>
            <a href="cadastrarFornecedor.php"><span class="icone"></span>Fornecedor</a>
            <a href="CadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php"><span class="icone"></span>Caixa</a>
            <a class="on" href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
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
        <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <div class="aba abaAtiva">CADASTRO DE CLIENTE</div>
                <a href="../view/listarClientes.php" class="aba">LISTA DE CLIENTES</a>

            </div>
        </div>

        <div class="dalheee">
            <div class="card">
                <form method="post">

                    <div class="topo">
                        <h1 class="titulo"><strong>Novo cliente</strong></h1>
                    </div>

                    <div class="campo">
                        <div class="campoTipo">
                            <label class="label"><strong>Nome do cliente</strong></label>
                        </div>
                        <input type="text" name="nomeCliente" class="input" required>
                    </div>

                    <div class="linha">
                        <div class="campo campoFlex">
                            <div class="campoTipo">
                                <label class="label"><strong>Apelido do cliente</strong></label>
                            </div>
                            <input type="text" name="apelidoCliente" class="input" required>
                        </div>
                        <br>

                        <div class="campo">
                            <label class="label"> <strong>Nome do caixa</strong></label>
                            <select name="nome_Caixa" class="input">
                                <option value=""> Selecione um caixa</option>

                                <?php foreach ($caixas as $caixa) { ?>

                                    <option value="<?php echo $caixa['idCaixa'] ?>">
                                        <?php echo $caixa['nomeCaixa'] ?>
                                    </option>

                                <?php } ?>
                            </select>



                        </div>


                    </div>

                    <div class="acao">
                        <form method="post">
                            <button type="submit" name="gravar" class="botao">Cadastrar cliente</button>
                        </form>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>

</html>