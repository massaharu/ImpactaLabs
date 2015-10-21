<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
var comboStorePaises = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/get-paises.php',
		root:'myData',
		fields:[{name:'despais',type:'string'}, 
				{name:'idpais',type:'int'},'desabreviacao2','desabreviacao3',
				{name:'instatus',type:'boolean'}],
      autoLoad:true
   });
		
	var comboStoreEstados = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/get_estadosbypais.php',
	  root:'myData',
	  fields:['idestado','desestado','desestadosigla',{name:'instatus',type:'boolean'}],	
	  autoLoad:true
   });
  
	var comboStoreCidades = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cidades/get_cidadesbyestado.php',
	  root:'myData',
	  fields:[{name:'idcidade',type:'int'},
			  {name:'descidade',type:'string'},
			  {name:'idestado',type:'int'}],
	  autoLoad:true
	}); 
	  
  	var comboStoreBairros = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/bairros/get_bairrosbycidades.php',
	  root:'myData',
	  fields:[{name:'idbairro',type:'int'},
			  {name:'desbairro',type:'string'},
			  {name:'idcidade',type:'int'}],
	  autoLoad:true
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
		cmargins:'2 0 2 2',
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
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/bairros/set_bairros.php',
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
		width:350,
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
							handler:function(){
								if(Ext.getCmp('formAddbairros').getForm().isValid()){
									Ext.getCmp('formAddbairros').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/bairros/set_bairros.php',
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
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cidades/set_cidades.php',
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
		width:350,
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
							handler:function(){
								if(Ext.getCmp('cidades_formAddcidades').getForm().isValid()){
									Ext.getCmp('cidades_formAddcidades').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cidades/set_cidades.php',
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
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Estados',
					 id:'estadoslist',
					 width:150,
					 sortable:true,
					 dataIndex:'desestado',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				},{
					 header:'Sigla',
					 id:'abrevia2',
					 width:79,
					 sortable:true,
					 dataIndex:'desestadosigla',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/set_estados.php',
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
		width:350,
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
						  handler:function(){
							  if(Ext.getCmp('estado_formAddestado').getForm().isValid()){
								  Ext.getCmp('estado_formAddestado').getForm().submit({
									  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/set_estados.php',
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
		  bbar:[{
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
							handler:function(){
								if(Ext.getCmp('Paises_formAddPais').getForm().isValid()){
									Ext.getCmp('Paises_formAddPais').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/set-paises.php',
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
							url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/stat-paises.php',
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
					 var _class = record.get('instatus');
					 if (!_class){
						 return 'red';
					 }/*else{
						 return 'black';
					 }*/
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
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/set-paises.php',
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
/*---------------------------TABPANEL(center)------------------------------------------------------------------*/
	var tabs = new Ext.TabPanel({
		margins:'2 0 0 0', 
		activeTab: 0,
		height:500,
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
		}]
	});

  
/*----------------------MAIN------------------------------------------------------------------------------*/
	if(Ext.getCmp('admCRM')){
		Ext.getCmp('admCRM')
	}else{
		var win = new Ext.Window({
			id:'admCRM',
			height:529,
			width:626,
			modal:false,
			minimizable:true,
			maximizable:true,
			maximized:false,
			minWidth:300,
			minHeight:400,
			closable:true,
			collapsible:true,
			title:'Administrativo para CRM',
			iconCls:'ico_flag_green',
			
			items: [tabs],	
						   
	  }).show();
  }
</script>