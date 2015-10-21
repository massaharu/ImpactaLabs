<?
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['BOOTSTRAP'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
	Ext.onReady(function(){
		//GLOBALS
		//var PATH = "/simpacweb/modulos/fit/admTurmasPAI";
		var PATH = "/simpacweb/labs/Massaharu/extjsTelas/25.IntegradorIDigitalClass";
		
/////////////////////// STORES ///////////////////////////////////////
		var storelist_turmapai = new Ext.data.JsonStore({
			url:PATH+'/json/list_turmapai.php',
			root:'data',
			fields:[
				{name:'idturmapai', type:'int'},
				{name:'id_cod_turma', type:'int'},
				{name:'desnome'},
				{name:'idperiodo', type: 'int'},
				{name:'desperiodo'},
				{name:'descurso_sophia'},
				{name:'nmlogin'},
				{name:'instatus',type:'bit'},
				{name:'dtcadastro',type:'date',dateFormat:'timestamp'}
			]
		});
		
		var storelist_periodos = new Ext.data.JsonStore({
			url:PATH+'/json/list_periodos.php',
			root:'data', 
			fields:[
				{name:'CODIGO', type:'int'},
				{name:'DESCRICAO'}
			],
			autoLoad:true,
			listeners:{
				load:function($this, rec, opts){}
			}
		});

/////////////////////// (ABA) TURMAS PAI //////////////////////////////
	////////////////CENTER
		var integradoridigitalclass_center_grid = new Ext.Panel({
			id:'idturmaspai_grid',
			region:'center',
			width:'100%',
			margins:'4 4 4 4',
			layout:'hbox',
			tbar:[{
				xtype: 'button',
				text: 'Adicionar',
				icon: PATH+'/res/img/add.png',
				scale: 'medium',
                iconAlign: 'top',
				cls: 'padding: 5px;',
				width: 60,
				handler:function(){
					xt('idturmaspai_add').expand();
				}
			},'-','->',{
				xtype: 'buttongroup',
				title:'<b>Período</b>',
              	columns: 1,
            	defaults: {
                	scale: 'small'
            	},
            	items: [{
					xtype: 'combo',
					store: storelist_periodos,
					valueField: 'CODIGO',
					displayField: 'DESCRICAO',
					typeAhead: true,
					mode: 'local',
					triggerAction: 'all',
					emptyText: 'Selecione o período.',
					selectOnFocus: true,
					id: 'cmbperiodos',
					width: 150,
					listeners:{
						'select': function(cmb, rec, index){
							
							loadGridsTurmaPai({
								idperiodo: rec.get('CODIGO')
							});
							
							xt('cmbperiodosadd').setValue(
								xt('cmbperiodos').getValue()
							).setRawValue(
								xt('cmbperiodos').getRawValue()
							);
						}
					}
            	}]	
			}],
			items:[{
				xtype:'grid',
				flex:1,
				id:'gridturmaspai',
				store:storelist_turmapai,
				loadMask:true,
				stripeRows:true,
				autoScroll:true,
				border:true,
				height:458,
				viewConfig:{
					forceFit:true,
					getRowClass:function(record, rowIndex, rp, ds){
						/*var _class = record.get('instatus');
						if (!_class){
							return 'red';
						}else{
							return 'black';
						}*/
					}
				},
				sm: new Ext.grid.RowSelectionModel({
					singleSelect: false
				}),
				cm:new Ext.grid.ColumnModel({
					defaults: {
						sortable: true, 
						collapsible: true
					},
					columns:[new Ext.grid.RowNumberer({
						width:30,
						header:'nº',
					}),{ 
						header:'Cod. da Turma',
						id:'colvestibular',
						width:45,
						dataIndex:'id_cod_turma'
					},{
						header:'Sigla Turma',
						id:'coldesnome',
						width:40,
						dataIndex:'desnome'
					},{
						header:'Curso',
						id:'coldescurso_sophia',
						dataIndex:'descurso_sophia'
					},{
						header:'Período',
						id:'coldesperiodo',
						width:30,
						dataIndex:'desperiodo'
					},{
						header:'Cadastrado',
						id:'colnmlogin',
						width:35,
						dataIndex:'nmlogin'
					},{
						xtype:'datecolumn',
						header:'Data de Cadastro',
						id:'coldtcadastro',
						width:50,
						dataIndex:'dtcadastro',
						format:'d/m/Y h:i',
					}],
				}),
			},{
				xtype:'grid',
				flex:1,
				id:'gridturmaspai2',
				store:storelist_turmapai,
				loadMask:true,
				stripeRows:true,
				autoScroll:true,
				border:true,
				height:458,
				viewConfig:{
					forceFit:true,
					getRowClass:function(record, rowIndex, rp, ds){
						/*var _class = record.get('instatus');
						if (!_class){
							return 'red';
						}else{
							return 'black';
						}*/
					}
				},
				sm: new Ext.grid.RowSelectionModel({
					singleSelect: false
				}),
				cm:new Ext.grid.ColumnModel({
					defaults: {
						sortable: true, 
						collapsible: true
					},
					columns:[new Ext.grid.RowNumberer({
						width:30,
						header:'nº',
					}),{ 
						header:'Cod. da Turma',
						id:'colvestibular',
						width:45,
						dataIndex:'id_cod_turma'
					},{
						header:'Sigla Turma',
						id:'coldesnome',
						width:40,
						dataIndex:'desnome'
					},{
						header:'Curso',
						id:'coldescurso_sophia',
						dataIndex:'descurso_sophia'
					},{
						header:'Período',
						id:'coldesperiodo',
						width:30,
						dataIndex:'desperiodo'
					},{
						header:'Cadastrado',
						id:'colnmlogin',
						width:35,
						dataIndex:'nmlogin'
					},{
						xtype:'datecolumn',
						header:'Data de Cadastro',
						id:'coldtcadastro',
						width:50,
						dataIndex:'dtcadastro',
						format:'d/m/Y h:i',
					}],
				}),
			}],
		});
		
	////////////////////EAST
		var integradoridigitalclass_east_add = new Ext.Panel({
			id:'idintegradoridigitalclass_add', 
			region:'east',
			collapseMode:'mini',
			collapsed:true,
			split:true,
			width:'100%',
			layout:'fit',
			tbar:[],
			items: [],
			listeners:{}
		});	
		
/////////////////////// MAIN WINDOW ///////////////////////////////////
		new Ext.Window({
			title:'Integrador IDigital Class',
			id:'idintegradoridigitalclass',
			iconCls:'ico_file',
			width:Page.width-100,
			height:553,
			layout:'border',
			items:[{
				xtype:'panel',
				region: 'center',
				margins:'2 2 2 2',
				border:false,
				layout:'fit',
				items:[{
					xtype:'tabpanel',
					margins:'2 2 2 2', 
					activeTab: 0,
					tabPosition:'bottom',
					items:[{
						title: 'Disciplinas',
						layout: 'border',	
						items:[integradoridigitalclass_center_grid, integradoridigitalclass_east_add],
					},{
						title: 'Turmas',
						//layout: 'border',	
					//	items:[documentos_center_grid/*,documentos_east_grid*/]
					}]
				}]		
			}],		
		}).show();
	});
</script>