<?php
# @AUTOR = ricardo #
# @AUTOR = massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
Ext.onReady(function(){		
	/* FUNÇÕES INTERNAS */
	function reloadEventos() {
		var myCursos = check_cursos.selections.items;
		var infos = [];

		for (i = 0; i < myCursos.length; i++) {
			infos[i] = myCursos[i].json.cursotipo_id;
		}
		
		eventos_store.reload({
			params: {
				tipos: infos.toString(),
				dt: Ext.getCmp("dt_evento").getValue().format("Y-m-d")
			}
		});
		
		Ext.getCmp("titulo_do_evento").setValue();
		Ext.getCmp("data_do_evento").setValue();
		Ext.getCmp("hora_do_evento").setValue();
		Ext.getCmp("vagas_do_evento").setValue();
		Ext.getCmp("palestrante_do_evento").setValue();
		Ext.getCmp("local_do_evento").setValue();
	}

	/* STORES */
	var tipo_store = new Ext.data.JsonStore({
		url: '/simpacweb/modulos/fit/adm_eventos/json/list_cursos_tipos.php',
		root: 'myData',
		fields: [{
			name: 'cursotipo_id',
			type: 'int'
		}, {
			name: 'cursotipo_titulo',
			type: 'string'
		}],
		autoLoad: true,
		listeners: {
			load: function(){
				Ext.getCmp('grid_tipos').getSelectionModel().selectAll();
			}
		}
	});
	
	var comboStoreCursosTipos = new Ext.data.JsonStore({
		url: '/simpacweb/modulos/fit/adm_eventos/json/list_cursos_tipos.php',
		root: 'myData',
		fields: [{name: 'cursotipo_id',type: 'int'},
				 {name: 'cursotipo_titulo',type: 'string'}],
		autoLoad:true
	});
	
	var comboStoreCursos = new Ext.data.JsonStore({
	  url:'/simpacweb/modulos/fit/adm_eventos/json/list_getcursobytipo.php',
	  root:'myData',
	  fields:[{name: 'curso_id',type: 'int'},
			  {name: 'curso_titulo',type: 'string'}],		
	  //autoLoad:true,
		listeners:{
			/*load:function(me,records,options){
				if(me.totalLength < 1){
					Ext.MessageBox.erro('Nenhum estado adicionado','Favor, insira os estados deste país');
				}
			},*/
		},
   });	
	/*var comboStoreCursos = new Ext.data.JsonStore({
		url: '/simpacweb/modulos/fit/adm_eventos/json/list_cursos.php',
		root: 'myData',
		fields: [{name: 'curso_id',type: 'int'},
				 {name: 'curso_titulo',type: 'string'}],			
	});*/
	
	var eventos_store = new Ext.data.JsonStore({
		url: '/simpacweb/modulos/fit/adm_eventos/json/list_cadastro_curso_tipo.php',
		root: 'myData',
		fields: [{
			name: 'cadastroid',
			type: 'int'
		},{
			name: 'cadastrotitulo',
			type: 'string'
		}, {
			name: 'cadastrodata',
			type: 'date',
			dateFormat: 'timestamp'
		}, {
			name: 'cadastrohora',
			type: 'string'
		}, {
			name: 'cadastrovagas',
			type: 'string'
		}, {
			name: 'cadastropalestrante',
			type: 'string'
		}, {
			name: 'cadastrolocal',
			type: 'string'
		},{
			name: 'cadastroid',
			type: 'int'
		},{
			name: 'ativo',
			type: 'int'
		},{
			name: 'cadastrodescricao',
			type: 'string'
		},{
			name: 'cadastrovagas',
			type: 'int'
		},{
			name: 'cadastrolink',
			type: 'string'
		},{
			name: 'cadastrocurso',
			type: 'string'
		},{
			name: 'cursos',
			type: 'int'
		}]
	});
	
	var alunos_store = new Ext.data.JsonStore({
		url: '/simpacweb/modulos/fit/adm_eventos/json/get_cadpalestra.php',
		root: 'myData',
		fields: [{
			name: 'alunonome',
			type: 'string'
		},{
			name: 'palestraId',
			type: 'int'
		},{
			name: 'palestraCadastroId',
			type: 'int',
		}]
	});
	
	var alunosinfo_store = new Ext.data.JsonStore({
		url: '/simpacweb/modulos/fit/adm_eventos/json/get_cadpalestra-all.php',
		root: 'myData',
		fields: [{
			name: 'palestraId',
			type: 'int'
		},{
			name: 'palestraNome',
			type: 'string'
		},{
			name: 'palestraRG',
			type: 'string'
		},{
			name: 'palestraEmail',
			type: 'string'
		},{
			name: 'palestraEvento',
			type: 'string'
		},{
			name: 'palestraDDD',
			type: 'string',
		},{
			name: 'palestraFone',
			type: 'string'
		},{
			name: 'palestraEndereco',
			type: 'string'
		},{
			name: 'palestraEmpresa',
			type: 'string'			
		},{
			name: 'palestraCargo',
			type: 'string'
		},{
			name: 'palestraEscolaridade',
			type: 'string'
		},{
			name: 'dtcadastro',
			type: 'date',
			dateFormat: 'timestamp'
		}]
	});
	
	var totalinscritos_store = new Ext.data.JsonStore({
		url: '/simpacweb/modulos/fit/adm_eventos/json/get_totalinscritos.php',
		root: 'myData',
		fields: [{
			name: 'totalinscritos',
			type: 'int'
		}],
		listeners:{
			'load':function(a){
				var totalinscritos = a.data.items[0].json.totalinscritos;
				var infototalinscrito = Ext.getCmp('infototalinscrito');
				var infototalinscritozero = Ext.getCmp('infototalinscritozero');
				
				function fn_infoInscrito(infototalinscrito,infototalinscritozero,v){
					if(infototalinscrito.isVisible()){
						if(v == true){
							infototalinscrito.setText(totalinscritos);
							infototalinscrito.show();
							infototalinscritozero.hide()
						}else{
							infototalinscritozero.setText(totalinscritos);
							infototalinscritozero.show();
							infototalinscrito.hide()
						}
					}else{
						infototalinscrito.hide();
						infototalinscritozero.hide()
					}
				}
				
				if(totalinscritos > 0){
					var v = true;
					fn_infoInscrito(infototalinscrito,infototalinscritozero,v)
				}else{		
					var v = false;
					fn_infoInscrito(infototalinscrito,infototalinscritozero,v)
				}
			}
		}
	});
	
	var arrayStoreSearch = new Ext.data.ArrayStore({
		fields:[{name:'search',type:'string'},
				{name: 'idsearch',type:'int'}],
		data:[['alunos',1],
			  ['RG',2],
			  ['Telefone',3],
			  ['E-mail',4],
			  ['Cargo',5]]
	});
	/* EXTENÇÕES */
	var check_cursos = new Ext.grid.CheckboxSelectionModel();
	check_cursos.addListener("selectionchange", function(){
		reloadEventos();
	});
	
	var expander = new Ext.ux.grid.RowExpander({
		tpl : new Ext.Template(
			'<p><b>Escolaridade: </b>{palestraEscolaridade}</p><p><b>Empresa: </b>{palestraEmpresa}</p><p><b>Cargo: </b>{palestraCargo}</p><p><b>Endereço: </b>{palestraEndereco}</p>'
		)
	});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	var cadastroeventos = new Ext.Panel({
		id:'panelcadastroeventos', 
		height:'100%',
		width:'100%',
		border:false,
		padding:15,
		items:[{
			xtype:'fieldset',
			title:'Cadastrar Eventos',
			autoHeight:true,
			collapsed:false,
			padding:2,
			margins:'25',
			buttonAlign:'center',
			defaults:{padding:5,margins:'15'},
			items:[{
				xtype: 'form',
				id:'formaddevento',
				padding: 5,
				height:450,
				width:660,
				border: false,
				buttonAlign:'left',
				defaults: {
					xtype: 'textfield',
					width: 100,
					margins:'10',
				},
				items: [{
					fieldLabel: 'Titulo',
					id:'tftitulo',
					name:'alunotitulo',
					allowBlank:false,
					anchor:'100%',
				}, {
					fieldLabel: 'Descrição',
					xtype:'textarea',
					autoHeight:true,
					id:'descricao',		
					height:65,
					width:536,
					name:'descricao',
					emptyText:'Adicione uma descrição...',
				},{
					xtype: 'datefield',
					fieldLabel: 'Data do Evento',
					id:'dtevento',
					allowBlank:false
				},{
					fieldLabel: 'Hora do Evento',
					xtype:'textfield',
					name:'horadoevento',
					id:'horaevento',
					emptyText:'00h00 às 00h00',
					allowBlank:false						
				},{
					fieldLabel: 'Link do Evento',
					name:'linkevento',
					anchor:'100%',
				},{
					xtype:'numberfield',
					fieldLabel: 'Nº de Vagas',
					name:'nrvagas',
					anchor:'100%',
				},{
					fieldLabel: 'Palestrante',
					name:'palestrante',
					anchor:'100%',
					allowBlank:false
				},{
					fieldLabel: 'Local',
					name:'local',
					anchor:'100%',
					allowBlank:false
				},{
					fieldLabel: 'Tipo',	
					xtype:'combo',
					id:'combo_cursostipos',
					width:300,
					autoHeight:true,
					store:comboStoreCursosTipos,
					displayField:'cursotipo_titulo',
					valueField:'cursotipo_id',
					typeAhead:true,
					triggerAction:'all',
					lazyRender:true,
					allowBlank:false,
					emptyText:'Selecione um tipo...',
					listeners:{
						'select':function(){
							if(Ext.getCmp('combo_cursostipos').isValid()){
								comboStoreCursos.load({
									params:{
									cursotipo_id:Ext.getCmp('combo_cursostipos').getValue()
									}
								});
							}
						}
					}
				},{
					fieldLabel: 'Curso',	
					xtype:'combo',
					id:'combo_cursos',
					width:300,
					autoHeight:true,
					store:comboStoreCursos,
					displayField:'curso_titulo',
					valueField:'curso_id',
					typeAhead:true,
					triggerAction:'all',
					lazyRender:true,
					name:'curso',
					emptyText:'Selecione um curso...',
					listeners:{
						'expand':function(){							
							if(!Ext.getCmp('combo_cursostipos').isValid()){
								Ext.MessageBox.info('Dica!','Por favor, Selecione um Tipo antes.')
							}else{
								comboStoreCursos.load({
									params:{
									cursotipo_id:Ext.getCmp('combo_cursostipos').getValue()
									}
								});
							}
						},
					}
				}],
				buttons:[{
					text:'Adicionar',
					iconCls:'ico_adicionar',
					scale:'medium',
					handler:function(){
						if(Ext.getCmp('formaddevento').getForm().isValid()){
							Ext.getCmp('formaddevento').getForm().submit({
								url:'/simpacweb/modulos/fit/adm_eventos/ajax/evento_save.php',
								params:{										
									cursotipo_id:Ext.getCmp('combo_cursostipos').getValue(),
									datadoevento:Ext.getCmp('dtevento').getValue().format('Y-m-d')
								},
							success:function(){
									Ext.getCmp('formaddevento').getForm().reset();
									Ext.getCmp('idformdescricao').getForm().reset();
									Ext.getCmp('idtabpanel').setActiveTab(0);
									Ext.MessageBox.info('Enviado!','Evento foi criado.');
								}
							})
						}else{
							Ext.MessageBox.warning('Aviso!','Preecha os dados obrigatórios.')
						}
					}
				}]			
			}]
		}]
	});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	var relatorioeventos = new Ext.Panel({
		id:'panelrelatorioeventos', 
		height:580,
		width:700,
		border:false,
		items: [{
			xtype: "panel",
			border: false,
			padding: 15,
			height: 250,
			layout: "table",
			layoutConfig: { columns: 2 },
			items: [{
				xtype: "panel",
				border: false,
				layout: "form",
				items: [{
					xtype: "datefield",
					id: "dt_evento",
					allowBlank: false,
					fieldLabel: "Depois de",
					listeners: {
						change: function() {
							reloadEventos();
						},
						select: function() {
							reloadEventos();
						}
					}
				}, {
					xtype: "grid",
					id: "grid_tipos",
					sm: check_cursos,
					width: 200,
					height: 200,
					store: tipo_store,
					columns:[check_cursos, {
						header: 'Tipo',
						dataIndex: 'cursotipo_titulo',
						width: 170
					}]
				}]
			}, {
				xtype: "grid",
				id: "grid_eventos",
				store: eventos_store,
				width: 465,
				height: 226,
				sm: new Ext.grid.RowSelectionModel({
					singleSelect: true
				}),
				columns: [{						
					header:'',
					dataIndex:'cursos',
					id:'hdcursos',
					hidden:true
				},{
					header:'',
					dataIndex:'cadastroid',
					id:'hdcadastroid',
					hidden:true
				},{
					header:'',
					width:20,
					id:'hdcadastroid',
					dataIndex:'ativo',
					renderer:function (v){	
						if(v == 1){
							return '<img src="/simpacweb/images/ico/16/accept.png"/>';
						}else{
							return '<img src="/simpacweb/images/ico/16/remove.png"/>';
						}														  
					}
					//hidden:true
				},{
					header: "Título",
					dataIndex: "cadastrotitulo",
					width: 150
				}, {
					xtype: 'datecolumn',
					header: "Data",
					dataIndex: "cadastrodata",
					format: "d/m/Y",
					width: 80
				}, {
					header: "Horário",
					dataIndex: "cadastrohora",
					width: 100
				}, {
					header: "Local",
					dataIndex: "cadastrolocal",
					width: 120
				}],
				viewConfig: {
					forceFit: true,
					showPreview: true,
					enableRowBody: true,
					getRowClass: function (record, rowIndex, rp, ds) {
						if (record.json.ativo != 1) {
							return 'red';
						}
					}
				},
				bbar:[{
					text:' Alterar Status',
					id:'btnstatusevento',
					iconCls:'ico_arrow_rotate_clockwise',
					disabled:true,
					handler:function(){		
						var rec = Ext.getCmp('grid_eventos').getSelectionModel().getSelected();
						var status = (!rec.get('ativo'));
						Ext.Ajax.request({
							url:'/simpacweb/modulos/fit/adm_eventos/ajax/evento_instatus.php',
							params:{											
								cadastroid:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastroid')
							},
							success:function(){
								rec.set('ativo', status);
								rec.commit();
							}
						})
					}
				},'-',{
					text:'Editar',
					id:'btnedit',
					iconCls:'ico_pencil',
					disabled:true,
					handler:function(){
						
						if(Ext.getCmp('wincadastroeventos')){
							Ext.getCmp('wincadastroeventos').show();
						}else{
							var updateeventos = new Ext.Window({
								id:'wincadastroeventos', 
								iconCls:'ico_pencil',
								title:'Editar evento: '+Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrotitulo'),
								height:459,
								width:611,
								border:false,
								items:[{
									xtype: 'form',
									id:'upformaddevento',
									padding: 15,
									height:500,
									width:600,
									margin:'10',
									border: false,
									buttonAlign:'left',										 
									items:[{
										xtype:'fieldset',
										title:'Cadastrar Eventos',
										autoHeight:true,
										collapsed:false,
										width:'100%',
										height:'100%',
										buttonAlign:'center',
											defaults: {
											xtype: 'textfield',												
										}, 
										items: [{
											fieldLabel: 'Titulo',
											id:'uptftitulo',
											name:'alunotitulo',
											allowBlank:false,
											anchor:'100%',
											value:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrotitulo')
										}, {
											fieldLabel: 'Descrição',
											xtype:'textarea',
											maxLength:500,
											id:'updescricao',
											maxLenght:500,
											width:433,
											height:65,
											name:'descricao',
											emptyText:'Adicione uma descrição...',
											value:Ext.getCmp('descricao_do_evento').getValue()
											
										},{
											xtype: 'datefield',
											fieldLabel: 'Data do Evento',
											id:'updtevento',
											allowBlank:false,
											value:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrodata')
										},{
											fieldLabel: 'Hora do Evento',
											xtype:'textfield',
											name:'horadoevento',
											id:'uphoraevento',
											emptyText:'00h00 às 00h00',
											allowBlank:false,
											value:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrohora')
										},{
											fieldLabel: 'Link do Evento',
											name:'linkevento',
											anchor:'100%',
											value:Ext.getCmp('link_do_evento').getValue()
										},{
											xtype:'numberfield',
											fieldLabel: 'Nº de Vagas',
											name:'nrvagas',
											anchor:'100%',
											value:Ext.getCmp('vagas_do_evento').getValue()
										},{
											fieldLabel: 'Palestrante',
											name:'palestrante',
											allowBlank:false,
											anchor:'100%',
											value:Ext.getCmp('palestrante_do_evento').getValue()
										},{
											fieldLabel: 'Local',
											name:'local',
											allowBlank:false,
											anchor:'100%',
											value:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrolocal')
										},{
											fieldLabel: 'Tipo',	
											xtype:'combo',
											width:300,
											id:'upcombo_cursostipos',
											autoHeight:true,
											store:comboStoreCursosTipos,
											displayField:'cursotipo_titulo',
											valueField:'cursotipo_id',
											typeAhead:true,
											triggerAction:'all',
											lazyRender:true,
											allowBlank:false,
											mode:'local',
											emptyText:'Selecione um tipo...',
											value:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cursos'),
																	//hiddenValue:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cursos')
											listeners:{
												'select':function(){
													if(Ext.getCmp('upcombo_cursostipos').isValid()){
														comboStoreCursos.load({
															params:{
															cursotipo_id:Ext.getCmp('upcombo_cursostipos').getValue()
															}
														});
													}
												}
											}
										},{
											fieldLabel: 'Curso',	
											xtype:'combo',
											width:300,
											id:'upcombo_cursos',
											autoHeight:true,
											store:comboStoreCursos,
											displayField:'curso_titulo',
											valueField:'curso_id',
											typeAhead:true,
											triggerAction:'all',
											lazyRender:true,
											name:'curso',
											allowBlank:false,
											emptyText:'Selecione um curso...',
											value:Ext.getCmp('curso_do_evento').getValue(),
											listeners:{
												'expand':function(){
													if(!Ext.getCmp('upcombo_cursostipos').isValid()){
														Ext.MessageBox.info('Dica!','Por favor, Selecione um Tipo antes.')
													}else{
														comboStoreCursos.reload({
															params:{
															cursotipo_id:Ext.getCmp('upcombo_cursostipos').getValue()
															}
														});
													}
												},
											}
										}],
										buttons:[{
											text:'Atualizar',
											iconCls:'ico_pencil',
											scale:'large',
											handler:function(btn){
												if(Ext.getCmp('upformaddevento').getForm().isValid()){
													loadInBtn(btn);

													Ext.getCmp('upformaddevento').getForm().submit({
														url:'/simpacweb/modulos/fit/adm_eventos/ajax/evento_update.php',
														params:{
															cadastroid:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastroid'),
															cursotipo_id:Ext.getCmp('upcombo_cursostipos').getValue(),
															datadoevento:Ext.getCmp('updtevento').getValue().format('Y-m-d')
														},
														success:function(){
															Ext.getCmp('grid_eventos').getStore().reload({
																callback:function(){
																	Ext.MessageBox.info('Atualizado!','Evento foi atualizado.');
																	Ext.getCmp('btnstatusevento').disable();
																	Ext.getCmp('btnedit').disable();
																	Ext.getCmp('btnremoverevento').disable();
																	Ext.getCmp('infoinscritos').hide();
																	Ext.getCmp('infototalinscrito').hide();
																	Ext.getCmp('infototalinscritozero').hide();
																	Ext.getCmp('idformdescricao').getForm().reset();
																	Ext.getCmp('wincadastroeventos').close();
																}	
															});																
														}
													})
												}else{
													Ext.MessageBox.warning('Aviso!','Preecha os dados obrigatórios.')
												}
											}
										}]			
									}]
								}]
							}).show();
						}
					}
				},'-',{
					text:'Deletar',
					id:'btnremoverevento',
					iconCls:'ico_delete',
					disabled:true,
					handler:function(){
						if(!Ext.getCmp('grid_eventos').getSelectionModel().getSelected()){
								Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar um evento para deletar.');
						}else{					
							Ext.MessageBox.confirm('Confirmação', 'Deseja deletar evento: '+Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrotitulo')+' ?',
							function(btn){
								if(btn=='yes'){
									Ext.Ajax.request({
										url: '/simpacweb/modulos/fit/adm_eventos/ajax/evento_delete.php',
										params:{ 
											cadastroid:Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastroid'),
										},
										success:function(){
											Ext.getCmp('grid_eventos').getStore().reload({
												callback:function(){
													Ext.getCmp('btnstatusevento').disable();
													Ext.getCmp('btnedit').disable();
													Ext.getCmp('btnremoverevento').disable();
													Ext.getCmp('btnvizualizartodos').disable();
													Ext.getCmp('infoinscritos').hide();
													Ext.getCmp('infototalinscrito').hide();
													Ext.getCmp('infototalinscritozero').hide();
													Ext.getCmp('idformdescricao').getForm().reset();
													Ext.MessageBox.info('','Evento deletado!');	
												}	
											});
										},
									});
								}
							});									
						}
					}
				},'-',{
					text:'Adicionar',
					iconCls:'ico_adicionar',
					handler:function(){
						Ext.getCmp('idtabpanel').setActiveTab(1);
						Ext.getCmp('infoinscritos').hide();
						Ext.getCmp('infototalinscrito').hide();
						Ext.getCmp('infototalinscritozero').hide()
					}
				},'->',{
					xtype:'label',
					id:'infoinscritos',
					text:'Inscritos: ',
					style:'margin:0 5px; font-weight: bold; font-size:10pt;'
				},{
					xtype:'label',
					id:'infototalinscrito',
					hidden:true,
					style:'margin:0 5px; font-size:15pt;font-weight: bold; color:green; '
				},{
					xtype:'label',
					id:'infototalinscritozero',
					hidden:true,
					style:'margin:0 5px; font-size:15pt;font-weight: bold; color:red; '
				}],
				listeners: {
					rowclick: function(grid, myrow){
						var infos = grid.getStore().getAt(myrow);
						//console.log(totalinscritos_store.data.items[0]);
						Ext.getCmp("titulo_do_evento").setValue(infos.json.cadastrotitulo);
						Ext.getCmp("data_do_evento").setValue(new Date(infos.json.cadastrodata*1000).format("Y-m-d"));
						Ext.getCmp("hora_do_evento").setValue(infos.json.cadastrohora);
						Ext.getCmp("vagas_do_evento").setValue(infos.json.cadastrovagas);
						Ext.getCmp("palestrante_do_evento").setValue(infos.json.cadastropalestrante);
						Ext.getCmp("local_do_evento").setValue(infos.json.cadastrolocal);
						Ext.getCmp("descricao_do_evento").setValue(infos.json.cadastrodescricao);
						Ext.getCmp("link_do_evento").setValue(infos.json.cadastrolink);
						
						if(infos.json.cadastrocurso == '...:: Selecione o Curso ::...' || infos.json.cadastrocurso == ''){

							Ext.getCmp("curso_do_evento").setValue('N/A');
						}else{
							Ext.getCmp("curso_do_evento").setValue(infos.json.cadastrocurso);
						}
						//console.log(infos);
						totalinscritos_store.reload({
							params: {
								palestracadastroid: infos.json.cadastroid
							},
							callback:function(a,b){
								
							}
						});
						alunos_store.reload({
							params: {
								palestra: infos.json.cadastroid
							}
						});
						alunosinfo_store.reload({
							params: {
								palestraCadastroId: infos.json.cadastroid
							}
						});							
					},
					'click':function(){
						if(Ext.getCmp('grid_eventos').getSelectionModel().getSelected()){
							Ext.getCmp('btnstatusevento').enable();
							Ext.getCmp('btnedit').enable();
							Ext.getCmp('btnremoverevento').enable();
							Ext.getCmp('btnvizualizartodos').enable();
							Ext.getCmp('infoinscritos').show();
							Ext.getCmp('infototalinscrito').show();
							Ext.getCmp('infototalinscritozero').show();
						}else{
							Ext.getCmp('btnstatusevento').disable();
							Ext.getCmp('btnedit').disable();
							Ext.getCmp('btnremoverevento').disable();
							Ext.getCmp('btnvizualizartodos').disable();
							Ext.getCmp('infoinscritos').hide();
							Ext.getCmp('infototalinscrito').hide();
							Ext.getCmp('infototalinscritozero').hide();
						}
					}
				}
			}]
		}, {
			xtype: "panel",
			border: false,
			style: "padding: 0px 15px 15px 15px;",
			layout: "table",
			layoutConfig: { columns: 2 },					
			items: [{
				xtype: "panel",
				layout: "form",
				padding: 15,
				height: 250,
				width: 400,
				autoScroll:true,
				items:[{
					xtype:'form',
					id:'idformdescricao',
					border:false,
					items: [{
						xtype: "displayfield",
						id: "titulo_do_evento",
						fieldLabel: "Título"
					}, {
						xtype:'displayfield',
						id: 'curso_do_evento',
						fieldLabel:'Curso',
					}, {
						xtype: "displayfield",
						id: "data_do_evento",
						fieldLabel: "Data"
					}, {
						xtype: "displayfield",
						id: "hora_do_evento",
						fieldLabel: "Horário"
					}, {
						xtype: "displayfield",
						id: "vagas_do_evento",
						fieldLabel: "Vagas"
					}, {
						xtype: "displayfield",
						id: "palestrante_do_evento",
						fieldLabel: "Palestrante"
					}, {
						xtype: "displayfield",
						id: "local_do_evento",
						fieldLabel: "Local"
					},{
						xtype:'displayfield',
						id:'descricao_do_evento',
						fieldLabel:'Descrição',									
					},{
						xtype:'displayfield',
						id:'link_do_evento',
						fieldLabel:'Link'
					}]
				}]
			}, {
				xtype: "grid",
				id: "grid_alunos",
				store: alunos_store,
				width: 269,
				height: 245,
				style: "padding: 0px 0px 0px 10px",
				bbar: [{
					xtype: "export",
					target: 'grid_alunos',
				},'-',{
					text:'Visualizar Todos',
					id:'btnvizualizartodos',
					disabled:true,
					iconCls:'ico_search',
					handler:function(){
						winAlunos = new Ext.Window({
							title:'Alunos Cadastrados no evento - '+Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrotitulo'),
							id:'winalunos',
							modal:true,
							iconCls:'ico_text_linespacing',
							width:790,
							height:500,
							items:[{
								xtype: "grid",
								id: "grid_alunos2",
								store: alunosinfo_store,
								width: 778,
								height: 468,
								plugins: expander,
								viewConfig:{
									 forceFit:true,
								 },
								sm: new Ext.grid.RowSelectionModel({
								 singleSelect: true,
								}),
								bbar: [{
									xtype: "export",
									target: 'grid_alunos2',
									/*xtype: "button",
									iconCls:'ico_arrow_right',
									text: "Exportar",
									width: 75*/
								},'-',{
									text:'Deletar',
									id:'btndeletealuno',
									iconCls:'ico_delete',
									disabled:true,
									handler: function(){
										if(!Ext.getCmp('grid_alunos2').getSelectionModel().getSelected()){
												Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar um participante para deletar.');
										}else{					
											Ext.MessageBox.confirm('Confirmação', 'Deseja deletar participante: '+Ext.getCmp('grid_alunos2').getSelectionModel().getSelected().get('palestraNome')+' ?',
											function(btn){
												if(btn=='yes'){
													Ext.Ajax.request({
														url: '/simpacweb/modulos/fit/adm_eventos/ajax/evento-aluno_delete.php',
														params:{ 
															palestraid:Ext.getCmp('grid_alunos2').getSelectionModel().getSelected().get('palestraId'),
														},
														success:function(){
															Ext.getCmp('grid_alunos2').getStore().reload({
																callback:function(){
																	Ext.MessageBox.info('','Aluno deletado!');	
																	Ext.getCmp('btndeletealuno').disable();
																}	
															});
														},
													});
												}
											});									
										}
									}
								},'->','Filtrar Por:',{
									xtype:'combo',
									id:'idcombosearch',
									autoHeight:true,
									typeAhead: true,
									triggerAction: 'all',
									lazyRender:true,
									mode: 'local',
									emptyText:'Pesquisar...',
									store: new Ext.data.ArrayStore({
										fields:[{name:'search',type:'string'},
												{name: 'idsearch',type:'int'}],
										data:[['Alunos',1],
											  ['RG',2],
											  ['Telefone',3],
											  ['E-mail',4],
											  ['Cargo',5],
											  ['Escolaridade',6],
											  ['Empresa',7],
											  ['Endereco',8]]
									}),
									valueField: 'idsearch',
									displayField: 'search',
									listeners:{
										change:function(){
											comboValue = Ext.getCmp('idcombosearch').getValue();
										},
										select:function(){
											comboValue = Ext.getCmp('idcombosearch').getValue();	
										},
									}
								},{
									xtype:'textfield',
									id:'filterAlunos', 
									style:'margin-left:6px;',
									emptyText:'Texto a ser pesquisado...',
									width:((Page.width/5)),
									listeners:{
										'valid':function(){
											switch(comboValue){
												case 1:alunosinfo_store.filter('palestraNome', this.getValue(), true, false);break;
												case 2:alunosinfo_store.filter('palestraRG', this.getValue(), true, false);break;
												case 3:alunosinfo_store.filter('palestraFone', this.getValue(), true, false);break;
												case 4:alunosinfo_store.filter('palestraEmail', this.getValue(), true, false);break;
												case 5:alunosinfo_store.filter('palestraCargo', this.getValue(), true, false);break;
												case 6:alunosinfo_store.filter('palestraEscolaridade', this.getValue(), true, false);break;
												case 7:alunosinfo_store.filter('palestraEmpresa', this.getValue(), true, false);break;
												case 8:alunosinfo_store.filter('palestraEndereco', this.getValue(), true, false);
											}
										}
									}
								}],
								columns: [expander,{
									header: "Alunos",
									dataIndex: "palestraNome",
									width: 182
								},{
									header: "RG",
									dataIndex: "palestraRG",
									width:89
								},{
									header: "DDD",
									dataIndex: "palestraDDD",
									width:39
								},{
									header: "Telefone",
									dataIndex: "palestraFone", 
									width:85
								},{
									header: "E-mail",
									dataIndex: "palestraEmail",
									width: 238
								},{
									xtype: "datecolumn",
									header: "Cadastrado",
									dataIndex: "dtcadastro",
									format: "d/m/Y",
									width: 102
								},{
									header: "Endereço",
									hidden:true,
									dataIndex: "palestraEndereco"
								},{
									header: "Empresa",
									hidden:true,
									dataIndex: "palestraEmpresa"
								},{
									header: "Cargo",
									hidden:true,
									dataIndex: "palestraCargo"
								},{
									header: "Empresa",
									hidden:true,
									dataIndex: "palestraEmpresa"
								},{
									header: "Escolaridade",
									hidden:true,
									dataIndex: "palestraEscolaridade"
								}],
								listeners:{
									'click':function(){
										if(Ext.getCmp('grid_alunos2').getSelectionModel().getSelected()){
											Ext.getCmp('btndeletealuno').enable();
										}else{
											Ext.getCmp('btndeletealuno').disable();
										}
									}
								}
							}]
						}).show();	
					}
				}],
				columns: [{
					header: "Alunos",
					dataIndex: "alunonome",
					width: 225
				}],
				listeners:{
					rowclick:function(grid, myrow,e){	
						var infos = grid.getStore().getAt(myrow);
					
						var winAluno = new Ext.Window({
							title:'Alunos Cadastrados no evento - '+Ext.getCmp('grid_eventos').getSelectionModel().getSelected().get('cadastrotitulo'),
							id:'winaluno',
							modal:true,
							iconCls:'ico_text_linespacing',
							width:496,
							height:393,
							items:[{
								xtype:'form',
								border:false,
								width:'100%',
								bodyStyle:'margin:10px;',
								items:[{
									xtype:'fieldset',
									title:'Dados do participante '+infos.json.alunonome ,
									autoHeight:true,
									collapsed:false,
									width:462,
									height:'100%',
									buttonAlign:'center',
									labelWidth:150,	
									defaults:{
										xtype:'displayfield'
									},
									items: [{
										fieldLabel:'Nome',
										value:infos.json.alunonome 
									},{
										fieldLabel:'RG',
										value:infos.json.palestraRG 
									},{
										fieldLabel:'E-mail',
										value:infos.json.palestraEmail 
									},{
										fieldLabel:'Telefone',
										value:'('+infos.json.palestraDDD+') '+infos.json.palestraFone 
									},{
										fieldLabel:'Endereço',
										value:infos.json.palestraEndereco 
									},{
										fieldLabel:'Empresa',
										value:infos.json.palestraEmpresa 
									},{
										fieldLabel:'Cargo',
										value:infos.json.palestraCargo 
									},{
										fieldLabel:'Telefone Comercial',
										value:'('+infos.json.palestraDDDCom+') '+infos.json.palestraFoneCom 
									},{
										fieldLabel:'Como conheceu a FIT?',
										value:infos.json.palestraEmailCom 
									},{
										fieldLabel:'Curso de Interesse',
										value:infos.json.cursoInteresse 
									},{
										fieldLabel:'Escolaridade',
										value:infos.json.palestraEscolaridade 
									}]
								}]
							}]
						}).show();
					}
				}
			}]
		}]
	});
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
	var mainWin = new Ext.Window({
		title:'Administrativo de Eventos (FIT)',		
		iconCls:'ico_aluno',
		height: 580,
		width: 730,
		modal:true,
		resizable: false,
		items:
		new Ext.TabPanel({
			id:'idtabpanel',							 
			activeTab: 0,
			height:548,
			border:false,
			tabPosition:'bottom',
			autoScroll:false,
			items:[{
				title: 'Relatório',	 
				layout: "table",
				listeners:{
					'activate':function() {
						eventos_store.reload();
						//console.log(eventos_store);
					}
				},
				items:[relatorioeventos],
				
			},{
				title: 'Cadastro',					
				items:[cadastroeventos],
				listeners:{
					'activate':function() {
						Ext.getCmp('btnstatusevento').disable();
						Ext.getCmp('btnedit').disable();
						Ext.getCmp('btnremoverevento').disable();
						Ext.getCmp('infoinscritos').hide();
						Ext.getCmp('infototalinscrito').hide();
						Ext.getCmp('infototalinscritozero').hide()
					}
				},
				
			}]
		})				
	}).show();	
	Ext.getCmp("dt_evento").setValue(new Date());			
});

</script>