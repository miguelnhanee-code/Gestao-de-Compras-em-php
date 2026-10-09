<?php
// include_once("clienteController.php");
include_once __DIR__ . '/../controller/utilizadorController.php';

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
$perfil = $_SESSION['perfil'];
$utilizadores = listar();


if (isset($_POST['remover'])) {
    remocao((int) $_POST['id']);
    header('Location: listarUtilizadores.php');
    exit;
}

if (isset($_POST['guardar']) && !empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['apelido']) && !empty($_POST['email']) && !empty($_POST['contacto']) && !empty($_POST['username']) && !empty($_POST['perfil'])) {
    $atual = encontraUtilizador((int) $_POST['id']);
    $utilizador = new utilizadores(
        $atual->getIdUtilizador(),
        $_POST['nome'],
        $_POST['apelido'],
        $_POST['email'],
        $_POST['contacto'],
        $_POST['username'],
        $atual->getSenha(),
        $_POST['perfil'],
        $atual->getBi(),
        $atual->getEstadoCivil(),
        $atual->getSexo()
    );
    edicao($utilizador);
    header('Location: listarUtilizadores.php');
    exit;
}


if (isset($_POST['resetar'])) {
    if (!empty($_POST['id'])) {
        resetarSenha((int) $_POST['id']);
    } else {
        echo "Utilizador nao encontrado";
    }
}

$perfis = listarPerfis();
$nomesPerfis = array_column($perfis, 'nomePerfil', 'idPerfil');

$pesquisa = $_GET['pesquisa'] ?? '';
$utilizadores = $pesquisa !== '' ? pesquisarUtilizador($pesquisa) : listar();


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
                <a href="cadastarUtilizadores.php" class="aba">CADASTRO DE UTILIZADORES</a>
                <div class="aba abaAtiva">LISTA DE UTILIZADORES</div>
            </div>
        </div>

        <div class="dalheee">
            <div class="card">

                <div class="topo">
                    <h1 class="titulo"><strong>Lista de Utilizadores</strong></h1>
                </div>

                <form method="get">
                    <div class="linha">
                        <div class="campo campoBusca">
                            <input type="text" name="pesquisa" class="input" placeholder="Pesquisar utilizador" value="<?= $pesquisa ?>">
                        </div>
                        <div class="campo">
                            <button type="submit" class="botao">Listar</button>
                        </div>
                    </div>
                </form>

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
                                <th>Genero</th>
                                <th>Estado Civil</th>
                                <th>Numero de BI</th>
                                <th>Acores</th>
                            </tr>
                        </thead>

                        <?php if (count($utilizadores) == 0) { ?>
                            <tr>
                                <td>SEM NENHUM UTILIZADOR REGISTADO</td>
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
                                    <td><?= $nomesPerfis[$utilizador->getPerfil()] ?? $utilizador->getPerfil() ?></td>
                                    <td><?= $utilizador->getSexo() ?></td>
                                    <td><?= $utilizador->getEstadoCivil() ?></td>
                                    <td><?= $utilizador->getBi() ?></td>
                                    <td>
                                        <div class="acoes">

                                            <a href="#editar-<?= $utilizador->getIdUtilizador() ?>" class="botaoAtualizar"> Editar </a>
                                            <a href="#removerModal-<?= $utilizador->getIdUtilizador() ?>" class="botaoRemover"> Remover </a>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $utilizador->getIdUtilizador() ?>">
                                                <button type="submit" class="botaoRemover" name="resetar"> Resetar Senha </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </table>

                    <?php for ($i = 0; $i < count($utilizadores); $i++) {   ?>
                        <!-- MODAL EDITAR -->
                        <div class="modalFundo" id="editar-<?= $utilizadores[$i]->getIdUtilizador() ?>">
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Editar utilizador</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $utilizadores[$i]->getIdUtilizador() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Nome</strong></label>
                                        </div>
                                        <input type="text" name="nome" class="input" value="<?= $utilizadores[$i]->getNome() ?>" required readonly>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Apelido</strong></label>
                                        </div>
                                        <input type="text" name="apelido" class="input" value="<?= $utilizadores[$i]->getApelido() ?>" required readonly>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Email</strong></label>
                                        </div>
                                        <input type="email" name="email" class="input" value="<?= $utilizadores[$i]->getEmail() ?>" required readonly>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Contacto</strong></label>
                                        </div>
                                        <input type="text" name="contacto" class="input" value="<?= $utilizadores[$i]->getContacto() ?>" required>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Username</strong></label>
                                        </div>
                                        <input type="text" name="username" class="input" value="<?= $utilizadores[$i]->getUsername() ?>" required readonly>
                                    </div>

                                    <div class="campo">
                                        <label class="label"><strong>Perfil</strong></label>
                                        <select name="perfil" class="input" required>
                                            <?php foreach ($perfis as $p) { ?>
                                                <option value="<?= $p['idPerfil'] ?>" <?= ($utilizadores[$i]->getPerfil() == $p['idPerfil'] || $utilizadores[$i]->getPerfil() == $p['nomePerfil']) ? 'selected' : '' ?>>
                                                    <?= $p['nomePerfil'] ?>
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

                    <?php for ($i = 0; $i < count($utilizadores); $i++) {   ?>
                        <!-- MODAL REMOVER -->
                        <div class="modalFundo" id="removerModal-<?= $utilizadores[$i]->getIdUtilizador() ?>">
                            <div class="modalCaixa">
                                <div class="modalTopo">
                                    <h2 class="titulo">Remover utilizador</h2>
                                    <a href="#" class="modalFechar">x</a>
                                </div>

                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $utilizadores[$i]->getIdUtilizador() ?>">

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Email</strong></label>
                                        </div>
                                        <input type="text" class="input" value="<?= $utilizadores[$i]->getEmail() ?>" readonly>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Apelido do Utilizador</strong></label>
                                        </div>
                                        <input type="text" class="input" value="<?= $utilizadores[$i]->getApelido() ?>" readonly>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Contacto</strong></label>
                                        </div>
                                        <input type="text" class="input" value="<?= $utilizadores[$i]->getContacto() ?>" readonly>
                                    </div>

                                    <div class="campo">
                                        <div class="campoTipo">
                                            <label class="label"><strong>Username</strong></label>
                                        </div>
                                        <input type="text" class="input" value="<?= $utilizadores[$i]->getUsername() ?>" readonly>
                                    </div>

                                    <div class="campo">
                                        <label class="label"> <strong>Perfil</strong></label>
                                        <input type="text" class="input" value="<?= $nomesPerfis[$utilizadores[$i]->getPerfil()] ?? $utilizadores[$i]->getPerfil() ?>" readonly>
                                    </div>

                                    <div class="acao">
                                        <button type="submit" name="remover" class="botao">Remover</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- fim da modal remover -->
                    <?php } ?>


                </div>

            </div>
        </div>

    </div>

</body>

</html>