<?php

include_once 'conn.php';
include_once 'session.php';

date_default_timezone_set("America/Sao_Paulo");

if (isset($_SESSION['username'])) {
    echo "<script>window.location='home.php'</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIGMA Solutions</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="custom-style.css">

        <link rel="shortcut icon" href="assets/ico/sigma.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>
    <body class="login-body">
        <div class="login-container">
            <div class="login-logo">
                <img class="login-img-logo" src="images/sigma_logo.png">
                <p class="login-title">Solutions</p>
            </div>
            <div class="login-box">
                <div class="login-box-info">
                    <h3>Informe seu usuário e senha.</h3>
                </div>
                <div class="login-form">
                    <form role="form" action="check-login.php" method="post" class="login-form">
                        <div class="form-group">
                            <label class="sr-only" for="form-username">Usuário</label>
                            <input type="text" name="username" placeholder="Usuário..." class="form-username form-control" id="form-username">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-password">Senha</label>
                            <input type="password" name="password" placeholder="Senha..." class="form-password form-control" id="form-password">
                        </div>
                        <button type="submit" class="login-btn btn">Entre</button>
                    </form>
                </div>
            </div>
            <a class="dev-link" href="http://labsoft.tech/" target="_blank" ><p style="text-align:center; width:100%;" class="text-muted">&nbsp Desenvolvido por <span class="text-primary" style="font-size:1.2em"><b>LAB</b>soft</span></p></a>
        </div>
        <div class="login-background">
            <img class="backgroud-image" src="images/sigma_background.png">
        </div>
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/scripts.js"></script>
    </body>
</html>