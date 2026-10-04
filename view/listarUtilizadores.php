<?php
// include_once("clienteController.php");
include_once __DIR__ . '/../controller/utilizadorController.php';

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];
$utilizadores = listar();



if (isset($_GET['id'])) {
    resetarSenha((int) $_GET['id']);
}

if (isset($_POST['remover'])) {
    global $conexao;
    remocao($_POST['id']);
    header('Location: listarUtilizadores.php');
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
    header('Location: listarClientes.php');
    exit;
}


if (isset($_POST['resetarSenha'])) {
    if (!empty($_POST['id'])) {
        resetarSenha($_POST['id']);
    } else {
        echo "Utilizador não encontrado";
    }
}


?>



<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>LISTAR UTILIZADORES</title>
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
                <a href="cadastarUtilizadores.php" class="aba">CADASTRO DE UTILIZADORES</a>
                <div class="aba abaAtiva">LISTA DE UTILIZADORES</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de Utilizadores</strong></h1>
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
                                <th>Nome </th>
                                <th>Apelido </th>
                                <th>contacto</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Perfil</th>
                                <th>Acores</th>
                            </tr>
                        </thead>

                        <?php if (count($utilizadores) == 0) { ?>
                            <tr>
                                <td>SEM NENHUM CAIXA REGISTADO</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($utilizadores as $utilizador) { ?>

                                <tr>
                                    <td><?= $utilizador->getIdUtilizador() ?></td>
                                    <td><?= $utilizador->getNome() ?></td>
                                    <td><?= $utilizador->getApelido() ?></td>
                                    <td><?= $utilizador->getContacto() ?></td>
                                    <td><?= $utilizador->getEmail() ?></td>
                                    <td><?= $utilizador->getUsername() ?></td>
                                    <td><?= $utilizador->getPerfil() ?></td>


                                    <td>
                                        <div class="acoes">

                                            <a href="#editar-<?= $utilizador->getIdUtilizador() ?>" class="botaoAtualizar"> Editar </a>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $utilizador->getIdUtilizador() ?>">
                                                <button type="submit" class="botaoRemover" name="remover"> Remover </button>
                                                <button type="submit" class="botaoRemover" name="resetar"> Resetar Senha </button>


                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </table>

                    <?php for ($i = 0; $i < count($utilizadores); $i++) {   ?>
                        <!-- MODAL-->
                        <div class="modalFundo" id="editar-<?= $utilizadores[$i]->getIdUtilizador() ?>">
                            <a href="#" class="modalOverlay" aria-label="Fechar"></a>
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Editar utilizador</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $utilizadores[$i]->getNome() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome do email</strong></label>
                                        </div>
                                        <input type="text" name="nome_cliente" class="input" value=" <?= $utilizadores[$i]->getEmail() ?>">
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Apelido do Utilizador</strong></label>
                                        </div>
                                        <input type="text" name="nome_cliente" class="input" value=" <?= $utilizadores[$i]->getApelido() ?>">
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Contacto</strong></label>
                                        </div>
                                        <input type="text" name="apelido_cliente" class="input" value="<?= $utilizadores[$i]->getContacto() ?>">
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Username</strong></label>
                                        </div>
                                        <input type="text" name="apelido_cliente" class="input" value="<?= $utilizadores[$i]->getUsername() ?>">
                                    </div>

                                    <div class="campo">
                                        <label class="label"> <strong>Nome do caixa</strong></label>

                                        <select name="perfil" class="input">
                                            <option value="">Selecione um perfil</option>
                                            <option value="ADMINISTRADOR">Administrador</option>
                                            <option value="AUDITOR">Auditor</option>
                                            <option value="OPERADOR">Operador</option>
                                            <option value="SUPER OPERADOR">Super Operador</option>
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


                </div>

            </div>
        </div>

    </div>

</body>

</html>