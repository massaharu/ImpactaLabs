<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
var comboStorePaises = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/paises/get-paises.php',
		root:'myData',
		fields:[{name:'despais',type:'string'}, 
				{name:'idpais',type:'int'},'desabreviacao2','desabreviacao3',
				{name:'instatus',type:'boolean'}],
      autoLoad:true
   });
		
	var comboStoreEstados = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/estados/get_estadosbypais.php',
	  root:'myData',
	  fields:['idestado','desestado','desestadosigla',{name:'instatus',type:'boolean'}],	
	  autoLoad:true,
		listeners:{
			load:function(me,records,options){
				if(me.totalLength < 1){
					Ext.MessageBox.erro('Nenhum estado adicionado','Favor, insira os estados deste país');
				}
			},
		},
   });
  
	var comboStoreCidades = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/cidades/get_cidadesbyestado.php',
	  root:'myData',
	  fields:[{name:'idcidade',type:'int'},
			  {name:'descidade',type:'string'},
			  {name:'idestado',type:'int'}],
	  autoLoad:true,
	  /*listeners:{
			load:function(me,records,options){
				if(me.totalLength < 1){
					Ext.MessageBox.erro('Nenhuma cidade adicionada','Favor, insira as cidades deste Estado');
				}
			},
		},*/
	}); 
	  
  	var comboStoreBairros = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/bairros/get_bairrosbycidades.php',
	  root:'myData',
	  fields:[{name:'idbairro',type:'int'},
			  {name:'desbairro',type:'string'},
			  {name:'idcidade',type:'int'}],
	  autoLoad:true,
	  /*listeners:{
			load:function(me,records,options){
				if(me.totalLength < 1){
					Ext.MessageBox.erro('Nenhum bairro adicionado','Favor, insira os bairros desta cidade');
					console.log(me,records,options);
				}
			},
		},*/
	});
	
	var comboStoreLogradourostipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/logradourostipos/get_logradourostipos.php',
		root:'myData',
		fields:[{name:'deslogradourotipo',type:'string'}, 
				{name:'idlogradourotipo',type:'int'}],
      autoLoad:true,
   });
		
	var comboStoreLogradouros = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/logradouros/get_logradourobytipoandbairro.php',
		root:'myData',
		fields:[{name:'deslogradouro',type:'string'}, 
				{name:'idlogradouro',type:'int'}],
      autoLoad:true,
	  listeners:{
			load:function(me,records,options){
				if(me.totalLength < 1){
					Ext.MessageBox.erro('Nenhum logradouro adicionado','Favor, insira os logradouros deste bairro');
				}
			},
		},
   });
	
	var comboStoreCargos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/cargos/get_cargos.php',
		root:'myData',
		fields:[{name:'descargo',type:'string'}, 
				{name:'idcargo',type:'int'}],
      autoLoad:true
   });
		
	var comboStoreContatoscategorias = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatoscategorias/get_contatoscategorias.php',
		root:'myData',
		fields:[{name:'descontatotipocategoria',type:'string'}, 
				{name:'idcontatotipocategoria',type:'int'}],
      //autoLoad:true
   });
	
	var comboStorePessoajuridicatipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/pessoajuridicatipos/get_pessoajuridicatipos.php',
		root:'myData',
		fields:[{name:'despessoajuridicatipo',type:'string'}, 
				{name:'idpessoajuridicatipo',type:'int'}],
      //autoLoad:true
   });
	
	var comboStoreDocumentostipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/documentostipos/get_documentostipos.php',
		root:'myData',
		fields:[{name:'desdocumentotipo',type:'string'}, 
				{name:'iddocumentotipo',type:'int'}],
      //autoLoad:true
   });
	var comboStoreContatostipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatostipos/get_contatostipos.php',
		root:'myData',
		fields:[{name:'descontatotipo',type:'string'}, 
				{name:'idcontatotipo',type:'int'}],
      //autoLoad:true
   });

/*--------------------ACCORDION(west)----------------------------------------------------------------*/
/*--------------------CARGOS-------------------------------------------------------------------------*/
	var item1 = new Ext.Panel({
		id:'accordion_cadastroscargos',
		title: 'Cargos',
		iconCls:'ico_chair',
		autoScroll:true,
		listeners:{
			'activate':function(){
				comboStoreCargos.load();
			}
		},
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar Cargo',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_cargos')){
					Ext.getCmp('win.add_cargos').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_cargos',
						height:98,
						width:450,
						modal:true,
						title:'Adicionar um novo Cargo',
						iconCls:'ico_chair',
						items:[{
							xtype:'form',
							id:'formAddCargos',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addcargos',
								fieldLabel:'Cargo',
								name:'descargo',
								emptyText:'Adicione um cargo...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddCargos').getForm().isValid()){
									Ext.getCmp('formAddCargos').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/cargos/set_cargos.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridcargos').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Cargo adicionado com sucesso!');	
													Ext.getCmp('win.add_cargos').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridcargos',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreCargos,
			 hideHeaders:true,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 //header:'Cargos',
					 id:'cargoslist',
					 width:300,
					 sortable:true,
					 dataIndex:'descargo',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/cargos/set_cargos.php',
						  params:{
							idcargo:e.record.get('idcargo'),
							descargo:e.record.get('descargo'),
							//idbairro:Ext.getCmp('logradourosComboListBairros').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	  });
	
/*--------------------------LOGRADOUROS TIPOS-------------------------------------------------------------------------*/
	  var item2 = new Ext.Panel({
		  id:'accordion_cadastroslogradourostipo',
		  title: 'Logradouros Tipos',
		  iconCls:'ico_flag_green',
		  autoScroll:true,
		  listeners:{
			'activate':function(){
				//console.log('alert');
				comboStoreLogradourostipos.load();
			}
		},
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar Logradouro',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_logradouros')){
					Ext.getCmp('win.add_logradouros').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_logradouros',
						height:98,
						width:450,
						modal:true,
						title:'Adicionar um novo Logradouro',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'formAddLogradouros',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addlogradouros',
								fieldLabel:'Logradouro',
								name:'deslogradourotipo',
								emptyText:'Adicione um logradouro...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddLogradouros').getForm().isValid()){
									Ext.getCmp('formAddLogradouros').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/logradourostipos/set_logradouros.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridlogradouros').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Logradouro adicionado com sucesso!');	
													Ext.getCmp('win.add_logradouros').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridlogradouros',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreLogradourostipos,
			 hideHeaders:true,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 //header:'Logradouros',
					 id:'logradourosslist',
					 width:300,
					 sortable:true,
					 dataIndex:'deslogradourotipo',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  console.log(e);					
				  Ext.Ajax.request({ 
					  url:'/simpacweb/modulos/atendimento/chat-adm/ajax/update_frase.php',
						  params:{					
							idfrase:e.record.get('idfrase'),
							desfrase:e.record.get('upfrase'),
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	  });

/*-------------------------CATEGORIA DE CONTATOS-------------------------------------------------------------------------*/
	  var item3 = new Ext.Panel({
		  title: 'Categorias de Contatos',
		  id:'accordion_cadastroscategoriascontato',
		  iconCls:'ico_contact_phone',
		  autoScroll:true,
		  listeners:{
			'activate':function(){
				//console.log('alert');
				comboStoreContatoscategorias.load();
			}
		},
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_contatotipocategoria')){
					Ext.getCmp('win.add_contatotipocategoria').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_contatotipocategoria',
						height:116,
						width:450,
						modal:true,
						title:'Adicionar uma nova Categoria de Contato',
						iconCls:'ico_contact_phone',
						items:[{
							xtype:'form',
							id:'formAddContatoscategorias',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addcontatostiposcategorias',
								fieldLabel:'Categoria de Contato',
								name:'descontatotipocategoria',
								emptyText:'Adicione uma categoria de contato...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddContatoscategorias').getForm().isValid()){
									Ext.getCmp('formAddContatoscategorias').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatoscategorias/set_contatoscategorias.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridcontatostiposcategorias').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Categoria de Contato adicionado com sucesso!');	
													Ext.getCmp('win.add_contatotipocategoria').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  },'-',{
			text:'Desativar',
			iconCls:'ico_delete',
			handler:function(){
				if(!Ext.getCmp('gridcontatostiposcategorias').getSelectionModel().getSelected()){
					Ext.MessageBox.erro('Aviso!', 'Por favor, Selecione uma categoria.');
				}else{
					Ext.MessageBox.confirm('Confirmacao', 'Deletar o registro selecionado?',function(btn){
						if(btn=='yes'){
							Ext.Ajax.request({
								url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatoscategorias/del_contatoscategorias.php',
								params:{											
									idcontatotipocategoria:Ext.getCmp('gridcontatostiposcategorias').getSelectionModel().getSelected().get('idcontatotipocategoria')
								},
								success:function(){
									Ext.getCmp('gridcontatostiposcategorias').getStore().reload({
										callback:function(){
											Ext.MessageBox.alert('','Categoria deletado!');	
										  }	
									  });
								  }
							  })
						  }
					  });
				  }
			  }
		  }],
			items:[{
			   xtype:'editorgrid',
			   id:'gridcontatostiposcategorias',
			   sm: new Ext.grid.RowSelectionModel({
			   singleSelect: true,
			  }),
			   store:comboStoreContatoscategorias,
			   hideHeaders:true,
			   loadMask:true,
			   stripeRows:true,
			   autoHeight:true,
			   border:false,
			   anchor:'100%',
			   viewConfig:{
			   forceFit:true,
			   },
			   cm:new Ext.grid.ColumnModel({
				   columns:[{
					   //header:'Categoria de Contatos',
					   id:'categoriadecontatoslist',
					   width:300,
					   sortable:true,
					   dataIndex:'descontatotipocategoria',
					   editor: new Ext.form.TextField({
						  AllowBlack: false,							  
					  })
				  }],
			   }),
			   listeners:{
			   afteredit: function(e){
					//console.log(e);	
					Ext.Ajax.request({ 
						url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatoscategorias/up_contatoscategorias.php',
							params:{
							  idcontatotipocategoria:e.record.get('idcontatotipocategoria'),
							  descontatotipocategoria:e.record.get('descontatotipocategoria'),
							  //idbairro:Ext.getCmp('logradourosComboListBairros').getValue()
							},			
							success:function(){
							   e.record.commit();
						  }
					  });	
				  }
			  },
			   height:610,
			   defaults:{anchor:'100%'},
			}],
	  });
/*-------------------------PESSOA JURIDICA TIPOS-------------------------------------------------------------------------*/	
	  var item4 = new Ext.Panel({
		  id:'accordion_cadastrospessoajuridicatipo',
		  iconCls:'ico_People',
		  title:' Pessoa Juridica Tipos',
		  autoScroll:true,
		  listeners:{
			'activate':function(){
				//console.log('alert');
				comboStorePessoajuridicatipos.load();
			}
		},
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_pessoajuridicatipo')){
					Ext.getCmp('win.add_pessoajuridicatipo').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_pessoajuridicatipo',
						height:116,
						width:450,
						modal:true,
						title:'Adicionar Tipo de Pessoa juridica',
						iconCls:'ico_People',
						items:[{
							xtype:'form',
							id:'formAddPessoajuridicatipo',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addpessoajuridicatipos',
								fieldLabel:'Pessoa Juridica Tipo',
								name:'despessoajuridicatipo',
								emptyText:'Adicione um tipo de Pessoa...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddPessoajuridicatipo').getForm().isValid()){
									Ext.getCmp('formAddPessoajuridicatipo').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/pessoajuridicatipos/set_pessoajuridicatipos.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridpessoajuridicatipos').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Pessoa Juridica Tipo adicionado com sucesso!');	
													Ext.getCmp('win.add_pessoajuridicatipo').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  },'-',{
			text:'Desativar',
			iconCls:'ico_delete',
			handler:function(){
				if(!Ext.getCmp('gridpessoajuridicatipos').getSelectionModel().getSelected()){
					Ext.MessageBox.erro('Aviso!', 'Por favor, Selecione um tipo de pessoa juridica.');
				}else{
					Ext.MessageBox.confirm('Confirmacao', 'Deletar o registro selecionado?',function(btn){
						if(btn=='yes'){
							Ext.Ajax.request({
								url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/pessoajuridicatipos/del_pessoajuridicatipos.php',
								params:{											
									idpessoajuridicatipo:Ext.getCmp('gridpessoajuridicatipos').getSelectionModel().getSelected().get('idpessoajuridicatipo')
								},
								success:function(){
									Ext.getCmp('gridpessoajuridicatipos').getStore().reload({
										callback:function(){
											Ext.MessageBox.alert('','Tipo deletado!');	
										  }	
									  });
								  }
							  })
						  }
					  });
				  }
			  }
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridpessoajuridicatipos',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStorePessoajuridicatipos,
			 hideHeaders:true,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Pessoa Juridica Tipos',
					 id:'pessoajuridicatiposlist',
					 width:300,
					 sortable:true,
					 dataIndex:'despessoajuridicatipo',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/pessoajuridicatipos/up_pessoajuridicatipos.php',
						  params:{
							idpessoajuridicatipo:e.record.get('idpessoajuridicatipo'),
							despessoajuridicatipo:e.record.get('despessoajuridicatipo'),
							//idbairro:Ext.getCmp('logradourosComboListBairros').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 defaults:{anchor:'100%'},
		  }],
	  });
/*-------------------------TIPOS DE DOCUMENTOS-------------------------------------------------------------------------*/	
	  var item5 = new Ext.Panel({
		  id:'accordion_cadastrosdocumentostipo',
		  iconCls:'ico_list',
		  title:' Tipos de Documentos',
		  autoScroll:true,
		  listeners:{
			'activate':function(){
				//console.log('alert');
				comboStoreDocumentostipos.load();
			}
		},
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_documentotipo')){
					Ext.getCmp('win.add_documentotipo').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_documentotipo',
						height:116,
						width:450,
						modal:true,
						title:'Adicionar um novo Tipo de Documento',
						iconCls:'ico_list',
						items:[{
							xtype:'form',
							id:'formAddDocumentostipos',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'adddocumentostipos',
								fieldLabel:'Tipo de Documento',
								name:'desdocumentotipo',
								emptyText:'Adicione um tipo de documento...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddDocumentostipos').getForm().isValid()){
									Ext.getCmp('formAddDocumentostipos').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/documentostipos/set_documentostipos.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('griddocumentostipos').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Tipo de Documento adicionado com sucesso!');	
													Ext.getCmp('win.add_documentotipo').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  },'-',{
			text:'Desativar',
			iconCls:'ico_delete',
			handler:function(){
				if(!Ext.getCmp('griddocumentostipos').getSelectionModel().getSelected()){
					Ext.MessageBox.erro('Aviso!', 'Por favor, Selecione um tipo de documento.');
				}else{
					Ext.MessageBox.confirm('Confirmacao', 'Deletar o registro selecionado?',function(btn){
						if(btn=='yes'){
							Ext.Ajax.request({
								url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/documentostipos/del_documentostipos.php',
								params:{											
									iddocumentotipo:Ext.getCmp('griddocumentostipos').getSelectionModel().getSelected().get('iddocumentotipo')
								},
								success:function(){
									Ext.getCmp('griddocumentostipos').getStore().reload({
										callback:function(){
											Ext.MessageBox.alert('','Tipo deletado!');	
										  }	
									  });
								  }
							  })
						  }
					  });
				  }
			  }
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'griddocumentostipos',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreDocumentostipos,
			 hideHeaders:true,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Documentos Tipos',
					 id:'documentostiposlist',
					 width:300,
					 sortable:true,
					 dataIndex:'desdocumentotipo',
					 editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/documentostipos/up_documentostipos.php',
						  params:{
							iddocumentotipo:e.record.get('iddocumentotipo'),
							desdocumentotipo:e.record.get('desdocumentotipo'),
							//idbairro:Ext.getCmp('logradourosComboListBairros').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 defaults:{anchor:'100%'},
		  }],
	  });
	  
/*-------------------------TIPOS DE CONTATOS-------------------------------------------------------------------------*/ 	
		var item6 = new Ext.Panel({
		  id:'accordion_cadastroscontatostipo',
		  title:' Tipos de Contatos',
		  autoScroll:true,
		  iconCls:'ico_contact_phone',
		  listeners:{
			'activate':function(){
				//console.log('alert');
				comboStoreContatostipos.load();
			}
		},
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_contatotipo')){
					Ext.getCmp('win.add_contatotipo').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_contatotipo',
						height:98,
						width:450,
						modal:true,
						title:'Adicionar um novo Tipo de Contato',
						iconCls:'ico_contact_phone',
						items:[{
							xtype:'form',
							id:'formAddContatostipos',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'textfield',
								id:'addcontatostipos',
								fieldLabel:'Tipo de Contato',
								name:'descontatotipo',
								emptyText:'Adicione um tipo de contato...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddContatostipos').getForm().isValid()){
									Ext.getCmp('formAddContatostipos').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatostipos/set_contatostipos.php',
										params:{											
											
										},
										success:function(){
											Ext.getCmp('gridcontatostipos').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Tipo de Contato adicionado com sucesso!');	
													Ext.getCmp('win.add_contatotipo').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  },'-',{
			text:'Desativar',
			iconCls:'ico_delete',
			handler:function(){
				if(!Ext.getCmp('gridcontatostipos').getSelectionModel().getSelected()){
					Ext.MessageBox.erro('Aviso!', 'Por favor, Selecione um tipo de contato.');
				}else{
					Ext.MessageBox.confirm('Confirmacao', 'Deletar o registro selecionado?',function(btn){
						if(btn=='yes'){
							Ext.Ajax.request({
								url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatostipos/del_contatostipos.php',
								params:{											
									idcontatotipo:Ext.getCmp('gridcontatostipos').getSelectionModel().getSelected().get('idcontatotipo')
								},
								success:function(){
									Ext.getCmp('gridcontatostipos').getStore().reload({
										callback:function(){
											Ext.MessageBox.alert('','Tipo deletado!');	
										  }	
									  });
								  }
							  })
						  }
					  });
				  }
			  }
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'gridcontatostipos',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreContatostipos,
			 hideHeaders:true,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Contatos Tipos',
					 id:'contatostiposlist',
					 width:300,
					 sortable:true,
					 dataIndex:'descontatotipo',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			   afteredit: function(e){
					//console.log(e);					
					Ext.Ajax.request({ 
						url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/contatostipos/up_contatostipos.php',
							params:{
							  idcontatotipo:e.record.get('idcontatotipo'),
							  descontatotipo:e.record.get('descontatotipo'),
							  //idbairro:Ext.getCmp('logradourosComboListBairros').getValue()
							},			
							success:function(){
							   e.record.commit();
						  }
					  });	
				  }
			},
			   height:610,
			   defaults:{anchor:'100%'},
			}],
		})

/*-------------------------MAIN PANEL-------------------------------------------------------------------------*/ 
	  var accordion = new Ext.Panel({
		  id:'accordion_cadastros',										
		  title:'Cadastros',
		  region:'west',
		  margins:'2 1 2 2',
		  collapsible:true,
		  split:true,
		  width: 250,		 
		  layout:'accordion',
		  tittleCollapse:true,
		  animCollapse:true,
		  listeners:{
			'active':function(){
				//console.log('alert'),
				ComboStoreCargos.load();
			}
		},
		  items: [item1, item2, item3, item4, item5, item6]
	  });
/*================================================================================================================*/	  
/*---------------------------LOCALIDADES(center)------------------------------------------------------------------*/
/*----------------------------LOGRADOUROS-----------------------------------------------------------------------------*/
var menuLogradourosCenter = new Ext.Panel({
		title: 'Logradouros',
		region: 'center',
		split: true,
		width: 100,
		autoScroll:true,
		collapsible: true,
		margins:'2 0 2 2',
		//cmargins:'12 0 12 12',
		layout:'fit',
		iconCls:'ico_flag_green',
		items:[{
			 xtype:'editorgrid',
			 id:'localidades_gridlogradouros',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreLogradouros,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:false,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Logradouros',
					 id:'logradouroslist',
					 width:240,
					 sortable:true,
					 dataIndex:'deslogradouro',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/logradouros/up_logradouros.php',
						  params:{
							idlogradouro:e.record.get('idlogradouro'),
							deslogradouro:e.record.get('deslogradouro'),
							idbairro:Ext.getCmp('logradouroComboListBairros').getValue(),
							idlogradourotipo:Ext.getCmp('logradouroComboListLogradourostipos').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	});
	
	var menuLogradourosEast = new Ext.Panel({
		title: 'Search',
		iconCls:'ico_search',
		region:'east',
		split:true,
		width:285,
		autoHeight:true,
		collapsible:true,
		margins:'2 2 2 0',
		cmargins:'2 0 2 2',
		defaults:{padding: 10},
		items:[{
			  xtype:'form',
			  border:'false',
			  height:413,
			  defaults:{xtype:'combo', anchor:'100%', padding:15, allowBlank:false},
			  items:[{
			  id:'logradouroComboListPaises',
			  store:comboStorePaises,
			  fieldLabel:'Países',
			  valueField:'idpais',
			  displayField:'despais',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idpais',
			  mode:'local',
			  emptyText:'Selecione um pais...',
			  listeners:{
				  'select':function(){
					  if(Ext.getCmp('logradouroComboListPaises').isValid()){
						  comboStoreEstados.load({
							  params:{
								  idpais:Ext.getCmp('logradouroComboListPaises').getValue(),
							  }
						   });
					    }
			  	     }
			      }
			  },{
			  id:'logradouroComboListEstados',
			  store:comboStoreEstados,
			  fieldLabel:'Estados',
			  valueField:'idestado',
			  displayField:'desestado',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idestado',
			  mode:'local',
			  emptyText:'Selecione um estado...',
			  listeners:{
				  'select':function(){
					  if(Ext.getCmp('logradouroComboListEstados').isValid()){
						  comboStoreCidades.load({
							  params:{
								  idestado:Ext.getCmp('logradouroComboListEstados').getValue(),
							  }
						   });
					    }
			  	     }
			      }
			  },{
			  id:'logradouroComboListCidades',
			  store:comboStoreCidades,
			  fieldLabel:'Cidades',
			  valueField:'idcidade',
			  displayField:'descidade',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idcidade',
			  mode:'local',
			  emptyText:'Selecione uma cidade...',
			  listeners:{
				  'select':function(){
						if((Ext.getCmp('logradouroComboListEstados').isValid())&&(Ext.getCmp('logradouroComboListCidades').isValid())){
							comboStoreBairros.load({
								params:{
									idcidade:Ext.getCmp('logradouroComboListCidades').getValue(),
								  }
							  });
						  }
					  }
				  }
			  },{
			  id:'logradouroComboListBairros',
			  store:comboStoreBairros,
			  fieldLabel:'Bairros',
			  valueField:'idbairro',
			  displayField:'desbairro',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idbairro',
			  mode:'local',
			  emptyText:'Selecione um bairro...',
			  /*listeners:{
				  'select':function(){
						if((Ext.getCmp('logradouroComboListCidades').isValid())&&(Ext.getCmp('logradouroComboListBairros').isValid())){
							comboStoreLogradouros.reload({
								params:{
									idbairro:Ext.getCmp('logradouroComboListbairros').getValue(),
								  }
							  });
						  }
					  }
				  }*/
			  },{
			  id:'logradouroComboListLogradourostipos',
			  store:comboStoreLogradourostipos,
			  fieldLabel:'Tipos de Logradouros',
			  valueField:'idlogradourotipo',
			  displayField:'deslogradourotipo',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idlogradourotipo',
			  mode:'local',
			  emptyText:'Selecione um tipo de logradouro...',
			  listeners:{
				  'select':function(){
						if((Ext.getCmp('logradouroComboListBairros').isValid())&&(Ext.getCmp('logradouroComboListLogradourostipos').isValid())){
							//console.log(Ext.getCmp('logradouroComboListBairros').getValue()),
							//console.log(Ext.getCmp('logradouroComboListLogradourostipos').getValue()),
							comboStoreLogradouros.load({
								params:{
									idbairro:Ext.getCmp('logradouroComboListBairros').getValue(),
									idlogradourotipo:Ext.getCmp('logradouroComboListLogradourostipos').getValue(),
								  }
							  });
						  }
					  }
				  }
			  }]
		}],
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Logradouro',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_logradouros')){
					Ext.getCmp('win.add_logradouros').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_logradouros',
						height:246,
						width:400,
						modal:true,
						title:'Adicionar um novo Logradouro',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'formAddlogradouros',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'combo',
								id:'logradourocombo_addpaises',
								store:comboStorePaises,
								valueField:'idpais',
								displayField:'despais',
								fieldLabel:'País',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione um país...',
								listeners:{
								  'select':function(){
									  if(Ext.getCmp('logradourocombo_addpaises').isValid()){
										  comboStoreEstados.load({
											  params:{
												  idpais:Ext.getCmp('logradourocombo_addpaises').getValue(),
											  }
										   });
										}
									 }
								  }
							 },{
								xtype:'combo',
								id:'logradourocombo_addestados',
								store:comboStoreEstados,
								valueField:'idestado',
								displayField:'desestado',
								fieldLabel:'Estados',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								/*name:'value',*/
								mode:'local',
								width:270,
								emptyText:'Selecione um estado...',
								listeners:{
								  'select':function(){
									  if(Ext.getCmp('logradourocombo_addestados').isValid()){
										  comboStoreCidades.load({
											  params:{
												  idestado:Ext.getCmp('logradourocombo_addestados').getValue(),
											  }
										   });
										}
									 }
								  }
							 },{
								xtype:'combo',
								id:'logradourocombo_addcidades',
								store:comboStoreCidades,
								valueField:'idcidade',
								displayField:'descidade',
								fieldLabel:'Cidades',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione uma cidade...',
								listeners:{
								  'select':function(){
									  if(Ext.getCmp('logradourocombo_addcidades').isValid()){
										  comboStoreBairros.load({
											  params:{
												  idcidade:Ext.getCmp('logradourocombo_addcidades').getValue(),
											  }
										   });
										}
									 }
								  }
							 },{
								xtype:'combo',
								id:'logradourocombo_addbairros',
								store:comboStoreBairros,
								valueField:'idbairro',
								displayField:'desbairro',
								fieldLabel:'Bairros',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione um bairro...',
								listeners:{
								  'select':function(){
									  if(Ext.getCmp('logradourocombo_addbairros').isValid()){
										  comboStoreLogradourostipos.reload();
										}
									 }
								  }							 
							 },{
								xtype:'combo',
								id:'logradourocombo_addlogradourostipo',
								store:comboStoreLogradourostipos,
								valueField:'idlogradourotipo',
								displayField:'deslogradourotipo',
								fieldLabel:'Logradouros Tipos',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione um tipo de logradouro...'
							 
							 
							 },{
								xtype:'textfield',
								id:'addlogradouro',
								fieldLabel:'Logradouro',
								name:'deslogradouro',
								emptyText:'Adicione um logradouro...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddlogradouros').getForm().isValid()){
									
									//console.log(Ext.getCmp('logradourocombo_addbairros').getValue()),
									//console.log(Ext.getCmp('logradourocombo_addlogradourostipo').getValue()),
										
									Ext.getCmp('formAddlogradouros').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/logradouros/set_logradouros.php',										
										params:{											
											idbairro:Ext.getCmp('logradourocombo_addbairros').getValue(),
											idlogradourotipo:Ext.getCmp('logradourocombo_addlogradourostipo').getValue(),
										},
										success:function(){
											Ext.getCmp('localidades_gridlogradouros').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Logradouro adicionado com sucesso!');	
													Ext.getCmp('win.add_logradouros').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  }],
	});

/*------------------------------BAIRROS-------------------------------------*/
	var menuBairrosCenter = new Ext.Panel({
		title: 'Bairros',
		region: 'center',
		split: true,
		width: 100,
		autoScroll:true,
		collapsible: true,
		margins:'2 0 2 2',
		//cmargins:'12 0 12 12',
		layout:'fit',
		iconCls:'ico_flag_green',
		items:[{
			 xtype:'editorgrid',
			 id:'gridbairros',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreBairros,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:false,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Bairros',
					 id:'bairroslist',
					 width:240,
					 sortable:true,
					 dataIndex:'desbairro',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/bairros/set_bairros.php',
						  params:{
							idbairro:e.record.get('idbairro'),
							desbairro:e.record.get('desbairro'),
							idcidade:Ext.getCmp('bairroComboListCidades').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	});
	
	var menuBairrosEast = new Ext.Panel({
		title: 'Search',
		iconCls:'ico_search',
		region:'east',
		split:true,
		width:285,
		autoHeight:true,
		collapsible:true,
		margins:'2 2 2 0',
		cmargins:'2 0 2 2',
		defaults:{padding: 10},
		items:[{
			  xtype:'form',
			  border:'false',
			  height:413,
			  defaults:{xtype:'combo', anchor:'100%', padding:15, allowBlank:false},
			  items:[{
			  id:'bairroComboListPaises',
			  store:comboStorePaises,
			  fieldLabel:'Países',
			  valueField:'idpais',
			  displayField:'despais',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idpais',
			  mode:'local',
			  emptyText:'Selecione um pais...',
			  listeners:{
				  'select':function(){
					  if(Ext.getCmp('bairroComboListPaises').isValid()){
						  comboStoreEstados.load({
							  params:{
								  idpais:Ext.getCmp('bairroComboListPaises').getValue(),
							  }
						   });
					    }
			  	     }
			      }
			  },{
			  id:'bairroComboListEstados',
			  store:comboStoreEstados,
			  fieldLabel:'Estados',
			  valueField:'idestado',
			  displayField:'desestado',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idestado',
			  mode:'local',
			  emptyText:'Selecione um estado...',
			  listeners:{
				  'select':function(){
					  if(Ext.getCmp('bairroComboListEstados').isValid()){
						  comboStoreCidades.load({
							  params:{
								  idestado:Ext.getCmp('bairroComboListEstados').getValue(),
							  }
						   });
					    }
			  	     }
			      }
			  },{
			  id:'bairroComboListCidades',
			  store:comboStoreCidades,
			  fieldLabel:'Cidades',
			  valueField:'idcidade',
			  displayField:'descidade',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'idcidade',
			  mode:'local',
			  emptyText:'Selecione uma cidade...',
			  listeners:{
				  'select':function(){
						if((Ext.getCmp('bairroComboListEstados').isValid())&&(Ext.getCmp('bairroComboListCidades').isValid())){
							comboStoreBairros.reload({
								params:{
									idcidade:Ext.getCmp('bairroComboListCidades').getValue(),
								  }
							  });
						  }
					  }
				  }
			  }]
		}],
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Bairro',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_bairros')){
					Ext.getCmp('win.add_bairros').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_bairros',
						height:178,
						width:400,
						modal:true,
						title:'Adicionar um novo Bairro',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'formAddbairros',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'combo',
								id:'bairrocombo_addpaises',
								store:comboStorePaises,
								valueField:'idpais',
								displayField:'despais',
								fieldLabel:'País',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione um país...',
								listeners:{
								  'select':function(){
									  if(Ext.getCmp('bairrocombo_addpaises').isValid()){
										  comboStoreEstados.load({
											  params:{
												  idpais:Ext.getCmp('bairrocombo_addpaises').getValue(),
											  }
										   });
										}
									 }
								  }
							 },{
								xtype:'combo',
								id:'bairrocombo_addestados',
								store:comboStoreEstados,
								valueField:'idestado',
								displayField:'desestado',
								fieldLabel:'Estados',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								/*name:'value',*/
								mode:'local',
								width:270,
								emptyText:'Selecione um estado...',
								listeners:{
								  'select':function(){
									  if(Ext.getCmp('bairrocombo_addestados').isValid()){
										  comboStoreCidades.load({
											  params:{
												  idestado:Ext.getCmp('bairrocombo_addestados').getValue(),
											  }
										   });
										}
									 }
								  }
							 },{
								xtype:'combo',
								id:'bairrocombo_addcidades',
								store:comboStoreCidades,
								valueField:'idcidade',
								displayField:'descidade',
								fieldLabel:'Cidades',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione uma cidade...'
							 },{
								 xtype:'textfield',
								 id:'addbairro',
								fieldLabel:'Bairro',
								name:'desbairro',
								emptyText:'Adicione um bairro...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('formAddbairros').getForm().isValid()){
									Ext.getCmp('formAddbairros').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/bairros/set_bairros.php',
										params:{											
											idcidade:Ext.getCmp('bairrocombo_addcidades').getValue(),
										},
										success:function(){
											Ext.getCmp('gridbairros').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Bairro adicionado com sucesso!');	
													Ext.getCmp('win.add_bairros').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  }],
	});
/*------------------------------CIDADES---------------------------------------------------------------*/
	var menuCidadesCenter = new Ext.Panel({
		title: 'Cidades',
		region: 'center',
		split: true,
		width: 100,
		collapsible: true,
		margins:'2 0 2 2',
		cmargins:'2 0 2 2',
		layout:'fit',
		iconCls:'ico_flag_green',
		items:[{
			 xtype:'editorgrid',
			 id:'gridcidades',
			 autoScroll:true,
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreCidades,
			 loadMask:true,
			 stripeRows:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Cidades',
					 id:'cidadeslist',
					 width:230,
					 sortable:true,
					 dataIndex:'descidade',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/cidades/set_cidades.php',
						  params:{
							idcidade:e.record.get('idcidade'),
							descidade:e.record.get('descidade'),
							idestado:Ext.getCmp('cidadesComboListCidades').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	});
	
	var menuCidadesEast = new Ext.Panel({
		title: 'Search',
		iconCls:'ico_search',
		region:'east',
		split:true,
		width:285,
		collapsible:true,
		margins:'2 2 2 0',
		cmargins:'2 0 2 2',
		defaults:{padding: 10},
		items:[{
			  xtype:'form',
			  border:'false',
			  height:413,
			  defaults:{xtype:'combo', anchor:'100%', padding:15, allowBlank:false},
			  items:[{
					id:'cidadesComboListPaises',
					store:comboStorePaises,
					fieldLabel:'Países',
					valueField:'idpais',
					displayField:'despais',
					typeAhead:true,
					triggerAction:'all',
					lazyRender:true,
					name:'idpais',
					mode:'local',
					emptyText:'Selecione um pais...',
					listeners:{
						'select':function(){
							
							
							if(Ext.getCmp('cidadesComboListPaises').isValid()){
								comboStoreEstados.load({
									params:{
										idpais:Ext.getCmp('cidadesComboListPaises').getValue(),
									  }
								  });
							  }
						  }
					  }
					},{
					xtype:'combo',
					id:'cidadesComboListCidades',
					store:comboStoreEstados,
					fieldLabel:'Estados',
					valueField:'idestado',
					displayField:'desestado',
					typeAhead:true,
					triggerAction:'all',
					lazyRender:true,
					name:'idestado',
					mode:'local',
					emptyText:'Selecione um estado...',
					listeners:{
						'select':function(){
							if(Ext.getCmp('cidadesComboListCidades').isValid()){
								comboStoreCidades.load({
									params:{
										idestado:Ext.getCmp('cidadesComboListCidades').getValue(),
									  }
								 });
							}
						}
					}
				}]
			}],
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Cidade',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_cidades')){
					Ext.getCmp('win.add_cidades').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_cidades',
						height:155,
						width:400,
						modal:true,
						title:'Adicionar uma nova Cidade',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'cidades_formAddcidades',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'combo',
								fieldLabel:'Países',
								id:'cidades_comboAddPaises',
								store:comboStorePaises,
								valueField:'idpais',
								displayField:'despais',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								name:'idpais',
								mode:'local',
								emptyText:'Selecione um pais...',
								listeners:{
									'select':function(){
										if(Ext.getCmp('cidades_comboAddPaises').isValid()){
											comboStoreEstados.load({
												params:{
													idpais:Ext.getCmp('cidades_comboAddPaises').getValue(),
												  }
											  });
										  }
									  }
								  }
							 },{
								xtype:'combo',
								id:'cidadescombo_addcidades',
								store:comboStoreEstados,
								valueField:'idestado',
								displayField:'desestado',
								fieldLabel:'Estados',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								/*name:'value',*/
								width:270,
								emptyText:'Selecione um estado...'
							 },{
								 xtype:'textfield',
								 id:'addcidade',
								fieldLabel:'Cidade',
								name:'descidade',
								emptyText:'Adicione uma cidade...',
								width:265,
							}],
						}],
						buttons:[{
							text:'Adicionar',
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('cidades_formAddcidades').getForm().isValid()){
									Ext.getCmp('cidades_formAddcidades').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/cidades/set_cidades.php',
										params:{											
											idestado:Ext.getCmp('cidadescombo_addcidades').getValue(),
										},
										success:function(){
											Ext.getCmp('gridcidades').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','Cidade adicionado com sucesso!');	
													Ext.getCmp('win.add_cidades').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  }],
	});
/*------------------------------ESTADOS-------------------------------------*/
	var menuEstadosCenter = new Ext.Panel({
		title: 'Estados',
		region: 'center',
		split: true,
		width: 100,
		collapsible: true,
		autoScroll:true,
		margins:'2 0 2 2',
		cmargins:'2 0 2 2',
		layout:'fit',	
		iconCls:'ico_flag_green',
		items:[{
			 xtype:'editorgrid',
			 id:'gridestados',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreEstados,
			 loadMask:true,
			 stripeRows:true,
			 border:false,
			 anchor:'100%',
			 viewConfig:{
				 forceFit:true,
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Estados',
					 id:'estadoslist',
					 width:150,
					 sortable:true,
					 dataIndex:'desestado',
					 editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				},{
					 header:'Sigla',
					 id:'abrevia2',
					 width:79,
					 sortable:true,
					 dataIndex:'desestadosigla',
					 editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/estados/set_estados.php',
						  params:{
							idestado:e.record.get('idestado'),
							desestado:e.record.get('desestado'),
							desestadosigla:e.record.get('desestadosigla'),
							idpais:Ext.getCmp('estado_comboListEstado').getValue()
						  },			
						  success:function(){
							 e.record.commit();
						}
					});	
			  	}
			},
			 height:610,
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	});
	
	var menuEstadosEast = new Ext.Panel({
		title: 'Search',
		iconCls:'ico_search',
		region:'east',
		split:true,
		width:285,
		collapsible:true,
		margins:'2 2 2 0',
		cmargins:'2 0 2 2',
		defaults:{padding: 10},
		items:[{
			  xtype:'form',
			  border:'false',
			  height:413,
			  defaults:{xtype:'combo', anchor:'100%', padding:15, allowBlank:false},
			  items:[{
					id:'estado_comboListEstado',
					store:comboStorePaises,
					fieldLabel:'Países',
					valueField:'idpais',
					displayField:'despais',
					typeAhead:true,
					triggerAction:'all',
					lazyRender:true,
					name:'despais',
					emptyText:'Selecione um país...',
					listeners:{ 
					  'select':function(){
						
						//console.log('gfg');  
						  if(Ext.getCmp('estado_comboListEstado').isValid()){
							  
							
							  comboStoreEstados.reload({
									
								  params:{
									  idpais:Ext.getCmp('estado_comboListEstado').getValue(),
									}
							  });
						  }
					  }
				  }
			  }],
		  }],
		bbar:[{
			xtype:'button',
			text:'Adicionar Estado',
			iconCls:'ico_adicionar',
			handler:function(){
				if(Ext.getCmp('win.add_estado')){
				  Ext.getCmp('win.add_estado').show();
				}else{
				  var win_add = new Ext.Window({
					  id:'win.add_estado',
					  height:155,
					  width:300,
					  modal:true,
					  title:'Adicionar um estado novo',
					  iconCls:'ico_flag_green',
					  items:[{
						  xtype:'form',
						  id:'estado_formAddestado',
						  border:'false',
						  padding:5,
						  defaults:{anchor:'100%', allowBlank:false},
						  items:[{
							  xtype:'combo',
							  id:'estado_combo_addestado',
							  store:comboStorePaises,
							  valueField:'idpais',
							  displayField:'despais',
							  fieldLabel:'País',
							  typeAhead:true,
							  triggerAction:'all',
							  lazyRender:true,
							  /*name:'value',*/
							  width:270,
							  emptyText:'Selecione um país...'
						   },{
							   xtype:'textfield',
							  fieldLabel:'Estado',
							  name:'desestado',
							  emptyText:'Adicione um estado...',
							  width:265,
						  },{
							  xtype:'textfield',
							  fieldLabel:'Sigla',
							  name:'desestadosigla',
							  emptyText:'Adicione uma abreviação...',
							  maxLength:2,
							  width:235
						  }],
					  }],
					  buttons:[{
						  text:'Adicionar',
						  iconCls:'ico_adicionar',
						  handler:function(btn){
							  loadInBtn(btn);
							  if(Ext.getCmp('estado_formAddestado').getForm().isValid()){
								  Ext.getCmp('estado_formAddestado').getForm().submit({
									  url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/estados/set_estados.php',
									  params:{											
										  idpais:Ext.getCmp('estado_combo_addestado').getValue(),
									  },
									  success:function(){
										  Ext.getCmp('gridestados').getStore().reload({
											  callback:function(){
												  Ext.MessageBox.alert('','Estado adicionado com sucesso!');	
												  Ext.getCmp('win.add_estado').close();
											  }	
										  });
									  }
								  })
							  }
						  }
					  }]
				  }).show();
			   }
			}
		}]
	});
/*------------------------------PAISES-------------------------------------*/
	var menuPaisesCenter = new Ext.Panel({
		region: 'center',
		layout:'fit',	
		autoScroll:true,
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar País',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_pais')){
					Ext.getCmp('win.add_pais').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_pais',
						height:150,
						width:400,
						modal:true,
						title:'Adicionar um país novo',
						iconCls:'ico_flag_green',
						items:[{
							xtype:'form',
							id:'Paises_formAddPais',
							border:'false',
							padding:5,
							defaults:{xtype:'textfield', allowBlank:false},
							items:[{
								fieldLabel:'País',
								name:'despais',
								emptyText:'Adicione um país...',
								width:265,
								/*tooltip:{title:'sadsds'},
								listeners:{
									'focus':function(t){
										console.log(t);
										this.getErrors();
									}
								}*/
							},{
								fieldLabel:'Abreviação tipo 2',
								name:'desabreviacao2',
								emptyText:'Adicione uma abreviação de duas letras...',
								maxLength:2,
								width:235
							},{
								fieldLabel:'Abreviação tipo 3',
								name:'desabreviacao3',
								emptyText:'Adicione uma abreviação de três letras...',
								maxLength:3,
								width:235
							},{
								xtype:'hidden',
								name:'instatus',
								value:'1'
							}],
						}],
						buttons:[{
							text:'Adicionar',
							buttonAlign:left,
							iconCls:'ico_adicionar',
							handler:function(btn){
								loadInBtn(btn);
								if(Ext.getCmp('Paises_formAddPais').getForm().isValid()){
									Ext.getCmp('Paises_formAddPais').getForm().submit({
										url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/paises/set-paises.php',
/*										params:{											
											despais:Ext.getCmp('addpais').getValue(),
											desabreviacao2:Ext.getCmp('addabrevia2').getValue(),
											desabreviacao3:Ext.getCmp('addabrevia3').getValue()
										},*/
										success:function(){
											Ext.getCmp('gridpaises').getStore().reload({
												callback:function(){
													Ext.MessageBox.alert('','País adicionado com sucesso!');	
													Ext.getCmp('win.add_pais').close();
												}	
											});
										}
									})
								}
							}
						}]
					}).show();
				 }
			  }
		  },'-',{
			  xtype:'button',
			  text:'Alterar Status',
			  iconCls:'ico_arrow_rotate_clockwise',
				 handler:function(){
					  var rec = Ext.getCmp('gridpaises').getSelectionModel().getSelected();
					  if(rec){
						  var status = (!rec.get('instatus'));
						  Ext.Ajax.request({
							  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/paises/stat-paises.php',
							  params: {
								  idpais: rec.get('idpais'),
								  instatus: status
							  },
							  success: function () {
								  rec.set('instatus', status);
								  rec.commit();
							  }
						  });
					  }else{
						  Ext.Msg.erro('','Selecione um país!');
					  }
				} 
		  }],
		  items:[{
			 xtype:'editorgrid',
			 bodyStyle:'overflow-x:hidden',
			 id:'gridpaises',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStorePaises,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 viewConfig:{
				 forceFit:true,
				 getRowClass:function(record){
					 console.log(record);
					 var _class = record.get('instatus');
					 if (!_class){
						 return 'red';
					 }else{
						 return 'black';
					 }
				 }
			 },
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Status',
					 id:'statuslist',
					 width:45,
					 sortable:true,
					 dataIndex:'instatus',
					 renderer:function(v){				
					 if(v == 1){
					 	return '<img src="/simpacweb/images/ico/16/accept.png"/>';
						}
					 else{
					 	return '<img src="/simpacweb/images/ico/16/remove.png"/>';
						}														  
					 }
				},{
					 header:'Países',
					 id:'paiseslist',
					 sortable:true,
					 dataIndex:'despais',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				},{
					 header:'Abreviação 2',
					 id:'abrevia2',
					 width:89,
					 sortable:true,
					 dataIndex:'desabreviacao2',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				},{
					header:'Abreviação 3',
					id:'abrevia3',
					width:89,
					sortable:true,
					dataIndex:'desabreviacao3',
					editor: new Ext.form.TextField({
						AllowBlack: false,							  
			    	})
			 	}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/paises/set-paises.php',
						  params:{
							idpais:e.record.get('idpais'),
							despais:e.record.get('despais'),
							desabreviacao2:e.record.get('desabreviacao2'),
							desabreviacao3:e.record.get('desabreviacao3'),
							instatus:e.record.get('instatus')
						  },			
						  success:function(){
							 e.record.commit();
						  }
					  });	
				  }
			  },
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	});
	
/*------------------------------------------LOCALIDADES(MAIN)------------------------------------------------*/
 var tabs = new Ext.Panel({
            title: 'Localidades',
            region: 'center',
            split: true,
            width: 250,
            collapsible: true,
			collapsed:false,
            margins:'2 1 2 1',
            cmargins:'2 2 2 2',
			layout:'fit',
			items:
			new Ext.TabPanel({
				margins:'2 0 0 0', 
				activeTab: 0,
				height:500,
				tabPosition:'bottom',
				defaults:{autoScroll:false},
				items:[{
					title: 'Países',
					layout: 'border',
			 
					items:[menuPaisesCenter],
				},{
					title: 'Estados',
					layout: 'border',
			 
					items:[menuEstadosCenter,menuEstadosEast],
				},{
					title: 'Cidades',
					layout: 'border',
			 
					items:[menuCidadesCenter,menuCidadesEast],
				},{
					title: 'Bairros',
					layout: 'border',
			 
					items:[menuBairrosCenter,menuBairrosEast],
				},{
					title: 'Logradouros',
					layout: 'border',
			 
					items:[menuLogradourosCenter,menuLogradourosEast],
				}]
			})				
		});
 /*================================================================================================*/
/*--------------------------DEPARTAMENTOS(east)-------------------------------------------------*/
        var menuEast = new Ext.Panel({
            title: 'Departamentos',
			id:'tabdepartamentos',
            region: 'east',
            split: true,
            width: 220,
            collapsible: true,
			collapsed:true,
            margins:'2 2 2 1',
            cmargins:'2 2 2 2',
			layout:'fit',
			bbar:[{
				xtype:'button',
				text:'Expandir Tudo',
				iconCls:'ico_arrow_out',
				handler:function(){
					Ext.getCmp('dept_treepanel').expandAll();		
      			}
			},{
				xtype:'button',
				text:'Contrair Tudo',
				iconCls:'ico_arrow_in',
				handler:function(){
					Ext.getCmp('dept_treepanel').collapseAll();		
      			}
			}],
			items: [{
				xtype: 'treepanel',
				id:'dept_treepanel',
				//renderTo: 'tree-div',
    			useArrows: true,
				autoScroll: true,
				animate: true,
				enableDD: true,
				containerScroll: true,
				border: false,
				split: true,
				expanded:true,
				loader: new Ext.tree.TreeLoader({
					id:'dept_treeloader',
					dataUrl:'departamentos/get_departamentos.php',
					listeners:{
						'beforeload':function(treeLoader, node){
							this.baseParams.iddepartamentopai = node.attributes.iddepartamentopai;
						}
					}
				}),
				root: new Ext.tree.AsyncTreeNode({
					id:'dept_asynctreenode',
					nodeType: 'async',
					text: 'Setores',
					draggable: false,
					expanded: false,
					expandable:true,
					iddepartamentopai:0
				}),
				rootVisible: true,
				listeners: {
					dblclick: function(node) {/*
						if(Ext.getCmp('win.editnode')){
							(Ext.getCmp('win.editnode')).show();
						}else{
							new Ext.Window({
								id:'win.editnode',
								title:'Adicionar submenu em '+node.text,
								padding:10,
								height:130,
								width:400,
								items:[{
									xtype:'form',
									id:'formEditNode',
									border:false,
									defaults:{padding:10},
									items:[{
										xtype:'textfield',
										id:'desdepartamento_value',
										emptyText:'Adicione um submenu em '+node.text+'...',
										name:'desdepartamento',
										hideLabel:true,
										anchor:'100%',
											allowBlank: false,
									},{
										xtype:'button',
										text:'OK',	
										iconCls:'ico_accept',
										width:100,
										handler:function(btn){
															
											console.log(node.attributes);
											
											loadInBtn(btn);
											
											if(Ext.getCmp('formEditNode').getForm().isValid()){
												Ext.getCmp('formEditNode').getForm().submit({
													url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/departamentos/set_departamentos.php',
													params:{											
														iddepartamentopai:node.attributes.iddepartamentopai,
													},
													success:function(form, action){
			
														node.leaf = false;
														node.expand(false, true, function(){
															node.appendChild({
																text:Ext.getCmp('desdepartamento_value').getValue(),
																iddepartamentopai:action.result.iddepartamento,
																leaf:true
															});
															Ext.getCmp('win.menuaddnode').close();
														});
													}
												})										
											}										
										}
									}]
								}]
							}).show();
						}
					*/},
					contextmenu: function(node, e){ //node = nó, e = posição x,y... 
						new Ext.menu.Menu({
							items:['<b>'+node.text+'</b>',{
									text:'Adicionar',
									iconCls:'ico_add',
									handler:function(){
										if(Ext.getCmp('win.menuaddnode')){
											(Ext.getCmp('win.menuaddnode')).show();
										}else{
											new Ext.Window({
												id:'win.menuaddnode',
												title:'Adicionar submenu em '+node.text,
												padding:10,
												height:130,
												width:400,
												items:[{
													xtype:'form',
													id:'formMenuAddNode',
													border:false,
													defaults:{padding:10},
													items:[{
														xtype:'textfield',
														emptyText:'Adicione um submenu em '+node.text+'...',
														name:'desdepartamento',
														id:'desdepartamento_value',
														hideLabel:true,
														anchor:'100%',
															allowBlank: false,
													},{
														xtype:'button',
														text:'OK',	
														iconCls:'ico_accept',
														width:100,
														handler:function( btn){
															//console.log(node);
															//console.log(node.attributes.iddepartamentopai);
															
															loadInBtn(btn);
															
															if(Ext.getCmp('formMenuAddNode').getForm().isValid()){
																Ext.getCmp('formMenuAddNode').getForm().submit({
																	url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/departamentos/set_departamentos.php',
																	params:{											
																		iddepartamentopai:node.attributes.iddepartamentopai,
																	},
																	success:function(form, action){
																		
																		//console.log(action);
																		//console.log(node.attributes.iddepartamentopai);
																		
																		node.leaf = false;
																		node.expand(false, true, function(){
																			node.appendChild({
																				text:Ext.getCmp('desdepartamento_value').getValue(),
																				iddepartamentopai:action.result.iddepartamento,
																				leaf:true
																			});
																			Ext.getCmp('win.menuaddnode').close();
																		});
																	}
																})										
															}										
														}
													}]
												}]
											}).show();
										}								
									}	
								},{
									text:'Renomear',
									iconCls:'ico_pencil',
										handler:function(){
										if(Ext.getCmp('win.menurenamenode')){
											(Ext.getCmp('win.menurenamenode')).show();
											//console.log(Ext.getCmp('dept_treepanel').getValue());
										}else{
											new Ext.Window({
												id:'win.menurenamenode',
												title:'Renomear '+node.text,
												padding:10,
												height:130,
												width:400,
												items:[{
													xtype:'form',
													id:'formMenuRenameNode',
													border:false,
													defaults:{padding:10},
													items:[{
														xtype:'textfield',
														id:'departamentoid',
														emptyText:'Renomeie '+node.text+'...',
														name:'desdepartamento',
														hideLabel:true,
														anchor:'100%',
														value: node.text,
															allowBlank: false,
													},{
														xtype:'button',
														text:'OK',	
														iconCls:'ico_accept',
														width:100,
														handler:function(btn){
															loadInBtn(btn);
															
															if(Ext.getCmp('formMenuRenameNode').getForm().isValid()){
																Ext.getCmp('formMenuRenameNode').getForm().submit({
																	url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/departamentos/set_departamentos.php',
																	params:{											
																		iddepartamento:node.attributes.iddepartamentopai,
																	},
																	success:function(form,action){
																		node.setText(Ext.getCmp('departamentoid').getValue());	
																		Ext.getCmp('win.menurenamenode').close();
																	}
																})										
															}										
														}
													}]
												}]
											}).show();
										}								
									}
								},{
									text:'Excluir',
									iconCls:'ico_delete',
									handler:function(){
									 Ext.MessageBox.confirm('Confirmação', 'Deletar o registro selecionado?',
										 function(btn){
											 if(btn=='yes'){
												Ext.Ajax.request({
												url:'/simpacweb/labs/Massaharu/extjsTelas/05.ADM-para-CRM/departamentos/del_departamentos.php',
												params:{ 
													iddepartamento:node.attributes.iddepartamentopai,
												},
												success:function(form,action){
													node.remove();							
												},
										   });
										}
									});									
								 }
							}]
						}).showAt(e.xy);
					}
				},
			}]
		});
/*===========================================================================================================*/		
/*----------------------MAIN------------------------------------------------------------------------------*/
      if(Ext.getCmp('admcrm')){
		  Ext.getCmp('admcrm')
	  }else{
	  var win = new Ext.Window({
		  id:'admcrm',
		  height:589,
		  width:1017,
		  modal:false,
		  minimizable:true,
		  maximizable:true,	
		  minWidth:300,
		  minHeight:400,
		  collapsible:true,
		  plain:true,
          layout: 'border',
		  title:'Administrativo CRM',	
		  iconCls:'ico_user_gray',
		  tbar:[{
				text:'Menu',
				iconCls:'ico_oneColor_r53_c25_s1',
				menu:[{
					text:' Departamentos',				
					iconCls:'ico_chart_organisation',
					handler:function(){
						Ext.getCmp('tabdepartamentos').toggleCollapse();
						setTimeout(
							function(){
								Ext.getCmp('dept_treepanel').getRootNode().expand();
							},1000
						);
						//console.log(Ext.getCmp('dept_treepanel').getRootNode().attributes.iddepartamentopai);
					},
				},{
					text:'Cadastros',
					iconCls:'ico_Essen_category',
					menu:[{
						  text:'Cargos',
						  iconCls:'ico_chair',
						  handler:function(){
							  Ext.getCmp('accordion_cadastroscargos').expand();
						  },
					},{
						  text:'Logradouros Tipos',
						  iconCls:'ico_flag_green',
						  handler:function(){
							  Ext.getCmp('accordion_cadastroslogradourostipo').expand();
						  },
					},{
						  text:'Cetegoria de Contatos',
						  iconCls:'ico_contact_phone',
						  handler:function(){
							  Ext.getCmp('accordion_cadastroscategoriascontato').expand();
						  },
					},{
						  text:'Pessoa Juridica Tipo',
						  iconCls:'ico_People',
						  handler:function(){
							  Ext.getCmp('accordion_cadastrospessoajuridicatipo').expand();
						  },
					},{
						  text:'Tipos de Documentos',
						  iconCls:'ico_list',
						  handler:function(){
							  Ext.getCmp('accordion_cadastrosdocumentostipo').expand();
						  },
					},{
						  text:'Tipos de Contatos',
						  iconCls:'ico_contact_phone',
						  handler:function(){
							  Ext.getCmp('accordion_cadastroscontatostipo').expand();
						  },
					}],
				}]
				/*listeners:{
					click:function(){
					Ext.getCmp('dept_treepanel').getRootNode().expand(node);
					}
				}*/
			}],
		  
		  items: [menuEast, tabs,accordion],	
		  					 
		}).show();
	}
</script>