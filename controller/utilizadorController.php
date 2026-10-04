<?php

include_once(__DIR__ . "/../model/utilizadoresModel.php");
$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");

function listar()
{
    global $conexao;
    $utilizadores = array();
    $sql = "select * from utilizadores";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        while ($rs = mysqli_fetch_assoc($result)) {
            $utilizador = new utilizadores($rs['idUtilizador'], $rs['nome'], $rs['apelido'], $rs['email'], $rs['contacto'], $rs['username'], $rs['senha'], $rs['perfil']);
            array_push($utilizadores, $utilizador);
        }
    }
    return $utilizadores;
}

function criacao($utilizador)
{
    global $conexao;
    $sql = "SELECT * FROM utilizadores 
            WHERE nome='{$utilizador->getNome()}'
            AND apelido='{$utilizador->getApelido()}'
            AND email='{$utilizador->getEmail()}'
            AND contacto='{$utilizador->getContacto()}'
            AND username='{$utilizador->getUsername()}'
            AND senha='{$utilizador->getSenha()}'
            AND perfil='{$utilizador->getPerfil()}'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "O utilizador ja existe";
    } else {
        $sql = "insert into utilizadores values (null,'{$utilizador->getNome()}','{$utilizador->getApelido()}','{$utilizador->getEmail()}','{$utilizador->getContacto()}','{$utilizador->getUsername()}','{$utilizador->getSenha()}','{$utilizador->getPerfil()}')";
        $result = mysqli_query($conexao, $sql);
        echo "utilizador inserido";
        if ($result) {
            // header('location:index.php');
        } else
            echo "Ocorreu um erro ao gravar os dados";
    }
}
function remocao($idUtilizador)
{
    global $conexao;
    $sql = "delete from utilizadores where idUtilizador=" . $idUtilizador;
    $result = mysqli_query($conexao, $sql);
    // header('location:index.php');
}

function edicao($utilizador)
{
    global $conexao;

    $sql = "update utilizadores  set nome='{$utilizador->getNome()}', apelido='{$utilizador->getApelido()}', email='{$utilizador->getEmail()}', contacto='{$utilizador->getContacto()}', username='{$utilizador->getUsername()}', senha='{$utilizador->getSenha()}', perfil='{$utilizador->getPerfil()}' where idUtilizador={$utilizador->getIdUtilizador()}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        //  header('location:index.php');
    } else
        echo "Ocorreu um erro ao atualizar os dados";
}


function encontraUtilizador($id)
{
    global $conexao;
    $sql = "select * from utilizadores where idUtilizador={$id}";
    $result = mysqli_query($conexao, $sql);
    $rs = mysqli_fetch_assoc($result);
    return new utilizadores($rs['idUtilizador'], $rs['nome'], $rs['apelido'], $rs['email'], $rs['contacto'], $rs['username'], $rs['senha'], $rs['perfil']);
}

function alterarSenha($email, $senha)
{
    global $conexao;

    $sql = "update utilizadores set senha='{$senha}' where email='{$email}'";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        //  header('location:index.php');
    } else
        echo "Ocorreu um erro ao atualizar a senha";
}


function resetarSenha($id)
{
    global $conexao;
    $senhaPadrao = "12345678";
    $sql = "update utilizadores set senha='{$senhaPadrao}' where idUtilizador={$id}";
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        echo "Senha resetada com sucesso";
    } else
        echo "Ocorreu um erro ao resetar a senha";
}
