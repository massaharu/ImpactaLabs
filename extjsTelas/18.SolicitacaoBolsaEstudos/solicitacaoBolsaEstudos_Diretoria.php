<?php
#@AUTOR = jvalezzi #
$GLOBALS['menu'] = true; //$GLOBALS['wallpaper'] = true; //$GLOBALS['JSON'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<style type="text/css">
	.x-panel-header{
		display:none;
	}
</style>
<script type="text/javascript">
Ext.onReady(function(){
	//CONSTANTES
	var xt = Ext.getCmp;
	var PERMISSOES = new Array();	
	
	var solicitacaobolsaestudosdiretoria = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/solicitacaobolsaestudosGestorRhDiretoria_list.php',
		root:'myData',
		baseParams:{
			idpermissao: 3
		},
		fields:[{name:'idsolicitacaobolsaestudo', type:'int'},
				{name:'idusuario', type:'int'},
				{name:'idsolicitacaobolsaestudostipo', type:'int'},
				{name:'curso_id', type:'int'},
				{name:'curso_titulo', type:'string'},
				{name:'dessemestre', type:'string'},
				{name:'desjustificativa', type:'string'},
				{name:'NmCompleto', type:'string'},
				{name:'nrpercentual', type:'int'},
				{name:'ingestor', type:'int'},
				{name:'inrh', type:'int'},
				{name:'indiretoria', type:'int'}],
		autoLoad:true
	});	
	
	var solicitacaobolsaestudosusuario = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/solicitacaobolsaestudosusuario_get.php',
		root:'myData',
		fields:[{name:'idusuario', type:'idusuario'},
				{name:'nmcompleto', type:'string'},
				{name:'nrcpf', type:'string'},
				{name:'nmlogin', type:'string'},
				{name:'cdemail', type:'string'},
				{name:'desdepartamento', type:'string'},
				{name:'descargo', type:'string'},
				{name:'idsolicitacaobolsaestudostipo', type:'int'},
				{name:'desnomedependente', type:'string'},
				{name:'desdependentetipo', type:'string'},
				{name:'dtnascimentodependente', type:'string'},
				{name:'nrcpfdependente', type:'string'},
				{name:'desemaildependente', type:'string'},
				{name:'desjustificativa', type:'string'},
				{name:'dtadmissao', type:'string'},
				{name:'dtsolicitacao', type:'string'},
				{name:'dtaprovacaorh', type:'string'}]
	});	
	
	var solicitacaobolsaestudosaprovados = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/solicitacaobolsaestudosaprovados_list.php',
		root:'myData',
		fields:[{name:'idsolicitacaobolsaestudo', type:'int'},
				{name:'idusuario', type:'int'},
				{name:'idsolicitacaobolsaestudostipo', type:'int'},
				{name:'curso_id', type:'int'},
				{name:'curso_titulo', type:'string'},
				{name:'dessemestre', type:'string'},
				{name:'desjustificativa', type:'string'},
				{name:'ingestor', type:'int'},
				{name:'inrh', type:'int'},
				{name:'indiretoria', type:'int'}]
	});	
	
	//EXPANDERS
	var expander = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<p style="margin-left:40px;"><b>Justificativa:</b></br>{desjustificativa}</p>'
        )
    });		
	var expander2 = new Ext.ux.grid.RowExpander({
		tpl : new Ext.Template(
			'<p style="margin-left:60px;"><b>Justificativa:</b></br>{desjustificativa}</p>'
		)
	});	
	
	//LISTA AS PERMISSOES
	$.ajax({
		url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/permissao_list.php',
		type:"POST",
		dataType:'json',
		success:function(response){	
			$.each(response.myData, function(){					
				var $Permissoes = new Object();				
				
					$Permissoes.idpermissao = this.idpermissao;
					$Permissoes.despermissao = this.despermissao;
					
					PERMISSOES.push($Permissoes);
			});
		}
	});
	
	
	
	//FUNCTION
	function fn_solicitacaoStatus(v){
		if(v == 1){
			return '<img src="/simpacweb/images/ico/16/Apply.png" />';
		}else if(v == 0){
			return '<img src="/simpacweb/images/ico/16/cross.png" />';
		}else if(v == 2){
			return '<img src="/simpacweb/images/ico/16/Essen_consulting.png" />';
		}			
	}
	function fn_maskCPF(cpf){
		return cpf.substr(0, 3)+'.'+cpf.substr(3, 3)+'.'+cpf.substr(6, 3)+'-'+cpf.substr(9, 3);
	}
	 
	new Ext.Viewport({
		layout:'border',
		renderTo:'div_solicitacaoBolsaEstudosDIRETORIA',
		id:'viewmport_diretoria',
		items:[{
			region:'north',
			border:false,
			style:'padding-top:27px;',
			html:'<?=topopagina("Gnome-X-Office-Address-Book-64.png","Gerenciamento de Solicitações de Bolsa de Estudos - DIRETORIA");?>'
		},{
			region:'center',
			layout:'fit',
			items:[{
				xtype:'grid',
				id:'gridsolicitacaobolsaestudosdiretoria',
				loadMask:true,
				border:false,
				plugins:expander,
				height:Page.height-128,
				store:solicitacaobolsaestudosdiretoria,
				tbar:[{
					xtype:'displayfield',
					style:'color: #15428B; padding-right:4px;',
					value:'<span class="ico_Info" style="width: 16px; height: 16px; float:left; margin-right:3px; margin-left:3px;"></span><b>Solicitações de Bolsa de Estudos Pendentes</b>'
				},'->',{
					xtype:'textfield',
					id:'idsearch',
					emptyText:'Pesquisar...',
					enableKeyEvents:true,
					style:'margin-right:10px;',
					listeners:{
						'keyup':function(){
							filterStoreByAllFields(Ext.getCmp('idsearch').getValue(), solicitacaobolsaestudosdiretoria);
						}
					}
				},'-',{
					text:'Expandir',
					id:'btnexpandir',
					iconCls:'ico_arrow_next',
					enableToggle:true,
					toggleHandler: function(button, state){
						if (state == true) {	
							Ext.getCmp('paneleastsolicitacaobolsaestudosdiretoria').collapse();
							Ext.getCmp('btnexpandir').setText('Mostrar Detalhes');
							Ext.getCmp('btnexpandir').setIconClass('ico_arrow_back');	
						}else{
							Ext.getCmp('paneleastsolicitacaobolsaestudosdiretoria').expand();
							Ext.getCmp('btnexpandir').setText('Expandir');	
							Ext.getCmp('btnexpandir').setIconClass('ico_arrow_next');	
						}
					}
				}],
				viewConfig:{
						 forceFit:true
					},
				sm: new Ext.grid.RowSelectionModel({
				 singleSelect: true,
				}),
				cm:new Ext.grid.ColumnModel({
					columns:[expander, new Ext.grid.RowNumberer({
						width:30,
						header:'nº',
					}),{
						header:'<center><b>Funcionário</b></center>',
						width:210,
						sortable:true,
						dataIndex:'NmCompleto'
					},{
						header:'<center><b>Curso</b><center>',
						width:210,
						sortable:true,
						dataIndex:'curso_titulo',
					},{
						header:'<center><b>Semestre</b></center>',
						width:100,
						sortable:true,
						dataIndex:'dessemestre'
					},{
						header:'<center><b>%</b></center>',
						width:80,
						sortable:true,
						tooltip:'Percentua de desconto concedido pelo RH',
						dataIndex:'nrpercentual',
						renderer:function(v){
							return v+'%';
						}
					},{
						header:'<b>Gestor</b>',
						align:'center',
						width:65,
						dataIndex:'ingestor',
						renderer:fn_solicitacaoStatus
					},{
						header:'<b>RH</b>',
						align:'center',
						width:65,
						dataIndex:'inrh',
						renderer:fn_solicitacaoStatus
					},{
						header:'<b>Diretoria</b>',
						align:'center',
						width:65,
						dataIndex:'indiretoria',
						renderer:fn_solicitacaoStatus
					}]
				}),
				listeners:{
					'rowclick':function(g,index,e){
						var mask = new Ext.LoadMask(xt('paneleastsolicitacaobolsaestudosdiretoria').body,{msg:'Aguarde...'});
						mask.show();
						var $grid = xt('gridsolicitacaobolsaestudosdiretoria').getStore().getAt(index);
						
						//Informações Usuário/Dependente
						solicitacaobolsaestudosusuario.load({
							params:{
								idsolicitacaobolsaestudo:$grid.get('idsolicitacaobolsaestudo')
							},
							callback:function(a,b){
								mask.hide();
								var $usuario_info = solicitacaobolsaestudosusuario.getAt(0);
								
								if($usuario_info.get('idsolicitacaobolsaestudostipo') == 1){
									xt('fsdependente').collapse();
								}else{
									xt('fsdependente').expand();
								}
								
								xt('func_solicitacaoBolsaEstudosDIRETORIA').setValue($usuario_info.get('nmcompleto'));
								xt('cpf_solicitacaoBolsaEstudosDIRETORIA').setValue(fn_maskCPF($usuario_info.get('nrcpf')));
								xt('login_solicitacaoBolsaEstudosDIRETORIA').setValue($usuario_info.get('nmlogin'));
								xt('mail_solicitacaoBolsaEstudosDIRETORIA').setValue($usuario_info.get('cdemail'));
								xt('depto_solicitacaoBolsaEstudosDIRETORIA').setValue($usuario_info.get('desdepartamento'));
								xt('cargo_solicitacaoBolsaEstudosDIRETORIA').setValue($usuario_info.get('descargo'));
								xt('depend_solicitacaoBolsaEstudosDIRETORIA_dependente').setValue($usuario_info.get('desnomedependente'));
								xt('mail_solicitacaoBolsaEstudosDIRETORIA_dependente').setValue($usuario_info.get('desemaildependente'));
								xt('cpf_solicitacaoBolsaEstudosDIRETORIA_dependente').setValue(fn_maskCPF($usuario_info.get('nrcpfdependente')));
								xt('dtnasc_solicitacaoBolsaEstudosDIRETORIA_dependente').setValue(($usuario_info.get('dtnascimentodependente') != 0)? $usuario_info.get('dtnascimentodependente'): 'N/A');
								xt('tipo_solicitacaoBolsaEstudosDIRETORIA_dependente').setValue($usuario_info.get('desdependentetipo'));	
								xt('iddatasolicitacao').setValue($usuario_info.get('dtsolicitacao'));	
								xt('iddataaprovacaorh').setValue($usuario_info.get('dtaprovacaorh'));										
							}
						});
						
						//Lista de Solicitações Aprovadas
						solicitacaobolsaestudosaprovados.load({
							params:{
								idusuario:$grid.get('idusuario')
							},
						});
					},
					'cellcontextmenu':function(grid,row,cell,e){
						$grid = grid.getStore().getAt(row).data;						
						if($grid.indiretoria == 2 && cell == 8){
							
							var $IDPERMISSAODIRETORIA;
	
							$.each(PERMISSOES, function(){
								if(this.despermissao.toLowerCase() == 'diretoria'){
									$IDPERMISSAODIRETORIA = this.idpermissao;
								}
							});
							
							new Ext.menu.Menu({
								items:[{
									text:'Autorizar Solicitação',
									iconCls:'ico_Apply',
									handler:function(){
										Ext.Msg.confirm('Aviso!','Deseja confirmar a solicitação?',function(btn){
											if(btn == 'yes'){
												console.log('yes');
												Ext.Ajax.request({
													url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/ajax/atualizarPermissaoGestorRhDiretoria.php',
													params:{
														idsolicitacaobolsaestudo:$grid.idsolicitacaobolsaestudo,
														idpermissao:$IDPERMISSAODIRETORIA,
														instatus:1,
														idsolicitacaobolsaestudostipo:$grid.idsolicitacaobolsaestudostipo
													},
													success:function(result, request){
														grid.getStore().reload();
														console.log('sucesso!');
														Ext.Msg.alert('Aviso!','Solicitação foi confirmada!<br /><br />Funcionário:<b> '+$grid.NmCompleto+'</b><br />Curso:<b>' +$grid.curso_titulo+'</b> do <b>'+$grid.dessemestre+'</b> semestre<br />');
														Ext.getCmp('formsolicitacaobolsaestudosDIRETORIA').getForm().reset();
														
													},
													failure:function(){
														Ext.Msg.alert('Aviso!','Não foi possível confirmar a solicitação.');//res.msg
													}
												});
											 }
										});
									}
								},{
									text:'Bloquear Solicitação',
									iconCls:'ico_cross',
									handler:function(){
										Ext.Msg.confirm('Aviso!','Deseja bloquear a solicitação?',function(btn){
											if(btn == 'yes'){
												
												Ext.Ajax.request({
													url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/ajax/atualizarPermissaoGestorRhDiretoria.php',
													method:'POST',
													params:{
														idsolicitacaobolsaestudo:$grid.idsolicitacaobolsaestudo,
														idpermissao:$IDPERMISSAODIRETORIA,
														instatus:0,
														idsolicitacaobolsaestudostipo:$grid.idsolicitacaobolsaestudostipo
													},
													success:function(result, request){
															
														Ext.getCmp('formsolicitacaobolsaestudosDIRETORIA').getForm().reset();
														
														Ext.Msg.alert('Aviso!','Solicitação foi bloqueada!<br /><br />Funcionário:<b> '+$grid.NmCompleto+'</b><br />Treinamento:<b>' +$grid.curso_titulo+'</b> do <b>'+$grid.dessemestre+'</b> semestre<br />',
														function(btn){
															if(btn == 'ok'){
																if(Ext.getCmp('winBloqueio_diretoria')){
																	Ext.getCmp('winBloqueio_diretoria').show();
																}else{																																																									
																	new Ext.Window({
																		id:'winBloqueio_diretoria',
																		iconCls:'ico_cross',
																		title:'Motivo do Bloqueio Solicitação',
																		border:false,
																		resizable:false,
																		width:500,
																		height:260,
																		items:[{
																			xtype:'form',
																			id:'formBloqueio_diretoria',
																			border:false,
																			padding:10,
																			items:[{
																				xtype:'fieldset',
																				items:[{
																					xtype:'textarea',
																					id:'textBloqueio_diretoria',
																					anchor:'100%',
																					allowBlank:false,
																					height:150,
																					autoScroll:true,
																					hideLabel:true
																				},{
																					xtype:'button',
																					style:'margin:10 0 0 160;',
																					text:'Cadastrar',
																					iconCls:'ico_Apply',
																					width:120,
																					height:25,
																					handler:function(){
																						if(Ext.getCmp('formBloqueio_diretoria').getForm().isValid()){
																							var maskBloqueio = new Ext.LoadMask(Ext.getBody(),{msg:"Aguarde..."});
																							maskBloqueio.show();
																							Ext.getCmp('formBloqueio_diretoria').getForm().submit({
																																																												url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/ajax/inserirMotivoSolicitacao.php',
																								params:{
																									idsolicitacaobolsaestudos:$grid.idsolicitacaobolsaestudo,
																									idpermissao:$IDPERMISSAODIRETORIA,
																									motivo:Ext.getCmp('textBloqueio_diretoria').getValue()
																								},
																								success:function(){
																									maskBloqueio.hide();
																									Ext.Msg.alert("Aviso!","Motivo cadastrado com sucesso.",function(btn){		
																																																																					if(btn == 'ok'){
																																																																								
																											Ext.getCmp('winBloqueio_diretoria').close();																																											 																												}
																																																																																																																																																			});
																								}
																							});
																						}
																					}
																				}]
																			}]
																		}]
																	}).show();
																}																																																																																																		                                                            }																																																																														                                                        });
																																																																																			 														grid.getStore().reload();													
																																																																																				 													},
													failure:function(){
														Ext.Msg.alert('Aviso!','Não foi possível bloquear a solicitação.');
													}
												});
											 }
										});
									}
								}]
							}).showAt(e.xy);
						}
					}
				}
			}]
		},{
			region:'east',
			id:'paneleastsolicitacaobolsaestudosdiretoria',
			split:true,
			border:false,
			width:'40%',//Page.width-710,
			collapsible:true,
			collapseMode:'mini',
			layout:'border',
			items:[{
				region:'center',
				id:'informacoesFuncionario_diretoria',
				height:Page.height-350,
				tbar:[{
					xtype:'displayfield',
					style:'color: #15428B; padding-right:4px;',
					value:'<span class="ico_usuario" style="width: 16px; height: 16px; float:left; margin-right:3px; margin-left:3px;"></span><b>Informações</b>'
				},'->',{
					text:'Ver Solicitações Aprovadas',
					id:'btnexpandirgrid',
					iconCls:'ico_down',
					enableToggle:true,
					toggleHandler: function(button, state){
						if (state == true) {	
							Ext.getCmp('informacoesSolicitacaoFuncionario_diretoria').expand();
							Ext.getCmp('btnexpandirgrid').setText('Mostrar Detalhes');	
							Ext.getCmp('btnexpandirgrid').setIconClass('ico_up');	
						}else{
							Ext.getCmp('informacoesSolicitacaoFuncionario_diretoria').collapse();
							Ext.getCmp('btnexpandirgrid').setText('Ver Solicitações Aprovadas');
							Ext.getCmp('btnexpandirgrid').setIconClass('ico_down');		
							
						}
					}
				}],
				split:true,
				items:[{
					xtype:'form',
					id:'formsolicitacaobolsaestudosDIRETORIA',
					padding:10,
					border:false,
					items:[{
						xtype:'fieldset',
						title:'Funcionário',
						collapsible:true,
						iconCls:'ico_account',
						style:'margin-top:15',
						defaults:{xtype:'displayfield',style:'margin-top:5'},
						items:[{
							fieldLabel:'<b>Funcionário</b>',
							id:'func_solicitacaoBolsaEstudosDIRETORIA',
							style:'margin-top:5',
						},{
							xtype:'compositefield',
							fieldLabel:'<b>CPF</b>',
							defaults:{xtype:'displayfield',flex:1},
							items:[{
								id:'cpf_solicitacaoBolsaEstudosDIRETORIA',
							},{
								value:'<b>NomeLogin</b>:',
								flex:0
							},{
								id:'login_solicitacaoBolsaEstudosDIRETORIA',
							}]
						},{
							xtype:'displayfield',
							fieldLabel:'<b>E-mail</b>',
							id:'mail_solicitacaoBolsaEstudosDIRETORIA'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Departamento</b>',
							id:'depto_solicitacaoBolsaEstudosDIRETORIA'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Cargo</b>',
							id:'cargo_solicitacaoBolsaEstudosDIRETORIA'
						}]
					},{
						xtype:'fieldset',
						id:'fsdependente',
						iconCls:'ico_usuario',
						title:'Dependente',
						style:'margin-top:15',
						collapsible:true,
						defaults:{xtype:'displayfield',style:'margin-top:5'},
						items:[{
							fieldLabel:'<b>Dependente</b>',
							id:'depend_solicitacaoBolsaEstudosDIRETORIA_dependente',
							style:'margin-top:5',
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Tipo</b>',
							id:'tipo_solicitacaoBolsaEstudosDIRETORIA_dependente'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>E-mail</b>',
							id:'mail_solicitacaoBolsaEstudosDIRETORIA_dependente'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>CPF</b>',
							id:'cpf_solicitacaoBolsaEstudosDIRETORIA_dependente'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Data de Nascimento</b>',
							id:'dtnasc_solicitacaoBolsaEstudosDIRETORIA_dependente'
						}]
					},{
						xtype:'fieldset',
						id:'fsdetalhes',
						iconCls:'ico_plus3d',
						title:'Mais Detalhes',
						style:'margin-top:15',
						collapsible:true,
						defaults:{xtype:'displayfield'},
						items:[{
							xtype:'compositefield',
							fieldLabel:'<b>Data solicitação</b>',
							defaults:{xtype:'displayfield',flex:1},
							items:[{
								id:'iddatasolicitacao',
							},{
								value:'<b>Aprovado pelo RH</b>:',
								flex:0
							},{
								id:'iddataaprovacaorh',
							}]
						}],
					}]	  
				}]
			},{
				region:'north',
				id:'informacoesSolicitacaoFuncionario_diretoria',
				height:485,
				collapsible:true,
				collapsed:true,
				collapseMode:'mini',
				layout:'fit',
				items:[{
					xtype:'grid',
					id:'gridsolicitacoesaprovadas',
					store:solicitacaobolsaestudosaprovados,
					plugins:expander2,
					loadMask:true,
					stripeRows:true,
					autoScroll:true,
					border:false,
					style:'margin-bottom:200px;',
					viewConfig:{
						 forceFit:true
					},
					sm: new Ext.grid.RowSelectionModel({
					 singleSelect: true,
					}),
					cm:new Ext.grid.ColumnModel({
						columns:[new Ext.grid.RowNumberer({
							width:30,
							header:'nº',
						}),expander2,{
							hidden:true,
							dataIndex:'idsolicitacaobolsaestudo'
						},{
							hidden:true,
							dataIndex:'idsolicitacaobolsaestudostipo'
						},{
							hidden:true,
							dataIndex:'idusuario'
						},{ 
							header:'Curso',
							width:200,
							sortable:true,
							dataIndex:'curso_titulo'
						},{ 
							header:'Semestre',
							width:50,
							sortable:true,
							dataIndex:'dessemestre'
						},{ 
							header:'Gestor',
							width:30,
							sortable:true,
							dataIndex:'ingestor',
							renderer:fn_solicitacaoStatus
						},{ 
							header:'RH',
							width:30,
							sortable:true,
							dataIndex:'inrh',
							renderer:fn_solicitacaoStatus
						},{
							header:'Diretoria',
							width:30,
							sortable:true,
							dataIndex:'indiretoria',
							renderer:fn_solicitacaoStatus
						}],
					}),
					tbar:[{
						text:'Imprimir Formulário',
						id:'btnimprimir',
						iconCls:'ico_print',
						disabled:true,
						handler:function(){
							
							var $grid_aprovados = xt('gridsolicitacoesaprovadas').getSelectionModel().getSelected();
							
							window.open('/simpacweb/modulos/RH/solicitacaoBolsaEstudos/print_solicitacaoBolsaEstudos.php?idsolicitacaobolsaestudo='+$grid_aprovados.get('idsolicitacaobolsaestudo'),'Print','width=1000, height=700, top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
						
						}
					}],
					listeners:{
						'rowclick':function(a, index, c){								
							if(xt('gridsolicitacoesaprovadas').getSelectionModel().getSelected()){
								xt('btnimprimir').enable();
							}else{
								xt('btnimprimir').disable();
							}								
						}
					}	
				}],
			}]
		}]
	});
});
</script>
<div id="div_solicitacaoBolsaEstudosDIRETORIA"> </div>