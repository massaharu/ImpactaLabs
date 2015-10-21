<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
  var comboStore = new Ext.data.JsonStore({
	  url:'/simpacweb/modulos/atendimento/chat-adm/ajax/listdepartamenots.php',
	  root:'myData',
	  fields:[{name:'desdepartamento', type:'string'},
			  {name:'iddepartamento', type:'int'}]
  });
	  
  var store = new Ext.data.JsonStore({
	  url:'/simpacweb/modulos/atendimento/chat-adm/ajax/listadefrasesdept.php',
	  root:'myData',
	  fields:['idfrase','desfrase']
  });
/*Ext.onReady(function(){*/
  if(Ext.getCmp('win.frases.deptchat')){
	  Ext.getCmp('win.frases.deptchat').show()
  }else{
	  var win = new Ext.Window({
		  id:'win.frases.deptchat',
		  height:649,
		  width:1017,
		  modal:true,
		  minimizable:true,
		  maximizable:true,
		  iconCls:'ico_BlackCast_showreel',
		  title:' Frases',
		  tbar:[{
			  xtype:'button',
			  text:'Adicionar nova frase',
			  iconCls:'ico_adicionar',
			  handler:function(){
				  if(Ext.getCmp('win.add_frase')){
					Ext.getCmp('win.add_frase').show();
				  }else{
				  	var win_add = new Ext.Window({
						id:'win.add_frase',
						height:117,
						width:700,
						modal:true,
						title:'Adicione uma frase',
						iconCls:'ico_BlackCast_showreel',
						items:[{
							xtype:'form',
							id:'formAddFrase',
							border:'false',
							padding:5,
							items:[{
								xtype:'textfield',
								id:'addfrase',
								emptyText:'Adicione uma frase...',
								hideLabel:true,
								width:670
							},{
								xtype:'combo',
								id:'combo_addfrase',
								store:comboStore,
								displayField:'desdepartamento',
								valueField:'iddepartamento',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								name:'desdepartamento',
								emptyText:'Selecione um dept.',
								hideLabel:true,
								width:370
							},{
								xtype:'button',
								iconCls:'ico_adicionar',
								text:'Adicionar',
								handler:function(){
									if(Ext.getCmp('formAddFrase').getForm().isValid()){
										Ext.getCmp('formAddFrase').getForm().submit({
											url:'/simpacweb/modulos/atendimento/chat-adm/ajax/add_frase.php',
											params:{
												iddepartamento:Ext.getCmp('combo_addfrase').getValue(),
												desfrase:Ext.getCmp('addfrase').getValue()	
											},
											success:function(){
												Ext.getCmp('comboDept').getStore().reload
												Ext.getCmp('gridfrases').getStore().reload({
													callback:function(){
														Ext.MessageBox.alert('','Frase adicionada com sucesso!');	
														Ext.getCmp('win.add_frase').close();
													}	
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
		  },'-',{
			  xtype:'button',
			  text:'Remover frase selecionada',
			  iconCls:'ico_action_delete',
			  handler:function(){
				 Ext.MessageBox.confirm('Confirmação', 'Deletar o registro selecionado?',
					 function(btn){
						 if(btn=='yes'){
							Ext.Ajax.request({
							url: '/simpacweb/modulos/atendimento/chat-adm/ajax/remove_frase.php',
							params:{ 
								idfrase:Ext.getCmp('gridfrases').getSelectionModel().getSelected().get('idfrase'),
							},
							success:function(){
								Ext.getCmp('gridfrases').getStore().reload({
									callback:function(){
										Ext.MessageBox.alert('','Frase deletada com sucesso!');	
									}	
								});
							},
					   });
					}
				});									
			 }
		  },'-',new Ext.form.ComboBox({
			  id:'comboDept',
			  store:comboStore,
			  valueField:'iddepartamento',
			  displayField:'desdepartamento',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  name:'desdepartamento',
			  emptyText:'Selecione um dept.'
			  }),'-',{
			  xtype:'button',
			  text:'Pesquisar',
			  iconCls:'ico_search', 
			  handler:function(){
				  if(Ext.getCmp('comboDept').isValid()){
					  store.reload({
						  params:{
							  iddepartamento:Ext.getCmp('comboDept').getValue(),
							}
						});
					}
				}
			}],
		  items:[{
			 xtype:'grid',
			 id:'gridfrases',
			 store:store,
			 loadMask:true,
			 stripeRows:true,
			 border:false,
			 columns:[new Ext.grid.RowNumberer(),{ /*RowNumberer enumera uma lista de '1' a 'n'...*/
				 header:'Frases',
				 id:'fraselist',
				 width:957,
				 sortable:true,
				 dataIndex:'desfrase'					 
			 }],
			 height:560,
			 border:true,
			 defaults:{anchor:'100%'},
			 listeners:{
			   'dblclick':function(){
				   if(Ext.getCmp('win.altfrase')){
					 	Ext.getCmp('win.altfrase').show();
				   }else{
					  var win_altfrase = new Ext.Window({
						   title:"Alterar frase...",
						   id:'win.altfrase',
						   height:108,
						   width:780,
						   defaults:{padding: 10},
						   items:[{
							   xtype:'form',
							   id:'altfrase',
							   border:'false',							   
							   items:[{
								   xtype:'textfield',
								   width:750,
								   id:'upfrase',
								   hideLabel:true,
								   value: Ext.getCmp('gridfrases').getSelectionModel().getSelected().get('desfrase')
								}]
							}],
							   buttons:[{
								   xtype:'button',
								   text:'Ok',
								   iconCls:'ico_accept',
								   width:80,
								   handler:function(){
									  if(Ext.getCmp('altfrase').getForm().isValid()){
										  Ext.getCmp('altfrase').getForm().submit({
											  url:'/simpacweb/modulos/atendimento/chat-adm/ajax/update_frase.php',
											  params:{
												  idfrase:Ext.getCmp('gridfrases').getSelectionModel().getSelected().get('idfrase'),
												  desfrase:Ext.getCmp('gridfrases').getSelectionModel().getSelected().get('upfrase'),
											  },
											  success:function(){
													Ext.getCmp('gridfrases').getStore().reload({
														callback:function(){
															Ext.MessageBox.alert('','Frase atualizada com sucesso!');	
															Ext.getCmp('win.altfrase').close();
														}	
													});
												}
											})
										}
									}
								},{
									xtype:'button',
									text:'Cancela',
									iconCls:'ico_cancel',
									width:80,
									handler:function(){
										win_altfrase.close();
									}
								}]
							}).show();
				   		}
					} 
		  		}
		  }],
		  buttons:[{
			  text:'Fechar',
			  iconCls:'ico_fechar',
			  handler:function(){
				  win.close();
			  }
		 }]		
	}).show();
}
/*Para adicionar utilize a seguinte procedure: 
sp_chatadmfrases_add – passe dois parametros: conteudo da frase e o id do departamento.
sp_chatadmfrases_update – passe três parâmetros: conteúdo da frase, id da frase
sp_chatadmfrases_remove – passe um parâmetro: id da frase.*/
</script>


