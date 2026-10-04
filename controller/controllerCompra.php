<?php
include_once __DIR__ . '/../model/Compra.php';
include_once __DIR__ . '/../model/Produto.php';
include_once __DIR__ . '/../controller/controllerProduto.php';


$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");


function cadastrarCompra($compra)
{
    global $conexao;
    $sql = "insert into compra values(null, {$compra->getIdproduto()}, {$compra->getIdcliente()},
    {$compra->getQuantidade()}, '{$compra->getDataCompra()}')";

    //com stock sql

    $result = mysqli_query($conexao, $sql);
    if ($result) {
        header('location:../view/ListarCompra.php');
    } else {
        echo "Ocorreu um erro ao gravar os dados";
    }
}

function listarCompra()
{
    global $conexao;
    $compras = array();
    $sql = "select compra.*, produto.produto as nomeProduto, produto.precoUnitario as precoProduto,cliente.nomeCliente as nomeCliente from compra
    join produto on compra.idProduto = produto.idProduto
    left join cliente on compra.idCliente = cliente.idCliente";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $compra = new Compra($rs['idCompra'], $rs['quantidade'], $rs['dataDaCompra'], $rs['idProduto'], $rs['idCliente']);
            $compras[] = array(
                'compra' => $compra,
                'nomeProduto' => $rs['nomeProduto'],
                'precoProduto' => $rs['precoProduto'],
                'nomeCliente' => $rs['nomeCliente']
            );
        }
    }
    return $compras;
}

function removerCompra($id)
{
    global $conexao;
    $sql = "delete from compra where idCompra=" . $id;
    $result = mysqli_query($conexao, $sql);
    header('location:../view/ListarCompra.php');
}

function actualizarCompra($compra)
{
    global $conexao;
    $sql = "update compra set idProduto={$compra->getIdproduto()}, idCliente={$compra->getIdcliente()}, 
    quantidade={$compra->getQuantidade()}, dataDaCompra='{$compra->getDataCompra()}' where idCompra={$compra->getIdcompra()}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        header('location:../view/ListarCompra.php');
        exit;
    } else {
        echo "Ocorreu um erro ao atualizar os dados";
    }
}

function encontraCompra($id)
{
    global $conexao;
    $sql = "select * from compra where idCompra=" . $id;
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);
    if (!$rs) {
        return null;
    }
    return new Compra($id, $rs['quantidade'], $rs['dataDaCompra'], $rs['idProduto'], $rs['idCliente']);
}
