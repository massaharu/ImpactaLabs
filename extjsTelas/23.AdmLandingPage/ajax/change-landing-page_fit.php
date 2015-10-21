<?php 
	# @AUTOR = massaharu #
	# @AUTOR = Jvalezzi #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
	//Functions
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
	
	function myFormatString($string){
		return (string)trim(strtolower($string));
	}
	
	function writeStringToFile($file, $string){
		$f=fopen($file, "wb");
		$file="\xEF\xBB\xBF".$string; // utf8 bom
		fputs($f, $string);
		fclose($f);
	}

	
/////////////////////////////////////////////////////////////////////////////////////////////
	
	$LandingPage = new LandingPage(post('idlandingpage-hidden-name-edit'));
	$path = "\\\\calibra\\fit$\\landing-page\\";
	$file = $_FILES['imagem'];
	
	$directory_new = utf8_decode(post('directory-name-edit'));
	$idunidade_new = post('unidade-landing-page-name-edit');
	$title_landing_page_new = utf8_decode(post('title-landing-page-name-edit'));
	$name_file_new = utf8_decode($file['name']);
	
	$path_full_new = $path.$directory_new."/img";
	
	$directory = (myFormatString($LandingPage->desdiretorio) != myFormatString($directory_new))? $directory_new : $LandingPage->desdiretorio;
	
	$name_file = (myFormatString($LandingPage->desnomearquivo) != myFormatString($name_file_new))? $name_file_new : $LandingPage->desnomearquivo;
	
	$title_landing_page = (myFormatString($LandingPage->deslandingpage) != myFormatString($title_landing_page_new))? $title_landing_page_new :$LandingPage->deslandingpage; 
	
	$idunidade = (myFormatString($LandingPage->idunidade) != myFormatString($idunidade_new))? $idunidade_new : $LandingPage->idunidade;
	
	////////////////// LER CORDENADAS ///////////////////////
	$landing_page = fopen($path.$LandingPage->desdiretorio."/default.php", "r");
	
	$file_content_string = fread($landing_page, filesize($path));
	
	$inicio_pos = (strpos($file_content_string, "{{{")) + 3;
	$final_pos = strpos($file_content_string, "}}}");
	
	$string_code = substr($file_content_string, $inicio_pos, $final_pos-$inicio_pos);
	$string_code = str_replace($LandingPage->desdiretorio, $directory, $string_code);
	fclose($landing_page);
	////////////////////////////////////////////////////////////////
	/*pre(array(
		'path_full_new'=> $path_full_new,
		'directory'=> $directory,
		'name_file'=> $name_file,
		'title_landing_page'=> $title_landing_page,
		'idunidade'=> $idunidade,
	));
	exit();*/
	
	//verificar se essa pastas já existe, se sim fazer algo para não sobrescrever a outra
	//criar diretório
	
	
	//Se diretório for renomeado
	if(trim($LandingPage->desdiretorio) != $directory_new)	{
		//Se NÃO EXISTE o diretório
		if(!is_dir($path.$LandingPage->desdiretorio)){
			exit(json_encode(array(
				"success"=>false,
				"msg"=>'Diretório a ser alterado não existe no servidor.',
				"path"=>$path.$LandingPage->desdiretorio.'/default.php',
				"conteudo"=>""
			)));
		//Se EXISTE o diretório
		}else{
			destroy_dir($path.$LandingPage->desdiretorio);
				
			if(!is_dir($path_full_new)){
				mkdir($path_full_new, 0777, true);
			}
		}
	//Se diretório NÃO for renomeado	
	}else{
		destroy_dir($path.$LandingPage->desdiretorio);
			
		if(!is_dir($path_full_new)){
			mkdir($path_full_new, 0777, true);
		}
	}

	//upload da img
	if($file['type'] == "image/jpeg" || $file['type'] == "image/png"){
		
		if(move_uploaded_file($file['tmp_name'], $path_full_new.'/'.$name_file)){

			$instatus = ($LandingPage->instatus)? $LandingPage->instatus : 0;
			//gravar no banco as informações - nome do arquivo, caminho completo com o nome do arquivo
			$LandingPage = new LandingPage(array(
				"idlandingpage" => $LandingPage->idlandingpage,
				"desdiretorio" => $directory ,
				"desnomearquivo" => $name_file, 
				"deslandingpage" => $title_landing_page ,
				"idunidade" => $idunidade ,
				"instatus" => $instatus
			));
			
			$LandingPage->Save();


			//criar arquivo
			if(!file_exists($path.$directory.'/default.php')){	
				$conteudo = 
'<?php
	require("../../inc/configuration.php");
	$page = new Page(array("path"=>"../../"));
				
	$hierarchy = array(
					array(
						"url" 	=> "/",
						"title" => "Home" 
					),
					array(
						"url" 	=> "",
						"title" => utf8_encode("'.$title_landing_page.'")
					)
				);
?>
	
	<script>
		function r3(total, a){
			return (a*100)/total;
		}

		function check(x, y, link, callback){
			
		  var success = false;
		  
		   if(
			   link.p1[0] <= x && link.p2[0] >= x && 
			   link.p1[1] <= y && link.p2[1] >= y
			){
				success = true;    
			}

			if(success){
			  return link;
			}else{
			  return false;
			}
		}

		$(function(){
	
			{{{


				'.trim($string_code).'


			}}}

			$img.on("click", function(event){
			
				if (!event.offsetX){
					 event.offsetX = event.originalEvent.layerX - $(event.originalEvent.target).position().left;
				}
				if (!event.offsetY){
					 event.offsetY = event.originalEvent.layerY - $(event.originalEvent.target).position().top;
				}
				
				var offset = {
					x: event.offsetX,
					y: event.offsetY
				}
				
				var x = r3($img.width(), offset.x);
				var y = r3($img.height(), offset.y);
			
				//console.log("p0:["+x+", "+y+"]");
			
				$.each(links, function(index, link){
					
					if(check(x, y, link)){
						//console.log(link.href);
						//window.location.href = link.href;
						if(link.href.search("http") == -1 && link.href.search("mailto:") == -1){
							link.href = "http://"+link.href;
						}
						
						window.open(link.href);
					}
				});
			});

			$img.on("mousemove", function(event){
			
				if (!event.offsetX){
					 event.offsetX = event.originalEvent.layerX - $(event.originalEvent.target).position().left;
				}
				if (!event.offsetY){
					 event.offsetY = event.originalEvent.layerY - $(event.originalEvent.target).position().top;
				}
				
				var offset = {
					x: event.offsetX || event.clientX - $(event.target).offset().left,
					y: event.offsetY || event.clientY - $(event.target).offset().top
				}
				
				var x = r3($img.width(), offset.x);
				var y = r3($img.height(), offset.y);

				//console.log("p0:["+x+", "+y+"]");

				var success = false;
				$.each(links, function(index, link){

					if(check(x, y, link)){
						success = true;
					}
				});

				if(success){
					$img.css("cursor", "pointer");
				}else{
					$img.css("cursor", "default");
				}
			});
		});
	</script>
	
	
	<div class="container container-middle"> 
		<div class="row">
		<? require("../../inc/panelleft.php");?>  
			<div class="span9 container-fit-default">
				<div class="row-fluid">
				<? $page->putTitle(utf8_encode("'.$title_landing_page.'"), $hierarchy) ?>
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
						"msg"=>'Landing-page editada com sucesso.',
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
				"success"=>false,
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