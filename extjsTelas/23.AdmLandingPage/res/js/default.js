window.FormDataCompatibility = (function() {

  function FormDataCompatibility() {
    this.fields = {};
    this.boundary = this.generateBoundary();
    this.contentType = "multipart/form-data; boundary=" + this.boundary;
    this.CRLF = "\r\n";
  }

  FormDataCompatibility.prototype.append = function(key, value) {
    return this.fields[key] = value;
  };

  FormDataCompatibility.prototype.setContentTypeHeader = function(xhr) {
    return xhr.setRequestHeader("Content-Type", this.contentType);
  };

  FormDataCompatibility.prototype.contentType = function() {
    var contentType;
    return contentType = "multipart/form-data; boundary=" + this.boundary;
  };

  FormDataCompatibility.prototype.generateBoundary = function() {
    return "AJAX--------------" + ((new Date).getTime());
  };

  FormDataCompatibility.prototype.buildBody = function() {
    var body, key, parts, value, _ref;
    parts = [];
    _ref = this.fields;
    for (key in _ref) {
      value = _ref[key];
      parts.push(this.buildPart(key, value));
    }
    body = "--" + this.boundary + this.CRLF;
    body += parts.join("--" + this.boundary + this.CRLF);
    body += "--" + this.boundary + "--" + this.CRLF;
    return body;
  };

  FormDataCompatibility.prototype.buildPart = function(key, value) {
    var part;
    if (typeof value === "string") {
      part = "Content-Disposition: form-data; name=\"" + key + "\"" + this.CRLF + this.CRLF;
      part += value + this.CRLF;
    } else {
      part = "Content-Disposition: form-data; name=\"" + key + "\"; filename=\"" + value.fileName + "\"" + this.CRLF;
      part += "Content-Type: " + value.type + this.CRLF + this.CRLF;
      part += value.getAsBinary() + this.CRLF;
    }
    return part;
  };

  return FormDataCompatibility;

})();

Array.prototype.unset = function(value) {
    if(this.indexOf(value) != -1) { // Make sure the value exists
        this.splice(this.indexOf(value), 1);
    }   
}
//////////////////////////////////////////////////////////////////////////////
$(function(){
	//GLOBALS
	var PINICIAL = [];
	var PFINAL = [];
	var ARR_OBJLINKCOORDS = [];
	var DIRETORIO = "";
	var IMG_NAME = "";
	var ISEXECUTED = false;
	
	var LinkCoords = new LinkCoords();
	
	//OBJECTS	
	function LinkCoords(){
		var self = this;
		var pinicialx;
		var pinicialy;
		var pfinalx;
		var pfinaly;
		var _link;
		
		self.construct = function(args){
			
			self.eraseInstancia();
			
			pinicialx = args.pinicialx;
			pinicialy = args.pinicialy;
			pfinalx = args.pfinalx;
			pfinaly = args.pfinaly;
			_link = args._link;
		}
		
		self.getInstancia = function(){
			return {
				'pinicialx' : pinicialx,
				'pinicialy' : pinicialy,
				'pfinalx' : pfinalx,
				'pfinaly' : pfinaly,
				'_link' : _link
			};
		}
		
		self.listLinkCoords = function(arr){
			
			self.eraseInstancia();
			
			var arr_linkcoords = [];
			
			$.each(arr, function(){
				pinicialx = this.pinicialx;
				pinicialy = this.pinicialy;
				pfinalx = this.pfinalx;
				pfinaly = this.pfinaly;
				_link = this._link;
				
				arr_linkcoords.push(self.getInstancia());
			});
			
			return arr_linkcoords;
		}
		
		self.eraseInstancia = function(){
			pinicialx = "";
			pinicialy = "";
			pfinalx = "";
			pfinaly = "";
			_link = "";
		}
	}
	
	//FUNCTIONS
	function responsiveHeight(divElement){
		
		//executar somente na primeira vez que carregar a página
		if(ISEXECUTED == false){
			var screenHeight = screen.height - 126;
			var divHeight = $(divElement).height();
			
			var $height = $(window).height() - (screenHeight - divHeight);
			
			$(window).resize(function(){
				
				$height = $(window).height() - (screenHeight - divHeight);
				$(divElement).css({
					'max-height' : $height+'px',
					'height' : $height+'px'
				});
			});
			
			$(divElement).css({
				'max-height' : $height+'px',
				'height' : $height+'px'
			});
		}
		
		ISEXECUTED = true;
	}
	
	function fn_getTimeStringFormated(data){ //Por parametro passa-se um objeto Data
	
		if(data.getDate() < 10){
			dataRetorno = "0"+data.getDate()+"/".toString();
		}else{			
			dataRetorno = data.getDate()+"/".toString();
		}
		
		if(data.getMonth() < 9){
			dataRetorno+= "0"+(data.getMonth()+1)+"/".toString();
		}else{
			dataRetorno+= (data.getMonth()+1)+"/".toString();
		}
		
		dataRetorno+= data.getFullYear()+" ";
		
		if(data.getHours() < 10){
			dataRetorno+= "0"+(data.getHours())+":".toString();
		}else{
			dataRetorno+= (data.getHours())+":".toString();
		}
		
		if(data.getMinutes() < 10){
			dataRetorno+= "0"+(data.getMinutes())+":".toString();
		}else{
			dataRetorno+= (data.getMinutes())+":".toString();
		}
		
		if(data.getSeconds() < 10){
			dataRetorno+= "0"+(data.getSeconds()).toString();
		}else{
			dataRetorno+= (data.getSeconds()).toString();
		}
		
		return dataRetorno;
	}
	
	function validaComponente(idcomponente, idlabelcomponente, focar){
		var valor = $(idcomponente).val();
		var retorno = false;
		if(valor == ""){
			$(idcomponente).css({
				"color":"#CF0000",
				"border-color":"#CF0000"
			});
			$(idlabelcomponente).css("color","#CF0000");
			if(focar){
				$(idcomponente).focus();
			}
			retorno = false;
		}else{
			$(idcomponente).css({
				"color":"#555",
				"border-color":"rgb(209, 205, 205)"
			});
			$(idlabelcomponente).css("color","#555");
			retorno = true;
		}
		
		return retorno;
	}
	
	function validaExpressaoComponente(idcomponente, idlabelcomponente, expressao, focar){
		var valor = $(idcomponente).val();
		retorno = false;
		if(valor.match(expressao)){
			$(idcomponente).css({
				"color":"#007C00",
				"border-color":"#007C00"
			});
			$(idlabelcomponente).css("color","#007C00");
			retorno = true;
		}else{
			$(idcomponente).css({
				"color":"#CF0000",
				"border-color":"#CF0000"
			});
			$(idlabelcomponente).css("color","#CF0000");
			retorno = false;
			//alert('Digite no mínimo 3 letras e somente números, letras, - , _' );
	
			if(focar){
				//$(idcomponente).focus();
			}
		}
		return retorno;
	}
	
	//Função de Regra de 3	
	function r3(total, a){
		return (a*100)/total;
	}
	
	function fn_positionXYGet($event, selectArea){
		if (!$event.offsetX){
			 $event.offsetX = $event.originalEvent.layerX - $($event.originalEvent.target).position().left;
		}
		if (!$event.offsetY){
			 $event.offsetY = $event.originalEvent.layerY - $($event.originalEvent.target).position().top;
		}
		
		var offset = {
			x: $event.offsetX,
			y: $event.offsetY
		}
		
		var x = r3(selectArea.width(), offset.x);
		var y = r3(selectArea.height(), offset.y);
		
		//console.log("p1:["+x+", "+y+"]");
		
		return [x, y];
	}
	
	/*function fn_eraseDialogFields(){
		$( "#dialog-message #pinicialx-name" ).val(""), 
		$( "#dialog-message #pinicialy-name" ).val(""), 
		$( "#dialog-message #pfinalx-name" ).val(""), 
		$( "#dialog-message #pfinalx-name" ).val(""), 
		$( "#dialog-message #link-name" ).val("")
	}*/
	
	function fn_resetDialogFieldsProperties(args){
		$.each(args, function(){
			$(this.label).css('color' , '#555');
			$(this.elementid).css({
				'border-color' : 'rgb(209, 205, 205)',
				'color' : '#555'
			});
		})
	}
	
	//Carrega as unidades na combo unidade
	function fn_loadUnidades(args){
		$.ajax({
			url: 'json/unidades_list.php',
			type: 'POST',
			dataType: 'json',
			success: function(retorno){
				var unidade = "";
				
				unidade += '"<option value="">Selecione uma unidade</option>';
				
				$.each(retorno.myData, function(a,b){
					unidade += '<option value="'+this.idunidade+'">'+this.desunidade+'</option>';
				});
				
				switch(args.form){
					case 1:
						$(args.unidadefieldid).html(unidade); break;
					case 2:
						$(args.unidadefieldid).html(unidade).val(args.idunidade);
						break;		
				}
			}
		});
	}
	
	//Caixa de diálogo que salva as coordenadas dos links adicionados à landing page
	function fn_callDialog(args){
		
		fn_resetDialogFieldsProperties([{
				label		: '#label-link-name',
				elementid	: '#link-name'
			},{
				label		: '#label-pinicialx-name',
				elementid	: '#pinicialx-name'
			},{
				label		: '#label-pinicialy-name',
				elementid	: '#pinicialy-name'
			},{
				label		: '#label-pfinalx-name',
				elementid	: '#pfinalx-name'
			},{
				label		: '#label-pfinalx-name',
				elementid	: '#pfinalx-name'
		}]);
		
		//Carrega a lista de links com as coordenadas a serem salvas no arquivo
		var $tr = "";
		$.each(LinkCoords.listLinkCoords(ARR_OBJLINKCOORDS), function(i){
			$tr += (
				'<div class="link-coord-list-item">'+
					'<button type="button" class="close unset-coord-link" data-dismiss="modal" array-index="'+i+'">×</button>'+
					'<table>'+
						'<tr>'+
							'<td><p><span class="coord-label">Pos. Inicial X: </span>'+this.pinicialx+'</p></td>'+
							'<td><p><span class="coord-label">Pos. Inicial Y: </span>'+this.pinicialy+'</td>'+
						'</tr>'+
						'<tr>'+
							'<td><p><span class="coord-label">Pos. Final X: </span>'+this.pfinalx+'</p></td>'+
							'<td> <p><span class="coord-label">Pos. Final Y: </span>'+this.pfinaly+'</p></td>'+
						'</tr>'+
						'<tr>'+
							'<td colspan="2"><p><span class="coord-label">Link: </span><a href="'+this._link+'">'+this._link+'</a></p></td>'+
						'</tr>'+
					'</table>'+
				'</div>'			 
			);
		});		
		$('#link-coord-list').html($tr);
		
		//Evento que retira um marcação de link
		$('.unset-coord-link').off('click');
		$('.unset-coord-link').on('click', function(){
			$this = $(this);
			
			$($this.parent()).animate({
				marginLeft: "1.6in",
				opacity: 0
			}, 500, "linear", 
			function() {
				
				$this.parent().remove();
				var $arr_index = $this.attr('array-index');
				
				//Remove um elemento da lista
				ARR_OBJLINKCOORDS.splice($arr_index, 1);
				
				//Reconstrói os indexes dos elementos de acordo com o array : ARR_OBJLINKCOORDS
				$.each($('.link-coord-list-item .unset-coord-link'), function(i){
					$(this).attr('array-index', i);
				});
			});
		});
		
		//Configuração dos botões do Dialog
		if(args.editable){
			$('#link-coord-form').css({'display' : 'block'});
			
			var $height = args.height;
			var $buttons = {
				Salvar: function(){
					
					var $link = validaComponente('#link-name', '#label-link-name', true);
					var $pinicialx = validaComponente('#pinicialx-name', '#label-pinicialx-name', true);
					var $pinicialy = validaComponente('#pinicialy-name', '#label-pinicialy-name', true);
					var $pfinalx = validaComponente('#pfinalx-name', '#label-pfinalx-name', true);
					var $pfinaly = validaComponente('#pfinaly-name', '#label-pfinaly-name', true);
					
					if($link && $pinicialx && $pinicialy && $pfinalx && $pfinaly){
					 
						LinkCoords.construct({
							pinicialx: $( "#dialog-message #pinicialx-name" ).val(), 
							pinicialy: $( "#dialog-message #pinicialy-name" ).val(), 
							pfinalx: $( "#dialog-message #pfinalx-name" ).val(), 
							pfinaly: $( "#dialog-message #pfinaly-name" ).val(), 
							_link: $( "#dialog-message #link-name" ).val()
						});
						
						
						ARR_OBJLINKCOORDS.push(LinkCoords.getInstancia());
						
						$('#form-landing-page-coords')[0].reset();
						$( this ).dialog( "close" );
					}else{
						alert("Campos inválidos");
					}
				},
				Fechar: function() {
					$('#form-landing-page-coords')[0].reset();
					$( this ).dialog( "close" );
				}
			}
		}else{
			$('#link-coord-form').css({'display' : 'none'});
			
			var $height = args.height;
			var $buttons = {
				Fechar: function(a) {
					$('#form-landing-page-coords')[0].reset();
					$( this ).dialog( "close" );
				}
			}
		}
		
		//Abre a caixa de diálogo
		$( "#dialog-message" ).dialog({
			title: "Inserir Link à marcação : <span style='font-size:17px;'>"+args.title+"</span><br />Diretório: "+args.diretorio,
			modal: true,
			height: $height,
			maxHeight: 514,
			width: 550,
			buttons: $buttons
		});
		
		$('.ui-dialog.ui-widget').css({'z-index' : '999999999'});
		
		$( "#dialog-message #pinicialx-name" ).val(PINICIAL[0]);
		$( "#dialog-message #pinicialy-name" ).val(PINICIAL[1]);
		$( "#dialog-message #pfinalx-name" ).val(PFINAL[0]);
		$( "#dialog-message #pfinaly-name" ).val(PFINAL[1]);
	}
	
	/*var a = $('<div style="width:50px; height:50px; background:black;"><span>Teste</span></div>');
	a.find('span').on('click', function(){
		console.info(100);
	});
	$(document.body).append(a);
	*/
	
	function fn_changeStatus(idlandingpage){
		
		$('#now-loading').css({'display' : '-webkit-box'});
		
		$.ajax({
			url: 'ajax/edit-status.php',
			type: 'POST',
			dataType: 'json',
			data:{
				idlandingpage: idlandingpage
			},
			success: function(retorno){
				
				var $status = (retorno.myData.instatus == 0)? "Desativado" : "Ativado";
				
				$('#now-loading').css({'display' : 'none'});
				fn_loadLandingPages();
				
				alert('A Landing page : '+retorno.myData.deslandingpage+' foi '+$status+' com sucesso.');
			},
			error: function(){
				
				$('#now-loading').css({'display' : 'none'});
			}
		});
	}
	
	//Cria os eventos em tempo de execução
	function fn_createModalEvent(){
		
		//Clicado na imagem
		$('.thumbnails li div.landing-image').click(function(){
			fn_callOpenModal($(this).parent());
		});
		
		//Mapear
		$('.thumbnails li .btn.mapear').click(function(){
			fn_callOpenModal($(this).parent().parent().parent());
		});
		
		//Alterar status
		$('.thumbnails li a.btn.landing-enable').click(function(){
			
			var $idlandingpage = $(this).parent().parent().parent().attr('idlandingpage');
			
			fn_changeStatus($idlandingpage);
		});
		
		//Editar Landing Page
		$('.thumbnails li a.btn.change-img').click(function(){
			var $idlandingpage = $(this).parent().parent().parent().attr('idlandingpage');
			
			fn_callOpenModalEdit($idlandingpage, $(this).parent().parent().parent());
		});
		
		//HOVERING THE THUMBNAIL
		$('div.thumbnail').hover(function(){
			
			$(this).find('.caption').fadeIn();
			//console.log('over')
		}, function(){
			$(this).find('.caption').fadeOut();
			//console.log('out')
		});
	}
	
	function fn_callOpenModal(thumbnail_div){
		
		var $thisParent = thumbnail_div;//$(this).parent();
		var $title = $.trim($thisParent.find('p.landing-title').text());
		var $link = $.trim($thisParent.find('p.landing-link').text());	
		DIRETORIO = $.trim($thisParent.find('p.landing-diretorio').text());	
		IMG_NAME = 	$.trim($thisParent.find('div.landing-image').attr('img_name'));
		var $img = $.trim($thisParent.find('img').attr('src'));	
			
		$('#modal-default .modal-header h4').text($title);	
		$('#modal-default .modal-body div#modal-landing-image img').attr('src',$img);		
		$('#modal-default .modal-body div#modal-landing-description a').attr('href', $link);
		$('#modal-default .modal-body div#modal-landing-description a').text($link);
		
		$('#modal-default').modal('show').css({'width': '800px','margin-left': function () {return -($(this).width() / 2);}})
		
		ARR_OBJLINKCOORDS = [];
		
		//define a área que será selecionável
		$img = $('.modal .modal-body div#modal-landing-image');
		
		$img.selectArea();
		
		$img.on("mousedown", function(event){
			PINICIAL = fn_positionXYGet(event, $(this));
			PFINAL = [0, 0];
		});
		
		$img.on("mouseup", function(event){
			
			PFINAL = fn_positionXYGet(event, $(this));
			
			if(PINICIAL[0] < PFINAL[0] && PINICIAL[1] < PFINAL[1]){
			
				fn_callDialog({
					title: $title,
					diretorio: DIRETORIO,
					height: "auto",
					editable: true
				});
			}else{
				alert("O mapeamento deve ser feito de cima para baixo, da esquerda para a direita. Obs: Atente-se para não soltar o botão do mouse fora da imagem.");
				return false;
			}
		});
		
		//Abre o dialog de marcação de links apenas para visualização
		$('#modal-ver-links-marcados').off('click');
		$('#modal-ver-links-marcados').on('click', function(){
			if(ARR_OBJLINKCOORDS.length > 0){
				fn_callDialog({
					title: $title,
					diretorio: DIRETORIO,
					height: "auto",
					editable: false
				});
			}else{
				alert("Nenhum Link ainda foi configurado para esta landing page.");
			}
		});
	}
	
	function fn_callOpenModalEdit(idlandingpage, thumbnail_div){
		
		var $thisParent = thumbnail_div;//$(this).parent();
		var $idlandingpage = $thisParent.attr('idlandingpage');
		var $title = $.trim($thisParent.find('p.landing-title').text());
		var $link = $.trim($thisParent.find('p.landing-link').text());	
		DIRETORIO = $.trim($thisParent.find('p.landing-diretorio').text());	
		IMG_NAME = 	$.trim($thisParent.find('div.landing-image').attr('img_name'));
		var $img = $.trim($thisParent.find('img').attr('src'));	
		
		$('#modal-default-edit .modal-header h4').text($title);		
		$('#modal-default-edit #directory-edit').val(DIRETORIO);
		$('#modal-default-edit #title-landing-page-edit').val($title);
		$('#modal-default-edit #idlandingpage-hidden-edit').val($idlandingpage);
		
		fn_loadUnidades({
			form : 2,
			unidadefieldid : '#unidade-landing-page-edit',
			idunidade : $thisParent.attr('idunidade'),
		});
		
		//console.log($thisParent.attr('idunidade'), $thisParent.find('p.landing-diretorio').text());
		
		$('#modal-default-edit').modal('show');
	}
	
	function fn_loadLandingPages(){
		//CARREGA AS LADING PAGES
		$('#now-loading').css({'display' : '-webkit-box'});
		
		$.ajax({
			url: 'json/landing-pages_list.php',
			type: 'POST',
			dataType: 'json',
			success: function(retorno){
				
				var $landing_page = "";
				
				var $landingpages_fit_ativas = "";
				var $landingpages_fit_desativas = "";
				var $landingpages_treinamentos_ativas = "";
				var $landingpages_treinamentos_desativas = "";
				
				if(retorno.success){
					$.each(retorno.myData, function(a,b){
						
						var $btn_class = "";
						var $btn_ico = "";
						var $btn_alt = "";
						var $link = "";
						
						//Se ativo
						if(this.instatus){ 
							$btn_class = "danger"; 
							$btn_alt = "Desativar";
							$btn_ico = "icon-arrow-down";
						//Se Inativo
						}else{
							$btn_class = "success";
							$btn_alt = "Ativar";
							$btn_ico = "icon-arrow-up";
						}
						
						//Se Faculdade FIT
						if(this.idunidade == 2){
							$link = "https://www.impacta.edu.br/landing-page/";
						//Se Impacta Treinamentos
						}else if(this.idunidade == 1){
							$link = "http://www.impacta.edu.br/landing-page/";
						}
						
						$landing_page = (
							'<li class="span3">'+
								'<div class="thumbnail" idunidade="'+this.idunidade+'" idlandingpage="'+this.idlandingpage+'">'+
									'<div class="landing-image" img_name="'+this.desnomearquivo+'">'+
										'<img src="'+$link+this.desdiretorio+'/img/'+this.desnomearquivo+'" alt="'+this.deslandingpage+'" />'+
									'</div>'+
									'<div class="line-separator"></div>'+
									'<h5>Título da Landing Page:</h5>'+
									'<p class="landing-title">'+this.deslandingpage+'</p>'+
									'<h5>Nome do Diretório:</h5>'+
									'<p class="landing-diretorio">'+this.desdiretorio+'</p>'+
									'<h5>Link Gerado:</h5>'+
									'<p class="landing-link"><a target="_blank" href="'+$link+this.desdiretorio+'/default.php">'+$link+this.desdiretorio+'/default.php</a></p>'+
									'<h5>Data de Cadastro:</h5>'+
									'<p class="landing-dtcadastro">'+fn_getTimeStringFormated(new Date(this.dtcadastro * 1000))+'</p>'+
									'<div class="line-separator"></div>'+
									'<div class="caption">'+
										'<p>	'+
											'<a href="javascript:void(0)" class="btn btn-'+$btn_class+' landing-enable" alt="'+$btn_alt+'" title="'+$btn_alt+'"><i class="'+$btn_ico+' icon-white"></i></a>'+
											'<a href="javascript:void(0)" class="btn btn-info mapear" id="a12">Mapear</a>'+
											'<a href="javascript:void(0)" class="btn btn-primary change-img">Editar</a>'+
										'</p>'+
									'</div>'+
								'</div>'+
							'</li>'
						);
						
						
						if(this.idunidade == 2)
							//Lista as landing pages na aba FIT ATIVAS
							if(this.instatus == 1)
								$landingpages_fit_ativas += $landing_page;
							//Lista as landing pages na aba FIT DESATIVADAS
							else
								$landingpages_fit_desativas += $landing_page;
						else
							//Lista as landing pages na aba Treinamentos ATIVAS
							if(this.instatus == 1)
								$landingpages_treinamentos_ativas += $landing_page;
							//Lista as landing pages na aba Treinamentos DESATIVAS
							else
								$landingpages_treinamentos_desativas += $landing_page;
					});
					
					$('#landing-page-fit-ativas ul.thumbnails').html($landingpages_fit_ativas);
					$('#landing-page-treinamentos-ativas ul.thumbnails').html($landingpages_treinamentos_ativas);
					$('#landing-page-fit-desativas ul.thumbnails').html($landingpages_fit_desativas);
					$('#landing-page-treinamentos-desativas ul.thumbnails').html($landingpages_treinamentos_desativas);
					
					responsiveHeight(".container.main");
					
					fn_createModalEvent();
					
					$('#now-loading').css({'display' : 'none'});
				}else{
					$('#now_loading').css({'display' : 'none'});
					
					alert('Ocorreu um erro ao listar as landing pages');
				}
			},
			error:function(){
				$('#now-loading').css({'display' : 'none'});
			}
		});
	}
	
	function fn_uploadLandingPage(args){
	
		var params = $(args.form).serializeArray();

		var form = (window.FormData)?new FormData():new FormDataCompatibility();

		$.each(params, function(){
			form.append(this.name, this.value);
		});

		$.each($(args.img).get(0).files, function(){
			form.append('imagem', this);
		});

		//$('#btn-cadastrar-landing').hide();

		var req = new XMLHttpRequest();
		req.onprogress = function(event){
			if(event.lengthComputable){
				var percentComplete = (event.loaded / event.total) * 100;
				console.log('onprogress', percentComplete);
				$(args.progressbar).show().find('.bar').attr('style', 'width: '+percentComplete+'%');
			}
		};
		
		//Se for para a Impacta Treinamentos
		if($(args.unidadeid).val() == 1){
			//req.open('POST', 'ajax/'+args.ajaxfile_treinamentos+'.php', true);
			alert('O módulo para a configuração das landing pages da Impacta Treinamentos ainda está sendo desenvolvido.');
			return false;
			
		//Se for para a Faculdade FIT
		}else if($(args.unidadeid).val() == 2){
			
			req.open('POST', 'ajax/'+args.ajaxfile_fit+'.php', true);
		}
		
		req.onreadystatechange = function(event){
			if(req.readyState == 4){
				$(args.progressbar).hide();
				var result = $.parseJSON(req.responseText);
				
				var mensagem = (result.path != "")? result.path : "";
				
				if(result.success){
					if(args.fromModal){
						$('#modal-default-edit').modal('hide');
					}
					
					$(args.form)[0].reset();			
				}
				
				alert(result.msg+"\n\n\nCaminho: "+mensagem);
				$(args.btnaction).show();
				fn_loadLandingPages();
			}
		};
		var progress = req.upload || req;
		progress.onprogress = function(event){
			var position = event.position || event.loaded;
			var total = event.totalSize ||  event.total;
			var porcent = (position / total) * 100;
			console.log('onprogress', parseInt(porcent));
			//$(args.progressbar).show().find('bar').width(parseInt(porcent)+'%');
			$(args.progressbar).show().find('.bar').attr('style', 'width: '+parseInt(porcent)+'%');

		};
		req.send(form);
	}
	
////////////// EVENTS /////////////////////////////////////////////////////////////////////////

	//ONLOAD
	fn_loadUnidades({
		form : 1,
		unidadefieldid : '#unidade-landing-page'
	});
	
	fn_loadLandingPages();
	
	$('#directory-name').on('blur keyup', function(){
		validaExpressaoComponente("#directory-name", "#label-directory-name", "^([A-Z,a-z,0-9,_,-]){3,100}$", false);
	});
	$('#title-landing-page').on('blur keyup', function(){
		validaComponente("#title-landing-page", "#label-title-landing-page", false);
	});
	$('#unidade-landing-page').on('select', function(){
		validaComponente("#unidade-landing-page", "#label-unidade-landing-page",  false);
	});
	
	$('#file-img, #file-img-edit').on('change', function(){
		if(
			this.files[0].type != "image/jpeg" &&
			this.files[0].type != "image/png"
		){
			$(this).val("");
			alert("Por favor, insira apenas imagem .jpg ou .png");
		}
		validaComponente("#file-img", "#label-file-img", true);
	});
	
	//Ação de cadastrar landing page nova
	$('#btn-cadastrar-landing').on('click', function(){
		if(
			validaExpressaoComponente("#directory-name", "#label-directory-name", "^([A-Z,a-z,0-9,_,-]){3,100}$", true) &&
			validaComponente("#file-img", "#label-file-img", true) &&
			validaComponente("#title-landing-page", "#label-title-landing-page", true) &&
			validaComponente("#unidade-landing-page", "#label-unidade-landing-page", true)
		){
		
			fn_uploadLandingPage({
				form : '#form-landing-page',
				img : '#file-img',
				progressbar : '#progress-bar-landing-page',
				unidadeid : '#unidade-landing-page',
				ajaxfile_fit : 'add-landing-page_fit',
				ajaxfile_treinamentos : 'add-landing-page_treinamentos',
				btnaction: '#btn-cadastrar-landing',
				fromModal:false
			});
			
		}else{
			alert('Dados inválidos, corrija-os e tente novamente');
		}
	});
	
	//Ação de editar uma landing page existente
	$('#btn-cadastrar-landing-edit').on('click', function(){
		
		if(
			validaExpressaoComponente("#directory-edit", "#label-directory-name-edit", "^([A-Z,a-z,0-9,_,-]){3,100}$", true) &&
			validaComponente("#file-img-edit", "#label-file-img-edit", true) &&
			validaComponente("#title-landing-page-edit", "#label-title-landing-page-edit", true) &&
			validaComponente("#unidade-landing-page-edit", "#label-unidade-landing-page-edit", true)
		){
		
			fn_uploadLandingPage({
				form : '#form-landing-page-edit',
				img : '#file-img-edit',
				progressbar : '#progress-bar-landing-page-edit',
				unidadeid : '#unidade-landing-page-edit',
				ajaxfile_fit : 'change-landing-page_fit',
				ajaxfile_treinamentos : 'change-landing-page_treinamentos',
				btnaction: '#btn-cadastrar-landing-edit',
				fromModal:true
			});
			
		}else{
			alert('Dados inválidos, corrija-os e tente novamente');
		}
	});
	
	//Mudar Tabs
	$('#tab-landing-page a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	// $('#data-inicio-trabalho')
	// 		.datepicker({language:'pt'})
	// 		.on('changeDate', function(ev){
	// 			$(this).datepicker('hide');	
	// 		});
	///////////////////////////////////////////////////////////
	
	
	$('#modal-fechar').on('click', function(){
		ARR_OBJLINKCOORDS = [];
	});
	$('#modal-finalizar').on('click', function(){
		//console.log('Salvar', LinkCoords.listLinkCoords(ARR_OBJLINKCOORDS));
		
		$.ajax({
			url: 'ajax/coords-link-save.php',
			dataType: 'json',
            type: 'POST',
            data:{
				link_coords_list: JSON.stringify(LinkCoords.listLinkCoords(ARR_OBJLINKCOORDS)),
				diretorio: DIRETORIO,
				img_name: IMG_NAME
			},
            success: function(retorno){
				
				if(retorno.success){
					ARR_OBJLINKCOORDS = [];
					
					alert('Mapeamento efetuado com sucesso!');
					
					$('#modal-default').modal('hide');
				}else{
					alert('Não há marcações de coordenadas');
				}
			},
			error: function(){
				//alert('Ocorreu um erro, tente novamente');
			}
		});
	});
	
	//TOGGLE MAIN FORM
	$('#toggle-form').on('click', function(){
		var $this = $(this);
		var $ico = $this.find('i');
		var $text = $this.find('span');
		
		//$this.find('i').toggleClass('icon-chevron-down');
		//$this.find('i').toggleClass('icon-chevron-up');
		
		if($ico.hasClass('icon-chevron-down')){
			$ico.removeClass('icon-chevron-down');
			$ico.addClass('icon-chevron-up');
			$text.text('');
			$('#container-form-main').slideDown();
		}else if($ico.hasClass('icon-chevron-up')){
			$ico.removeClass('icon-chevron-up');
			$ico.addClass('icon-chevron-down');
			$text.text('Cadastrar');
			$('#container-form-main').slideUp();
		}else{
			$ico.removeClass('icon-chevron-up');
			$ico.addClass('icon-chevron-down');
			$text.text('');
			$('#container-form-main').slideDown();
		}
	});	
	
	
	
});
