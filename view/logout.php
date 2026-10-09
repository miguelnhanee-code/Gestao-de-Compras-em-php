<?php

include_once __DIR__ . '/../controller/controllerLogin.php';
$sessao->logout();
session_destroy();
header("Location: Login.php");
exit;