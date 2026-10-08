<?php
// session_start();
// include_once(__DIR__ . "/../controller/controllerLogin.php");
include_once(__DIR__ . "/../controller/utilizadorController.php");

if (isset($_POST['entrar'])) {
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        alterarSenha($_POST['email'], $_POST['senha']);
        header("Location: Login.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='Login.css'>
    <title>ALTERAR SENHA</title>
</head>

<body>
    <div class="mae">

        <div class="esquerda">
            <div class="logo">
                <img src="logo.png" alt="Logo" class="marca-logo">
                <span>SISTEMA DE<br>GESTÃO DE COMPRAS</span>
            </div>

            <div class="mensagem">

                <h1>Controle as suas compras num só lugar.</h1>
                <p>Produtos, fornecedores, clientes, caixa e envios, tudo integrado.</p>
            </div>

            <small></small>
        </div>

        <div class="direita">
            <form method="post">
                <h2>Alterar senha</h2>
                <p class="subtitulo">Introduza uma nova senha para aceder ao sistema.</p>

                <label for="usuario">Email</label>
                <input type="email" name="email" placeholder="Email de utilizador" required>

                <label for="senha">Atiga Palavra-passe</label>
                <input type="text" name="senha" placeholder="Senha antiga" requir>

                <label for="senha">NOVA Palavra-passe</label>
                <input type="password" name="senha" placeholder="••••••••" requir>

                <label for="senha">Confirma nova Palavra-passe</label>
                <input type="password" name="senha" placeholder="••••••••" required>

                <button type="submit" name="entrar">Entrar</button>
                <!-- <a href="#">Esqueceu a palavra-passe?</a> -->
            </form>
        </div>

    </div>
</body>

</html>