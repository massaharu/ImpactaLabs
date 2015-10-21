<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$alunotitulo = utf8_decode(post(alunotitulo));
if((!utf8_decode(post(descricao))) == 'Adicione uma descriчуo...'){
	$descricao = utf8_decode(post(descricao));
}else{
	$descricao = '';
}
$datadoevento = post(datadoevento). " 00:00";
$horadoevento = utf8_decode(post(horadoevento));
$linkevento = utf8_decode(post(linkevento));
$nrvagas = post(nrvagas);
$palestrante = utf8_decode(post(palestrante));
$curso = utf8_decode(post(curso));
$local = utf8_decode(post(local));
$cursotipo_id = post(cursotipo_id);

function emptyInt($emptValue){
	if($emptValue == ''){
		return "'"."'";
	}else{
		return $emptValue;
	}
}


//echo $alunotitulo.' '.$descricao.' '.$datadoevento.' '.$horadoevento.' '.$linkevento.' '.emptyInt($nrvagas).' '.$palestrante.' '.$curso.' '.$local.' '.$cursotipo_id;

//exit("sp_Cadcadastro_save '$alunotitulo', '$descricao', '$datadoevento', '$horadoevento', '$linkevento', ".emptyInt($nrvagas).", '$palestrante', '$curso', '$local', $cursotipo_id");
Sql::query('SQL_TESTE','FIT_NEW',"sp_Cadcadastro_save '$alunotitulo', '$descricao', '$datadoevento', '$horadoevento', '$linkevento', ".emptyInt($nrvagas).", '$palestrante', '$curso', '$local', $cursotipo_id");

echo success;
?>