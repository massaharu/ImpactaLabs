<?php 
# @AUTOR = massaharu #
# @AUTOR = Jvalezzi #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
$LandingPage = new LandingPage(array(
					"desdiretorio" => "diretorio nome" ,
					"desnomearquivo" => "arquivo nome", 
					"deslandingpage" => "landing nome" ,
					"idunidade" => "2",
				));

function destroy_dir($dir) { 
	
	if (!is_dir($dir) || is_link($dir)) return unlink($dir); 
	
	foreach (scandir($dir) as $file) { 
		if ($file == '.' || $file == '..') continue; 
		if (!destroy_dir($dir . DIRECTORY_SEPARATOR . $file)) { 
			chmod($dir . DIRECTORY_SEPARATOR . $file, 0777); 
			if (!destroy_dir($dir . DIRECTORY_SEPARATOR . $file)) return false; 
		}; 
	} 
	return rmdir($dir); 
} 

$path = $_SERVER['DOCUMENT_ROOT']."/simpacweb/labs/Massaharu/deeletar";

destroy_dir($path);
?>