<?php

include_once(__DIR__ . "/../model/Produto.php");
include_once(__DIR__ . "/../model/Compra.php");
include_once(__DIR__ . "/../model/caixaModel.php");
include_once(__DIR__ . "/../model/clienteModel.php");
include_once(__DIR__ . "/../controller/clienteController.php");
include_once(__DIR__ . "/../controller/clienteController.php");

$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");

function dashboardProdutos()
{
    global $conexao;
    $produtos = array();
    $sql = "select * from produto";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $produto = new Produto($rs['idProduto'], $rs['produto'], $rs['precoUnitario'], $rs['dataConfecao'], $rs['dataValidade']);
            array_push($produtos, $produto);
        }
    }
    return $produtos;
}

function dashboardCompras()
{
    global $conexao;
    $compras = array();
    $sql = "select compra.*, produto.produto as nomeProduto, produto.precoUnitario as precoProduto, cliente.nomeCliente as nomeCliente
    from compra join produto on compra.idProduto = produto.idProduto left join cliente on compra.idCliente = cliente.idCliente
    order by compra.idCompra";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $compra = new Compra($rs['idCompra'], $rs['quantidade'], $rs['dataDaCompra'], $rs['idProduto'], $rs['idCliente']);
            array_push($compras, array('compra' => $compra, 'nomeProduto' => $rs['nomeProduto'], 'precoProduto' => $rs['precoProduto'], 'nomeCliente' => $rs['nomeCliente']));
        }
    }
    return $compras;
}

function dashboardCaixas()
{
    global $conexao;
    $caixas = array();
    $sql = "select * from caixa";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $caixa = new Caixa($rs['idCaixa'], $rs['nomeCaixa']);
            array_push($caixas, $caixa);
        }
    }
    return $caixas;
}

function dashboardClientes()
{
    global $conexao;
    $clientes = array();
    $sql = "select * from cliente";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente($rs['idCliente'], $rs['nomeCliente'], $rs['apelidoCliente'], $rs['idCaixa']);
            array_push($clientes, $cliente);
        }
    }
    return $clientes;
}

// soma quantidade vezepreco de cada produto usa lista de compras
function dashboardValorPorProduto($compras)
{
    $valorProduto = array();
    foreach ($compras as $compra) {
        $nome = $compra['nomeProduto'];
        $total = $compra['compra']->getQuantidade() * $compra['precoProduto'];
        if (isset($valorProduto[$nome])) {
            $valorProduto[$nome] = $valorProduto[$nome] + $total;
        } else {
            $valorProduto[$nome] = $total;
        }
    }
    return $valorProduto;
}

function dashboardFornecedores()
{
    global $conexao;
    $fornecedores = array();
    $sql = "SELECT * FROM fornecedor";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $fornecedores[] = $rs;
        }
    }
    return $fornecedores;
}

function dashboardUltimaCompra($compras)
{
    if (count($compras) == 0) {
        return null;
    }
    return end($compras);
}
