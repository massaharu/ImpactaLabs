<?php
	# @AUTOR = Bcunha #
	$GLOBALS['menu'] = true;
	
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

	//Coloca o cabeçário na tela
	topopagina('ImpacBot2.png', 'EXTJS PAGE TEST');
	/*topopagina('contract_256.png', 'Solicitação de Prestador de Serviço');*/
?>
<script type="text/javascript">
/*-------------------------------STORE-------------------------------------------------------*/
var store = new Ext.data.ArrayStore({
		fields:[{name:'nome'},
				{name:'profissao'},
				{name:'idade',type:'int'}],
		data:[['Rodrigo Silva','Programador','21'],
			  ['Yukari Morishima','Secretaria','19'],
			  ['Kamui Kobayashi','Software Engineer','23'],
			  ['Robert de Niro','Actor','61'],
			  ['David Gilmour','Guitarrist','68']]
});	
	
var store1 = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/myTests_lab/Ext/ExtJs Window2/get_extjswindow2.php',
		root:'myData',
		fields:[{name: 'inpreenchido',type:'int'},
				{name: 'descurso', type:'string'},
				{name: 'nome', type:'string'}],
		autoLoad:true
});


Ext.onReady(function(){

/*--------------------ACCORDION(west)----------------------------------------------------------------*/
	var item1 = new Ext.Panel({
		title: 'Basic Information',
		iconCls: 'ico_accept',
		items: [{
			xtype: 'form',
			padding: 5,
			border: false,
			defaults: {
				xtype: 'textfield',
				anchor: '100%',
				width: 100,
				padding: 5
			},
			items: [{
				fieldLabel: 'Nome',
			}, {
				fieldLabel: 'Surname',
			}, {
				fieldLabel: 'E-Mail',
			}, {
				fieldLabel: 'Company',
			}, {
				fieldLabel: 'Identification',
			}, {
				xtype: 'datefield',
				fieldLabel: 'Bithday'
			}],
			buttons: [{
				text: 'Submit',
				iconCls:'ico_accept'
			}, {
				text: 'Clear',
				iconCls:'ico_clear'
			}]
		}]
	});
	
	  var item2 = new Ext.Panel({
		  title: 'Accordion Item 2',
		  iconCls:'ico_Terminate'
	  });
	
	  var item3 = new Ext.Panel({
		  title: 'Accordion Item 3',
		  iconCls:'ico_table_multiple'
	  });
	
	  var item4 = new Ext.Panel({
		  title: 'Accordion Item 4',
		  iconCls:'ico_sport_tennis'
	  });
	
	  var item5 = new Ext.Panel({
		  title: 'Accordion Item 5',
		  iconCls:'ico_Linux'
	  });
	  var accordion = new Ext.Panel({
		  title:'Profile data',
		  region:'west',
		  margins:'2 0 0 2',
		  collapsible:true,
		  split:true,
		  width: 250,		  
		  layout:'accordion',
		  items: [item1, item2, item3, item4, item5]
	  });
/*---------------------------TABPANEL(center)------------------------------------------------------------------*/
	  var tabs = new Ext.TabPanel({
		region: 'center',
		margins:'2 0 0 0', 
		activeTab: 0,
		defaults:{autoScroll:true},
		listeners:{
			'tabchange':function(t,tab){
				console.log(t);
				console.log(tab);
				if(tab.title == "Formulário"){
					Ext.Msg.alert('aviso','ola impacta!!!');
				}
			}
		},
		  items:[{
		  title: 'First Tab',
		  xtype:'form',
		  id:'formAlterarCursos',
		  layout:'vbox',
		  layoutConfig:{padding:10,align:'left'},
		  padding:15,
		  border:false,
		  defaults:{hideLabel:true, margins:'5', height:20 },
		  items:[{
			  xtype:'combo_cursosativos',
			  typeAhead:true,
			  triggerAction:'all',
			  lazyRender:true,
			  allowBlank:false,//Não permite entradas vazias
			  emptyText:'Selecione um curso...',
			  name:'idcurso',
			  hiddenName:'idcurso'
		  },{
			  xtype:'button',
			  text:'Salvar',
			  iconCls:'ico_save',
			  handler:function(){					
				  if(Ext.getCmp('formAlterarCursos').getForm().isValid()){
					  Ext.getCmp('formAlterarCursos').getForm().submit({
						  success:function(){
							  Ext.getCmp('grid_treinamentosMarcados').getStore().reload({
								  callback:function(){
									  Ext.MessageBox.alert('','Registro salvo com sucesso!');	
									  Ext.getCmp('winAlterarCursos').close();
								  }	
							  });
						  }
					  })
				  }
			  }
		  },{
			  xtype:'button',
			  text:'Fechar',
			  iconCls:'ico_fechar',
			  handler:function(){
				  Ext.getCmp('winAlterarCursos').close();
				  }
			  }],
		},{
			title: 'Formulário',
			items:[{
				xtype:'form',
				border:false,
				padding:10,
				defaults:{xtype:'textfield', anchor:'100%',width:100},
			  items: [{
				  fieldLabel: 'First Name',
				  name: 'first',
				  allowBlank:false,		
			  },{
				  fieldLabel: 'Last Name',
				  name: 'last'
			  },{
				  fieldLabel: 'Company',
				  name: 'company'
			  },{
				  fieldLabel: 'Email',
				  name: 'email',
				  vtype:'email'
			  },{
				  fieldLabel: 'Time',
				  name: 'time',
				  minValue: '8:00am',
				  maxValue: '6:00pm'
				}]
			}],    
			closable:true
		},{
			title: 'Grid',
			items:[{
				xtype:'grid',
					store: store,
					loadMask:true,
					listeners:{
						'rowclick':function(grid,index,e){//rowclick - seleciona toda a linha de uma grid
							//console.log(grid);
							//console.log(index);
							//console.log(e);
							console.log(grid.store.data.items[index].data.nome);//'index' para que a linha inteira seja selecionada
							if(index == 3){
								Ext.Msg.alert('aviso','ola imapcta!!!');
							}
						}
					},
					columns:[{
						header:'Nome',
						width:220,
						id:'nome',
						sortable:true,
						dataIndex: 'nome'
					},{
						header:'Profissão',
						width:220,
						id:'profissao',
						sortable:true,
						dataIndex:'profissao'
					},{
						header:'idade',
						width:60,
						id:'idade',
						sortable:true,
						dataIndex:'idade'						
					}],
					height:180,
					width:500,
					border:true,
					defaults:{anchor:true},		
				}],                
			closable:true
		},{
			title:'Miscelaneous',
			items:[{
				xtype:'form',
				padding:15,
				height:400,
				border:true,
				defaults:{hideLabel:false,anchor:100},	
					items:[{
						xtype:'button',
						text:'Simple Form',
						padding:20,
						handler:function(){
						Ext.getCmp('simpleForm').show()
						}
					},{
						xtype:'combo_cursosativos',
						typeAhead:true,
						triggerAction:'All',
						lazyRender: true,
						allowBlank:false,
						hideLabel:true,
						width:300,
						anchor:'100%',
					},{
						xtype:'textfield',
						fieldLabel:'Textfield'					
				  }]
			  }],
			closable:true,
		}]
	  });
	  
	  /*--------------------------PANELS(east, south)-------------------------------------------------*/
	  var menuEast = new Ext.Panel({
		title: 'Menu',
		region: 'east',
		split: true,
		width: 250,
		collapsible: true,
		collapsed:true,
		margins:'2 2 0 0',
		cmargins:'2 2 2 2',
		layout:'fit',
		items:
		new Ext.TabPanel({
			border:false,
			activeTab:0,
			tabPosition:'bottom',
			items:[{
				title:'Something else'
			},new Ext.grid.PropertyGrid({
				title:'Property Grid',
				closable:true,
				source: {
					"(name)": "Properties Grid",
					"grouping": false,
					"autoFitColumns": true,
					"productionQuality": false,
					"created": new Date(Date.parse('10/15/2006')),
					"tested": false,
					"version": 0.01,
					"borderWidth": 1
				}
			}),{
				title:'Grid Curso',
				items:[{
					xtype:'grid',
					store:store1,
					loadMask:true,
					columns:[{
						header:'',
						width:40,
						id:'void',
						sortable:true,
						dataIndex:'inpreenchido'
					},{
						header:'Curso',
						width:230,
						id:'curso',
						sortable:true,
						dataIndex:'descurso'							
					}],
					height:361,
					width:280,
					border:true,
					defaults:{anchor:true},
				}],
			}]
		})					
	  });
	  
	  var menuSouth = new Ext.Panel({
		title: 'SubMenu',
		region:'south',
		split:true,
		height:100,
		collapsible:true,
		margins:'0 2 2 2'
	  });
/*---------------------------------------------------------------------------------------------*/
	  var dateMenu = new Ext.menu.DateMenu({
        /*handler: function(dp, date){
            Ext.example.msg('Date Selected', 'You chose {0}.', date.format('M j, Y'));
	}*/
});
/*----------------------MAIN------------------------------------------------------------------------------*/
   /*   if(Ext.getCmp('firstExtWindow')){
		  Ext.getCmp('firstExtWindow')
	  }else{
	  var win = new Ext.Window(
							   
	Ext.onReady(function(){
		  id:'firstExtWindow',
		  height:649,
		  width:1017,
		  modal:false,
		  minimizable:true,
		  maximizable:true,	
		  maximized:true,
		  minWidth:300,
		  minHeight:400,
		  collapsible:true,
		  closable:true,
		  plain:true,
          layout: 'border',
		  title:'ExtJS Window 2',		  
		  tbar:['De: ',{
			  xtype:'datefield',
			  format:'d/m/y',
			  width:150,
			  allowBlank:false,
		  },'-','A: ',{
			  xtype:'datefield',
			  format:'d/m/y',
			  width:150,
			  allowBlank:false,
		  },'-',{
			  xtype:'button',
			  iconCls:'ico_search',
			  text:'Pesquisar'
		  },'-',{
			  text:'Menu',
			  iconCls:'ico_BlackFill_order-192',
			  menu:[{				  	
					iconCls:'ico_datatype_date',
					text:'Choose a Date',
					menu:dateMenu				
		  		},{
					xtype:'combo_cursosativos',
					iconCls:'ico_datatype_date',
					emptyText:'Selecione um Curso...',
					mode:'local',
					selectOnFocus:true,
					typeAhead:true,
					triggerAction:'all',
					name:'idcurso',
					hiddenName:'idcurso',
					width:250
		 	 }]
		}],
		bbar:[{
			  text:'Option A',
			 	menu:[{
					text:'Option A1'
				},{
					text:'Option A2'
				}]
		 	 },'-',{
			  text:'Option B',
				menu:[{
				  text:'Option B1',
				  	menu:[{
						text:'Option B1.1'
					},{
						text:'Option B1.2'						
					}]
			  	},{
				  text:'Option B2'
			  		}]
		 		},'-',{
			  text:'Option C',
			  	menu:[{
					text:'Option C1',
					menu:[{
						text:'Option C1.1'
					},{
						text:'Option C1.2',
						menu:[{
							text:'Option C1.2.1'
						},{
							text:'Option C1.2.2'
						}]				
					}]
				},{
					text:'Option C2',
					menu:[{
						text:'Option C2.1'
					},{
						text:'Option C2.2'
					}]
				}]
			  
		 	}],
		  
		  items: [menuEast, tabs, menuSouth, accordion],		  
			  
		  buttons:[{
					text:'Fechar',
					iconCls:'ico_fechar',
					handler:function(){
						win.close();
					}
				},{
					text:'Message',			
					handler:function(){
					Ext.Msg.alert('This is a status line', 'This is a message line.');				
					}				
				}]	
		  */
		  new Ext.FullPanel({
			/*____________________________________________________________________________________________*/
			/*title:'Solicitação de Prestador de Serviço',*/ //Título
			id:'SolicitacaoPrestadorServicoBase', //Id da 'Window'
			height:Page.height - 128,
			plain:false,
			modal:true, //Bloquear conteúdo da página enquanto a janela está ativa
			items:[{				
			}/*,
				janelaSolicitacoes,
				janelaConteudo*/
			],
			items: [menuEast, tabs, menuSouth, accordion],
			layout:'border',
			/*____________________________________________________________________________________________*/
			//BBAR
			bbar:['->',{
				text:'Salvar',
				iconCls:'ico_save',
				//Função
				handler:function(){
								
				}				
			}],
			/*____________________________________________________________________________________________*/
		});
		  
				//Reajusta o tamanho da tela
			window.onresize = function(){			 
				//Obtem o tamanho no exato momento
				var a = getPageSize();	
				
				//No componente com determinado 'Id', é setado o novo tamanho (Para reajuste da tela)		 
				Ext.getCmp('SolicitacaoPrestadorServicoBase').setSize(a.width,a.height - 122);
			}
		
		});
</script>