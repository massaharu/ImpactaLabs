<hr />
<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>

<script type="text/javascript">
	if (Ext.getCmp('win.dept')){
		(Ext.getCmp('win.dept')).show()
	}else{
		var win = new Ext.Window({
			id:'win.dept',
			height:550,
			width:450,
			minimizable:true,
		  	maximizable:true,
			collapsible: true,
			autoScroll:true,
			iconCls:'ico_chart_organisation',
			title:'Departamentos',
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
				title: 'Setores',
				collapsible: true,
				//renderTo: 'tree-div',
    			useArrows: true,
				autoScroll: true,
				animate: true,
				enableDD: true,
				containerScroll: true,
				border: false,
				split: true,
				loader: new Ext.tree.TreeLoader({
					id:'dept_treeloader',
					dataUrl:'get_departamentos.php',
					listeners:{
						'beforeload':function(treeLoader, node){
							this.baseParams.iddepartamentopai = node.attributes.iddepartamentopai;
						}
					}
				}),
				root: new Ext.tree.AsyncTreeNode({
					id:'dept_asynctreenode',
					nodeType: 'async',
					text: 'Ext tree ',
					draggable: false,
					expanded: true,
					expandable:true,
					iddepartamentopai:0
				}),
				rootVisible: false,
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
													url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/departamentos/set_departamentos.php',
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
															console.log(node);
															console.log(node.attributes.iddepartamentopai);
															
															loadInBtn(btn);
															
															if(Ext.getCmp('formMenuAddNode').getForm().isValid()){
																Ext.getCmp('formMenuAddNode').getForm().submit({
																	url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/departamentos/set_departamentos.php',
																	params:{											
																		iddepartamentopai:node.attributes.iddepartamentopai,
																	},
																	success:function(form, action){
																		
																		console.log(action);
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
											console.log(Ext.getCmp('dept_treepanel').getValue());
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
																	url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/departamentos/set_departamentos.php',
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
												url:'/simpacweb/labs/Massaharu/myTests_lab/ExtJs/5.ADM-para-CRM/departamentos/del_departamentos.php',
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
		}).show();	
	}
/*- agricultura,
  	- biotecnologia,
    
- varejo,
	- Vestuário,
    - utilitários

- Bancário,
	- Consultoria,
	- Finanças,
    	- Sem fins lucrativos,
    	- media,
	- Seguros,    

- Engenharia,
	- energia,
    - construção,
    - ambiental,
    
- governo,
	- educação,
    	- Recreação,
	- saúde,
	- hospitalidade,
    - transporte,
    
- Industrial,
	- máquinas,
    - produtos químicos,
    - Alimentos e Bebidas,
    
- tecnologia,
	- Eletrônicos,
    	- Entretenimento,
    - comunicações,
		- telecomunicações,
    
- outro,
	- Envio,*/

/*Renomear - passa sempre o iddepartamento 0
  Deletar - não deleta nó com filhos.*/
</script>				   






