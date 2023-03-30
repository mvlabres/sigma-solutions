<?php

function sec_session_start() {
    error_reporting(0);
    date_default_timezone_set("America/Sao_Paulo");
    $session_name = 'logado'; 
    $secure=false;
    $httponly = true;

    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header('Location: index.php');
        exit();
    }
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    
    session_name($session_name);
    session_start();            

    session_regenerate_id();    
    
}

sec_session_start();

if( $_SERVER['REQUEST_METHOD'] =='POST' ){
    
    $request = md5(implode( $_POST ) );

    if( isset( $_SESSION['last_request'] ) && $_SESSION['last_request'] == $request ) unset($_POST);
    else $_SESSION['last_request'] = $request;
    
}


function login($usuario, $senha, $mysqli) 
{
    $data = date('d/m/Y');
    $hora = date('h:i');
    if ($stmt = $mysqli->prepare("SELECT id,nome, username, password, dataInclusao, tipo FROM usuario  WHERE username = ? LIMIT 1"))
    { 
        
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($id, $nome, $username,$password, $data_inclusao, $tipo);
        $stmt->fetch();
        if ($stmt->num_rows == 1) 
        {   
            if ($senha == $password) 
            { 
                $_SESSION['id'] = $id;
                $_SESSION['nome'] = $nome;
                $_SESSION['username'] = $username;
                $_SESSION['tipo'] = $tipo;
                return true;
            } 
            else 
            {
                return false;
            }
            
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    if (isset($_SESSION['username'])) 
    {
        $username = $_SESSION['username'];
        if ($stmt = $mysqli->prepare("SELECT id,nome, username, password, dataInclusao, tipo FROM usuario  WHERE username = ? LIMIT 1")) 
        {
            $stmt->bind_param('i', $id);
            $stmt->execute();  
            $stmt->store_result();
            if($stmt->num_rows == 1) {
                if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 7200)) 
                {
                    session_unset();     
                    session_destroy();  
                    return false;
                }
                else
                {
                    $_SESSION['LAST_ACTIVITY'] = time();
                     return true;
                }
            }else {
                // Não foi logado 
                return false;
            }
        } 
        else {
            // Não foi logado 
            return false;
        }
    } else {
        // Não foi logado 
        return false;
    }
}