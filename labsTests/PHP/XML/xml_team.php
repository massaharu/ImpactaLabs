<?
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
////////////////////////////////////////////////////////////////////////////////////

$xml = simplexml_load_file("xml_files/team.xml");

/*$sql = Sql::arrays("SONATA", "SOPHIA", 
			"SELECT a.CODIGO, a.NOME 
			FROM SONATA.SOPHIA.SOPHIA.TURMAS a
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS b ON b.PRODUTO = a.CURSO
			WHERE a.PERIODO = 125 AND b.PRODUTO <> 72 AND b.NIVEL IN (1, 2) 
			ORDER BY a.NOME"
		);*/
//pre($sql); exit;

$arr_turmas = array(
	array(
		'from' =>2524,
		'to' =>1
	),
	array(
		'from' =>2558,
		'to' =>2
	),
	array(
		'from' =>2559,
		'to' =>4
	),
	array(
		'from' =>2560,
		'to' =>6
	),
	array(
		'from' =>2561,
		'to' =>7
	),
	array(
		'from' =>2562, 
		'to' =>8
	),
	array(
		'from' =>2530,
		'to' =>9
	),
	array(
		'from' =>2531,
		'to' =>82
	),
	array(
		'from' =>2565,
		'to' =>10
	),
	array(
		'from' =>2609,
		'to' =>103
	),
	array(
		'from' =>2566,
		'to' =>11
	) ,
	array(
		'from' =>2567,
		'to' =>12
	) ,
	array(
		'from' => 2611,
		'to' =>149
	) ,
	array(
		'from' => 2568,
		'to' =>13
	) ,
	array(
		'from' => 2532,
		'to' =>14
	),
	array(
		'from' => 2569,
		'to' =>75
	),
	array(
		'from' => 2570,
		'to' =>15
	),
	array(
		'from' => 2571,
		'to' =>16
	),
	array(
		'from' => 2572,
		'to' =>17
	),
	array(
		'from' => 2537,
		'to' =>104
	),
	array(
		'from' => 2576,
		'to' =>119
	),
	array(
		'from' => 2577,
		'to' =>148
	),
	array(
		'from' => 2538,
		'to' =>120
	) ,
	array(
		'from' => 2591,
		'to' =>150
	),
	array(
		'from' => 2540,
		'to' =>121
	),
	array(
		'from' => 2542,
		'to' =>123
	) ,
	array(
		'from' => 2533,
		'to' =>83
	),
	array(
		'from' => 2573,
		'to' =>106
	),
	array(
		'from' => 2574,
		'to' =>115
	),
	array(
		'from' => 2575,
		'to' =>147
	)   ,
	array(
		'from' => 2536,
		'to' =>124
	) ,
	array(
		'from' => 2535,
		'to' =>125
	)      ,
	array(
		'from' => 2578,
		'to' =>31
	) ,
	array(
		'from' => 2579,
		'to' =>33
	) ,
	array(
		'from' => 2580,
		'to' =>34
	) ,
	array(
		'from' => 2581,
		'to' =>35
	)   ,
	array(
		'from' => 2526,
		'to' =>126
	),
	array(
		'from' => 2529,
		'to' =>127
	),
	array(
		'from' => 2582,
		'to' =>37
	),
	array(
		'from' => 2583,
		'to' =>38
	),
	array(
		'from' => 2584,
		'to' =>39
	),
	array(
		'from' => 2585,
		'to' =>40
	),
	array(
		'from' => 2587,
		'to' =>41
	),
	array(
		'from' => 2589,
		'to' =>42
	),
	array(
		'from' => 2590,
		'to' =>43
	)      
);

foreach($arr_turmas as $arr_turma){
	$team = $xml->addChild('team');	
	$team->addChild('from', $arr_turma['from']);
	$team->addChild('to', $arr_turma['to']);
}

/*foreach($xml->children() as $child) {
 	echo "[from] => " . $child->from . " | [to] => ".$child->to ."<br>";
}
*/
//pre($xml);
$domxml = new DOMDocument('1.0');
$domxml->preserveWhiteSpace = false;
$domxml->formatOutput = true;
$domxml->loadXML($xml->asXML());
$domxml->save("new_xml_files/team.xml");
//$xml->asXML("new_xml_files/team.xml");
//pre($xml);
?>