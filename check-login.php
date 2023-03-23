<?php

require('conn.php');
require('session.php');

$username =  $_POST['username'];
$password =  $_POST['password'];


if (login($username, $password, $MySQLi) == true)
{        			   
	echo "<script>window.location='home.php'</script>";	
}
else	
{
	echo '<script type="text/javascript">alert("ERRO: SENHA OU USUARIO INCORRETOS!'. $req_senha .'");</script>';
	
	echo "<script>window.location='index.php'</script>";
}  
?>
