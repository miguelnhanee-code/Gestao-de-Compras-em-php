<?php

include_once(__DIR__ . "/../model/Compra.php");
include_once(__DIR__ . "/controllerLog.php");
$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");


function listarCompra()
{
    global $conexao;
    $compras = array();
    $sql = "select compra.*, produto.produto as nomeProduto, produto.precoUnitario as precoProduto,cliente.nomeCliente as nomeCliente, caixa.nomeCaixa as nomeCaixa from compra
    join produto on compra.idProduto = produto.idProduto
    left join cliente on compra.idCliente = cliente.idCliente
    left join caixa on cliente.idCaixa = caixa.idCaixa";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $compra = new Compra($rs['idCompra'], $rs['quantidade'], $rs['dataDaCompra'], $rs['idProduto'], $rs['idCliente'], $rs['nomeProduto'], $rs['precoProduto'], $rs['nomeCliente'], $rs['nomeCaixa']);
            array_push($compras, $compra);
        }
    }
    return $compras;
}

function criacaoCompra($compra)
{
    global $conexao;
    $sql = "select stock from produto where idProduto={$compra->getIdproduto()}";
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);
    if ($rs['stock'] < $compra->getQuantidade()) {
        echo "Stock insuficiente";
    } else {
        $sql = "insert into compra values (null, {$compra->getIdproduto()}, {$compra->getIdcliente()},
        {$compra->getQuantidade()}, '{$compra->getDataCompra()}')";
        $result = mysqli_query($conexao, $sql);
        if ($result) {
            $sql = "update produto set stock=stock-{$compra->getQuantidade()} where idProduto={$compra->getIdproduto()}";
            mysqli_query($conexao, $sql);
            registarAccao("Cadastrou compra");
        }
        echo "Compra inserida";
        if ($result) {
            // header('location:../view/ListarCompra.php');
        } else
            echo "Ocorreu um erro ao gravar os dados";
    }
}
function remocaoCompra($idCompra)
{
    global $conexao;
    $sql = "delete from compra where idCompra=" . $idCompra;
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Removeu compra");
    }
    // header('location:../view/ListarCompra.php');
}

function edicaoCompra($compra)
{
    global $conexao;

    $sql = "update compra set idProduto={$compra->getIdproduto()}, idCliente={$compra->getIdcliente()},
    quantidade={$compra->getQuantidade()}, dataDaCompra='{$compra->getDataCompra()}' where idCompra={$compra->getIdcompra()}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Editou compra");
    }
    if ($result) {
        //  header('location:../view/ListarCompra.php');
    } else
        echo "Ocorreu um erro ao atualizar os dados";
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
    $compra = new Compra($id, $rs['quantidade'], $rs['dataDaCompra'], $rs['idProduto'], $rs['idCliente']);
    return $compra;
}

function pesquisarCompra($pesquisa)
{
    global $conexao;
    $compras = array();
    $pesquisa = mysqli_real_escape_string($conexao, $pesquisa);
    $sql = "select compra.*, produto.produto as nomeProduto, produto.precoUnitario as precoProduto,cliente.nomeCliente as nomeCliente, caixa.nomeCaixa as nomeCaixa from compra
    join produto on compra.idProduto = produto.idProduto
    left join cliente on compra.idCliente = cliente.idCliente
    left join caixa on cliente.idCaixa = caixa.idCaixa
    where produto.produto like '%{$pesquisa}%' or cliente.nomeCliente like '%{$pesquisa}%' or compra.dataDaCompra like '%{$pesquisa}%' or compra.quantidade like '%{$pesquisa}%'";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $compra = new Compra($rs['idCompra'], $rs['quantidade'], $rs['dataDaCompra'], $rs['idProduto'], $rs['idCliente'], $rs['nomeProduto'], $rs['precoProduto'], $rs['nomeCliente'], $rs['nomeCaixa']);
            array_push($compras, $compra);
        }
    }
    return $compras;
}
