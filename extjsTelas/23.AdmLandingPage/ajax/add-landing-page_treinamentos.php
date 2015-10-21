<?php 
	# @AUTOR = massaharu #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
	$directory = utf8_decode($_POST['directory-name']);
	//$path = $_SERVER['DOCUMENT_ROOT']."teste/adm-landing-page/landing-page/";
	$path = $_SERVER['DOCUMENT_ROOT']."/simpacweb/labs/Massaharu/extjsTelas/23.AdmLandingPage/";
	$path_full = $path.$directory."/img";
	$title_landing_page = utf8_decode($_POST['title-landing-page-name']);

	$file = $_FILES['imagem'];
	$name_file = utf8_decode($file['name']);
	
	/*pre(
		var_dump($_FILES)
	);

	exit();*/
	// echo($directory).' - ';
	// echo($title).' - ';
	// echo('<pre />');
	// print_r($file);

	// echo('<pre />');
	// print_r($_SERVER);
	// exit();

	//verificar se essa pastas já existe, se sim fazer algo para não sobrescrever a outra
	//criar diretório
	if(!is_dir($path_full)){
		mkdir($path_full, 0777, true);
	}

	//upload da img
	if($file['type'] == "image/jpeg" || $file['type'] == "image/png"){
		if(move_uploaded_file($file['tmp_name'], $path_full.'/'.$name_file)){

			//gravar no banco as informações - nome do arquivo, caminho completo com o nome do arquivo

			//criar arquivo
			if(!file_exists($path.$directory.'/default.php')){	
				$conteudo = '<?php
			 					require("../../inc/configuration.php");
			 					$page = new Page(array("path"=>"../../"));
											
			 					$hierarchy = array(
			 									array(
			 										"url" 	=> "/",
			 										"title" => "Home" 
			 									),
			 									array(
			 										"url" 	=> "",
			 										"title" => "'.$title_landing_page.'"
			 									)
			 								);
			 					?>
								
			 					{{{
									
									script
									
								}}}
								
								
			 					<div class="container container-middle"> 
							    	<div class="row">
								    <? require("../../inc/panelleft.php");?>  
			 					        <div class="span9 container-fit-default">
			 					            <div class="row-fluid">
			 					            <? $page->putTitle("'.$title_landing_page.'", $hierarchy) ?>
			 					                <div class="span9 well-fit-default">
			 					                	<div id="container-img-'.$directory.'" >
			 					                    	<img src="img/'.$name_file.'" border="0" />  
			 					                  </div>
			 					                </div>
			 					            </div>
			 					        </div>
								    </div>
			 					</div>';

			 	file_put_contents($path.$directory.'/default.php', $conteudo);
				
				
			 	exit(json_encode(array(
						"success"=>true,
						"msg"=>'Landing-page criada com sucesso, por favor mapear a imagem.',
						"path"=>$path.$directory.'/default.php',
						"conteudo"=>$conteudo
				)));
			}else{
				exit(json_encode(array(
						"success"=>false,
						"msg"=>'Arquivo já existe ou não foi criado.',
						"path"=>$path.$directory.'/default.php',
						"conteudo"=>$conteudo
				)));
			}
		}else{
			exit(json_encode(array(
				"sucess"=>false,
				"msg"=>'Não foi possível fazer Upload, contate o desenvolvimento.',
				"path"=>$path.$directory.'/default.php',
				"conteudo"=>$conteudo
			)));
		}
	}else{
		exit(json_encode(array(
			"success"=>false,
			"msg"=>'Por favor, insira apenas imagem .jpg ou .png',
			"path"=>$path.$directory.'/default.php',
			"conteudo"=>$conteudo
		)));
	}
?>