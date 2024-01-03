<?php
//inicia sessao, para aceder as variaveis em database.php
session_start();
//verificar se utilizador esta autenticado, direciona para a index.php
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jogo Do Galo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        //processa o formulario quando se envia
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           //conexao a base de dados
            require_once "database.php";
            //consulta a base de dados para o utilizador com o email fornecido
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //verifica se o utilizador existe
            if ($user) {
                //verifica se senha fornecida coincide com armazenada na base de dados
                if (password_verify($password, $user["password"])) {
                    //inicia sessao e direciona o utilizador para a pagina principal
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die(); //termina o script para evitar erros
                }else{
                    //mostra mensagem de erro se a senha nao coincidir
                    echo "<div class='alert alert-danger'>Password nao combina</div>";
                }
            }else{
                //mostra mensagem de erro se o email nao coincidir
                echo "<div class='alert alert-danger'>Email nao combina</div>";
            }
        }
        ?>
      <form action="login.php" method="post">
        <div class="form-group">
            <input type="email" placeholder="Introduza o Mail" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Introduza a Password" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Iniciar Sessao" name="login" class="btn btn-primary">
        </div>
      </form>
     <div><p>Se ainda não tem conta, <a href="registration.php">registe-se aqui</a></p></div>
    </div>
</body>
</html>