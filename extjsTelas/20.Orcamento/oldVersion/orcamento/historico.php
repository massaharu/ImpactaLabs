<?php
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
Sql::query('SPIDER','simpacweb',"sp_historicoorcamento_insert '".post('idpedido')."',".$_SESSION['idusuario']);
?>