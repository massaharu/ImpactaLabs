<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
  var comboStorePaises = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/paises/get-paises.php',
	  root:'myData',
	  fields:['idpais','despais','desabreviacao2','desabreviacao3',{name:'instatus',type:'boolean'}],	
	autoLoad:true
  });
  var comboStore = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/get_estadosbypais.php',
	  root:'myData',
	  fields:['idestado','desestado','desestadosigla',{name:'instatus',type:'boolean'}],	
  });
	  
  var store = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cidades/get_cidadesbyestado.php',
	  root:'myData',
	  fields:[{name:'idcidade',type:'int'},
			  {name:'descidade',type:'string'},
			  {name:'idestado',type:'int'}],
});
  
  
  if(Ext.getCmp('win.cidades')){
	  Ext.getCmp('win.cidades').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.cidades',
		  height:475,
		  width:347,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_flag_green',
		  title:' Cidades',
		  autoScroll:true,
		  tbar:[new Ext.form.ComboBox({
			  id:'comboListpaises',
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
					  if(Ext.getCmp('comboListpaises').isValid()){
						  comboStore.load({
							  params:{
								  idpais:Ext.getCmp('comboListpaises').getValue(),
								}
							});
						}
				    }
				}
			  }),new Ext.form.ComboBox({
			  id:'comboListcidades',
			  store:comboStore,
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
					  if(Ext.getCmp('comboListcidades').isValid()){
						  store.load({
							  params:{
								  idestado:Ext.getCmp('comboListcidades').getValue(),
								}
							});
						}
				   }}
			  })/*,'-',{
			  xtype:'button',
			  text:'Pesquisar',
			  iconCls:'ico_search', 
			  handler:function(){
				  if(Ext.getCmp('comboListcidades').isValid()){
					  store.reload({
						  params:{
							  idestado:Ext.getCmp('comboListcidades').getValue(),
							}
						});
					}
				}
			}*/],
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
							id:'formAddcidades',
							border:'false',
							padding:5,
							defaults:{anchor:'100%', allowBlank:false},
							items:[{
								xtype:'combo',
								fieldLabel:'Países',
								id:'comboAddPaises',
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
										if(Ext.getCmp('comboAddPaises').isValid()){
											comboStore.load({
												params:{
													idpais:Ext.getCmp('comboAddPaises').getValue(),
												  }
											  });
										  }
									  }
								  }
							 },{
								xtype:'combo',
								id:'combo_addcidades',
								store:comboStore,
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
								if(Ext.getCmp('formAddcidades').getForm().isValid()){
									Ext.getCmp('formAddcidades').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cidades/set_cidades.php',
										params:{											
											idestado:Ext.getCmp('combo_addcidades').getValue(),
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
		  items:[{
			 xtype:'editorgrid',
			 id:'gridcidades',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:store,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Cidades',
					 id:'cidadeslist',
					 width:300,
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
							idestado:Ext.getCmp('comboListcidades').getValue()
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
	}).show();
}
/*Todos vão ter delete, update e insert.
cidades (Grid - com três colunas)
descidades
desabreviacao2
desabreviacao3*/
</script>


