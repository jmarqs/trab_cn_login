<?php
//inicia sessao, para aceder as variaveis em database.php
session_start();
//destroi a sessao atual
session_destroy();
//direciona o utilizador para pagina de login
header("Location: login.php");
?>