<?php

// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

include_once(__DIR__ . "/../model/LogModel.php");
$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");

function registarLog($idUsuario, $nome, $perfil, $accao)
{
    global $conexao;
    $sql = "insert into log (idUsuario, nome, perfil, accao, dataAccao) VALUES ('{$idUsuario}', '{$nome}', '{$perfil}', '{$accao}', NOW())";
    $result = mysqli_query($conexao, $sql);
    if (!$result) {
        echo "Ocorreu um erro ao registar o log";
    }
}

function registarAccao($accao)
{
    if (isset($_SESSION['idUtilizador'])) {
        $idUtilizador = $_SESSION['idUtilizador'];
    } else {
        $idUtilizador = 0;
    }

    if (isset($_SESSION['nome'])) {
        $nome = $_SESSION['nome'];
    } else {
        $nome = '';
    }

    if (isset($_SESSION['perfil'])) {
        $perfil = $_SESSION['perfil'];
    } else {
        $perfil = '';
    }

    registarLog($idUtilizador, $nome, $perfil, $accao);
}

function listaDeLogs()
{
    global $conexao;
    $logs = array();
    $sql = "select *, u.email from log left join utilizadores u on u.idUtilizador = idUsuario ORDER BY dataAccao DESC";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $log = new Log($rs['idLog'], $rs['idUsuario'], $rs['nome'], $rs['perfil'], $rs['accao'], $rs['dataAccao'], $rs['email']);
            array_push($logs, $log);
        }
    }
    return $logs;
}