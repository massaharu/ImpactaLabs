<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
	var comboStoreDocumentostipos = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/documentostipos/get_documentostipos.php',
		root:'myData',
		fields:[{name:'desdocumentotipo',type:'string'}, 
				{name:'iddocumentotipo',type:'int'}],
      autoLoad:true
   });
  
  if(Ext.getCmp('win.documentostipos')){
	  Ext.getCmp('win.documentostipos').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.documentostipos',
		  height:460,
		  width:320,
		  modal:false,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_list',
		  title:' Tipos de Documentos',
		  autoScroll:true,
		  bbar:[{
			  xtype:'button',
			  text:'Adicionar Tipo de Documento',
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
							handler:function(){
								if(Ext.getCmp('formAddDocumentostipos').getForm().isValid()){
									Ext.getCmp('formAddDocumentostipos').getForm().submit({
										url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/documentostipos/set_documentostipos.php',
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
		  }],
		  items:[{
			 xtype:'editorgrid',
			 id:'griddocumentostipos',
			 sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			 store:comboStoreDocumentostipos,
			 loadMask:true,
			 stripeRows:true,
			 autoHeight:true,
			 border:false,
			 anchor:'100%',
			 cm:new Ext.grid.ColumnModel({
				 columns:[{
					 header:'Documentos Tipos',
					 id:'documentostiposlist',
					 width:300,
					 sortable:true,
					 dataIndex:'desdocumentotipo',
					 editor: new Ext.form.TextField({
						AllowBlack: false,							  
					})
				}],
			 }),
			 listeners:{
			 afteredit: function(e){
				  //console.log(e);					
				  Ext.Ajax.request({ 
					  url: '/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/documentostipos/set_documentostipos.php',
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
			 border:true,
			 defaults:{anchor:'100%'},
		  }],
	}).show();
}
</script>


