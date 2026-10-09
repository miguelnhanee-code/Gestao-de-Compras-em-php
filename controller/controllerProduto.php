<?php
include_once __DIR__ . '/../model/Produto.php';
include_once(__DIR__ . "/controllerLog.php");

$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");


function cadastrarProduto($produto)
{
    global $conexao;
    $sql = "select * from produto where produto='{$produto->getProduto()}'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "O produto ja existe";
    } else {
        $sql = "insert into produto values(null, '{$produto->getProduto()}', {$produto->getPrecoUnitario()},'{$produto->getDataConfecao()}', '{$produto->getDataValidade()}')";
        $result = mysqli_query($conexao, $sql);
        if ($result) {
            registarAccao("Cadastrou Produto");
        }
        if ($result) {
            // header('location:../view/ListarProduto.php');
        } else {
            echo "Ocorreu um erro ao gravar";
        }
    }
}

function listarProduto()
{
    global $conexao;
    $produtos = array();
    $sql = "select * from produto";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $produto = new Produto($rs['idProduto'], $rs['produto'], $rs['precoUnitario'], $rs['dataValidade'], $rs['dataConfecao']);
            array_push($produtos, $produto);
        }
    }
    return $produtos;
}

function removerProduto($id)
{
    global $conexao;
    $sql = "delete from produto where idProduto=" . $id;
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Removeu Produto");
    }
    // header('location:../view/ListarProduto.php');
}

function actualizarProduto($produto)
{
    global $conexao;
    $sql = "update produto set produto='{$produto->getProduto()}', precoUnitario={$produto->getPrecoUnitario()},
    dataConfecao='{$produto->getDataConfecao()}', dataValidade='{$produto->getDataValidade()}'
    where idProduto={$produto->getIdproduto()}";

    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Actualizou Produto");
    }
    if ($result) {
        // header('location:../view/ListarProduto.php');
    } else {
        echo "Ocorreu um erro ao atualizar os dados.";
    }
}



//rever
function encontraProduto($id)
{
    global $conexao;
    $sql = "select * from produto where idProduto=" . $id;
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);
    $produto = new Produto($rs['idProduto'], $rs['produto'], $rs['precoUnitario'], $rs['dataValidade'], $rs['dataConfecao']);
    return $produto;
}


function pesquisarProduto($pesquisa)
{
    global $conexao;
    $produtos = array();
    $pesquisa = mysqli_real_escape_string($conexao, $pesquisa);
    $sql = "select * from produto where produto like '%{$pesquisa}%' or precoUnitario like '%{$pesquisa}%' or dataValidade like '%{$pesquisa}%' or dataConfecao like '%{$pesquisa}%'";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $produto = new Produto($rs['idProduto'], $rs['produto'], $rs['precoUnitario'], $rs['dataValidade'], $rs['dataConfecao']);
            array_push($produtos, $produto);
        }
    }
    return $produtos;
}
