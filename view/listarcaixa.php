<?php

include_once(__DIR__ . "/../controller/caixaController.php");
include_once __DIR__ . '/../controller/controllerLogin.php';

if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$perfil = $_SESSION['perfil'];

if (isset($_POST['remover'])) {
    global $conexao;
    remocao($_POST['id']);
    header('Location: listarcaixa.php');
    exit;
}

if (isset($_POST['guardar']) && !empty($_POST['id']) && !empty($_POST['atualizarCaixa'])) {
    $caixa = encontra($_POST['id']);
    if ($caixa) {
        $caixa->setNomeCaixa($_POST['atualizarCaixa']);
        edicao($caixa);
    }
    header('Location: listarcaixa.php#');
    exit;
}

$caixas = listarCaixa();

$pesquisa = $_GET['pesquisa'] ?? '';
$caixas = $pesquisa !== '' ? pesquisarCaixa($pesquisa) : listarCaixa();
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
            <a href="cadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php" class="on"><span class="icone"></span>Caixa</a>
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
                <a href="cadastrarCaixa.php" class="aba">CADASTRO DE CAIXAS</a>
                <div class="aba abaAtiva">LISTA DE CAIXAS</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de caixas</strong></h1>
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
                                <th>Nome do caixa</th>
                                <th>Acoes</th>
                            </tr>
                        </thead>

                        <?php if (count($caixas) == 0) { ?>
                            <tr>
                                <td>SEM NENHUM CAIXA REGISTADO</td>
                            </tr>
                        <?php } else { ?>

                            <?php foreach ($caixas as $caixa) {  ?>
                                <tr>
                                    <td><?= $caixa->getIdCaixa() ?></td>
                                    <td><?= $caixa->getNomeCaixa() ?></td>

                                    <td class="acoes">

                                        <?php if ($perfil == 'ADMINISTRADOR' || $perfil == 'AUDITOR' || $perfil == 'SUPER OPERADOR') { ?>

                                            <a href="#editar-<?= $caixa->getIdCaixa() ?>" class="botaoAtualizar"> Editar </a>
                                            <a href="#remover-<?= $caixa->getIdCaixa() ?>" class="botaoRemover"> REMOVER </a>
                                        <?php } ?>

                                        <form method="post">
                                            <input type="hidden" name="id" value="<?= $caixa->getIdCaixa() ?>">
                                            <!-- <button type="submit" name="remover">Remover</button> -->
                                        </form>

                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </table>

                    <?php for ($i = 0; $i < count($caixas); $i++) { ?>
                        <!-- MODAL EDITAR-->
                        <div class="modalFundo" id="editar-<?= $caixas[$i]->getIdCaixa() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Editar caixa</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>
                                <div class="campo">
                                    <div class="campoTipo">
                                        <label class="label"><strong>Nome do Caixa</strong></label>
                                    </div>
                                    <form method="post">
                                        <input type="text" name="atualizarCaixa" class="input" value="<?= $caixas[$i]->getNomeCaixa() ?>">
                                        <input type="hidden" name="id" value="<?= $caixas[$i]->getIdCaixa() ?>">
                                        <div class="acao">
                                            <button name="guardar" type="submit" class="botao">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- fim da class modal -->
                    <?php } ?>


                    <?php for ($i = 0; $i < count($caixas); $i++) { ?>
                        <!-- MODAL REMOVER-->
                        <div class="modalFundo" id="remover-<?= $caixas[$i]->getIdCaixa() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">REMOVER caixa</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>
                                <div class="campo">
                                    <div class="campoTipo">
                                        <label class="label"><strong>Nome do Caixa</strong></label>
                                    </div>
                                    <form method="post">
                                        <input type="text" name="atualizarCaixa" class="input" value="<?= $caixas[$i]->getNomeCaixa() ?>">
                                        <input type="hidden" name="id" value="<?= $caixas[$i]->getIdCaixa() ?>">
                                        <div class="acao">
                                            <button name="remover" type="submit" class="botao">REMOVER</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- fim da class modal -->
                    <?php } ?>



                </div>

            </div>
        </div>

    </div>

    </div>

    </div>




</body>

</html>