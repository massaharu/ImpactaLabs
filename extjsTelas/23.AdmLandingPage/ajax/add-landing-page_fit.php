<?php 
	# @AUTOR = massaharu #
	# @AUTOR = Jvalezzi #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
	$directory = utf8_decode(post('directory-name'));
	$idunidade = post('unidade-landing-page-name');
	//$path = $_SERVER['DOCUMENT_ROOT']."teste/adm-landing-page/landing-page/";
	$path = "\\\\calibra\\fit$\\landing-page\\";
	$path_full = $path.$directory."/img";
	$title_landing_page = utf8_decode(post('title-landing-page-name'));

	$file = $_FILES['imagem'];
	$name_file = utf8_decode($file['name']);

	//verificar se essa pastas já existe, se sim fazer algo para não sobrescrever a outra
	//criar diretório
	if(!is_dir($path_full)){
		mkdir($path_full, 0777, true);
	}

	//upload da img
	if($file['type'] == "image/jpeg" || $file['type'] == "image/png"){
		if(move_uploaded_file($file['tmp_name'], $path_full.'/'.$name_file)){

			//gravar no banco as informações - nome do arquivo, caminho completo com o nome do arquivo
			$LandingPage = new LandingPage(array(
				"desdiretorio" => $directory ,
				"desnomearquivo" => $name_file, 
				"deslandingpage" => $title_landing_page ,
				"idunidade" => $idunidade ,
				"instatus" => "1" ,
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


				script


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