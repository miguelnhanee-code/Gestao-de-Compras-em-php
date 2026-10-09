<?php

include_once(__DIR__ . "/../model/fornecedorModel.php");
include_once(__DIR__ . "/controllerLog.php");
$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");


// class caixaController    
// {

function listarFornecedor()
{
    global $conexao;
    $fornecedores = array();
    $sql = "select * from fornecedor";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $fornecedor = new Fornecedor($rs['idFornecedor'], $rs['nomeFornecedor'],  $rs['telefone'], $rs['endereco'], $rs['email']);
            array_push($fornecedores, $fornecedor);
        }
    }
    return $fornecedores;
}

function criacao($fornecedor)
{
    global $conexao;
    // $sql = "select * from fornecedor where nomeFornecedor='{$fornecedor->getNomeFornecedor()}', telefone ='{$fornecedor->getTelefone()}',  endereco ='{$fornecedor->getEndereco()}', email ='{$fornecedor->getEmail()}'";
    $sql = "SELECT * FROM fornecedor 
            WHERE nomeFornecedor='{$fornecedor->getNomeFornecedor()}'
            AND telefone='{$fornecedor->getTelefone()}'
            AND endereco='{$fornecedor->getEndereco()}'
            AND email='{$fornecedor->getEmail()}'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "O fornecedor ja existe";
    } else {
        $sql = "insert into fornecedor values (null,'{$fornecedor->getNomeFornecedor()}','{$fornecedor->getTelefone()}','{$fornecedor->getEndereco()}','{$fornecedor->getEmail()}')";
        $result = mysqli_query($conexao, $sql);
        echo "fornecedor inserido";
        if ($result) {
            registarAccao("Cadastrou Fornecedor");
        }
        if ($result) {
            // header('location:index.php');
        } else
            echo "Ocorreu um erro ao gravar os dados";
    }
}
function remocao($idFornecedor)
{
    global $conexao;
    $sql = "delete from fornecedor where idFornecedor=" . $idFornecedor;
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Removel Fornecedor");
    }
    // header('location:index.php');
}

function edicao($fornecedor)
{
    global $conexao;

    $sql = "update fornecedor  set nomeFornecedor='{$fornecedor->getNomeFornecedor()}', telefone='{$fornecedor->getTelefone()}',  endereco='{$fornecedor->getEndereco()}', email='{$fornecedor->getEmail()}'where idFornecedor={$fornecedor->getIdFornecedor()}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        registarAccao("Editou Fornecedor");
    }
    if ($result) {
        //  header('location:index.php');
    } else
        echo "Ocorreu um erro ao atualizar os dados";
}

// function encontra($idFornecedor)
// {
//     global $conexao;
//     $sql = "select * from fornecedor where idFornecedor=" . $idFornecedor;
//     $result = mysqli_query($conexao, $sql);
//     $rs = mysqli_fetch_assoc($result);
//     $fornecedor = new Fornecedor($rs['nomeFornecedor'], $rs['telefone'], $rs['endereco'], $rs['telefone']);
//     return $fornecedor;
// }


// }


function encontraFornecedor($id)
{
    global $conexao;
    $sql = "select * from fornecedor where idFornecedor={$id}";
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);
    return new Fornecedor($rs['idFornecedor'], $rs['nomeFornecedor'], $rs['telefone'], $rs['endereco'], $rs['email']);
}


function pesquisarFornecedor($pesquisa)
{
    global $conexao;
    $fornecedores = array();
    $pesquisa = mysqli_real_escape_string($conexao, $pesquisa);
    $sql = "select * from fornecedor where nomeFornecedor like '%{$pesquisa}%' or telefone like '%{$pesquisa}%' or endereco like '%{$pesquisa}%' or email like '%{$pesquisa}%'";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $fornecedor = new Fornecedor($rs['idFornecedor'], $rs['nomeFornecedor'],  $rs['telefone'], $rs['endereco'], $rs['email']);
            array_push($fornecedores, $fornecedor);
        }
    }
    return $fornecedores;
}
