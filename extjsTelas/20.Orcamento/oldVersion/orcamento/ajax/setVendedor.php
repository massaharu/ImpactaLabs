<?php
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
Sql::query('SATURN','Simpac',"sp_pedidos_set_idvendedor ".(post('idpedido')-15000).", ".post('idvendedor'));
echo success;
?>