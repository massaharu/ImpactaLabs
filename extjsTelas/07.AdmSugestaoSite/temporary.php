<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">

	var store1 = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/7.AdmSugestaoSite/treinamentoslistados_list.php',	
		root:'myData',
		fields:[{name:'descurso',type:'string'}, 
				{name:'idcurso',type:'int'}],
		autoLoad:true
   });		
				
	var store = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/7.AdmSugestaoSite/gerenciadortreinamentos_list.php',	
		root:'myData',
		fields:[{name:'descurso',type:'string'}, 
				{name:'descursoavancado',type:'string'}, 
				{name:'descursoprerequisito',type:'string'}, 
				{name:'idcurso',type:'int'},
				{name:'idavancado',type:'int'},
				{name:'idprerequisito',type:'int'},
				{name:'idclassificacao',type:'int'},
				{name:'dtcadastro',type:'date',dateFormat:'timestamp'}],
      autoLoad:true
   });
	
	if(Ext.getCmp('wingerenciadortreinamentos')){
		(Ext.getCmp('wingerenciadortreinamentos').show)
	}else{
		var rec = SimpacWeb.vars.rec;
		var winMain = new Ext.Window({
			title:'Gerenciador de Treinamentos',
			id:'wingerenciadortreinamentos',
			height:450,
			width:800,
			resizable:false,
			minimizable:true,
			maximizable:true,	
			minWidth:200,
			minHeight:100,
			//autoScroll:true,
			collapsible:true,
			//plain:true,
			layout:'fit',
			//anchor:'100%',
			iconCls:'ico_book_edit',
			tbar:[{
				 xtype:'button',
				 text:'Add Treinamento',
				 iconCls:'ico_add',
				 handler:function(){
				 	if(Ext.getCmp('winaddtreinamento')){
						Ext.getCmp('winaddtreinamento').show();
					}else{
						var winAddTreinamento = new Ext.Window({
							title:'Adicionar Treinamento, Pre-Requisitos e Sugestões',
							id:'winaddtreinamento',
							iconCls:'ico_book_edit',
							height:200,
							width:500,
							modal:true,
							items:[/*{
							  	xtype:'form',
								id:'formaddtreinamento',
								padding:10,
								border:false,
								items:[{
									xtype:'fieldset',
									title:'Treinamentos',
									autoHeight:true,
									collapsed:false,
									padding:2,
									items:[{
										xtype:'combo_cursosativos',
										id:'cmbcursos',
										hideLabel:true,
										typeAhead:true,
										triggerAction:'all',
										lazyRender:true,
										allowBlank:false,//Não permite entradas vazias
										emptyText:'Selecione um treinamento para ser listado...',
										name:'idcurso',
										hiddenName:'idcurso',
										width:430,
										listeners:{
											'select':function(){
												if(Ext.getCmp('cmbcursos').isValid()){
													cmbtreinamentos.load();
												}
											}
										}
									},{
										xtype:'button',
										iconCls:'ico_add',
										text:'Adicionar',
										handler:function(){
											if(Ext.getCmp('formaddtreinamento').getForm().isValid()){
												Ext.getCmp('formaddtreinamento').getForm().submit({
													url:'/simpacweb/labs/Massaharu/extjsTelas/7.AdmSugestaoSite/treinamento_save.php',
													params:{
														destreinamento:Ext.getCmp('cmbcursos').lastSelectionText
													},
													success:function(){
														Ext.getCmp('gridgerenciadortreinamento').getStore().reload({
															callback:function(){
																Ext.MessageBox.alert('Treinamento adicionado com sucesso!','Adicione um pre-requisito e uma sugestão abaixo.');	
															}	
														});
													}													
												})
											}
										}
									}],
								}],
							},*/{
								xtype:'form',
								id:'formaddrequisitosugestao',
								padding:10,
								border:false,
								items:[{								
									xtype:'fieldset',
									title:'Adicionar Pre-Requisito e Sugestão para o Treinamento',
									autoHeight:true,
									collapsed:false,
									padding:2,
									defaults:{padding:5,margins:'5'},
									items:[{
										xtype:'combo',
										store:store1,
										id:'cmbtreinamentos',
										fieldLabel:'Treinamento',
										valueField:'idcurso',
										displayField:'descurso',
										typeAhead:true,
										triggerAction:'all',
										lazyRender:true,
										allowBlank:false,
										emptyText:'Selecione um treinamento listado...',
										name:'idcurso',
										hiddenName:'idcurso',
										mode:'local',//filtra a pesquisa na combo
										width:330,
										/*listeners:{
											'afterrender':function(c){
												store1 = xt('cmbtreinamentos').getStore();
												store2 = xt('cmbtreinamentos').getStore();
												console.log(xt('cmbtreinamentos').getStore());
											}
										}*/
									},{
										xtype:'combo_cursos',
										id:'cmbprerequisito',
										fieldLabel:'Pré-requisito',
										valueField:'idcurso',
										displayField:'descurso',
										typeAhead:true,
										triggerAction:'all',
										lazyRender:true,
										allowBlank:false,
										emptyText:'Selecione um pre-requisito para o treinamento acima...',
										name:'idprerequisito',
										hiddenName:'idprerequisito',
										mode:'local',//filtra a pesquisa na combo
										width:330
									},{
										xtype:'combo_cursos',
										id:'cmbavancado',
										fieldLabel:'Sugestões',
										valueField:'idcurso',
										displayField:'descurso',
										typeAhead:true,
										triggerAction:'all',
										lazyRender:true,
										allowBlank:false,
										emptyText:'Selecione uma sugestão para o treinamento acima...',
										name:'idavancado',
										hiddenName:'idavancado',
										mode:'local',//filtra a pesquisa na combo
										width:330
									},{
										xtype:'button',
										iconCls:'ico_add',
										text:'Adicionar',
										handler:function(btn){
											
											if(Ext.getCmp('formaddrequisitosugestao').getForm().isValid()){
												loadInBtn(btn);
												Ext.getCmp('formaddrequisitosugestao').getForm().submit({
													url:'/simpacweb/labs/Massaharu/extjsTelas/7.AdmSugestaoSite/gerenciadortreinamentos_save.php',
													
													success:function(){
														
														Ext.getCmp('gridgerenciadortreinamento').getStore().reload({
															callback:function(){
																//Ext.MessageBox.alert('Inserido com sucesso!','Treinamento adicionado com sucesso!');	
																Ext.getCmp('winaddtreinamento').close();
															}	
														});
													}
												})
											}
										}
									}],
								}],
							}],
						}).show();
					}
				 }				
			},'-',{
				xtype:'button',
				text:'Delete Treinamento',
				iconCls:'ico_delete',
				handler:function(){
					if(!Ext.getCmp('gridgerenciadortreinamento').getSelectionModel().getSelected()){
						Ext.MessageBox.erro('Aviso!', 'Por favor, você deve selecionar um registro para deletar.');
					}else{
						 Ext.MessageBox.confirm('Confirmação', 'Deletar o registro selecionado?',
							 function(btn){
								 if(btn=='yes'){
									Ext.Ajax.request({
									url: '/simpacweb/labs/Massaharu/extjsTelas/7.AdmSugestaoSite/gerenciadortreinamentos_remove.php',
									params:{ 
										idclassificacao:Ext.getCmp('gridgerenciadortreinamento').getSelectionModel().getSelected().get('idclassificacao')
										/*idtreinamento:Ext.getCmp('gridgerenciadortreinamento').getSelectionModel().getSelected().get('idtreinamento'),
										idprerequisito:Ext.getCmp('gridgerenciadortreinamento').getSelectionModel().getSelected().get('idprerequisito'),
										idavancado:Ext.getCmp('gridgerenciadortreinamento').getSelectionModel().getSelected().get('idavancado'),*/
									},
									success:function(){
										Ext.getCmp('gridgerenciadortreinamento').getStore().reload({
											callback:function(){
												Ext.MessageBox.alert('','Registro deletado com sucesso!');	
											}	
										});
									},
							   });
							}
						});	
					}
			   }				
			},'->',{
				xtype:'label',
				text:'Busca por treinamentos: ',
				style:'margin:0 5px; font-weight: bold;'
			},{
				xtype:'textfield',
				id:'filterCurso', width:((Page.width/5)),
				listeners:{
					'valid':function(a){
						store.filter('descurso', a.getValue(), true, false);
					}
				}
			}, {
				xtype:'hidden',
				id:'idcurso'
			},'-',],
			items:[{
				xtype:'grid',
				id:'gridgerenciadortreinamento',
				store:store,
				//bodyStyle:'overflow-x:hidden',
				//autoHeight:true,
				autoScroll:true,
				height:400,
				loadMask:true,
				stripeRows:true,
				border:false,
				anchor:'100%',
				sm: new Ext.grid.RowSelectionModel({
					singleSelect:true,
				}),	
				viewConfig:{
					forceFit:true,
			 	},
				cm: new Ext.grid.ColumnModel({
					columns:[new Ext.grid.RowNumberer(),{
						header:'Treinamentos',
						id:'gridtreinamentos',
						width:100,
						sortable:true,
						dataIndex:'descurso',
						editor: new Ext.form.TextField({
						})
					},{
						header:'Pre-Requisitos',
						id:'gridprerequisito',
						width:100,
						sortable:true,
						dataIndex:'descursoprerequisito',
						editor: new Ext.form.TextField({
						})
					},{
						header:'Sugestões',
						id:'gridavançado', 
						width:100,
						sortable:true,
						dataIndex:'descursoavancado',
						editor: new Ext.form.TextField({
						})
					},{
						header:'Data de Cadastro',
						xtype:'datecolumn',
						id:'griddtcadastro',
						width:100,
						sortable:true,
						dataIndex:'dtcadastro',
						format:'d/m/Y H:i:s',
					}]
				}),
				listeners:{
				 afteredit: function(e){				
					  Ext.Ajax.request({ 
						  url: '/simpacweb/labs/Massaharu/extjsTelas/7.AdmSugestaoSite/gerenciadortreinamentos_update.php',
							  params:{
								idclassificacao:e.record.get('idclassificacao'),
								descursoprerequisito:e.record.get('descursoprerequisito'),
								idprerequisito:e.record.get('idprerequisito'),
								descurso:e.record.get('descurso'),
								idcurso:e.record.get('idcurso'),
								descursoavancado:e.record.get('descursoavancado'),
								idavancado:e.record.get('idavancado'),
							  },			
							  success:function(){
								 e.record.commit();
							}
						});	
					}
				},
			}],
		}).show();
	}
</script>