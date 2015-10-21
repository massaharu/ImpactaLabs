<?php  
/*@AUTHOR = MASSAHARU, JVALEZZI*/
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['BOOTSTRAP'] = true; //$GLOBALS['JSON'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
topopagina('catalog_256.png', 'Sistema Administrador de Landing Page');
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<title>Form - Upload</title>
		<script src="res/js/default.js"></script>
        <script src="res/js/jquery.selectArea-1.0.js"></script>
		<link rel="stylesheet" href="res/css/default.css" media="screen" />
	</head>
	<body>
    	
    	<div class="container main">
        	<div id="container-form-main">
                <div id="container-form">
                    <form class="form-horizontal" id="form-landing-page">
                        <fieldset>
                            <legend><h1>Criar Landing-page</h1></legend>
                            <div class="control-group">
                                <label class="control-label" for="directory-name" id="label-directory-name">
                                    Nome do Diretório:
                                </label>
                                <div class="controls">
                                    <input type="text" class="input-xxlarge input-height" name="directory-name" id="directory-name" placeholder="ex: nome-diretorio" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="file-img" id="label-file-img">
                                    Arquivo da Imagem:
                                </label>
                                <div class="controls">
                                    <input type="file" name="file-img-name" id="file-img" placeholder="arquivo da imagem" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="title-landing-page" id="label-title-landing-page">
                                    Título da landing-page:
                                </label>
                                <div class="controls">
                                    <input type="text" class="input-xxlarge input-height" name="title-landing-page-name" id="title-landing-page" placeholder="título da landing page" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="unidade-landing-page" id="label-unidade-landing-page">
                                    Unidade:
                                </label>
                                <div class="controls">
                                    <select class="input-xxlarge input-height" name="unidade-landing-page-name" id="unidade-landing-page">
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div id="container-button">
                    <button class="btn btn-large btn-info" id="btn-cadastrar-landing">
                       <img class="img-freq-btns" src="http://www.impacta.edu.br/res/img/professor/save-frequencia.png"> 
                       <span>Salvar</span>
                    </button>
                </div>
                <div class="progress progress-striped active hide" id="progress-bar-landing-page">
                    <div class="bar" style="width: 0%;">
                    
                    </div>
                </div>
            </div>
            <div id="toggle-form">
                <a href="javascript:void(0)"  class="btn btn-large btn-warning" >
                	<i class="icon-chevron-down icon-white"></i><span>  Cadastrar</span>
                </a>
            </div>
			<div class="container tabs">
				<ul class="nav nav-tabs" id="tab-landing-page">
					<li class="active"><a href="#landing-page-fit-ativas">FIT (Ativas)</a></li>
					<li><a href="#landing-page-fit-desativas">FIT (Desativadas)</a></li>
					<li><a href="#landing-page-treinamentos-ativas">Treinamentos (Ativas)</a></li>
					<li><a href="#landing-page-treinamentos-desativas">Treinamentos (Desativadas)</a></li>
				</ul>
				 
				<div class="tab-content">
					<!-- ABA FACULDADE FIT [ATIVAS] --->
					<div class="tab-pane active" id="landing-page-fit-ativas">
						<ul class="thumbnails">
							
						</ul>
					</div>
					<!-- ABA FACULDADE FIT [DESATIVADAS] --->
					<div class="tab-pane " id="landing-page-fit-desativas">
						<ul class="thumbnails">
							
						</ul>
					</div>
					<!-- ABA IMPACTA TREINAMENTOS [ATIVAS] --->
					<div class="tab-pane" id="landing-page-treinamentos-ativas">
						<ul class="thumbnails">
							
						</ul>
					</div>
					<!-- ABA IMPACTA TREINAMENTOS [DEATIVADAS] --->
					<div class="tab-pane" id="landing-page-treinamentos-desativas">
						<ul class="thumbnails">
							
						</ul>
					</div>
				</div>
			</div>
		</div>
<!-- ****************************************   MODAL   **********************************************-->
        <div class="modal hide fade" id="modal-default">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4></h4>
            </div>
            <div class="modal-body">
                <div id="modal-landing-image"><img /></div>
                <div class="line-separator"></div>
                <div id="modal-landing-description"><a target="_blank"></a></div>
            </div>
            <div class="modal-footer">
            	<a href="javascript:void(0)" id="modal-fechar" class="btn btn-inverse" data-dismiss="modal">Fechar</a>
                <a href="javascript:void(0)" id="modal-finalizar" class="btn btn-primary">Finalizar</a>
                <a href="javascript:void(0)" id="modal-ver-links-marcados" class="btn btn-info">Ver Links</a>
            </div>
        </div>
<!-- ****************************************   DIALOG MAPEAR LINK  **********************************************-->
        <div id="dialog-message" title="" class="hide">
          <div id="link-coord-list">
			<div class="link-coord-list-item">
            	<table>
                    <tr>
                        <td><p><span class="coord-label">Pos. Inicial X: </span>4534535</p></td>
                        <td><p><span class="coord-label">Pos. Inicial Y: </span>4534535</td>
                    </tr>
                    <tr>
                        <td><p><span class="coord-label">Pos. Final X: </span>4534535</p></td>
                        <td> <p><span class="coord-label">Pos. Final Y: </span>4534535</p></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p><span class="coord-label">Link: </span>www.impacta.com.br</p></td>
                    </tr>
                </table>
            </div>			         
          </div>
          <div class="line-separator"></div>
          <div id="link-coord-form">
              <form class="form-horizontal" id="form-landing-page-coords">
                    <fieldset>
                        <div class="control-group">
                            <div class="control-group">
                                <label class="control-label" for="pinicialx-name" id="label-pinicialx-name">
                                    Posição Inicial X:
                                </label>
                                <div class="controls">
                                    <input type="text" class="input input-xlarge input-height" name="pinicialx-name" id="pinicialx-name" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="pinicialy-name" id="label-pinicialy-name">
                                    Posição Inicial Y:
                                </label>
                                <div class="controls">
                                    <input type="text" class="input input-xlarge input-height" name="pinicialy-name" id="pinicialy-name" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="pfinalx-name" id="label-pfinalx-name">
                                    Posição Final X:
                                </label>
                                <div class="controls">
                                    <input type="text" class="input input-xlarge input-height" name="pfinalx-name" id="pfinalx-name" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="pfinaly-name" id="label-pfinaly-name">
                                    Posição Final Y:
                                </label>
                                <div class="controls">
                                    <input type="text" class="input input-xlarge input-height" name="pfinaly-name" id="pfinaly-name" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="link-name" id="label-link-name">
                                    Link:
                                </label>
                                <div class="controls">
                                    <input type="text" class="input input-xlarge input-height" name="link-name" id="link-name" placeholder="http://www.impacta.com.br"/>
                                </div>
                            </div>
                        </div>
                    </fieldset>                    
            	</form>  
        	</div>
    	</div>
<!-- ****************************************   MODAL EDITAR LANDING-PAGE **********************************************-->
		<div class="modal hide fade" id="modal-default-edit">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4></h4>
            </div>
            <div class="modal-body-edit">
            	<form class="form-horizontal" id="form-landing-page-edit">
                    <fieldset>
                        <legend>Criar Landing-page</legend>
                        <div class="control-group">
                            <label class="control-label" for="directory-name-edit" id="label-directory-edit">
                                Nome do Diretório:
                            </label>
                            <div class="controls">
                            	<input type="hidden" name="idlandingpage-hidden-name-edit" id="idlandingpage-hidden-edit" />
                                <input type="text" class="input-xlarge input-height" name="directory-name-edit" id="directory-edit" placeholder="nome do diretório" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="file-img-edit" id="label-file-img-edit">
                                Arquivo da Imagem:
                            </label>
                            <div class="controls">
                                <input type="file" name="file-img-name-edit" id="file-img-edit" placeholder="arquivo da imagem" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="title-landing-page-edit" id="label-title-landing-page-edit">
                                Título da landing-page:
                            </label>
                            <div class="controls">
                                <input type="text" class="input-xlarge input-height" name="title-landing-page-name-edit" id="title-landing-page-edit" placeholder="título da landing page" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="unidade-landing-page-edit" id="label-unidade-landing-page-edit">
                                Unidade:
                            </label>
                            <div class="controls">
                                <select class="input-xlarge input-height" name="unidade-landing-page-name-edit" id="unidade-landing-page-edit">
                                	
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div class="progress progress-striped active hide" id="progress-bar-landing-page-edit">
                    <div class="bar" style="width: 0%;">
                    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            	<a href="javascript:void(0)" id="modal-fechar-edit" class="btn btn-inverse" data-dismiss="modal">Fechar</a>
                <a href="javascript:void(0)" id="btn-cadastrar-landing-edit" class="btn btn-primary">Finalizar</a>
            </div>
        </div>
        <!-------------------- MODAL LOADING ---------------------->
        <div id="now-loading">
        	<img src="res/img/now_loading.gif" />
        </div>
	</body>
</html>

