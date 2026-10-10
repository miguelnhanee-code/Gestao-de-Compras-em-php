<?php
include_once __DIR__ . '/../controller/controllerProduto.php';
include_once __DIR__ . '/../controller/controllerFornecedor.php';
include_once __DIR__ . '/../model/Produto.php';

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
$perfil = $_SESSION['perfil'];

$produtos = listarProduto();
$fornecedores = listarFornecedor();

if (isset($_POST['remover'])) {
    global $conexao;
    remocaoProduto($_POST['id']);
    header('Location: ListarProduto.php');
}

if (
    isset($_POST['guardar']) && !empty($_POST['id']) && !empty($_POST['produto']) && !empty($_POST['precoUnitario'])
    && !empty($_POST['dataConfeccao']) && !empty($_POST['dataValidade'])
) {
    $produto = encontraProduto($_POST['id']);

    if ($produto) {
        $produto->setProduto($_POST['produto']);
        $produto->setPrecoUnitario($_POST['precoUnitario']);
        $produto->setDataConfecao($_POST['dataConfeccao']);
        $produto->setDataValidade($_POST['dataValidade']);
        $produto->setStock($_POST['stock']);
        $produto->setUnidadeMedida($_POST['unidadeMedida']);
        $produto->setIdFornecedor($_POST['idFornecedor']);
        edicaoProduto($produto);
    }
    header('Location: ListarProduto.php#');
}
$produtos = listarProduto();
$pesquisa = $_POST['pesquisaCampo'] ?? '';
if (isset($_POST['pesquisarBt'])) {
    if (!empty($pesquisa)) {
        $produtos = pesquisarProduto($pesquisa);
    }
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>LISTAR PRODUTO</title>
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
            <a class="on" href="CadastrarProduto.php"><span class="icone"></span>Produto</a>
            <a href="cadastrarFornecedor.php"><span class="icone"></span>Fornecedor</a>
            <a href="CadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php"><span class="icone"></span>Caixa</a>
            <a href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
            <a href="cadastarEnvio.php"><span class="icone"></span>Envio</a>
            <?php if ($perfil == 'ADMINISTRADOR') { ?>
                <a href="cadastarUtilizadores.php"><span class="icone"></span>Utilizadores </a>
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
                <a href="CadastrarProduto.php" class="aba">CADASTRO DE PRODUTO</a>
                <div class="aba abaAtiva">LISTA DE PRODUTO</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de Produtos</strong></h1>
                </div>
                <form method="post">
                    <div class="linha">
                        <div class="campo campoBusca">
                            <input type="text" name="pesquisaCampo" class="input" placeholder="Pesquisar " value="<?= $pesquisa ?>">
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
                                <th>Nome do Produto</th>
                                <th>Stock</th>
                                <th>unidade Medida</th>
                                <th>Data Confeccao</th>
                                <th>Data Validade</th>
                                <th>Preco unitario</th>
                                <th>Fornecedor</th>
                                <th>Acao</th>
                            </tr>
                        </thead>

                        <?php if (count($produtos) == 0) { ?>
                            <tr>
                                <td>SEM NENHUM PRODUTO REGISTADO</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($produtos as $produto) { ?>

                                <tr>
                                    <td><?= $produto->getIdproduto() ?></td>
                                    <td><?= $produto->getProduto() ?></td>
                                    <td><?= $produto->getStock() ?></td>
                                    <td><?= $produto->getUnidadeMedida() ?></td>
                                    <td><?= $produto->getDataConfecao() ?></td>
                                    <td><?= $produto->getDataValidade() ?></td>
                                    <td><?= $produto->getPrecoUnitario() ?></td>
                                    <td><?= $produto->getIdFornecedor() ?></td>

                                    <td>
                                        <div class="acoes">
                                            <?php if ($perfil == 'ADMINISTRADOR' || $perfil == 'AUDITOR' || $perfil == 'SUPER OPERADOR') { ?>

                                                <a href="#editar-<?= $produto->getIdproduto() ?>" class="botaoAtualizar"> Editar </a>
                                                <a href="#remover-<?= $produto->getIdproduto() ?>" class="botaoRemover"> Remover </a>


                                            <?php } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $produto->getIdproduto() ?>">
                                                <!-- <button type="submit" class="botaoRemover" name="remover"> Remover </button> -->
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </table>

                    <?php foreach ($produtos as $produto) { ?>
                        <!-- MODAL-->
                        <div class="modalFundo" id="editar-<?= $produto->getIdproduto() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Editar Produto</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $produto->getIdproduto() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome do produto</strong></label>
                                        </div>
                                        <input type="text" name="produto" class="input" value="<?= $produto->getProduto() ?>">
                                    </div>

                                    <div class="linha">
                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Unidade de Medida</strong></label>
                                            </div>
                                            <input type="text" name="unidadeMedida" class="input" value="<?= $produto->getUnidadeMedida() ?>" required>
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Stock</strong></label>
                                            </div>
                                            <input type="number" step="any" name="stock" class="input" value="<?= $produto->getStock() ?>" required>
                                        </div>
                                    </div>

                                    <div class="linha">
                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Data Confeccao</strong></label>
                                            </div>
                                            <input type="date" name="dataConfeccao" class="input" value="<?= $produto->getDataConfecao() ?>">
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Data Validade</strong></label>
                                            </div>
                                            <input type="date" name="dataValidade" class="input" value="<?= $produto->getDataValidade() ?>">
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Preco unitario</strong></label>
                                            </div>
                                            <input type="text" name="precoUnitario" class="input" value="<?= $produto->getPrecoUnitario() ?>">
                                        </div>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Fornecedor</strong></label>
                                        </div>
                                        <select name="idFornecedor" class="input">
                                            <option value="">Seleccione o fornecedor</option>
                                            <?php foreach ($fornecedores as $fornecedor) { ?>
                                                <option value="<?= $fornecedor->getIdFornecedor() ?>"
                                                    <?= $fornecedor->getNomeFornecedor() == $produto->getIdFornecedor() ? 'selected' : '' ?>>
                                                    <?= $fornecedor->getNomeFornecedor() ?>
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

                    <?php foreach ($produtos as $produto) { ?>
                        <!-- MODAL remover-->
                        <div class="modalFundo" id="remover-<?= $produto->getIdproduto() ?>">
                            <!-- <a href="#" class="modalOverlay" aria-label="Fechar"></a> -->
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Remover Produto</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $produto->getIdproduto() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome do produto</strong></label>
                                        </div>
                                        <input type="text" name="produto" class="input" value="<?= $produto->getProduto() ?>">
                                    </div>

                                    <div class="linha">
                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Unidade de Medida</strong></label>
                                            </div>
                                            <input type="text" name="unidadeMedida" class="input" value="<?= $produto->getUnidadeMedida() ?>" required>
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Stock</strong></label>
                                            </div>
                                            <input type="number" step="any" name="stock" class="input" value="<?= $produto->getStock() ?>" required>
                                        </div>
                                    </div>

                                    <div class="linha">
                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Data Confeccao</strong></label>
                                            </div>
                                            <input type="date" name="dataConfeccao" class="input" value="<?= $produto->getDataConfecao() ?>">
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Data Validade</strong></label>
                                            </div>
                                            <input type="date" name="dataValidade" class="input" value="<?= $produto->getDataValidade() ?>">
                                        </div>

                                        <div class="campo campoFlex">
                                            <div class="campoTipo">
                                                <label class="label"><strong>Preco unitario</strong></label>
                                            </div>
                                            <input type="text" name="precoUnitario" class="input" value="<?= $produto->getPrecoUnitario() ?>">
                                        </div>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Fornecedor</strong></label>
                                        </div>
                                        <select name="idFornecedor" class="input">
                                            <option value="">Seleccione o fornecedor</option>
                                            <?php foreach ($fornecedores as $fornecedor) { ?>
                                                <option value="<?= $fornecedor->getIdFornecedor() ?>"
                                                    <?= $fornecedor->getNomeFornecedor() == $produto->getIdFornecedor() ? 'selected' : '' ?>>
                                                    <?= $fornecedor->getNomeFornecedor() ?>
                                                </option>
                                            <?php } ?>
                                        </select>
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