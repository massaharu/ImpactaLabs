<?php
	# @AUTOR = Massaharu #
	$GLOBALS['menu'] = true;
	
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

	//Coloca o cabeçário na tela
	topopagina('drawing_board.png', 'Sistema de Visualização de Atividades da Editora');
?>

<script type="text/javascript">
		var store = new Ext.data.JsonStore({
			url: 'ajax/loadandamento.php',
			root: 'myData',
			fields: [{name:'id', type:'int'}, {name:'nmcurso', type:'string'}, {name:'inprioridade', type:'int'}, {name:'indivisao', type:'int'}, {name:'desdivisao', type:'string'}, {name:'dtprevisao', type:'date'}, {name:'dtcadastro', type:'date'}, {name:'nmusuario', type:'string'}, {name:'inposicao', type:'int'}, {name:'instatus', type:'int'}, {name:'desstatus', type:'string'}, {name:'dtfinalizado', type:'date'}, {name:'inrelatorio', type:'int'},, {name:'desdescricao', type:'string'}]
		});
		store.load();
		
		var storedivisao = new Ext.data.JsonStore({
			url: 'ajax/loaddivisao.php',
			root: 'myData',
			fields: [{name:'iddivisao', type:'int'}, {name:'desdivisao', type:'string'}]
		});
		storedivisao.load();
		
		/*var tabs = new Ext.TabPanel({
			resizeTabs:true, // turn on tab resizing
			enableTabScroll:true,
			border:false,
			height:Page.height,
			id:'tabs'
		});*/
		
		function fnprioridade(v){
			if(v == '1'){
				return '<img src="/simpacweb/images/ico/16/flag_blue.png" />'
			} else if (v == '2'){
				return '<img src="/simpacweb/images/ico/16/flag_red.png" />'
			}
		}
		
		function fnstatus(v){
			if(v == '1'){
				return '<img src="/simpacweb/images/ico/16/clock_go.png" /> Em Andamento'
			} else if (v == '2'){
				return '<img src="/simpacweb/images/ico/16/accept.png" /> Concluido'
			}
		}
		
		function fncolor(value, metaData, record, rowIndex, colIndex, store){
			if(record.get('inrelatorio') == 0){
				return '<span style="color:#999999">'+value+'</span>'
			} else {
				return value
			}
		}

//=======================================================================================================================
	Ext.onReady(function(){
//_________________________________________PANEL DETALHES (SOUTH)________________________________________________________			 
		var tabs = new Ext.TabPanel({
			resizeTabs:true, // turn on tab resizing
			enableTabScroll:true,
			border:false,
			height:310,
			id:'tabs',
			defaults:{
				autoScroll:true
			},
		});
//_____________________________________TREE PANEL (TREINAMENTOS EM ESPERA)_____________________________________________________________________________
	var tree = new Ext.tree.TreePanel({
			useArrows: false,
			autoScroll:true,
			autoHeight:true,
			lines: true,
			animate: false,
			enableDD: true,
			containerScroll: true,
			border: false,
			pathSeparator: ';',
			rootVisible: false,
			id:'treeespera',
			loader: new Ext.tree.TreeLoader({
				url:'ajax/loadespera.php',
				baseParams:{category:''},
				listeners:{
					'beforeload':function(treeLoader, node) {
						this.baseParams.category = node.attributes.category;
						this.baseParams.id = node.attributes.itemId;
					}	
				}
			}),
			root: new Ext.tree.AsyncTreeNode({
				children:[{
					iconCls:"ico_folder_open",
					text:"Solicita&ccedil;&otilde;es em Espera",
					category:"novostreinamentos",
					expanded: true
				}]
			}),
			listeners:{		
				'movenode':function(tree, node, oldParent, newParent, index){
					var id = "";
					newParent.eachChild(function(obj){
						if(id != ''){
							id += ','
						}
						id += obj.attributes.data.id;
					});	
					Ext.Ajax.request({
						url: 'ajax/altprioridade.php',
						params:{
							order:id
						}
					});
				},
				'click':function(e){
					tabs.removeAll();
					tabs.add({
						/*title:e.attributes.data.nmcurso,*/
						title:'Informações',
						closable:true,
						padding:5,
						tbar:[{
							text:'Alterar Solicita&ccedil;&atilde;o',
							iconCls:'ico_pencil',
							handler:function(){
								new Ext.Window({
									width:500,
									height:180,
									modal:true,
									id:'winalteracao',
									title:'Alterar Solicitação',
									items:[{
										xtype:'form',
										defaultType: 'textfield',
										id:'frmalteracao',
										labelWidth: 175,
										border:false,
										padding:5,
										width:480,
										items:[{
											fieldLabel: 'Treinamento',
											name: 'nmcurso',
											value:e.attributes.data.nmcurso,
											width:280,
										},{
											xtype: 'radiogroup',
											fieldLabel: 'Prioridade',
											allowBlank:false,
											value:e.attributes.data.inprioridade,
											items: [{
												boxLabel: 'Prioridade 1', 
												name: 'inprioridade', 
												inputValue: 1
											},{
												boxLabel: 'Prioridade 2', 
												name: 'inprioridade', 
												inputValue: 2
											}]
										},{
											xtype: 'radiogroup',
											fieldLabel: 'Relatorio Entregue?',
											allowBlank:false,
											value:e.attributes.data.inrelatorio,
											items: [{
												boxLabel: 'Sim', 
												name: 'inrelatorio', 
												inputValue: 1
											},{
												boxLabel: 'Nao', 
												name: 'inrelatorio', 
												inputValue: 0
											}]
										},new Ext.form.ComboBox({
											typeAhead: true,
											triggerAction: 'all',
											lazyRender:true,
											mode: 'local',
											store: storedivisao,
											valueField: 'iddivisao',
											displayField: 'desdivisao',
											fieldLabel: 'Divis&atilde;o',
											hiddenName:'iddivisao',
											hiddenValue:e.attributes.data.indivisao,
											value:e.attributes.data.indivisao,
											width:280,
											submitValue:true
										})],
										buttons:[{
											text:'Salvar',
											iconCls:'ico_disk',
											handler:function(){
												Ext.getCmp('frmalteracao').getForm().submit({
													url:'ajax/alttreinamento.php',
													params:{
														id:e.attributes.data.id
													},
													success:function(){
														Ext.MessageBox.alert('','Altera&ccedil;&atilde;o feita com Sucesso!');
														store.reload();
														tree.root.reload();
														tabs.getActiveTab().destroy();
														Ext.getCmp('winalteracao').close();
													}
												});
											}
										}]
									}]
								}).show();
							}
						},'-',{
							text:'Excluir Treinamento',
							iconCls:'ico_erase',
							handler:function(){
								Ext.MessageBox.confirm('','Deseja realmente excluir este projeto?',function(btn){
									if(btn == 'yes'){
										Ext.Ajax.request({
											url: 'ajax/excprojeto.php',
											success: function(){
												Ext.MessageBox.alert('','Treinamento excluido com Sucesso!');
												store.reload();
												tree.root.reload();
												tabs.getActiveTab().destroy();
											},
											params:{
												id:e.attributes.data.id
											}
										});
									}
								});
							}
						}],
						items:[{
							xtype:'fieldset',
							title: 'Informações',
							defaultType: 'textfield',
							collapsed: false,
							items:[{
								xtype:'form',
								defaultType: 'textfield',
								id:'frmstatus',
								labelWidth: 120,
								border:false,
								width:400,
								defaults:{style:'border:none; background:none;',width:190},
								items:[{
									fieldLabel: 'Treinamento',
									name: 'destreinamento',
									value:e.attributes.data.nmcurso
								},{
									fieldLabel: 'Prioridade',
									name: 'inprioridade',					
									value:e.attributes.data.inprioridade
								},{
									fieldLabel: 'Divis&atilde;o',
									name: 'desdivisao',
									value:e.attributes.data.desdivisao
								},{
									fieldLabel: 'Cadastrado em',
									name: 'dtcadastro',
									value:e.attributes.data.dtcadastro
								},{
									fieldLabel: 'Solicitante',
									name: 'nmusuario',
									value:e.attributes.data.nmusuario
								},{
									fieldLabel: 'Concluido em',
									name: 'dtfinalizado',
									value:e.attributes.data.dtfinalizado
								},{
									fieldLabel: 'Relatorio Entregue',
									name: 'dtfinalizado',
									value:e.attributes.data.inrelatorio,
								}]
							}],
							listeners:{
								'beforerender':function(obj){
									if(e.attributes.data.dtfinalizado == null){
										Ext.getCmp('frmstatus').items.items[5].setValue('-');
									}
									if(e.attributes.data.inrelatorio == 1){
										Ext.getCmp('frmstatus').items.items[6].setValue('Sim');
									} else {
										Ext.getCmp('frmstatus').items.items[6].setValue('Não');
									}	
								}
							}
						}/*,{
							xtype:'fieldset',
							title: 'Painel Administrativo',
							defaultType: 'textfield',
							collapsed: false,
							flex:1,
							items:[{
								xtype:'form',
								id:'frmalterarstatus',
								labelWidth: 120,
								border:false,
								width:500,
								defaults:{allowBlank:false,width:165},
								items:[{
									fieldLabel: 'Previs&atilde;o de Entrega',
									name: 'dtprevisao',
									xtype:'datefield',
									allowBlank:true,
									value:Ext.util.Format.date(e.attributes.data.dtprevisao,'d/m/Y'),
								},{
									fieldLabel: '% Concluida',
									name: 'desstatus',
									xtype:'numberfield',
									value:e.attributes.data.desstatus
								},{
									xtype:'button',
									fieldLabel:'Status',
									name:'instatus',
									height:20,
									width:165,
									id:'btn-'+e.id,
									enableToggle: true,												
									listeners:{
										'beforerender':function(obj){
											if(e.attributes.data.instatus == 0){
												obj.pressed = false;
												obj.setText('Iniciar');
												obj.setIconClass('ico_Play');
											} else if (e.attributes.data.instatus == 1){
												obj.pressed = true;
												obj.setText('Pausar');
												obj.setIconClass('ico_stop');
											} else {
												obj.setText('Concluido');
												obj.setIconClass('ico_accept');
												obj.disable();
											}
										},
										'toggle':function(obj,pressed){
											if(pressed == true){
												obj.setText('Pausar');
												obj.setIconClass('ico_stop');
											} else {
												obj.setText('Iniciar');
												obj.setIconClass('ico_Play');
											}
										}
									}
								}],
								buttons:[{
									text:'Salvar',
									iconCls:'ico_disk',
									handler:function(){
										if(Ext.getCmp('frmalterarstatus').getForm().isValid()){
											var status = ((Ext.getCmp('btn-'+e.id).pressed == true) ? "1" : "0");
											Ext.getCmp('frmalterarstatus').getForm().submit({
												url:'ajax/cadandamento.php',
												params:{
													instatus:status,
													id:e.attributes.data.id
												},
												success:function(){
													Ext.MessageBox.alert('','Alterações feitas com Sucesso!');
													store.reload();
													tree.root.reload();
												}
											});
										}
									}
								},{
									text:'Finalizar',
									iconCls:'ico_tick',
									handler:function(){
										Ext.MessageBox.confirm('','Deseja concluir o desenvolvimento deste treinamento?',function(btn){
											if(btn == 'yes'){
												Ext.Ajax.request({
													url: 'ajax/cadconclusao.php',
													success: function(){
														Ext.MessageBox.alert('','Treinamento concluido com Sucesso!');
														store.reload();
														tabs.getActiveTab().destroy();
													},
													params:{
														id:e.attributes.data.id
													}
												});
											}						
										});
									}
								}]
							}],
						}*/],
							listeners:{
							'close':function(p){
								tabs.getActiveTab().destroy();
							},
							'afterrender':function(obj){
								if(e.attributes.data.inprioridade == 1){
									obj.setIconClass('ico_flag_blue');
								} else {
									obj.setIconClass('ico_flag_red');
								}								
							}		
						}
					},{
						/*title:e.attributes.data.nmcurso,*/
						title:'Ações',
						closable:true,
						padding:5,
						tbar:[{
							text:'Alterar Solicita&ccedil;&atilde;o',
							iconCls:'ico_pencil',
							handler:function(){
								new Ext.Window({
									width:500,
									height:180,
									modal:true,
									id:'winalteracao',
									title:'Alterar Solicitação',
									items:[{
										xtype:'form',
										defaultType: 'textfield',
										id:'frmalteracao',
										labelWidth: 175,
										border:false,
										padding:5,
										width:480,
										items:[{
											fieldLabel: 'Treinamento',
											name: 'nmcurso',
											value:e.attributes.data.nmcurso,
											width:280,
										},{
											xtype: 'radiogroup',
											fieldLabel: 'Prioridade',
											allowBlank:false,
											value:e.attributes.data.inprioridade,
											items: [{
												boxLabel: 'Prioridade 1', 
												name: 'inprioridade', 
												inputValue: 1
											},{
												boxLabel: 'Prioridade 2', 
												name: 'inprioridade', 
												inputValue: 2
											}]
										},{
											xtype: 'radiogroup',
											fieldLabel: 'Relatorio Entregue?',
											allowBlank:false,
											value:e.attributes.data.inrelatorio,
											items: [{
												boxLabel: 'Sim', 
												name: 'inrelatorio', 
												inputValue: 1
											},{
												boxLabel: 'Nao', 
												name: 'inrelatorio', 
												inputValue: 0
											}]
										},new Ext.form.ComboBox({
											typeAhead: true,
											triggerAction: 'all',
											lazyRender:true,
											mode: 'local',
											store: storedivisao,
											valueField: 'iddivisao',
											displayField: 'desdivisao',
											fieldLabel: 'Divis&atilde;o',
											hiddenName:'iddivisao',
											hiddenValue:e.attributes.data.indivisao,
											value:e.attributes.data.indivisao,
											width:280,
											submitValue:true
										})],
										buttons:[{
											text:'Salvar',
											iconCls:'ico_disk',
											handler:function(){
												Ext.getCmp('frmalteracao').getForm().submit({
													url:'ajax/alttreinamento.php',
													params:{
														id:e.attributes.data.id
													},
													success:function(){
														Ext.MessageBox.alert('','Altera&ccedil;&atilde;o feita com Sucesso!');
														store.reload();
														tree.root.reload();
														tabs.getActiveTab().destroy();
														Ext.getCmp('winalteracao').close();
													}
												});
											}
										}]
									}]
								}).show();
							}
						},'-',{
							text:'Excluir Treinamento',
							iconCls:'ico_erase',
							handler:function(){
								Ext.MessageBox.confirm('','Deseja realmente excluir este projeto?',function(btn){
									if(btn == 'yes'){
										Ext.Ajax.request({
											url: 'ajax/excprojeto.php',
											success: function(){
												Ext.MessageBox.alert('','Treinamento excluido com Sucesso!');
												store.reload();
												tree.root.reload();
												tabs.getActiveTab().destroy();
											},
											params:{
												id:e.attributes.data.id
											}
										});
									}
								});
							}
						}],
						items:[{
							xtype:'fieldset',
							title: 'Painel Administrativo',
							defaultType: 'textfield',
							collapsed: false,
							flex:1,
							items:[{
								xtype:'form',
								id:'frmalterarstatus',
								labelWidth: 120,
								border:false,
								width:500,
								defaults:{allowBlank:false,width:165},
								items:[{
									fieldLabel: 'Previs&atilde;o de Entrega',
									name: 'dtprevisao',
									xtype:'datefield',
									allowBlank:true,
									value:Ext.util.Format.date(e.attributes.data.dtprevisao,'d/m/Y'),
								},{
									fieldLabel: '% Concluida',
									name: 'desstatus',
									xtype:'numberfield',
									value:e.attributes.data.desstatus
								},{
									xtype:'button',
									fieldLabel:'Status',
									name:'instatus',
									height:20,
									width:165,
									id:'btn-'+e.id,
									enableToggle: true,												
									listeners:{
										'beforerender':function(obj){
											if(e.attributes.data.instatus == 0){
												obj.pressed = false;
												obj.setText('Iniciar');
												obj.setIconClass('ico_Play');
											} else if (e.attributes.data.instatus == 1){
												obj.pressed = true;
												obj.setText('Pausar');
												obj.setIconClass('ico_stop');
											} else {
												obj.setText('Concluido');
												obj.setIconClass('ico_accept');
												obj.disable();
											}
										},
										'toggle':function(obj,pressed){
											if(pressed == true){
												obj.setText('Pausar');
												obj.setIconClass('ico_stop');
											} else {
												obj.setText('Iniciar');
												obj.setIconClass('ico_Play');
											}
										}
									}
								}],
								buttons:[{
									text:'Salvar',
									iconCls:'ico_disk',
									handler:function(){
										if(Ext.getCmp('frmalterarstatus').getForm().isValid()){
											var status = ((Ext.getCmp('btn-'+e.id).pressed == true) ? "1" : "0");
											Ext.getCmp('frmalterarstatus').getForm().submit({
												url:'ajax/cadandamento.php',
												params:{
													instatus:status,
													id:e.attributes.data.id
												},
												success:function(){
													Ext.MessageBox.alert('','Alterações feitas com Sucesso!');
													store.reload();
													tree.root.reload();
												}
											});
										}
									}
								},{
									text:'Finalizar',
									iconCls:'ico_tick',
									handler:function(){
										Ext.MessageBox.confirm('','Deseja concluir o desenvolvimento deste treinamento?',function(btn){
											if(btn == 'yes'){
												Ext.Ajax.request({
													url: 'ajax/cadconclusao.php',
													success: function(){
														Ext.MessageBox.alert('','Treinamento concluido com Sucesso!');
														store.reload();
														tabs.getActiveTab().destroy();
													},
													params:{
														id:e.attributes.data.id
													}
												});
											}						
										});
									}
								}],
								listeners:{
									'close':function(p){
										tabs.getActiveTab().destroy();
									},
									'afterrender':function(obj){
										if(e.attributes.data.inprioridade == 1){
											obj.setIconClass('ico_flag_blue');
										} else {
											obj.setIconClass('ico_flag_red');
										}								
									}		
								}
							}],
						}],
						listeners:{
							'close':function(p){
								tabs.getActiveTab().destroy();
							},
							'afterrender':function(obj){
								if(e.attributes.data.inprioridade == 1){
									obj.setIconClass('ico_flag_blue');
								} else {
									obj.setIconClass('ico_flag_red');
								}								
							}		
						}
					});
					tabs.setActiveTab(tabs.items.items.length-2);
				}
			}
		});
//______________________________________PANEL TREINAMENTOS EM ESPERA (CENTER)_________________________________________________							 
		var panelTreinamentoEspera = new Ext.Panel({
			title:'Treinamentos em Espera',
			iconCls:'ico_hourglass',
			//baseCls:'x-plain',
			id:'Conteudo',
			region:'center',
			width:'55%',
			margins:'4 0 4 4',
			collapsible: true,
			split:true,
			layout:'border',
			border:true,
			autoScroll:true,
			items:[{
				iconCls:'ico_page',
				region:'center',
				height:'50%',
				autoScroll:true,
				items:[
					   
					   tree
					   
				],
				tbar:[{
					  text:'Gerenciar Divisões',
					  iconCls:'ico_application_form_edit',
					  handler:function(obj){
						new Ext.Window({
							width:300,
							height:260,
							modal:true,
							id:'wincadastrar2',
							title:obj.text,
							autoScroll:true,
							items:[new Ext.grid.GridPanel({
								store: storedivisao,
								border:false,
								sm: new Ext.grid.RowSelectionModel({
									singleSelect: true
								}),
								autoHeight:true,
								//height:200,
								columns: [{
									id:'desdivisao',
									header: "Divisao", 
									sortable: true, 
									dataIndex: 'desdivisao'
									},			
								],
								viewConfig: {
									forceFit:true
								},
								stripeRows: true,
								listeners:{
									'rowClick':function(obj,index,node){
										data = obj.store.data.items[index].data;
										new Ext.Window({
											width:260,
											height:110,
											modal:true,
											id:'winalterardivisao',
											title:'Gerenciar Divisao',
											items:[{
												xtype:'form',
												defaultType: 'textfield',
												id:'frmalterardivisao',
												labelWidth: 50,
												border:false,
												padding:5,
												width:250,
												items:[{
													fieldLabel: 'Divis&atilde;o',
													name: 'caddivisao',
													width:180,
													allowBlank:false,
													value:data.desdivisao
												}],
												buttons:[{
													text:'Salvar',
													iconCls:'ico_disk',
													handler:function(){
														if(Ext.getCmp('frmalterardivisao').getForm().isValid()){
															Ext.getCmp('frmalterardivisao').getForm().submit({
																url:'ajax/altdivisao.php',
																success:function(){
																	Ext.MessageBox.alert('','Divisão alterada com Sucesso!');
																	storedivisao.reload();
																	Ext.getCmp('winalterardivisao').close();
																},
																params:{
																	id:data.iddivisao
																}
															});
														}
													}
												},{
													text:'Excluir',
													iconCls:'ico_delete',
													handler:function(){
														Ext.MessageBox.confirm('','Deseja excluir realmente?',function(btn){
															if(btn == 'yes'){
																Ext.Ajax.request({
																	url: 'ajax/excdivisao.php',
																	success: function(){
																		Ext.MessageBox.alert('','Divisão excluida com Sucesso!');
																		storedivisao.reload();
																		Ext.getCmp('winalterardivisao').close();
																	},
																	params:{
																		id:data.iddivisao
																	}
																});
															}
														});
													}
												}]
											}]
										}).show();
									}
								},
								tbar:[{
									text:'Adicionar Divisão',
									iconCls:'ico_add',
									border:false,
									handler:function(){
										new Ext.Window({
											width:300,
											height:110,
											modal:true,
											id:'wincadastrardivisao',
											title:'Cadastrar novo curso',
											items:[{
												xtype:'form',
												defaultType: 'textfield',
												id:'frmcadastrodivisao',
												labelWidth: 75,
												border:false,
												padding:5,
												width:290,
												items:[{
													fieldLabel: 'Divisão',
													name: 'caddivisao',
													width:190,
													allowBlank:false
												}],
												buttons:[{
													text:'Salvar',
													iconCls:'ico_disk',
													handler:function(){
														if(Ext.getCmp('frmcadastrodivisao').getForm().isValid()){
															Ext.getCmp('frmcadastrodivisao').getForm().submit({
																url:'ajax/caddivisao.php',
																success:function(){
																	Ext.MessageBox.alert('','Registro Salvo com Sucesso!');
																	Ext.getCmp('wincadastrardivisao').close();
																	
																	console.log('salvo');
																	
																	storedivisao.reload();
																},
																failure:function(obj,msg){
																	Ext.MessageBox.show({
																		title:'',
																		msg: msg.result.msg,
																		icon: Ext.MessageBox.ERROR,
																		buttons: Ext.MessageBox.OK,
																	});
																}
															});
														}
													}
												}]
											}]
										}).show();
									}
								}]
							})]
						}).show();
					}
				},'-',{
					text:'Add Treinamentos',
					iconCls:'ico_add',
					handler:function(){
						new Ext.Window({
							width:400,
							height:190,
							modal:true,
							id:'wincadastrar',
							title:'Cadastrar novo curso',
							items:[{
								xtype:'form',
								defaultType: 'textfield',
								id:'frmcadastro',
								labelWidth: 175,
								border:false,
								padding:5,
								width:390,
								items:[{
									fieldLabel: 'Treinamento',
									name: 'destreinamento',
									width:190,
									allowBlank:false
								},{
									xtype: 'radiogroup',
									fieldLabel: 'Prioridade',
									allowBlank:false,
									items: [{
										boxLabel: 'Prioridade 1', 
										name: 'inprioridade', 
										inputValue: 1
									},{
										boxLabel: 'Prioridade 2', 
										name: 'inprioridade', 
										inputValue: 2
									}]
								},{
									xtype: 'radiogroup',
									fieldLabel: 'Relatorio Entregue?',
									allowBlank:false,
									items: [{
										boxLabel: 'Sim', 
										name: 'inrelatorio', 
										inputValue: 1
									},{
										boxLabel: 'Nao', 
										name: 'inrelatorio', 
										inputValue: 0
									}]
								},new Ext.form.ComboBox({
									typeAhead: true,
									triggerAction: 'all',
									lazyRender:true,
									mode: 'local',
									store: storedivisao,
									valueField: 'iddivisao',
									displayField: 'desdivisao',
									fieldLabel: 'Divis&atilde;o',
									hiddenName:'indivisao',
									hiddenValue:'iddivisao',
									width:190,
									submitValue:true
								})],
								buttons:[{
									text:'Salvar',
									iconCls:'ico_disk',
									handler:function(){
										if(Ext.getCmp('frmcadastro').getForm().isValid()){
											Ext.getCmp('frmcadastro').getForm().submit({
												url:'ajax/cadtreinamento.php',
												success:function(){
													Ext.MessageBox.alert('','Registro Salvo com Sucesso!');
													Ext.getCmp('wincadastrar').close();
													tree.root.reload();
													store.reload();
													tabs.getActiveTab().destroy();
												}
											});
										}
									}
								}]
							}]
						}).show();
					}
				 }],
			},{
				title:'Detalhes',
				height:340,
				region:'south',
				iconCls:'ico_BlackFill_pen',
				border: true,
				id:'detalhes',
				split:true,
				autoScroll:true,
				items:[tabs],
			}]
		});
		
//____________________________________________PANEL LISTA DE TREINAMENTOS EM DESENVOLVIMENTO OU CONCLUÍDO (EAST)________________________________________________		
		var panelTreinamentoConcluido = new Ext.Panel({
			title:'Lista de Treinamentos em Desenvolvimento ou Concluído',
			region:'east',
			iconCls:'ico_BlackFill_order',
			/*split:false,*/
			width:'45%',
			margins:'4 4 4 0',
			collapsible: true,
			border:false,
			height:500,
			border:true,
			split:true,
			autoScroll:true,
			layout:'fit',
			bbar:[{
				  text:'Imprimir Lista',
				  iconCls:'ico_print',
				  handler:function(){
						new Ext.Window({
							width:500,
							height:110,
							modal:true,
							id:'winimprimir',
							title:'Tipo de Impress&atilde;o',
							items:[{
								xtype:'form',
								defaultType: 'textfield',
								id:'frmcadastro',
								labelWidth: 100,
								border:false,
								padding:5,
								width:480,
								items:[{
									xtype: 'radiogroup',
									fieldLabel: '<b>Escolha o Tipo</b>',
									allowBlank:false,
									id:'impressao',
									items: [{
										boxLabel: 'Concluido', 
										name: 'impressao',
										inputValue: 2
									},{
										boxLabel: 'Em Andamento', 
										name: 'impressao', 
										inputValue: 1
									},{
										boxLabel: 'Parado', 
										name: 'impressao', 
										inputValue: 0
									}]
								}]							
							}],
							buttons:[{
								text:'Imprimir',
								iconCls:'ico_print',
								handler:function(){
									window.open('print.php?tipo='+Ext.getCmp('impressao').getValue(),'Print','width=400, height=400, top=0, left=0, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, addressbar=no, menubar=no, resizable=yes,maximize=yes');
									Ext.getCmp('winimprimir').close();
								}
							}]
						}).show();
					}
			  	},'-','Legenda: ','-',{
				   text:'Prioridade 1',
				   iconCls:'ico_flag_blue',
			  	},'-',{
				   text:'Prioridade 2',
				   iconCls:'ico_flag_red',
			}],	
			items:[new Ext.grid.GridPanel({
					store: store,
					border:false,
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true
					}),
					id:'grid',
					autoHeight:true,
					columns: [new Ext.grid.RowNumberer({
						width: 30
					}),{
						width: 200,
						id:'nmcurso',
						header: "Nome de Treinamento", 
						sortable: true, 
						dataIndex: 'nmcurso', 
						renderer:fncolor
					},{
						id:'inprioridade',
						header: "Prioridade", 
						sortable: true, 
						dataIndex: 'inprioridade', 
						renderer:fnprioridade
					},{
						id:'desstatus',
						header: "% Concluida", 
						sortable: true, 
						dataIndex: 'desstatus'
					},{
						id:'dtprevisao',
						header: "Previs&atilde;o para Conclus&atilde;o", 
						sortable: true, 
						dataIndex: 'dtprevisao', 
						renderer: Ext.util.Format.dateRenderer('d/m/Y')
					},{
						id:'instatus',
						header: "Status", 
						sortable: true, 
						dataIndex: 'instatus', 
						renderer:fnstatus
					},{
						header: "Divis&atilde;o", 
						sortable: true, 
						dataIndex: 'desdivisao'
					}],
					viewConfig: {
						forceFit:true
					},
					stripeRows: true,
					listeners:{
						'rowclick':function(obj,index,node){
							data = obj.store.data.items[index].data;
							tabs.removeAll();
							tabs.add({
								/*title:data.nmcurso,*/
								title:'Informações',
								closable:true,
								iconCls: 'ico_How-to',
								padding:5,
								tbar:[{
									text:'Alterar Solicita&ccedil;&atilde;o',
									iconCls:'ico_pencil',
									handler:function(){
										new Ext.Window({
											width:500,
											height:180,
											modal:true,
											id:'winalteracao',
											title:'Alterar Solicita&ccedil;&atilde;o',
											items:[{
												xtype:'form',
												defaultType: 'textfield',
												id:'frmalteracao',
												labelWidth: 175,
												border:false,
												padding:5,
												width:480,
												items:[{
													fieldLabel: 'Treinamento',
													name: 'nmcurso',
													value:data.nmcurso,
													width:280,
												},{
													xtype: 'radiogroup',
													fieldLabel: 'Prioridade',
													allowBlank:false,
													value:data.inprioridade,
													items: [{
														boxLabel: 'Prioridade 1', 
														name: 'inprioridade', 
														inputValue: 1
													},{
														boxLabel: 'Prioridade 2', 
														name: 'inprioridade', 
														inputValue: 2
													}]
												},{
													xtype: 'radiogroup',
													fieldLabel: 'Relatorio Entregue?',
													allowBlank:false,
													value:data.inrelatorio,
													items: [{
														boxLabel: 'Sim', 
														name: 'inrelatorio', 
														inputValue: 1
													},{
														boxLabel: 'Nao', 
														name: 'inrelatorio', 
														inputValue: 0
													}]
												},new Ext.form.ComboBox({
													typeAhead: true,
													triggerAction: 'all',
													lazyRender:true,
													mode: 'local',
													store: storedivisao,
													valueField: 'iddivisao',
													displayField: 'desdivisao',
													fieldLabel: 'Divis&atilde;o',
													hiddenName:'iddivisao',
													hiddenValue:data.indivisao,
													value:data.indivisao,
													width:280,
													submitValue:true
												})],
												buttons:[{
													text:'Salvar',
													iconCls:'ico_disk',
													handler:function(){
														Ext.getCmp('frmalteracao').getForm().submit({
															url:'ajax/alttreinamento.php',
															params:{
																id:data.id
															},
															success:function(){
																Ext.MessageBox.alert('','Altera&ccedil;&atilde;o feita com Sucesso!');
																store.reload();
																tree.root.reload();
																tabs.getActiveTab().destroy();
																Ext.getCmp('winalteracao').close();
															}
														});
													}
												}]
											}]
										}).show();
									}
								},'-',{
									text:'Excluir Treinamento',
									iconCls:'ico_erase',
									handler:function(){
										Ext.MessageBox.confirm('','Deseja realmente excluir este projeto?',function(btn){
											if(btn='yes'){														
												Ext.Ajax.request({
													url: 'ajax/excprojeto.php',
													success: function(){
														Ext.MessageBox.alert('','Treinamento excluido com Sucesso!');
														store.reload();
														tree.root.reload();
														tabs.getActiveTab().destroy();
													},
													params:{
														id:data.id
													}
												});	
											}
										});
									}
								}],
								items:[{
									xtype:'fieldset',
									title: 'Informações ',
									autoHeight:true,
									defaultType: 'textfield',
									collapsed: false,
									items:[{
										xtype:'form',
										defaultType: 'textfield',
										id:'frmstatus',
										labelWidth: 120,
										border:false,
										width:500,
										defaults:{style:'border:none; background:none;',width:290},
										items:[{
											fieldLabel: 'Treinamento',
											name: 'destreinamento',
											value:data.nmcurso
										},{
											fieldLabel: 'Prioridade',
											name: 'inprioridade',
											value:data.inprioridade
										},{
											fieldLabel: 'Divis&atilde;o',
											name: 'desdivisao',
											value:data.desdivisao
										},{
											fieldLabel: 'Cadastrado em',
											name: 'dtcadastro',
											value:Ext.util.Format.date(data.dtcadastro,'d/m/Y')
										},{
											fieldLabel: 'Solicitante',
											name: 'nmusuario',
											value:data.nmusuario
										},{
											fieldLabel: 'Concluido em',
											name: 'dtfinalizado',
											value:Ext.util.Format.date(data.dtfinalizado,'d/m/Y')
										},{
											fieldLabel: 'Relatorio Entregue',
											name: 'dtfinalizado',
											value:data.inrelatorio,
										},{
											xtype:'button',
											name:'btn_retornar',
											id:'btn_retornar',
											hidden:true,
											text:'Retornar Projeto',
											iconCls:'ico_page_edit',
											handler:function(){
												Ext.MessageBox.confirm('','Deseja iniciar novamente este projeto?',function(btn){
													Ext.Ajax.request({
														url: 'ajax/altprojeto.php',
														success: function(){
															Ext.MessageBox.alert('','Treinamento retomado com Sucesso!');
															store.reload();
															tabs.getActiveTab().destroy();
														},
														params:{
															id:data.id
														}
													});	
												});
											}
										}]
									}],
									listeners:{
										'beforerender':function(obj){
											if(data.dtfinalizado == null){
												Ext.getCmp('frmstatus').items.items[5].setValue('-');
											} else {
												tabs.setIconClass('ico_accept');
											}
											
											if(data.inrelatorio == 1){
												Ext.getCmp('frmstatus').items.items[6].setValue('Sim');
											} else {
												Ext.getCmp('frmstatus').items.items[6].setValue('Não');
											}
										},
										'afterrender':function(obj){
											if(data.instatus == 2){
												Ext.getCmp('btn_retornar').show();
											}
										}
									}
								},/*{
									xtype:'fieldset',
									title: 'Painel Administrativo',
									autoHeight:true,
									defaultType: 'textfield',
									collapsed: false,
									flex:1,
									items:[{
										xtype:'form',
										id:'frmalterarstatus',
										labelWidth: 120,
										border:false,
										width:500,
										defaults:{allowBlank:false,width:165},
										items:[{
											fieldLabel: 'Previs&atilde;o de Entrega',
											name: 'dtprevisao',
											xtype:'datefield',
											allowBlank:true,
											value:Ext.util.Format.date(data.dtprevisao,'d/m/Y'),
										},{
											fieldLabel: '% Concluida',
											name: 'desstatus',
											xtype:'numberfield',
											value:data.desstatus
										},{
											xtype:'button',
											fieldLabel:'Status',
											name:'instatus',
											height:20,
											width:165,
											id:'btn-'+data.id,
											enableToggle: true,												
											listeners:{
												'beforerender':function(obj){
													if(data.instatus == 0){
														obj.pressed = false;
														obj.setText('Iniciar');
														obj.setIconClass('ico_Play');
													} else if (data.instatus == 1){
														obj.pressed = true;
														obj.setText('Pausar');
														obj.setIconClass('ico_stop');
													}
												},
												'toggle':function(obj,pressed){
													if(pressed == true){
														obj.setText('Pausar');
														obj.setIconClass('ico_stop');
													} else {
														obj.setText('Iniciar');
														obj.setIconClass('ico_Play');
													}
												}
											}
										}],
										buttons:[{
											text:'Salvar',
											iconCls:'ico_disk',
											handler:function(){
												if(Ext.getCmp('frmalterarstatus').getForm().isValid()){
													var status = ((Ext.getCmp('btn-'+data.id).pressed == true) ? "1" : "0");
													Ext.getCmp('frmalterarstatus').getForm().submit({
														url:'ajax/cadandamento.php',
														params:{
															instatus:status,
															id:data.id
														},
														success:function(){
															Ext.MessageBox.alert('','Alterações feitas com Sucesso!');
															store.reload();
															tree.root.reload();
														}
													});
												}
											}
										},{
											text:'Finalizar',
											iconCls:'ico_tick',
											handler:function(){
												Ext.MessageBox.confirm('','Deseja concluir o desenvolvimento deste treinamento?',function(btn){
													if(btn == 'yes'){
														Ext.Ajax.request({
															url: 'ajax/cadconclusao.php',
															success: function(){
																Ext.MessageBox.alert('','Treinamento concluido com Sucesso!');
																store.reload();
																tabs.getActiveTab().destroy();
															},
															params:{
																id:data.id
															}
														});
													}						
												});
											}
										}]
									}],
									listeners:{
										'beforerender':function(obj){
											if(data.instatus == 2){
												obj.hide();
											}
										}
									}
								}*/],
								listeners:{
									'close':function(p){
										tabs.getActiveTab().destroy();
									},
									'afterrender':function(obj){
										if(data.inprioridade == 1){
											obj.setIconClass('ico_flag_blue');
										} else {
											obj.setIconClass('ico_flag_red');
										}
									}		
								}
							},{
								tbar:[{
									text:'Alterar Solicita&ccedil;&atilde;o',
									iconCls:'ico_pencil',
									handler:function(){
										new Ext.Window({
											width:500,
											height:180,
											modal:true,
											id:'winalteracao',
											title:'Alterar Solicita&ccedil;&atilde;o',
											items:[{
												xtype:'form',
												defaultType: 'textfield',
												id:'frmalteracao',
												labelWidth: 175,
												border:false,
												padding:5,
												width:480,
												items:[{
													fieldLabel: 'Treinamento',
													name: 'nmcurso',
													value:data.nmcurso,
													width:280,
												},{
													xtype: 'radiogroup',
													fieldLabel: 'Prioridade',
													allowBlank:false,
													value:data.inprioridade,
													items: [{
														boxLabel: 'Prioridade 1', 
														name: 'inprioridade', 
														inputValue: 1
													},{
														boxLabel: 'Prioridade 2', 
														name: 'inprioridade', 
														inputValue: 2
													}]
												},{
													xtype: 'radiogroup',
													fieldLabel: 'Relatorio Entregue?',
													allowBlank:false,
													value:data.inrelatorio,
													items: [{
														boxLabel: 'Sim', 
														name: 'inrelatorio', 
														inputValue: 1
													},{
														boxLabel: 'Nao', 
														name: 'inrelatorio', 
														inputValue: 0
													}]
												},new Ext.form.ComboBox({
													typeAhead: true,
													triggerAction: 'all',
													lazyRender:true,
													mode: 'local',
													store: storedivisao,
													valueField: 'iddivisao',
													displayField: 'desdivisao',
													fieldLabel: 'Divis&atilde;o',
													hiddenName:'iddivisao',
													hiddenValue:data.indivisao,
													value:data.indivisao,
													width:280,
													submitValue:true
												})],
												buttons:[{
													text:'Salvar',
													iconCls:'ico_disk',
													handler:function(){
														Ext.getCmp('frmalteracao').getForm().submit({
															url:'ajax/alttreinamento.php',
															params:{
																id:data.id
															},
															success:function(){
																Ext.MessageBox.alert('','Altera&ccedil;&atilde;o feita com Sucesso!');
																store.reload();
																tree.root.reload();
																tabs.getActiveTab().destroy();
																Ext.getCmp('winalteracao').close();
															}
														});
													}
												}]
											}]
										}).show();
									}
								},'-',{
									text:'Excluir Treinamento',
									iconCls:'ico_erase',
									handler:function(){
										Ext.MessageBox.confirm('','Deseja realmente excluir este projeto?',function(btn){
											if(btn=='yes'){
												Ext.Ajax.request({
													url: 'ajax/excprojeto.php',
													success: function(){
														Ext.MessageBox.alert('','Treinamento excluido com Sucesso!');
														store.reload();
														tree.root.reload();
														tabs.getActiveTab().destroy();
													},
													params:{
														id:data.id
													}
												});	
											}
										});
									}
								}],
								/*{
							text:'Excluir Treinamento',
							iconCls:'ico_erase',
							handler:function(){
								Ext.MessageBox.confirm('','Deseja realmente excluir este projeto?',function(btn){
									if(btn == 'yes'){
										Ext.Ajax.request({
											url: 'ajax/excprojeto.php',
											success: function(){
												Ext.MessageBox.alert('','Treinamento excluido com Sucesso!');
												store.reload();
												tree.root.reload();
												tabs.getActiveTab().destroy();
											},
											params:{
												id:e.attributes.data.id
											}
										});
									}
								});
							}
						}*/
								/*title:data.nmcurso,*/
								title:'Ações',
								closable:true,
								iconCls: 'ico_How-to',
								padding:5,
								items:[{
									xtype:'fieldset',
									title: 'Painel Administrativo',
									autoHeight:true,
									defaultType: 'textfield',
									collapsed: false,
									flex:1,
									items:[{
										xtype:'form',
										id:'frmalterarstatus',
										labelWidth: 120,
										border:false,
										width:500,
										defaults:{allowBlank:false,width:165},
										items:[{
											fieldLabel: 'Previs&atilde;o de Entrega',
											name: 'dtprevisao',
											xtype:'datefield',
											allowBlank:true,
											value:Ext.util.Format.date(data.dtprevisao,'d/m/Y'),
										},{
											fieldLabel: '% Concluida',
											name: 'desstatus',
											xtype:'numberfield',
											value:data.desstatus
										},{
											xtype:'button',
											fieldLabel:'Status',
											name:'instatus',
											height:20,
											width:165,
											id:'btn-'+data.id,
											enableToggle: true,												
											listeners:{
												'beforerender':function(obj){
													if(data.instatus == 0){
														obj.pressed = false;
														obj.setText('Iniciar');
														obj.setIconClass('ico_Play');
													} else if (data.instatus == 1){
														obj.pressed = true;
														obj.setText('Pausar');
														obj.setIconClass('ico_stop');
													}
												},
												'toggle':function(obj,pressed){
													if(pressed == true){
														obj.setText('Pausar');
														obj.setIconClass('ico_stop');
													} else {
														obj.setText('Iniciar');
														obj.setIconClass('ico_Play');
													}
												}
											}
										}],
										buttons:[{
											text:'Salvar',
											iconCls:'ico_disk',
											handler:function(){
												if(Ext.getCmp('frmalterarstatus').getForm().isValid()){
													var status = ((Ext.getCmp('btn-'+data.id).pressed == true) ? "1" : "0");
													Ext.getCmp('frmalterarstatus').getForm().submit({
														url:'ajax/cadandamento.php',
														params:{
															instatus:status,
															id:data.id
														},
														success:function(){
															Ext.MessageBox.alert('','Alterações feitas com Sucesso!');
															store.reload();
															tree.root.reload();
														}
													});
												}
											}
										},{
											text:'Finalizar',
											iconCls:'ico_tick',
											handler:function(){
												Ext.MessageBox.confirm('','Deseja concluir o desenvolvimento deste treinamento?',function(btn){
													if(btn == 'yes'){
														Ext.Ajax.request({
															url: 'ajax/cadconclusao.php',
															success: function(){
																Ext.MessageBox.alert('','Treinamento concluido com Sucesso!');
																store.reload();
																tabs.getActiveTab().destroy();
															},
															params:{
																id:data.id
															}
														});
													}						
												});
											}
										}],
									}],								
								}],	
								listeners:{
									'close':function(p){
										tabs.getActiveTab().destroy();
									},
									'afterrender':function(obj){
										if(data.inprioridade == 1){
											obj.setIconClass('ico_flag_blue');
										} else {
											obj.setIconClass('ico_flag_red');
										}
									}		
								}
							});
							tabs.setActiveTab(tabs.items.items.length-2);
						}
					}
				})],
			autoScroll:true
		});
		
//___________________________________MAIN PANEL_______________________________________________________________________________		
		new Ext.FullPanel({
			id:'SistVizualizacaoAtivEditora', //Id da 'Window'
			height:Page.height - 128,
			plain:false,
			modal:true, //Bloquear conteúdo da página enquanto a janela está ativa
			items:[
				   panelTreinamentoEspera,
				   panelTreinamentoConcluido
			],
			layout:'border',
			bbar:['->',{
				  text:'',
			}],
		});

//___________________________Reajusta o tamanho da tela____________________________________________________________________________________
	window.onresize = function(){			 
		//Obtem o tamanho no exato momento
		var a = getPageSize();	
		//No componente com determinado 'Id', é setado o novo tamanho (Para reajuste da tela)		 
		Ext.getCmp('SistVizualizacaoAtivEditora').setSize(a.width,a.height - 122);
	};
});
</script>