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
				{name:'idpais',type:'int'},
				{name:'instatus',type:'boolean'}],
      autoLoad:true
   });
		
	var comboStoreEstados = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/estados/get_estadosbypais.php',
	  root:'myData',
	  fields:['idestado','desestado','desestadosigla',{name:'instatus',type:'boolean'}],	
   });
  
	var comboStoreCidades = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cidades/get_cidadesbyestado.php',
	  root:'myData',
	  fields:[{name:'idcidade',type:'int'},
			  {name:'descidade',type:'string'},
			  {name:'idestado',type:'int'}],
	}); 
	  
  	var store = new Ext.data.JsonStore({
	  url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/bairros/get_bairrosbycidades.php',
	  root:'myData',
	  fields:[{name:'idbairro',type:'int'},
			  {name:'desbairro',type:'string'},
			  {name:'idcidade',type:'int'}],
	});
  
  if(Ext.getCmp('win.bairros')){
	  Ext.getCmp('win.bairros').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.bairros',
		  height:460,
		  width:455,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_flag_green',
		  title:' Bairros',
		  autoScroll:true,
		  tbar:[new Ext.form.ComboBox({
			  id:'comboListpaises',
			  store:comboStorePaises,
			  width:150,
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
						  comboStoreEstados.load({
							  params:{
								  idpais:Ext.getCmp('comboListpaises').getValue(),
							  }
						   });
					    }
			  	     }
			      }
			  }),new Ext.form.ComboBox({
			  id:'comboListestados',
			  store:comboStoreEstados,
			  width:150,
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
					  if(Ext.getCmp('comboListestados').isValid()){
						  comboStoreCidades.load({
							  params:{
								  idestado:Ext.getCmp('comboListestados').getValue(),
							  }
						   });
					    }
			  	     }
			      }
			  }),new Ext.form.ComboBox({
			  id:'comboListcidades',
			  store:comboStoreCidades,
			  width:150,
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
						if((Ext.getCmp('comboListestados').isValid())&&(Ext.getCmp('comboListcidades').isValid())){
							store.reload({
								params:{
									idcidade:Ext.getCmp('comboListcidades').getValue(),
								  }
							  });
						  }
					  }
				  }
			  })
			],
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
								id:'combo_addpaises',
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
									  if(Ext.getCmp('combo_addpaises').isValid()){
										  comboStoreEstados.load({
											  params:{
												  idpais:Ext.getCmp('combo_addpaises').getValue(),
											  }
										   });
										}
									 }
								  }
							 },{
								xtype:'combo',
								id:'combo_addestados',
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
									  if(Ext.getCmp('combo_addestados').isValid()){
										  comboStoreCidades.load({
											  params:{
												  idestado:Ext.getCmp('combo_addestados').getValue(),
											  }
										   });
										}
									 }
								  }
							 },{
								xtype:'combo',
								id:'combo_addcidades',
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
											idcidade:Ext.getCmp('combo_addcidades').getValue(),
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
		  items:[{
			 xtype:'editorgrid',
			 id:'gridbairros',
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
					 header:'Bairros',
					 id:'bairroslist',
					 width:300,
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
							idcidade:Ext.getCmp('comboListcidades').getValue()
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
bairros (Grid - com três colunas)
descidades
desabreviacao2
desabreviacao3*/
</script>


