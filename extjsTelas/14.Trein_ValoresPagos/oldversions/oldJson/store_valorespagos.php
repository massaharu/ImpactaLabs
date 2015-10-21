<?php
////////////////////////////////////////////////////////////////////////////////////////////
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
////////////////////////////////////////////////////////////////////////////////////////////
$data1 = post('data1');
$data2 = post('data2');
$idcurso = post('idcurso');

$data = array();
////////////////////////////////////////////////////////////////////////////////////////////
if($idcurso){
	$a = Sql::arrays('SATURN','Simpac',"sp_valorespagostreinamentos_get_idcurso '$data1 00:00:00', '$data2 23:59:59', $idcurso");
} else {
	$a = Sql::arrays('SATURN','Simpac',"sp_valorespagostreinamentos '$data1 00:00:00', '$data2 23:59:59'");
}

/*while($r = mssql_fetch_array($a))
{

	flush();
	
	$lista2 = Sql::select('SATURN','Simpac',"sp_ValoresPagosTurma ".$r['idcursoagendado']);
	
	array_push($data, array(
			"descurso" => linkpermissao('modulos/cursosagendados/treinamento_dados.php', 'idcursoagendado='.$r['idcursoagendado'], $r['descurso'], '', '', 'turma.png'),
			"dtinicio" => formatdatetime($r['dtinicio'],7),
			"dttermino" => formatdatetime($r['dttermino'],7),
			"desperiodo" => utf8_encode($r['desperiodo']),
			"vlinstrutor" => $r['vlinstrutor'],
			"nminstrutor" => utf8_encode($r['nminstrutor']),
			"idcursoagendado" =>$r['idcursoagendado'],
			"vltotalpago" => $lista2['total']
	));
	
	unset($lista2);
	
}

unset($r);*/
////////////////////////////////////////////////////////////////////////////////////////////
echo json_encode(array("myData"=>$a));
////////////////////////////////////////////////////////////////////////////////////////////
?>
