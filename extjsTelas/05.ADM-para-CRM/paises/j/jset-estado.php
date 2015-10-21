<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$novo_estado = new Estado();

var_dump($novo_estado);

/*foreach($_POST as $key=>$val){
	$novo_estado->{$key} = post($key);
}

$novo_estado->save();

echo success;*/

/*sp_pais_save – Procedure para salvar e atualizar – Passar como parâmetro idpais, despais, desabreviacao2, desabreviacao3.*/
?>