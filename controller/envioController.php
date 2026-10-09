<?php

include_once(__DIR__ . "/../model/envioModel.php");
include_once(__DIR__ . "/controllerLog.php");

$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");


function listarEnvio()
{
    global $conexao;
    $envios = array();
    $sql = "SELECT e.idEnvia,e.idFornecedor,e.idProduto, e.dataEnvio, f.nomeFornecedor, p.produto FROM envia e INNER JOIN fornecedor f ON e.idFornecedor = f.idFornecedor INNER JOIN produto p  ON e.idProduto = p.idProduto";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $envio = new Envio($rs['idEnvia'], $rs['idFornecedor'], $rs['idProduto'], $rs['dataEnvio'], $rs['nomeFornecedor'], $rs['produto']);
            array_push($envios, $envio);
        }
    }
    return $envios;
}


function criacaoEnvio($envio)
{
    global $conexao;
    $sql = "SELECT * FROM envia WHERE idFornecedor='{$envio->getIdFornecedor()}' AND idProduto='{$envio->getIdProduto()}' AND dataEnvio='{$envio->getDataEnvio()}'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "O envio ja existe";
    } else {
        $sql = "INSERT INTO envia VALUES ( null, '{$envio->getIdFornecedor()}', '{$envio->getIdProduto()}', '{$envio->getDataEnvio()}' )";
        $result = mysqli_query($conexao, $sql);
        if ($result) {
            registarAccao("Cadastrou envio");
        }
        if ($result) {
            // echo "Envio inserido";
        } else {
            echo "Ocorreu um erro ao gravar os dados";
        }
    }
}


function remocaoEnvio($idEnvia)
{
    global $conexao;
    $sql = "DELETE FROM envia WHERE idEnvia={$idEnvia}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Removeu envio");
    }
}


function edicaoEnvio($envio)
{
    global $conexao;
    $sql = "UPDATE envia SET  idFornecedor='{$envio->getIdFornecedor()}',  idProduto='{$envio->getIdProduto()}', dataEnvio='{$envio->getDataEnvio()}' WHERE idEnvia={$envio->getIdEnvia()}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Editou envio");
    }
    if (!$result) {
        echo "Ocorreu um erro ao atualizar os dados";
    }
}


function encontraEnvio($id)
{
    global $conexao;
    $sql = "SELECT * FROM envia WHERE idEnvia={$id}";
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);

    return new Envio($rs['idEnvia'],  $rs['idFornecedor'],  $rs['idProduto'],  $rs['dataEnvio'], $rs['nomeFornecedor'], $rs['nomeProduto']);
}

// METODOS PAR LISTAR CONTEUDOS DAS OUTRAS ENTIDADE 

function listarProdutosEnviados()
{
    global $conexao;
    $produtos = array();
    $sql = "SELECT idProduto, produto FROM produto";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $produtos[] = $rs;
        }
    }
    return $produtos;
}


function listarFornecedoresEnviados()
{
    global $conexao;
    $fornecedores = array();
    $sql = "SELECT idFornecedor, nomeFornecedor FROM fornecedor";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $fornecedores[] = $rs;
        }
    }
    return $fornecedores;
}


function pesquisarEnvio($pesquisa)
{
    global $conexao;
    $envios = array();
    $pesquisa = mysqli_real_escape_string($conexao, $pesquisa);
    $sql = "SELECT e.idEnvia,e.idFornecedor,e.idProduto, e.dataEnvio, f.nomeFornecedor, p.produto FROM envia e INNER JOIN fornecedor f ON e.idFornecedor = f.idFornecedor INNER JOIN produto p  ON e.idProduto = p.idProduto
    WHERE f.nomeFornecedor like '%{$pesquisa}%' or p.produto like '%{$pesquisa}%' or e.dataEnvio like '%{$pesquisa}%'";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $envio = new Envio($rs['idEnvia'], $rs['idFornecedor'], $rs['idProduto'], $rs['dataEnvio'], $rs['nomeFornecedor'], $rs['produto']);
            array_push($envios, $envio);
        }
    }
    return $envios;
}
