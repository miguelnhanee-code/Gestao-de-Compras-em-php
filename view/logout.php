<?php

include_once __DIR__ . '/../controller/controllerLogin.php';

$sessao->logout();

header("Location: Login.php");
exit();