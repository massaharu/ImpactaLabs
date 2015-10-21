<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['ext_theme'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
topopagina('frase.png ','Frases ');
?>
<script type="text/javascript">
	var comboStore = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/04.Frases-dept_chat/listdepartamenots.php',
		root:'myData',
		fields:[{name:'desdepartamento', type:'string'},
				{name:'iddepartamento', type:'int'}]
	});
	
	var store = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/04.Frases-dept_chat/listadefrasesdept.php',
		root:'myData',
		fields:['idfrase','desfrase']
	});
	
Ext.onReady(function(){
					 
	var panelFrasesaddremove = new Ext.Panel({
		title:'Adicionar Frase',
		id:'idpanelAddFrase', 
		iconCls:'ico_adicionar',
		region:'south',
		margins:'0 4 4 4',
		collapsible: true,
		collapsed:true,
		height:108,
		width:'100%',
		border:true,
		split:true,
		layout:'fit',
		tbar:[{
			xtype:'combo',
			id:'combo_addfrase',
			width:200,
			autoHeight:true,
			store:comboStore,
			displayField:'desdepartamento',
			valueField:'iddepartamento',
			typeAhead:true,
			triggerAction:'all',
			lazyRender:true,
			name:'desdepartamento',
			allowBlank:false,
			emptyText:'Selecione um departamento...',			
		},'-',{
			iconCls:'ico_adicionar',
			text:'Adicionar',
			handler:function(){
				if(Ext.getCmp('formAddFrase').getForm().isValid() && Ext.getCmp('combo_addfrase').isValid()){
					Ext.getCmp('formAddFrase').getForm().submit({
						url:'/simpacweb/labs/Massaharu/extjsTelas/04.Frases-dept_chat/add_frase.php',
						params:{
							iddepartamento:Ext.getCmp('combo_addfrase').getValue(),
							desfrase:Ext.getCmp('addfrase').getValue()	
						},
						success:function(){
							if(!Ext.getCmp('comboDept').isValid()){
								store.reload({
									params:{
										iddepartamento:Ext.getCmp('combo_addfrase').getValue(),
									},
								callback:function(){
										Ext.MessageBox.info('','Frase adicionada com sucesso!',function(btnok){
											if(btnok == 'ok'){
												Ext.getCmp('idpanelAddFrase').collapse();
											}
										});	
									}		
								});
							}else{
								Ext.getCmp('gridfrases').getStore().reload({
									callback:function(){
										Ext.MessageBox.alert('','Frase adicionada com sucesso!',function(btnok){
											if(btnok == 'ok'){
												Ext.getCmp('idpanelAddFrase').collapse();
											}
										});	
									}	
								});
							}
						}
					})
				}else{
					Ext.MessageBox.warning('Aviso!','Selecione um departamento e insira uma frase.')
				}
			}
		},'-',{
			iconCls:'ico_Down',
			tooltip:"Esconder janela",
			handler:function(){
				Ext.getCmp('idpanelAddFrase').collapse();
			}
		}],
		items:[{
			xtype:'form',
			id:'formAddFrase',
			height:200,
			border:false,
			padding:10,
			style:"padding:0 10 0 0;",
			defaults:{
				allowBlank:false,
				hideLabel:true,				
			},			
			items:[{
				xtype:'textarea',
				autoHeight:true,
				id:'addfrase',				
				width:'100%',
				height:10,
				emptyText:'Adicione uma frase...',
			}]
		}]
	});	
//==========================================================================================================================================================
	var panelFrasesgrid = new Ext.Panel({
		id:'idpanelFrasesgrid',
		region:'center',
		width:'100%',
		margins:'4 4 0 4',
		split:true,
		layout:'fit',
		tbar:[{
			xtype:'combo',	
			id:'comboDept',
			store:comboStore,
			valueField:'iddepartamento',
			displayField:'desdepartamento',
			typeAhead:true,
			triggerAction:'all',
			lazyRender:true,
			name:'desdepartamento',
			emptyText:'Selecione um departamento...',
			allowBlank:false,
			listeners:{
				'select':function(){
					if(Ext.getCmp('comboDept').isValid()){
						//console.log('texto');
						store.reload({
							params:{
								iddepartamento:Ext.getCmp('comboDept').getValue(),
							}
						});
					}
				}
			}
		},'-',{
			iconCls:'ico_Undo', 
			tooltip:"Recarregar",
			handler:function(){
				if(Ext.getCmp('comboDept').isValid()){
					//console.log(panelFrasesaddremove.collapsible);
					store.reload({
						params:{
							iddepartamento:Ext.getCmp('comboDept').getValue(),
						}
					});
				}else{
					Ext.MessageBox.warning('Aviso!','Nenhum Departamento foi selecionado!');
				}
			}
		}],
		items:[{
			xtype:'editorgrid',
			id:'gridfrases',
			store:store,
			loadMask:true,
			stripeRows:true,
			autoScroll:true,
			border:false,
			height:458,
			viewConfig:{
				 forceFit:true,
			 },
			sm: new Ext.grid.RowSelectionModel({
			 singleSelect: true,
			}),
			cm:new Ext.grid.ColumnModel({
				columns:[new Ext.grid.RowNumberer({
					width:30,
					header:'nº',
				}),{ 
					header:'Frases',
					id:'fraselist',
					width:980,
					sortable:true,
					dataIndex:'desfrase',
					editor: new Ext.form.TextField({
						AllowBlank: false,							  
					})
				}],
			}),
			listeners:{
				afteredit: function(e){	
					console.log(e.record.get('desfrase'));
					Ext.Ajax.request({ 
						url:'/simpacweb/modulos/atendimento/chat-adm/ajax/update_frase.php',
							  params:{
								 idfrase:e.record.get('idfrase'),
								 upfrase:e.record.get('desfrase'),
							  },			
							  success:function(){
								 e.record.commit();
							}
						});	
					},
				'click':function(){
						if(Ext.getCmp('gridfrases').getSelectionModel().getSelected()){
							Ext.getCmp('btnremover').enable();
						}else{
							Ext.getCmp('btnremover').disable();
						}
					}	
				}
			}],
		});
//==========================================================================================================================================================	
	new Ext.FullPanel({
		id:'panel.frasesdeptchat', //Id da 'Window'
		height:Page.height - 128,
		plain:false,
		modal:true, //Bloquear conteúdo da página enquanto a janela está ativa
		layout:'border',
		bbar:[{
			xtype:'button',
			text:'Adicionar Frase',
			iconCls:'ico_adicionar',
			handler:function(){
				setTimeout(
					function(){
						Ext.getCmp('idpanelAddFrase').expand()
					},500
				);
			}
		},'-',{
		  xtype:'button',
		  id:'btnremover',
		  text:'Remover Frase',
		  disabled:true,
		  iconCls:'ico_action_delete',
		  handler:function(){
			  	if(!Ext.getCmp('gridfrases').getSelectionModel().getSelected()){
						Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar uma frase para deletar.');
				}else{					
					Ext.MessageBox.confirm('Confirmação', 'Deseja deletar a frase selecionada?',
					function(btn){
						if(btn=='yes'){
							Ext.Ajax.request({
								url: '/simpacweb/labs/Massaharu/extjsTelas/04.Frases-dept_chat/remove_frase.php',
								params:{ 
									idfrase:Ext.getCmp('gridfrases').getSelectionModel().getSelected().get('idfrase'),
								},
								success:function(){
									Ext.getCmp('gridfrases').getStore().reload({
										callback:function(){
											Ext.MessageBox.info('','Frase deletada com sucesso!');	
										}	
									});
								},
							});
						}
					});									
				}
			}
		},'-',],
		items:[
			   panelFrasesgrid,
			   panelFrasesaddremove
		],		
	});	
//_____________________Reajusta o tamanho da tela____________________________________________________________________________________	
	window.onresize = function(){			 
		//Obtem o tamanho no exato momento
		var a = getPageSize();	
		//No componente com determinado 'Id', é setado o novo tamanho (Para reajuste da tela)		 
		Ext.getCmp('panel.frasesdeptchat').setSize(a.width,a.height - 122);
	};					
});
</script>


