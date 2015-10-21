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
	
	var solicitacaobolsaestudosgestor = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/solicitacaobolsaestudosGestorRhDiretoria_list.php',
		root:'myData',
		baseParams:{
			idpermissao:1
		},
		fields:[{name:'idsolicitacaobolsaestudo', type:'int'},
				{name:'idusuario', type:'int'},
				{name:'idsolicitacaobolsaestudostipo', type:'int'},
				{name:'curso_id', type:'int'},
				{name:'curso_titulo', type:'string'},
				{name:'dessemestre', type:'string'},
				{name:'desjustificativa', type:'string'},
				{name:'dtcadastro', type:'date', dateFormat:'timestamp'},
				{name:'NmCompleto', type:'string'},
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
				{name:'dtadmissao', type:'string'}]
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
	
	var storegestores = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/json/gestores_list.php',
		root:'myData',
		fields:[{name:'idusuario', type:'int'},
				{name:'nmcompleto', type:'string'}],
		autoLoad:true
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
		renderTo:'div_solicitacaoBolsaEstudosGestor',
		id:'viewmport_gestor',
		listeners:{
			'afterrender':function(){
				var $access = <?=$_SESSION['idusuario']?>;
				if($access == 1495 || $access == 221){
					xt('idcombogestor').show();
				}
			}
		},
		items:[{
			region:'north',
			border:false,
			style:'padding-top:27px;',
			html:'<?=topopagina("Gnome-X-Office-Address-Book-64.png","Gerenciamento de Solicitações de Bolsa de Estudos - Gestor");?>'
		},{
			region:'center',
			layout:'fit',
			items:[{
				xtype:'grid',
				id:'gridsolicitacaobolsaestudosgestor',
				loadMask:true,
				border:false,
				plugins:expander,
				height:Page.height-128,
				store:solicitacaobolsaestudosgestor,
				tbar:[{
					xtype:'combo',
					id:'idcombogestor',
					name:'nomegestor',
					hidden:true,
					autoHeight:true,
					store:storegestores,
					displayField:'nmcompleto',
					valueField:'idusuario',
					typeAhead:true,
					triggerAction:'all',
					lazyRender:true,
					mode:'local',
					allowBlank:false,
					width:200,
					emptyText:'Lista de gestores...',
					listeners:{
						'select':function(){
							solicitacaobolsaestudosgestor.load({
								params:{
									idusuario:xt('idcombogestor').getValue()
								}
							})
						}
					}
				},{
					xtype:'displayfield',
					style:'color: #15428B; padding-right:4px;',
					value:'<span class="ico_curso" style="width: 16px; height: 16px; float:left; margin-right:3px; margin-left:3px;"></span><b>Solicitações de Bolsa de Estudos Pendentes</b>'
				},'->',{
					xtype:'textfield',
					id:'idsearch',
					emptyText:'Pesquisar...',
					enableKeyEvents:true,
					style:'margin-right:10px;',
					listeners:{
						'keyup':function(){
							filterStoreByAllFields(Ext.getCmp('idsearch').getValue(), solicitacaobolsaestudosgestor);
						}
					}
				},'-',{
					text:'Expandir',
					id:'btnexpandir',
					iconCls:'ico_arrow_next',
					enableToggle:true,
					toggleHandler: function(button, state){
						if (state == true) {	
							Ext.getCmp('paneleastsolicitacaobolsaestudosgestor').collapse();
							Ext.getCmp('btnexpandir').setText('Mostrar Detalhes');
							Ext.getCmp('btnexpandir').setIconClass('ico_arrow_back');		
						}else{
							Ext.getCmp('paneleastsolicitacaobolsaestudosgestor').expand();
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
						header:'<b>Funcionário</b>',
						align:'center',
						width:210,
						sortable:true,
						dataIndex:'NmCompleto'
					},{
						header:'<b>Curso</b>',
						align:'center',
						width:210,
						sortable:true,
						dataIndex:'curso_titulo',
					},{
						header:'<b>Semestre</b>',
						align:'center',
						width:100,
						sortable:true,
						dataIndex:'dessemestre'
					},{
						header:'<b>Data Solicitação</b>',
						xtype:'datecolumn',
						tooltip:'Data de solicitação da bolsa',
						align:'center',
						width:100,
						sortable:true,
						dataIndex:'dtcadastro',
						format:'d/m/Y',
					},{
						header:'<b>Gestor</b>',
						align:'center',
						width:65,
						dataIndex:'ingestor',
						renderer:fn_solicitacaoStatus
					}]
				}),
				listeners:{
					'rowclick':function(g,index,e){
						var mask = new Ext.LoadMask(xt('paneleastsolicitacaobolsaestudosgestor').body,{msg:'Aguarde...'});
						mask.show();
						var $grid = xt('gridsolicitacaobolsaestudosgestor').getStore().getAt(index);
						
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
								
								xt('func_solicitacaoBolsaEstudosGestor').setValue($usuario_info.get('nmcompleto'));
								xt('cpf_solicitacaoBolsaEstudosGestor').setValue(fn_maskCPF($usuario_info.get('nrcpf')));
								xt('login_solicitacaoBolsaEstudosGestor').setValue($usuario_info.get('nmlogin'));
								xt('mail_solicitacaoBolsaEstudosGestor').setValue($usuario_info.get('cdemail'));
								xt('depto_solicitacaoBolsaEstudosGestor').setValue($usuario_info.get('desdepartamento'));
								xt('cargo_solicitacaoBolsaEstudosGestor').setValue($usuario_info.get('descargo'));
								xt('depend_solicitacaoBolsaEstudosGestor_dependente').setValue($usuario_info.get('desnomedependente'));
								xt('mail_solicitacaoBolsaEstudosGestor_dependente').setValue($usuario_info.get('desemaildependente'));
								xt('cpf_solicitacaoBolsaEstudosGestor_dependente').setValue(fn_maskCPF($usuario_info.get('nrcpfdependente')));
								xt('dtnasc_solicitacaoBolsaEstudosGestor_dependente').setValue(($usuario_info.get('dtnascimentodependente') != 0)? $usuario_info.get('dtnascimentodependente'): 'N/A');
								xt('tipo_solicitacaoBolsaEstudosGestor_dependente').setValue($usuario_info.get('desdependentetipo'));	
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
						if($grid.ingestor == 2 && cell == 6){
							
							var $IDPERMISSAOGESTOR;
							
							$.each(PERMISSOES, function(){
								if(this.despermissao.toLowerCase() == 'gestor'){
									$IDPERMISSAOGESTOR = this.idpermissao;
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
														idpermissao:$IDPERMISSAOGESTOR,
														instatus:1,
														idsolicitacaobolsaestudostipo:$grid.idsolicitacaobolsaestudostipo
													},
													success:function(result, request){
														grid.getStore().reload();
														console.log('sucesso!');
														Ext.Msg.alert('Aviso!','Solicitação foi confirmada!<br /><br />Funcionário:<b> '+$grid.NmCompleto+'</b><br />Curso:<b>' +$grid.curso_titulo+'</b> do <b>'+$grid.dessemestre+'</b> semestre<br />');
														Ext.getCmp('formsolicitacaobolsaestudosGestor').getForm().reset();
														
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
														idpermissao:$IDPERMISSAOGESTOR,
														instatus:0,
														idsolicitacaobolsaestudostipo:$grid.idsolicitacaobolsaestudostipo
													},
													success:function(result, request){
															
														Ext.getCmp('formsolicitacaobolsaestudosGestor').getForm().reset();
														
														Ext.Msg.alert('Aviso!','Solicitação foi bloqueada!<br /><br />Funcionário:<b> '+$grid.NmCompleto+'</b><br />Treinamento:<b> ' +$grid.curso_titulo+'</b> do <b>'+$grid.dessemestre+'</b> semestre<br />',
														function(btn){
															if(btn == 'ok'){
																if(Ext.getCmp('winBloqueio_gestor')){
																	Ext.getCmp('winBloqueio_gestor').show();
																}else{																																																									
																	new Ext.Window({
																		id:'winBloqueio_gestor',
																		iconCls:'ico_cross',
																		title:'Motivo do Bloqueio Solicitação',
																		border:false,
																		resizable:false,
																		width:500,
																		height:260,
																		items:[{
																			xtype:'form',
																			id:'formBloqueio_gestor',
																			border:false,
																			padding:10,
																			items:[{
																				xtype:'fieldset',
																				items:[{
																					xtype:'textarea',
																					id:'textBloqueio_gestor',
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
																						if(Ext.getCmp('formBloqueio_gestor').getForm().isValid()){
																							var maskBloqueio = new Ext.LoadMask(Ext.getBody(),{msg:"Aguarde..."});
																							maskBloqueio.show();
																							Ext.getCmp('formBloqueio_gestor').getForm().submit({
																																																												url:'/simpacweb/modulos/RH/solicitacaoBolsaEstudos/ajax/inserirMotivoSolicitacao.php',
																								params:{
																									idsolicitacaobolsaestudos:$grid.idsolicitacaobolsaestudo,
																									idpermissao:$IDPERMISSAOGESTOR,
																									motivo:Ext.getCmp('textBloqueio_gestor').getValue()
																								},
																								success:function(){
																									maskBloqueio.hide();
																									Ext.Msg.alert("Aviso!","Motivo cadastrado com sucesso.",function(btn){		
																																																																					if(btn == 'ok'){
																																																																								
																											Ext.getCmp('winBloqueio_gestor').close();																																											 																												}
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
			id:'paneleastsolicitacaobolsaestudosgestor',
			split:true,
			collapsible:true,
			collapseMode:'mini',
			border:false,
			width:'40%',
			layout:'border',
			items:[{
				region:'center',
				id:'informacoesFuncionario_gestor',
				height:Page.height-350,
				tbar:[{
					xtype:'displayfield',
					style:'color: #15428B; padding-right:4px;',
					value:'<span class="ico_Info" style="width: 16px; height: 16px; float:left; margin-right:3px; margin-left:3px;"></span><b>Informações</b>'
				},'->',{
					text:'Ver Solicitações Aprovadas',
					id:'btnexpandirgrid',
					iconCls:'ico_down',
					enableToggle:true,
					toggleHandler: function(button, state){
						if (state == true) {	
							Ext.getCmp('informacoesSolicitacaoFuncionario_gestor').expand();
							Ext.getCmp('btnexpandirgrid').setText('Mostrar Detalhes');	
							Ext.getCmp('btnexpandirgrid').setIconClass('ico_up');	
						}else{
							Ext.getCmp('informacoesSolicitacaoFuncionario_gestor').collapse();
							Ext.getCmp('btnexpandirgrid').setText('Ver Solicitações Aprovadas');
							Ext.getCmp('btnexpandirgrid').setIconClass('ico_down');		
							
						}
					}
				}],
				split:true,
				items:[{
					xtype:'form',
					id:'formsolicitacaobolsaestudosGestor',
					padding:10,
					border:false,
					items:[{
						xtype:'fieldset',
						title:'Funcionário',
						collapsible:true,
						iconCls:'ico_account',
						style:'margin-top:15',
						defaults:{xtype:'displayfield',style:'margin-top:15'},
						items:[{
							fieldLabel:'<b>Funcionário</b>',
							id:'func_solicitacaoBolsaEstudosGestor',
							style:'margin-top:5',
						},{
							xtype:'compositefield',
							fieldLabel:'<b>CPF</b>',
							defaults:{xtype:'displayfield',flex:1},
							items:[{
								id:'cpf_solicitacaoBolsaEstudosGestor',
							},{
								value:'<b>NomeLogin</b>:',
								flex:0
							},{
								id:'login_solicitacaoBolsaEstudosGestor',
							}]
						},{
							xtype:'displayfield',
							fieldLabel:'<b>E-mail</b>',
							id:'mail_solicitacaoBolsaEstudosGestor'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Departamento</b>',
							id:'depto_solicitacaoBolsaEstudosGestor'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Cargo</b>',
							id:'cargo_solicitacaoBolsaEstudosGestor'
						}]
					},{
						xtype:'fieldset',
						id:'fsdependente',
						iconCls:'ico_usuario',
						title:'Dependente',
						style:'margin-top:15',
						collapsible:true,
						defaults:{xtype:'displayfield',style:'margin-top:15'},
						items:[{
							fieldLabel:'<b>Dependente</b>',
							id:'depend_solicitacaoBolsaEstudosGestor_dependente',
							style:'margin-top:5',
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Tipo</b>',
							id:'tipo_solicitacaoBolsaEstudosGestor_dependente'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>E-mail</b>',
							id:'mail_solicitacaoBolsaEstudosGestor_dependente'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>CPF</b>',
							id:'cpf_solicitacaoBolsaEstudosGestor_dependente'
						},{
							xtype:'displayfield',
							fieldLabel:'<b>Data de Nascimento</b>',
							id:'dtnasc_solicitacaoBolsaEstudosGestor_dependente'
						}]
					}]	  
				}]
			},{
				region:'north',
				id:'informacoesSolicitacaoFuncionario_gestor',
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
<div id="div_solicitacaoBolsaEstudosGestor"> </div>