<?php
include_once __DIR__ . '/../controller/controllerFornecedor.php';

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}

$perfil = $_SESSION['perfil'];
if (isset($_GET['remover'])) {
    remocao($_GET['remover']);
}

if (isset($_POST['removerFornecedor'])) {
    global $conexao;
    remocao($_POST['id']);
    header('Location: ListarProduto.php');
}



if (isset($_POST['gravar']) && !empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['contacto']) &&  !empty($_POST['endereco']) &&  !empty($_POST['email'])) {
    $fornecedor = encontraFornecedor($_POST['id']);
    if ($fornecedor) {
        $fornecedor->setNomeFornecedor($_POST['nome']);
        $fornecedor->setTelefone($_POST['contacto']);
        $fornecedor->setEndereco($_POST['endereco']);
        $fornecedor->setEmail($_POST['email']);
        edicao($fornecedor);
    }
    header('Location: listarFornecedores.php');
    exit;
}

$fornecedores = listarFornecedor();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>LISTAR FORNECEDORES</title>
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

            <?php if ($perfil == 'AUDITOR') { ?>
                <a href="ListarLog.php"><span class="icone"></span>Envio</a>
            <?php } ?>


        </nav>

        <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="cabecalho">
            <div class="abas">
                <a href="cadastrarFornecedor.php" class="aba">CADASTRO DE FORNECEDOR</a>
                <div class="aba abaAtiva">LISTA DE FORNECEDORES</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de fornecedores</strong></h1>
                </div>

                <div class="linha">
                    <div class="campo campoBusca">
                        <input type="text" name="pesquisa" class="input" placeholder="Pesquisar compra">
                    </div>
                    <div class="campo">
                        <button type="button" class="botao">Listar</button>
                    </div>
                </div>

                <div class="tabela">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome do Fornecedor</th>
                                <th>Contacto</th>
                                <th>Endereco</th>
                                <th>Email</th>
                                <th>Acao</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($fornecedores) == 0) { ?>
                                <tr>
                                    <td colspan="6">Nenhum fornecedor cadastrado</td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($fornecedores as $fornecedor) { ?>
                                    <tr>
                                        <td><?= $fornecedor->getIdFornecedor() ?></td>
                                        <td><?= $fornecedor->getNomeFornecedor() ?></td>
                                        <td><?= $fornecedor->getTelefone() ?></td>
                                        <td><?= $fornecedor->getEndereco() ?></td>
                                        <td><?= $fornecedor->getEmail() ?></td>
                                        <td>
                                            <div class="acoes">
                                                <?php if ($perfil == 'ADMINISTRADOR' || $perfil == 'AUDITOR' || $perfil == 'SUEPER OPERADOR') { ?>
                                                    <a href="#editar-<?= $fornecedor->getIdFornecedor() ?>" class="botaoAtualizar">Editar</a>
                                                    <a href="#remover-<?= $fornecedor->getIdFornecedor() ?>" class="botaoRemover">remover</a>

                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>


                        </tbody>
                    </table>
                </div>


                <?php foreach ($fornecedores as $fornecedor) { ?>
                    <!-- modal editar -->
                    <div class="modalFundo" id="editar-<?= $fornecedor->getIdFornecedor() ?>">
                        <a href="#" class="modalOverlay" aria-label="Fechar"></a>
                        <div class="modalCaixa">
                            <div class="modalTopo">
                                <h2 class="titulo">Editar fornecedor</h2>
                                <a href="#" class="modalFechar">x</a>
                            </div>

                            <form method="post">
                                <input type="hidden" name="id" value="<?= $fornecedor->getIdFornecedor() ?>">

                                <div class="campo">
                                    <div class="campoTipo">
                                        <label class="label"><strong>Nome do fornecedor</strong></label>
                                    </div>
                                    <input type="text" name="nome" class="input" value="<?= $fornecedor->getNomeFornecedor() ?>">
                                </div>

                                <div class="linha">
                                    <div class="campo campoFlex">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Contacto</strong></label>
                                        </div>
                                        <input type="number" name="contacto" class="input" value="<?= $fornecedor->getTelefone() ?>">
                                    </div>

                                    <div class="campo campoFlex">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Endereco</strong></label>
                                        </div>
                                        <input type="text" name="endereco" class="input" value="<?= $fornecedor->getEndereco() ?>">
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Email</strong></label>
                                        </div>
                                        <input type="email" name="email" class="input" value="<?= $fornecedor->getEmail() ?>">
                                    </div>
                                </div>

                                <div class="acao">
                                    <button type="submit" name="gravar" class="botao">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- fim modal -->
                <?php } ?>


                <?php foreach ($fornecedores as $fornecedor) { ?>
                    <!-- modal editar -->
                    <div class="modalFundo" id="remover-<?= $fornecedor->getIdFornecedor() ?>">
                        <a href="#" class="modalOverlay" aria-label="Fechar"></a>
                        <div class="modalCaixa">
                            <div class="modalTopo">
                                <h2 class="titulo">Remover fornecedor</h2>
                                <a href="#" class="modalFechar">x</a>
                            </div>

                            <form method="post">
                                <input type="hidden" name="id" value="<?= $fornecedor->getIdFornecedor() ?>">

                                <div class="campo">
                                    <div class="campoTipo">
                                        <label class="label"><strong>Nome do fornecedor</strong></label>
                                    </div>
                                    <input type="text" name="nome" class="input" value="<?= $fornecedor->getNomeFornecedor() ?>">
                                </div>

                                <div class="linha">
                                    <div class="campo campoFlex">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Contacto</strong></label>
                                        </div>
                                        <input type="number" name="contacto" class="input" value="<?= $fornecedor->getTelefone() ?>">
                                    </div>

                                    <div class="campo campoFlex">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Endereco</strong></label>
                                        </div>
                                        <input type="text" name="endereco" class="input" value="<?= $fornecedor->getEndereco() ?>">
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Email</strong></label>
                                        </div>
                                        <input type="email" name="email" class="input" value="<?= $fornecedor->getEmail() ?>">
                                    </div>
                                </div>

                                <div class="acao">
                                    <button type="submit" name="removerFornecedor" class="botao">Remover</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- fim modal -->
                <?php } ?>

            </div>
        </div>

    </div>

</body>

</html>