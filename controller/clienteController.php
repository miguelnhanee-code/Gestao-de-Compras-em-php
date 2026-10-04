<?php

//  include_once("clienteModel.php");
include_once(__DIR__ . "/../model/clienteModel.php");
$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");

function listarCliente()
{
    global $conexao;
    $clientes = array();
    $sql = "SELECT c.idCliente, c.nomeCliente, c.apelidoCliente, p.idCaixa, p.nomeCaixa 
        FROM cliente c inner JOIN caixa p ON c.idCaixa = p.idCaixa";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente($rs['idCliente'], $rs['nomeCliente'], $rs['apelidoCliente'], $rs['nomeCaixa']);
            array_push($clientes, $cliente);
        }
    }
    return $clientes;
}



function criacao($cliente)
{
    global $conexao;
    //problemas nessa query 
    $sql = "SELECT * FROM cliente 
            WHERE nomeCliente = '{$cliente->getNomeCliente()}'
            AND apelidoCliente = '{$cliente->getApelidoCliente()}'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "O cliente ja existem ";
    } else {
        $sql = "insert into cliente values (null,'{$cliente->getNomeCliente()}', '{$cliente->getApelidoCliente()}', '{$cliente->getIdCaixa()}')";
        $result = mysqli_query($conexao, $sql);
        echo "Cliente inserida";
        if ($result) {
            // header('location:index.php');
        } else
            echo "Ocorreu um erro ao gravar os dados";
    }
}
function remocao($id)
{
    global $conexao;
    $sql = "delete from cliente  where idCliente=" . $id;
    $result = mysqli_query($conexao, $sql);
    // header('location:index.php');
}

function edicao($cliente)
{
    global $conexao;
    $sql = "UPDATE cliente SET  nomeCliente='{$cliente->getNomeCliente()}', apelidoCliente='{$cliente->getApelidoCliente()}', idCaixa='{$cliente->getIdCaixa()}' WHERE idCliente='{$cliente->getIdCliente()}'";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        //  header('location:index.php');
    } else
        echo "Ocorreu um erro ao atualizar os dados";
}


function encontra($id)
{
    global $conexao;
    $sql = "select * from cliente where idCliente=" . $id;
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);
    $cliente = new Cliente($rs['idCliente'], $rs['nomeCliente'], $rs['apelidoCliente'], $rs['idCaixa']);
    return $cliente;
}


function listarCaixas()
{
    global $conexao;
    $caixas = array();
    $sql = "SELECT idCaixa, nomeCaixa FROM caixa";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $caixas[] = $rs;
        }
    }
    return $caixas;
}
