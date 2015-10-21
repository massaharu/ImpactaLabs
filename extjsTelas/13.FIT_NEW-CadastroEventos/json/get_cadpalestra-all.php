<?php
# @AUTOR = ricardo #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

function toLowerCase($term) {
	return strtr(($term), "ABCDEFGHIJKLMNOPQRSTUVWXYZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "abcdefghijklmnopqrstuvwxyzàáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
}

function ajeita($nome) {
	$nome = toLowerCase($nome);
	$nome = explode(" ", $nome);
	
	//deixando a primeira letra maiuscula
	$runfor = count($nome); //número de vezes que o for irá rodar
	for ($j = 0; $j < $runfor; $j++) {
		if (!($nome[$j] == "de" OR $nome[$j] == "la" OR $nome[$j] == "el" OR $nome[$j] == "dos" OR
				$nome[$j] == "da" OR $nome[$j] == "das" OR $nome[$j] == "do" OR $nome[$j] == "com" OR
				$nome[$j] == "e" OR $nome[$j] == "na" OR $nome[$j] == "no" OR $nome[$j] == "nas" OR
				$nome[$j] == "nos" OR $nome[$j] == "às" OR $nome[$j] == "a" OR $nome[$j] == "e" OR
				$nome[$j] == "o" OR $nome[$j] == "ou" OR $nome[$j] == "pra" OR $nome[$j] == "para" OR
				$nome[$j] == "pras" OR $nome[$j] == "pra" OR $nome[$j] == "y")) {
			$nome[$j] = ucfirst($nome[$j]);
		}
	}
	
	return implode(" ", $nome);
}
	

$palestraCadastroId = post("palestraCadastroId");
//echo $palestraCadastroId.' '.$palestraId ;
//exit("SATURN", "FIT_NEW", "sp_cadpalestrabyaluno_get $palestraCadastroId, $palestraId");
$data = Sql::arrays("SATURN", "FIT_NEW", "sp_cadpalestrabyaluno_get $palestraCadastroId");

foreach($data as &$aluno) {
	//ajeitando os nomes, por exemplo: de 'ana maria' para 'Ana Maria'
	$aluno["palestraNome"] = ajeita($aluno["palestraNome"]);
}
success(TRUE, array("myData"=>$data));
?>