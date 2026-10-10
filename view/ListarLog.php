<?php
include_once(__DIR__ . "/../controller/controllerLog.php");
include_once(__DIR__ . "/../controller/controllerLogin.php");

if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$perfil = $_SESSION['perfil'];
if (isset($_POST['remover'])) {
    remocao($_POST['remover']);
}

$logs = listaDeLogs();
$pesquisa = $_POST['pesquisaCampo'] ?? '';
if (isset($_POST['pesquisarBt'])) {
    if (!empty($pesquisa)) {
        $logs = pesquisarLog($pesquisa);
    }
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>LISTAR LOGS</title>
    <link rel='stylesheet' href='Log.css'>
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
                <a href="cadastarUtilizadores.php">
                    <span class="icone"></span>Utilizadores
                </a>
            <?php } ?>
            <a href="ListarLog.php" class="on"><span class="icone"></span>Log</a>
        </nav>
        <div style="margin: 15px;">
            <p>Olá, <?= isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>!</p>
            <p>Perfil: <?= isset($_SESSION['perfil']) ? $_SESSION['perfil'] : ''; ?></p>
        </div>
        <a href="alterarSenha.php" class="sair">Alterar Senha</a>
        <a href="logout.php" class="sair"><span class="icone"></span>Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <div class="aba abaAtiva">LISTA DE LOGS</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de Logs</strong></h1>
                </div>

                <form method="post">
                    <div class="linha">
                        <div class="campo campoBusca">
                            <input type="text" name="pesquisaCampo" class="input" placeholder="Pesquisar ">
                        </div>
                        <div class="campo">
                            <button type="submit" name="pesquisarBt" class="botao">Pesquisar</button>
                        </div>
                    </div>
                </form>

                <div class="tabela">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Nome</th>
                                <th>Perfil</th>
                                <th>Acao</th>
                                <th>Data da Acao</th>
                            </tr>
                        </thead>
                        <?php if (count($logs) == 0) { ?>
                            <tr>
                                <td>SEM NENHUM LOG REGISTADO</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($logs as $log) { ?>
                                <tr>
                                    <td><?= $log->getIdLog() ?></td>
                                    <td><?= $log->getEmail() ?></td>
                                    <td><?= $log->getNome() ?></td>
                                    <td><?= $log->getPerfil() ?></td>
                                    <td><?= $log->getAccao() ?></td>
                                    <td><?= $log->getDataAccao() ?></td>
                                </tr>
                        <?php }
                        } ?>

                    </table>
                </div>

            </div>
        </div>

    </div>

</body>

</html>