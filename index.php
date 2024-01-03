<?php
//inicia sessao, para aceder as variaveis em database.php
session_start();
//verifica se o utilizador nao esta autenticado
if (!isset($_SESSION["user"])) {
    //direciona para a login.php para fazer o login
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Jogo Do Galo</title>
</head>
<body>
    <div class="container">
        <h1>Jogo Do Galo</h1>
        <a href="logout.php" class="btn btn-warning">Sair Da Sessao</a>
    </div>
    <script>
        //redireciona para o URL do jogo do galo após carregar a página
        window.location.href = "http://localhost:3000/";
    </script>
</body>
</html>
