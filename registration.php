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
    <title>Registo - Jogo Do Galo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        //verifica se formulario foi submetido
        if (isset($_POST["submit"])) {
            //recupera dados do formulario
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           //hash da senha para armazenar com mais seguranca na base de dados
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            //array para armazenar mensagens de erro
           $errors = array();
           //verifica se todos os campos foram preenchidos
           if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"Sao necessarios todos os campos");
           }
           //verifica se formato do mail e valido
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email nao e valido");
           }
           //verifica se senha tem pelo menos 8 caracteres
           if (strlen($password)<8) {
            array_push($errors,"Password tem de ter pelo menos 8 caracteres");
           }
           //verifica se as senhas fornecidas coincidem
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password nao combinam");
           }
           //verifica se mail ja esta registaado na base de dados
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email ja existente!");
           }
           //se houver erros, exibe mensagens de erro
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            //se nao houver erros, insere o novo utilizador na base de dados
            $sql = "INSERT INTO users (full_name, email, password) VALUES ( ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sss",$fullName, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Registado com sucesso.</div>";
            }else{
                die("Something went wrong");
            }
           }
          

        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Introduza o Nome">
            </div>
            <div class="form-group">
                <input type="emamil" class="form-control" name="email" placeholder="Introduza o Mail">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Introduza a Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Introduza a Password novamente">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Registar" name="submit">
            </div>
        </form>
        <div>
        <div><p>Se já tem conta, <a href="login.php">entre aqui</a></p></div>
      </div>
    </div>
</body>
</html>