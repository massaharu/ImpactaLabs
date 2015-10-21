<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStoreCargos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cargos/get_cargos.php',
		root:'myData',
		fields:[{name:'descargo',type:'string'}, 
				{name:'idcargo',type:'int'}],
      autoLoad:true
   });
  
  if(Ext.getCmp('win.cargos')){
	  Ext.getCmp('win.cargos').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.cargos',
		  height:460,
		  width:320,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  c
		  title:' Tipos de Cargos',
		  autoScroll:true,
		  bbar:[{
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
							handler:function(){
								if(Ext.getCmp('formAddCargos').getForm().isValid()){
									Ext.getCmp('formAddCargos').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cargos/set_cargos.php',
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
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Cargos',
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
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/cargos/set_cargos.php',
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
	}).show();
}
</script>


