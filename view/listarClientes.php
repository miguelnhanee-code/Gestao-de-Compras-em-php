<?php
include_once(__DIR__ . "/../controller/clienteController.php");

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
$perfil = $_SESSION['perfil'];

$clientes = listarCliente();
$caixas = listarCaixas();

if (isset($_POST['remover'])) {
    global $conexao;
    remocao($_POST['id']);
    header('Location: listarClientes.php');
    exit;
}

if (isset($_POST['guardar']) && !empty($_POST['id']) && !empty($_POST['nome_cliente']) && !empty($_POST['apelido_cliente']) && !empty($_POST['idCaixa'])) {
    $cliente = encontra($_POST['id']);
    if ($cliente) {
        $cliente->setNomecliente($_POST['nome_cliente']);
        $cliente->setApelidoCliente($_POST['apelido_cliente']);
        $cliente->setIdCaixa($_POST['idCaixa']);
        edicao($cliente);
    }
    header('Location: listarClientes.php#');
    exit;
}

$pesquisa = $_GET['pesquisa'] ?? '';
$clientes = $pesquisa !== '' ? pesquisarCliente($pesquisa) : listarCliente();

?>



<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>LISTAR CLIENTES</title>
    <link rel='stylesheet' href='ListarProduto.css'>
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
                <a href="../view/cadastarCliente.php" class="aba">CADASTRO DE CLIENTES</a>
                <div class="aba abaAtiva">LISTA DE CLIENTES</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de Clientes</strong></h1>
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
                                <th>Nome do Cliente</th>
                                <th>Apelido do Cliente</th>
                                <th>Nome do Caixa</th>
                                <th>Acao</th>
                            </tr>
                        </thead>

                        <?php if (count($clientes) == 0) { ?>
                            <tr>
                                <td>SEM NENHUM CAIXA REGISTADO</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($clientes as $cliente) { ?>

                                <tr>
                                    <td><?= $cliente->getIdCliente() ?></td>
                                    <td><?= $cliente->getNomeCliente() ?></td>
                                    <td><?= $cliente->getApelidoCliente() ?></td>
                                    <td><?= $cliente->getIdCaixa() ?></td>

                                    <td>
                                        <div class="acoes">
                                            <?php if ($perfil == 'ADMINISTRADOR' || $perfil == 'AUDITOR' || $perfil == 'SUPER OPERADOR') { ?>

                                                <a href="#editar-<?= $cliente->getIdCliente() ?>" class="botaoAtualizar"> Editar </a>
                                                <a href="#remover-<?= $cliente->getIdCliente() ?>" class="botaoRemover"> REMOVER </a>

                                            <?php } ?>

                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $cliente->getIdCliente() ?>">
                                                <!-- <button type="submit" class="botaoRemover" name="remover"> Remover </button> -->

                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </table>

                    <?php foreach ($clientes as $cliente) {   ?>
                        <!-- MODAL EDITAR-->
                        <div class="modalFundo" id="editar-<?= $cliente->getIdCliente() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Editar Cliente</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $cliente->getIdCliente() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome do cliente</strong></label>
                                        </div>
                                        <input type="text" name="nome_cliente" class="input" value=" <?= $cliente->getNomeCliente() ?>">
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Apelido do Cliente</strong></label>
                                        </div>
                                        <input type="text" name="apelido_cliente" class="input" value="<?= $cliente->getApelidoCliente() ?>">
                                    </div>

                                    <div class="campo">
                                        <label class="label"> <strong>Nome do caixa</strong></label>

                                        <select name="idCaixa" class="input">
                                            <option value=""> Selecione um caixa</option>

                                            <?php foreach ($caixas as $caixa) { ?>

                                                <option value="<?php echo $caixa['idCaixa'] ?>">
                                                    <?php echo $caixa['nomeCaixa'] ?>
                                                </option>

                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="acao">
                                        <button type="submit" name="guardar" class="botao">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- fim da modal -->
                    <?php } ?>

                    <?php foreach ($clientes as $cliente) {   ?>
                        <!-- MODAL REMOVER-->
                        <div class="modalFundo" id="remover-<?= $cliente->getIdCliente() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">RENOVER Cliente</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $cliente->getIdCliente() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome do cliente</strong></label>
                                        </div>
                                        <input type="text" name="nome_cliente" class="input" value=" <?= $cliente->getNomeCliente() ?>">
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Apelido do Cliente</strong></label>
                                        </div>
                                        <input type="text" name="apelido_cliente" class="input" value="<?= $cliente->getApelidoCliente() ?>">
                                    </div>

                                    <div class="campo">
                                        <label class="label"> <strong>Nome do caixa</strong></label>

                                        <select name="idCaixa" class="input">
                                            <option value=""> Selecione um caixa</option>

                                            <?php foreach ($caixas as $caixa) { ?>

                                                <option value="<?php echo $caixa['idCaixa'] ?>">
                                                    <?php echo $caixa['nomeCaixa'] ?>
                                                </option>

                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="acao">
                                        <button type="submit" name="remover" class="botao">REMOVER</button>
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