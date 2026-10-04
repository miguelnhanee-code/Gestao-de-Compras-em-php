<?php

include_once(__DIR__ . "/../controller/utilizadorController.php");
include_once __DIR__ . '/../controller/controllerLogin.php';

if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];

$utilizadores = listar();

if (isset($_POST['cadastrar'])) {

    if (
        !empty($_POST['nome']) && !empty($_POST['apelido']) && !empty($_POST['email']) && !empty($_POST['contacto']) && !empty($_POST['username']) && !empty($_POST['senha']) && !empty($_POST['perfil'])
    ) {
        $utilizador = new utilizadores(null, $_POST['nome'], $_POST['apelido'], $_POST['email'], $_POST['contacto'], $_POST['username'], $_POST['senha'],  $_POST['perfil']);
        criacao($utilizador);
    } else {
        echo "Preencha todos os campos";
    }
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>CADASTRAR UTILIZADORES</title>
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
            <a href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
            <a href="cadastarEnvio.php"><span class="icone"></span>Envio</a>

            <?php if ($perfil == 'ADMINISTRADOR') { ?>

                <a class="on" href="cadastarUtilizadores.php">
                    <span class="icone"></span>Utilizadores
                </a>

            <?php } ?>

        </nav>
        <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <div class="aba abaAtiva">CADASTRO DE UTILIZADORES</div>
                <a href="listarUtilizadores.php" class="aba">LISTA DE UTILIZADORES</a>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">
                <form method="post">

                    <div class="topo">
                        <h1 class="titulo"><strong>Novo utilizador</strong></h1>
                    </div>

                    <div class="campo">
                        <div class="campoTipo">
                            <label class="label"><strong>Nome do utilizador</strong></label>
                        </div>
                        <input type="text" name="nome" class="input">
                    </div>

                    <div class="campo">
                        <div class="campoTipo">
                            <label class="label"><strong>Apelido do utilizador</strong></label>
                        </div>
                        <input type="text" name="apelido" class="input">
                    </div>

                    <div class="campo">
                        <div class="campo">
                            <div class="campoTipo">
                                <label class="label"><strong>Username</strong></label>
                            </div>
                            <input type="text" name="username" class="input">
                        </div>

                        <div class="campo">
                            <div class="campo ">
                                <div class="campoTipo">
                                    <label class="label"><strong>Email</strong></label>
                                </div>
                                <input type="email" name="email" class="input">
                            </div>

                            <div class="campo">
                                <div class="campo ">
                                    <div class="campoTipo">
                                        <label class="label"><strong>Contacto</strong></label>
                                    </div>
                                    <input type="number" name="contacto" class="input">
                                </div>

                                <div class="campo">
                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Senha</strong></label>
                                        </div>
                                        <input type="text" name="senha" class="input" value="12345678" readonly>
                                    </div>

                                    <div class="campo">
                                        <label class="label"> <strong>Perfil do utilizador</strong></label>
                                        <select name="perfil" class="input">
                                            <option value="">Selecione um perfil</option>
                                            <option value="ADMINISTRADOR">Administrador</option>
                                            <option value="AUDITOR">Auditor</option>
                                            <option value="OPERADOR">Operador</option>
                                            <option value="SUPER OPERADOR">Super Operador</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="acao">

                                    <button type="submit" name="cadastrar" class="botao">Cadastrar utilizador</button>

                                </div>

                </form>
            </div>
        </div>

    </div>

</body>

</html>