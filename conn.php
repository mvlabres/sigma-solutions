<?php
header('Content-Type: text/html; charset=utf-8');

/*$MySQL = array(
    'servidor' => 'localhost',  
    'usuario' => 'labsoftt_marcos',   
    'senha' => 'getnis2018',       
    'banco' => 'labsoftt_sigmaScheduling'  
);*/

$MySQL = array(
    'servidor' => 'localhost',  
    'usuario' => 'root',   
    'senha' => '',       
    'banco' => 'sigmascheduling'  
); 


$MySQLi = new MySQLi($MySQL['servidor'], $MySQL['usuario'], $MySQL['senha'], $MySQL['banco']);
$MySQLi->set_charset("utf8");
?>