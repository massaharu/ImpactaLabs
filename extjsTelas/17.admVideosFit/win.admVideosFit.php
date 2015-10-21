<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false; $GLOBALS['FALSE'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript" src="../../labs/Massaharu/extjsTelas/17.admVideosFit/js/ FileUploadField.js"></script>
<script type="text/javascript">
	Ext.onReady(function(){

		
								 
		var storevideos = new Ext.data.JsonStore({
			url:'/simpacweb/modulos/fit/adm_videos/json/videos_list.php',
			root:'myData',
			fields:[{name:'desvideotipo', type:'string'},
					{name:'idvideotipo', type:'int'},
					{name:'idvideo', type:'int'},
					{name:'destitulo',type:'string'},
					{name:'desvideo', type:'string'},
					{name:'desurl', type:'string'},
					{name:'instatus',type:'bit'},
					{name:'dtcadastro',type:'date',dateFormat:'timestamp'}],
			autoLoad:true
		});	
		
		var storevideostipos = new Ext.data.JsonStore({
			url:'/simpacweb/modulos/fit/adm_videos/json/videostiposbyinstatus_list.php',
			root:'myData',
			fields:[{name:'desvideotipo', type:'string'},
					{name:'idvideotipo', type:'int'}],
			autoLoad:true
		});	
		
		//FUNCTIONS
		function youtube_parser(url){
			var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
			var match = url.match(regExp);
			if (match&&match[7].length==11){
				return match[7];
			}else{
				return false;
			}
		}
		
		function fn_status(v){	
			if(v == true){
				return '<img src="/simpacweb/images/ico/16/accept.png"/>';
			}else{
				return '<img src="/simpacweb/images/ico/16/remove.png"/>';
			}														  
		}		
//////////////////////////////////////////////////////////////////////////////////////////////////
		var relatoriovideos = new Ext.Panel({
			id:'panelrelatoriovideos', 
			height:580,
			width:700,
			border:false,
			items: [{
				xtype: "panel",
				border: false,
				padding: 5,
				height: 250,
				items: [/*{
					xtype: "panel",
					border: false,
					style: "margin: -40px 0px 0px 0px;",
					layout: "form",
					items: [{
						xtype: "grid",
						id: "grid_tipos",
						width: 300,
						height: 212,
						stripeRows:true,
						autoScroll:true,
						store: tipo_store,
						viewConfig:{
							 forceFit:true,
						 },
						sm: check_cursos,
						columns:[check_cursos, {
							header: 'Tipo',
							dataIndex: 'cursotipo_titulo',
						},{
							header: 'Status',
							width:40
							
						}],
						bbar:[{
							text:'Add/Edit',
							iconCls:'ico_Essen_category',
							menu:[{
								text:'Adicionar',
								iconCls:'ico_add',
								handler:function(){
									var winAddVideosTipos = new Ext.Window({
										title:'Adicionar Tipo do Vídeo',
										id:'idwinaddvideostipos',
										modal:true,
										iconCls:'ico_text_linespacing',
										width:500,
										height:180,
										items:[{
											xtype: 'form',
											id:'formvideostipo',
											padding:15,
											height:140,
											width:490,
											margin:'10',
											border: false,
											buttonAlign:'left',										 
											items:[{
												xtype:'fieldset',
												title:'Cadastrar Tipo do Vídeo',
												autoHeight:true,
												collapsed:false,
												width:'100%',
												height:'100%',
												buttonAlign:'center',
													defaults: {
													xtype: 'textfield',												
												}, 
												items: [{
													fieldLabel: 'Video Tipo',
													id:'addvideotipo',
													name:'videotipo',
													allowBlank:false,
													anchor:'100%'
												}],
												buttons:[{
													text:'Cadastrar',
													iconCls:'ico_add',
													scale:'large',
												}]			
											}]
										}]
									}).show();
								}  
							},{
								text:'Editar',
								iconCls:'ico_add',
								handler:function(){
									var winEditVideosTipos = new Ext.Window({
										title:'Editar Tipo do Vídeo',
										id:'idwineditvideostipos',
										modal:true,
										iconCls:'ico_text_linespacing',
										width:400,
										height:500,
									}).show();
								}
							}]
						}]
					}]
				},*/ {
					xtype: 'form',
					id:'formvideos',
					padding: 15,
					height:300,
					width:675,
					margin:'10',
					border: false,
					buttonAlign:'left',										 
					items:[{
						xtype:'fieldset',
						title:'Cadastrar Vídeo',
						autoHeight:true,
						collapsed:false,
						width:'100%',
						height:'100%',
						buttonAlign:'center',
							defaults: {
							xtype: 'textfield',												
						}, 
						items: [{
							fieldLabel: 'Titulo *',
							id:'addvideotitulo',
							name:'videotitulo',
							allowBlank:false,
							anchor:'100%'
						},{
							fieldLabel: 'Descrição',
							id:'adddescricaotitulo',
							name:'videodescricao',
							anchor:'100%'
						},{
							fieldLabel: 'Link do Vídeo *',
							id:'addvideolink',
							name:'videolink',
							anchor:'100%',
							emptyText:'Ex: http://www.youtube.com/watch?v=_yYCDUbcvWg',
							allowBlank:false
						},{
							fieldLabel: 'Tipo de Vídeo *',	
							xtype:'combo',
							editable:false,
							id:'idcombovideotipo',
							autoHeight:true,
							store:storevideostipos,
							displayField:'desvideotipo',
							valueField:'idvideotipo',
							typeAhead:true,
							triggerAction:'all',
							lazyRender:true,
							allowBlank:false,
							mode:'local',
							emptyText:'Selecione para qual página do site o vídeo será vinculado...',
							anchor:'100%'
						}],
						buttons:[{
							text:'Cadastrar',
							iconCls:'ico_add',
							scale:'large',
							handler:function(){
								if(Ext.getCmp('formvideos').getForm().isValid()){
									if(youtube_parser(Ext.getCmp('addvideolink').getValue())){
										Ext.getCmp('formvideos').getForm().submit({
											url:'/simpacweb/modulos/fit/adm_videos/ajax/videos_save.php',
											params:{
												idvideotipo:Ext.getCmp('idcombovideotipo').getValue()
											},
											success:function(){
												Ext.getCmp('gridvideos').getStore().reload({
													callback:function(){
														Ext.MessageBox.info('',Ext.getCmp('addvideotitulo').getValue()+' Adicionado!',function(btnok){
															if(btnok == 'ok'){
																Ext.getCmp('formvideos').getForm().reset();
															}
														});	
													}	
												});
											}
										})
									}else{
										Ext.MessageBox.warning('Aviso!','URL inválida!<br />'+
																	'Padrões aceitos: <br /><br />'+
																	'www.youtube.com/watch?v=0zM3nApSvMg&feature=feedrec_grec_index<br />'+
																	'www.youtube.com/user/IngridMichaelsonVEVO#p/a/u/1/QdK8U-VIH_o<br />'+
																	'www.youtube.com/v/0zM3nApSvMg?fs=1&amp;hl=en_US&amp;rel=0<br />'+
																	'www.youtube.com/watch?v=0zM3nApSvMg#t=0m10s<br />'+
																	'www.youtube.com/watch?v=0zM3nApSvMg')
									}
								}else{
									Ext.MessageBox.warning('Aviso!','Preecha todos os campos obrigatórios.')
								}
							}
						}]			
					}]
				}]
			},{
				xtype:'panel',
				id:'panelgridvideos',
				border: false,
				style:'margin-top:-35px',
				padding: 20,
				height: 290,
				autoScroll:true,
				items: [{
					xtype:'editorgrid',
					id:'gridvideos',
					store:storevideos,
					loadMask:true,
					stripeRows:true,
					autoScroll:true,
					border:false,
					height:250,
					viewConfig:{
						 forceFit:true,
						 getRowClass:function(record, rowIndex, rp, ds){
							 var _class = record.get('instatus');
							 if (!_class){
								 return 'red';
							 }else{
								 return 'black';
							 }
						 }
					 },
					sm: new Ext.grid.RowSelectionModel({
					 singleSelect: true,
					}),
					cm:new Ext.grid.ColumnModel({
						columns:[new Ext.grid.RowNumberer({
							width:30,
							header:'nº',
						}),{
							header:'idvideo',
							width:200,
							sortable:true,
							hidden:true,
							dataIndex:'idvideo',
						},{
							header:'idvideotipo',
							width:200,
							sortable:true,
							hidden:true,
							dataIndex:'idvideotipo',
						},{ 
							header:'Titulo',
							width:200,
							sortable:true,
							dataIndex:'destitulo',
							editor: new Ext.form.TextField({
								AllowBlank: false,							  
							})
						},{ 
							header:'Tipo',
							sortable:true,
							dataIndex:'desvideotipo',
							editor: new Ext.form.ComboBox({
								editable:false,
								id:'ideditorcombovideotipo',
								store:storevideostipos,
								displayField:'desvideotipo',
								valueField:'idvideotipo',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								allowBlank:false,
								listeners:{
									'select': function(){
										console.log(Ext.getCmp('ideditorcombovideotipo').getValue())
									}
								}
							})
						},{ 
							header:'Descrição',
							sortable:true,
							dataIndex:'desvideo',
							editor: new Ext.form.TextField({
								AllowBlank: false,							  
							})
						},{
							header:'URL',
							sortable:true,
							dataIndex:'desurl',
							editor: new Ext.form.TextField({
								AllowBlank: false,							  
							})
						},{
							xtype:'datecolumn',
							header:'Data de Cadastro',
							sortable:true,
							dataIndex:'dtcadastro',
							format:'d/m/Y h:i',
						},{
							header:'Status',
							sortable:true,
							width:50,
							dataIndex:'instatus',
							renderer:fn_status
						}],
					}),
					listeners:{					
						afteredit: function(e){	
							Ext.Ajax.request({ 
								  url:'/simpacweb/modulos/fit/adm_videos/ajax/videos_update.php',
								  params:{
									 idvideo:e.record.get('idvideo'),
									 idvideotipo:e.record.get('idvideotipo'),
									 videotitulo:e.record.get('destitulo'),
									 videodescricao:e.record.get('desvideo'),
									 videolink:e.record.get('desurl')
								  },			
								  success:function(){
									 e.record.commit();
								}
							});	
						},
						'click':function(){
							if(Ext.getCmp('gridvideos').getSelectionModel().getSelected()){
								Ext.getCmp('btnremovervideo').enable();
								Ext.getCmp('btnstatusvideo').enable();
							}else{
								Ext.getCmp('btnremovervideo').disable();
								Ext.getCmp('btnstatusvideo').disable();
							}
						},			
					},
					tbar:[{					
						text:'Deletar',
						iconCls:'ico_delete',
						tooltip:'O video será apagado permanentemente.',
						id:'btnremovervideo',
						disabled:true,
						handler:function(){
							if(!Ext.getCmp('gridvideos').getSelectionModel().getSelected()){
									Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar um vídeo para deletar.');
							}else{					
								Ext.MessageBox.confirm('Confirmação', 'Deseja realmente deletar '+Ext.getCmp('gridvideos').getSelectionModel().getSelected().get('desvideo')+' ?',
								function(btn){
									if(btn=='yes'){
										Ext.Ajax.request({
											url: '/simpacweb/modulos/fit/adm_videos/ajax/videos_delete.php',
											params:{ 
												idvideo:Ext.getCmp('gridvideos').getSelectionModel().getSelected().get('idvideo'),
											},
											success:function(){
												Ext.getCmp('gridvideos').getStore().reload({
													callback:function(){
														Ext.MessageBox.info('',Ext.getCmp('gridvideos').getSelectionModel().getSelected().get('desvideo')+' deletado!');	
													}	
												});
											},
										});
									}
								});									
							}
						}
					},{
						text:' Alterar Status',
						id:'btnstatusvideo',
						tooltip:'O vídeo deixará de ser exibido no site',
						iconCls:'ico_arrow_rotate_clockwise',
						disabled:true,
						handler:function(){		
							var rec = Ext.getCmp('gridvideos').getSelectionModel().getSelected();
							var status = (!rec.get('instatus'));
							Ext.Ajax.request({
								url:'/simpacweb/modulos/fit/adm_videos/ajax/videos_instatus.php',
								params:{											
									idvideo:Ext.getCmp('gridvideos').getSelectionModel().getSelected().get('idvideo')
								},
								success:function(){
									rec.set('instatus', status);
									rec.commit();
								}
							})
						}
					},'->',{
						xtype:'combo',
						width:120,
						editable:false,
						id:'idcombovideotipo2',
						autoHeight:true,
						store:storevideostipos,
						displayField:'desvideotipo',
						valueField:'idvideotipo',
						typeAhead:true,
						triggerAction:'all',
						lazyRender:true,
						allowBlank:false,
						emptyText:'Pesquisar pelo tipo do vídeo',
						listeners:{
							'select':function(){
								storevideos.filter('idvideotipo', this.getValue(), false, false);
							}
						}
					},{
						text:'',
						iconCls:'ico_search',
						tooltip:'Ver Todos',
						handler:function(){
							Ext.getCmp('gridvideos').getStore().reload();
						}
					}]
				}]
			}]
		});
		
		var visualizacaovideos = new Ext.Panel({
			id:'panelvisualizacaovideos', 
			height:520,
			width:700,
			border:false,
			autoScroll:true,
			tbar:['->',{
				xtype:'combo',
				width:120,
				editable:false,
				id:'idcombovideotipo3',
				autoHeight:true,
				store:storevideostipos,
				displayField:'desvideotipo',
				valueField:'idvideotipo',
				typeAhead:true,
				triggerAction:'all',
				lazyRender:true,
				allowBlank:false,
				emptyText:'Pesquisar pelo tipo do vídeo',
				listeners:{
					'select':function(){
						var videotiposearch = this.getValue()
							
						$.ajax({
							url:"/simpacweb/modulos/fit/adm_videos/json/videos_list.php",
							type:"POST",
							dataType:'json',
							data:{
							},
							success:function(response){
								var content, style, url, img;
								$('#panelvisualizacaovideos').children().find('.x-panel-body').html('');
								
								$('#panelvisualizacaovideos').children().find('.x-panel-body').prepend('<style type="text/css">'+
											'#contentvideos:hover {'+
												'height: 100%;'+
												'opacity: 0.6;'+
											'	-moz-opacity: 0.6;'+
												'filter: alpha(opacity=60);'+
											'}'+
											'#contentvideos{'+
												'-webkit-transition: all 0.3s ease-in-out;'+
												'-moz-transition: all 0.3s ease-in-out;'+
												'transition: all 0.3s ease-in-out;'+
												'line-height: 132px;'+
											'}'+
											'#panelvisualizacaovideos .x-panel-body{'+
												'background-color:#DDE5EE'+
											'}'+
										'</style>');
		
								$.each(response.myData, function(){
									if(videotiposearch == this.idvideotipo){
										videoId = youtube_parser(this.desurl);
										img = 'http://img.youtube.com/vi/'+videoId+'/1.jpg';
										
										var $tooltip;
										if(this.desvideo && this.desvideo != ""){
											$tooltip = this.desvideo;
										}else{
											$tooltip = this.destitulo;
										}
										
										content = ('<a href="http://www.youtube.com/watch?v='+videoId+'" title="'+$tooltip+'" target="_blank" style="float:left;text-align:center;">'+
														'<div id="contentvideos" style="background-image: url('+img+');height: 120px;width: 160px;position: relative;margin: 5px;background-repeat: no-repeat;background-size: 100%;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;">'+
														'</div>'+
														'<div style="max-width:170px;width:170px;height:70px;"><span style="font-family: \'Trebuchet MS\', Arial, Helvetica, sans-serif;text-shadow: 0px 2px 2px rgba(16, 16, 17, .7);">'+
															'<b>'+this.desvideotipo+' <br /> "'+this.destitulo+'"</b>'+
														'</span></div>'+
													'</a>');
										$('#panelvisualizacaovideos').children().find('.x-panel-body').append(content);
										//console.log(youtube_parser(this.desurl));
									}
								})
								
							}
						});
					}
				}
			}],
			
		});
		
		var mainWin = new Ext.Window({
			title:'Administrativo de Videos (FIT)',		
			iconCls:'ico_aluno',
			height: 580,
			width: 710,
			modal:true,
			resizable: false,
			minimizable:true,
			items:new Ext.TabPanel({
				id:'idtabpanel',							 
				activeTab: 1,
				height:548,
				border:false,
				tabPosition:'bottom',
				autoScroll:false,
				items:[{
					title:'Visualização',
					items:[visualizacaovideos],
					listeners:{
						activate:function(){	
							$.ajax({
								url:"/simpacweb/modulos/fit/adm_videos/json/videos_list.php",
								type:"POST",
								dataType:'json',
								data:{
								},
								success:function(response){
									var content, url, img;
									$('#panelvisualizacaovideos').children().find('.x-panel-body').html('');
									
									$('#panelvisualizacaovideos').children().find('.x-panel-body').prepend('<style type="text/css">'+
											'#contentvideos:hover {'+
												'height: 100%;'+
												'opacity: 0.6;'+
											'	-moz-opacity: 0.6;'+
												'filter: alpha(opacity=60);'+
											'}'+
											'#contentvideos{'+
												'-webkit-transition: all 0.3s ease-in-out;'+
												'-moz-transition: all 0.3s ease-in-out;'+
												'transition: all 0.3s ease-in-out;'+
												'line-height: 132px;'+
											'}'+
											'#panelvisualizacaovideos .x-panel-body{'+
												'background-color:#DDE5EE'+
											'}'+
										'</style>');
			
									$.each(response.myData, function(){
										videoId = youtube_parser(this.desurl);
										
										var $tooltip;
										if(this.desvideo && this.desvideo != ""){
											$tooltip = this.desvideo;
										}else{
											$tooltip = this.destitulo;
										}
										
										img = 'http://img.youtube.com/vi/'+videoId+'/1.jpg';
										
										content = ('<a href="http://www.youtube.com/watch?v='+videoId+'" title="'+$tooltip+'" target="_blank" style="float:left;text-align:center;">'+
														'<div id="contentvideos" style="background-image: url('+img+');height: 120px;width: 160px;position: relative;margin: 5px;background-repeat: no-repeat;background-size: 100%;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;">'+
														'</div>'+
														'<div style="max-width:170px;width:170px;height:70px;"><span style="font-family: \'Trebuchet MS\', Arial, Helvetica, sans-serif;text-shadow: 0px 2px 2px rgba(16, 16, 17, .7);">'+
															'<b>'+this.desvideotipo+' <br /> "'+this.destitulo+'"</b>'+
														'</span></div>'+
													'</a>');
										$('#panelvisualizacaovideos').children().find('.x-panel-body').append(content);
										console.log(youtube_parser(this.desurl));	
									})
									
								}
							});
							
							
							
						}
					}
				},{
					title:'Cadastro',
					layout: "table",
					border:false,
					items:[relatoriovideos],
				}]
			})
		}).show();
	});
</script>