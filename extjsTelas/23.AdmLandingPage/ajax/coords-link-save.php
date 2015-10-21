<?php 
	# @AUTOR = massaharu #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
	$arr_objLinkCoordsList = json_decode(post('link_coords_list'));
	$diretorio = post('diretorio');
	$img_name = post('img_name');
	
	if(count($arr_objLinkCoordsList) == 0){
		echo success(false);
		exit();
	}
	
	//pre($arr_objLinkCoordsList);	exit();
	
	$link_coords_script = "\r\n\r\n\r\n";
	/*$link_coords_script .= '$(".span9.well-fit-default").html(';
	$link_coords_script .=	'"<div id=\'container-img-'.$diretorio.'\' >"+';
	$link_coords_script .=		'"<img src=\'img/'.$img_name.'\' border=\'0\' />"+';
	$link_coords_script .=  	'"</div>"';
	$link_coords_script .= ');';*/
	
	$link_coords_script .= "var links = [";
	
	$numItems = count($arr_objLinkCoordsList);
	$i = 0;
	foreach($arr_objLinkCoordsList as $key=>$LinkCoordsList){
		
		//Se NÃO for o último index do array
		$virgula = (!(++$i === $numItems))? "," : "";
		
		$link_coords_script .= "{"; 
		$link_coords_script .= "href : \"".$LinkCoordsList->_link."\",";
		$link_coords_script .= "p1 : [".$LinkCoordsList->pinicialx.", ".$LinkCoordsList->pinicialy."],";
		$link_coords_script .= "p2 : [".$LinkCoordsList->pfinalx.", ".$LinkCoordsList->pfinaly."]";
		$link_coords_script .= "}".$virgula;
	}
	$link_coords_script .= "];";	
	$link_coords_script .= '$img = $("#container-img-'.$diretorio.' img");';
	$link_coords_script .= "\r\n\r\n\r\n";
	
	$path = "\\\\calibra\\fit$\\landing-page\\$diretorio\\default.php";
	
	$landing_page = fopen($path, "r");
	
	$file_content_string = fread($landing_page, filesize($path));
	
	$inicio_pos = (strpos($file_content_string, "{{{")) + 3;
	$final_pos = strpos($file_content_string, "}}}");
	
	$string_code = substr($file_content_string, $inicio_pos, $final_pos-$inicio_pos);
	
	$new_script = str_replace($string_code, $link_coords_script, $file_content_string);
	
	fclose($landing_page);
	//Escreve no arquivo
	$file = fopen($path ,'w+');
	fwrite($file, $new_script);
	fclose($file);
	
	echo success();
?>