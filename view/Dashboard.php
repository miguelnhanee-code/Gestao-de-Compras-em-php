<?php
// include_once __DIR__ . '/../controller/controllerDashboard.php';

include_once __DIR__ . '/../controller/controllerDashboard.php';

include_once __DIR__ . '/../controller/controllerLogin.php';
if (!$sessao->esta_logado()) {
    header("Location: Login.php");
    exit();
}
$perfil = $_SESSION['perfil'];

$produtos = dashboardProdutos();
$compras  = dashboardCompras();
$caixas   = dashboardCaixas();
$clientes = dashboardClientes();
$fornecedores = dashboardFornecedores();

$totalProdutos   = count($produtos);
$totalFornecedor = count($fornecedores);
$totalCompras    = count($compras);
$totalCaixas     = count($caixas);
$totalClientes   = count($clientes);

$valorPorProduto = dashboardValorPorProduto($compras);
$ultimaCompra    = dashboardUltimaCompra($compras);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INICIO</title>
    <link rel="stylesheet" href="Dashboard.css">
</head>

<body>

    <div class="navbar">
        <div class="marca">
            <img src="logo.png" alt="Logo" class="marca-logo">
            <div class="titulo-marca">SISTEMA DE GESTÃO DE COMPRAS</div>
        </div>

        <nav class="navlinks">
            <a class="on" href="Dashboard.php"> <span class="icone"></span>Inicio</a>
            <a href="CadastrarProduto.php"><span class="icone"></span>Produto</a>
            <a href="cadastrarFornecedor.php"><span class="icone"></span>Fornecedor</a>
            <a href="CadastrarCompra.php"><span class="icone"></span>Compra</a>
            <a href="cadastrarCaixa.php"><span class="icone"></span>Caixa</a>
            <a href="cadastarCliente.php"><span class="icone"></span>Cliente</a>
            <a href="cadastarEnvio.php"><span class="icone"></span>Envio</a>
             <a href="ListarLog.php" ><span class="icone"></span>Log</a>
            <?php if ($perfil == 'ADMINISTRADOR') { ?>

                <a href="cadastarUtilizadores.php">
                    <span class="icone"></span>Utilizadores
                </a>

            <?php } ?>
        </nav>

        <a href="logout.php" class="sair">Log out</a>
    </div>

    <div class="mae">

        <div class="topo">
            <h1>Olá, <?= isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>!</h1>
            <p>Perfil: <?= isset($_SESSION['perfil']) ? $_SESSION['perfil'] : ''; ?></p>

            <a href="CadastrarCompra.php" class="botao">Nova compra</a>
        </div>

        <div class="dashboard">

            <div class="quadrado quadrado1">
                <div class="icone">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2l9 5v10l-9 5-9-5V7z" />
                        <path d="M3 7l9 5 9-5M12 12v10" />
                    </svg>
                </div>
                <p class="legenda">Produtos</p>
                <p class="numero"><?= $totalProdutos ?></p>
            </div>

            <div class="quadrado quadrado2">
                <div class="icone">
                    <svg viewBox="0 0 24 24">
                        <path d="M2 6h12v10H2zM14 9h4l3 3v4h-7" />

                    </svg>
                </div>
                <p class="legenda">Fornecedor</p>
                <p class="numero"><?= $totalFornecedor ?></p>
            </div>

            <div class="quadrado quadrado3">
                <div class="icone">
                    <svg viewBox="0 0 24 24">
                        <path d="M5 8h14l-1 13H6z" />
                        <path d="M9 8V6a3 3 0 0 1 6 0v2" />
                    </svg>
                </div>
                <p class="legenda">Compra</p>
                <p class="numero"><?= $totalCompras ?></p>
            </div>

            <div class="quadrado quadrado4">
                <div class="icone">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v10M9.5 9.5h4a1.5 1.5 0 0 1 0 3h-3a1.5 1.5 0 0 0 0 3h4" />
                    </svg>
                </div>
                <p class="legenda">Caixa</p>
                <p class="numero"><?= $totalCaixas ?></p>
            </div>


        </div>

</body>

</html>