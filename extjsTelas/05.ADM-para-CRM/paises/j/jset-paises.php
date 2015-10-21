<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$novo_pais = new Pais();

foreach($_POST as $key=>$val){
	$novo_pais->{$key} = post($key);
}

$novo_pais->save();

echo success;

/*sp_pais_save – Procedure para salvar e atualizar – Passar como parâmetro idpais, despais, desabreviacao2, desabreviacao3.*/
?>