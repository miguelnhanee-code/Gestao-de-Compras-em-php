<?php

include_once(__DIR__ . "/../model/utilizadoresModel.php");
include_once(__DIR__ . "/controllerLog.php");
// include_once(__DIR__ . "/../model/Sessao.php");

class Sessao
{
    private $logado = false;
    public $idUtilizador;
    public $email;

    function __construct()
    {
        session_start();
        $this->verificar_login();
    }

    private function verificar_login()
    {
        if (
            isset($_SESSION['idUtilizador']) &&
            isset($_SESSION['email'])
        ) {

            $this->idUtilizador = $_SESSION['idUtilizador'];
            $this->email = $_SESSION['email'];
            $this->logado = true;
        } else {

            unset($this->idUtilizador);
            unset($this->email);

            $this->logado = false;
        }
    }

    public function esta_logado()
    {
        return $this->logado;
    }

    public function login($usuario)
    {
        if ($usuario) {

            $_SESSION['idUtilizador'] = $usuario['idUtilizador'];
            $this->idUtilizador = $_SESSION['idUtilizador'];
            $_SESSION['email'] = $usuario['email'];
            $this->email = $_SESSION['email'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['perfil'] = $usuario['perfil'];

            $this->logado = true;
        }
    }

    public function logout()
    {
        unset($_SESSION['idUtilizador']);
        unset($this->idUtilizador);
        unset($_SESSION['email']);
        unset($this->email);
        unset($_SESSION['nome']);
        unset($_SESSION['perfil']);

        $this->logado = false;
    }
}
$sessao = new Sessao();


$conexao = mysqli_connect("localhost", "root", "", "gestaocompra");

function login($email, $senha)
{
    global $conexao, $sessao;

    $sql = "select * from utilizadores where email='{$email}'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) > 0) {
        $utilizador = mysqli_fetch_assoc($result);
        if (password_verify($senha, $utilizador['senha'])) {
            $sessao->login($utilizador);
            header("location:../view/Dashboard.php");
            if ($result) {
                registarAccao("Log in");
            }
            exit();
        } else {
            echo "Senha incorrecta";
        }
    } else {
        echo "Email não encontrado";
    }
}
