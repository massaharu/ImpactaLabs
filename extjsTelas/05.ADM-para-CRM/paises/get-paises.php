<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

echo json_encode(array("myData"=>Sql::arrays('SATURN','VENDAS',"sp_paises_list")))

//echo json_encode(array("myData"=>Pais::todos()));


/*sp_paises_list – Listar todos os paises*/
?>