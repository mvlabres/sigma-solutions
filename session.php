<?php

define('ROOT_PATH', dirname(__FILE__));

function sec_session_start() {  
    error_reporting(0);
    date_default_timezone_set("America/Sao_Paulo");
    $session_name = 'logado'; 
    $secure=false;
    $httponly = true;

    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header('Location:index.php');
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

$pagesNotClearPost = ['searchSchedule.php'];

sec_session_start();

$contentPost = '';

if(isset($_GET['conteudo']) && $_GET['conteudo'] != null){
    $contentPost = $_GET['conteudo'];
}

if( $_SERVER['REQUEST_METHOD'] =='POST' && !in_array($contentPost, $pagesNotClearPost) && $_GET['comteudo'] != 'newSchedule.php'){
    
    $request = md5(implode( $_POST ) );

    if( isset( $_SESSION['last_request'] ) && $_SESSION['last_request'] == $request ) {
        unset($_POST);
        $_SESSION['last_request'] = '';
    }
    else {
        $_SESSION['last_request'] = $request;
    }
    
}


function login($usuario, $senha, $mysqli) {

    $data = date('d/m/Y');
    $hora = date('h:i');

    if ($stmt = $mysqli->prepare("SELECT id,nome, username, password, dataInclusao, tipo FROM usuario  WHERE username = ? LIMIT 1")){ 
        
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($id, $nome, $username,$password, $data_inclusao, $tipo);
        $stmt->fetch();

        if ($stmt->num_rows == 1){ 

            if ($senha == $password){ 
                $_SESSION['id'] = $id;
                $_SESSION['nome'] = $nome;
                $_SESSION['username'] = $username;
                $_SESSION['tipo'] = $tipo;
                getAccess($mysqli);
                return true;

            } else return false;
            
        } else return false;
    }
}

function getAccess($mysqli){

    $FUNCTION_ACCESS = [
        'schedule'=> 'hidden',
        'schedule_new'=> 'hidden',
        'schedule_list'=> 'hidden',
        'register'=> 'hidden',
        'register_operation_type'=> 'hidden',
        'register_truck_type'=> 'hidden',
        'register_shipping_company'=> 'hidden',
        'register_log'=> 'hidden',
        'register_report'=> 'hidden'
    ];

    $sql = "SELECT id, userType, functionName
            FROM user_access 
            WHERE userType = '".$_SESSION['tipo'] ."'";

                    
    $result = $mysqli->query($sql);

    while ($data = $result->fetch_assoc()){ 
        $FUNCTION_ACCESS[$data['functionName']] = '';

    }

    $_SESSION['FUNCTION_ACCESS'] = $FUNCTION_ACCESS;
}

function login_check($mysqli) {

    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        if ($stmt = $mysqli->prepare("SELECT id,nome, username, password, dataInclusao, tipo FROM usuario  WHERE username = ? LIMIT 1")){
            $stmt->bind_param('i', $id);
            $stmt->execute();  
            $stmt->store_result();

            if($stmt->num_rows == 1) {
                if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 15000)) {
                    session_unset();     
                    session_destroy();  
                    return false;
                }
                else{
                    $_SESSION['LAST_ACTIVITY'] = time();
                    return true;
                }
            }else return false;
        } 

        else return false;
        
    } else  return false;
}


