<?php

include_once(__DIR__ . "/../model/caixaModel.php");
include_once(__DIR__ . "/controllerLog.php");
$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");


// class caixaController    
// {

function listarCaixa()
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

function criacao($caixa)
{
    global $conexao;
    $sql = "select * from caixa where nomeCaixa='{$caixa->getNomeCaixa()}'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "O caixa ja existem na agenda";
    } else {
        $sql = "insert into caixa values (null,'{$caixa->getNomeCaixa()}')";
        $result = mysqli_query($conexao, $sql);
        if ($result) {
            registarAccao("Cadastrou caixa");
        }
        echo "Caixa inserida";
        if ($result) {
            // header('location:index.php');
        } else
            echo "Ocorreu um erro ao gravar os dados";
    }
}
function remocao($idCaixa)
{
    global $conexao;
    $sql = "delete from caixa where idCaixa=" . $idCaixa;
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Removeu caixa");
    }
    // header('location:index.php');
}

function edicao($caixa)
{
    global $conexao;

    $sql = "update caixa  set nomeCaixa='{$caixa->getNomeCaixa()}' where idCaixa={$caixa->getIdCaixa()}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Editou caixa");
    }
    if ($result) {
        //  header('location:index.php');
    } else
        echo "Ocorreu um erro ao atualizar os dados";
}

function encontra($id)
{
    global $conexao;
    $sql = "select * from caixa where idCaixa=" . $id;
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);
    $caixa = new Caixa($rs['idCaixa'], $rs['nomeCaixa']);
    return $caixa;
}

function pesquisarCaixa($pesquisa)
{
    global $conexao;
    $caixas = array();
    $pesquisa = mysqli_real_escape_string($conexao, $pesquisa);
    $sql = "select * from caixa where nomeCaixa like '%{$pesquisa}%'";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $caixa = new Caixa($rs['idCaixa'], $rs['nomeCaixa']);
            array_push($caixas, $caixa);
        }
    }
    return $caixas;
}
