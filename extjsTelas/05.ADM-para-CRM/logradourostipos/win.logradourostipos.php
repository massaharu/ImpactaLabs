<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStoreLogradourostipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/logradourostipos/get_logradourostipos.php',
		root:'myData',
		fields:[{name:'deslogradourotipo',type:'string'}, 
				{name:'idlogradourotipo',type:'int'}],
      autoLoad:true
   });
  
  if(Ext.getCmp('win.logradouros')){
	  Ext.getCmp('win.logradouros').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.logradouros',
		  height:460,
		  width:320,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_flag_green',
		  title:' Tipos de Logradouros',
		  autoScroll:true,
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
							handler:function(){
								if(Ext.getCmp('formAddLogradouros').getForm().isValid()){
									Ext.getCmp('formAddLogradouros').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/logradourostipos/set_logradouros.php',
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
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Logradouros',
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
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/logradouros/set_logradouros.php',
						  params:{
							idlogradouros:e.record.get('deslogradourotipo'),
							deslogradouro:e.record.get('deslogradourotipo'),
							idbairro:Ext.getCmp('logradourosComboListBairros').getValue()
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


