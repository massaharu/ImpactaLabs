<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$pais = new Pais(1);
	
var_dump($pais);


/*sp_pais_save – Procedure para salvar e atualizar – Passar como parâmetro idpais, despais, desabreviacao2, desabreviacao3.*/
?>