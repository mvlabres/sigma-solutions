<?php
header('Content-Type: text/html; charset=utf-8');

$isProduction = false;

$productionConn = array(
    'servidor' => 'localhost',  
    'usuario' => 'labsoftt_marcos',   
    'senha' => 'getnis2018',       
    'banco' => 'labsoftt_sigma'  
);

$homolConn = array(
    'servidor' => 'localhost',  
    'usuario' => 'root',   
    'senha' => '',       
    'banco' => 'sigma'  
);

$MySQL = ($isProduction) ? $productionConn : $homolConn;

$MySQLi = new MySQLi($MySQL['servidor'], $MySQL['usuario'], $MySQL['senha'], $MySQL['banco']);
$MySQLi->set_charset("utf8");

?>