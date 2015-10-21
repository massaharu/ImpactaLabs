<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">

	var store = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/09.AvalDiariaInstrutor/json/avalDiariaInstrutor_list.php',
		root:'myData',
		fields:[{name:'nm_treinamento',type:'string'},
				{name:'dtcadastramento',type:'date',dateFormat:'timestamp'},
				{name:'data_inicio',type:'date',dateFormat:'timestamp'},
				{name:'data_termino',type:'date',dateFormat:'timestamp'},
				{name:'periodo',type:'string'},
				{name:'nm_sala',type:'string'},
				{name:'comentario',type:'string'},
				{name:'nminstrutor',type:'string'}],				
	});
	
	var expander = new Ext.ux.grid.RowExpander({
		tpl : new Ext.Template(
			'<b>Comentário:</b></br>{comentario}</br></br><b>Data de Cadastramento: </b>{dtcadastramento:date("d/m/Y H:i:s")}</br><b>Data de Inicio: </b>{data_inicio:date("d/m/Y H:i:s")}</br><b>Data de Término: </b>{data_termino:date("d/m/Y H:i:s")}'
		)
	});
	
	var dataHoje = new Date();
	
	function fncolor(value, metaData, record, rowIndex, colIndex, store){
		if(record.data.comentario != ""){
			metaData.attr="style='background-color:#C7C9D1;'";	
		}
		return value;
	}
//==========================================================================================================================
	if(Ext.getCmp('winavalDiariaInstrutor')){
		Ext.getCmp('winavalDiariaInstrutor').show();
	}else{ 
		var win = new Ext.Window({
			id:'winavalDiariaInstrutor',
			title:' Avaliação Diária do Instrutor',
			iconCls:'ico_avise_me',
			width:900,
			height:600,
			modal:true,
			minimizable:true,
			maximizable:true,
			collapsible:true,
			layout:'fit',
			tbar:['-',{
				xtype:'combo_periodos',
				id:'cmbperiodo',
				emptyText:'Escolha um período',
				displayField:'desperiodo',
				valueField:'idperiodo',
				typeAhead:true,
				triggerAction: 'all',
				lazyRender: true,
				name:'idperiodo',
				mode:'local',
				allowBlank:false
			},'-',{
				xtype:'datefield',
				id:'iddata',
				emptyText:'Data',
				value:dataHoje,
				allowBlank:false
			},'-',{
				text:'Pesquisar',
				iconCls:'ico_search',
				handler:function(record){
					if(Ext.getCmp('cmbperiodo').isValid() && Ext.getCmp('iddata').isValid()){
						store.reload({
							params:{
								idperiodo:Ext.getCmp('cmbperiodo').getValue(),
								data:Ext.getCmp('iddata').getValue().format('Y-m-d')
							}
						});						
					}else{
						console.log('false');
					}					
				}
			},'-',],
			items:[{
				xtype:'editorgrid',
				id:'idgridavaliacaoinstrutor',
				bodyStyle:'overflow-x:hidden',
				store:store,
				width: 600,
				height: 300,
				loadMask:true,
				stripeRows:true,
				plugins: expander,
				animCollapse: false,
				sm: new Ext.grid.RowSelectionModel({
					singleSelect: true,
				}),
				viewConfig:{
					forceFit:true,
					getRowClass:function(record){
						console.log(record);
						var _class = record.get('nm_sala');
						if (_class!=""){
							return 'red';
						}/*else{
						 return 'black';
						}*/
					}
				},
				cm: new Ext.grid.ColumnModel({
					defaults: {
						sortable: true
					},
					columns:[expander,{
						header: "Treinamento",
						width:80,
						dataIndex: 'nm_treinamento',
						renderer:fncolor/*function(value, metaData, record){
							if(record.data.comentario != ""){
								metaData.attr="style='background-color:#D5DBE0;'";								
							}
							return value;
							//console.log(value, metaData, record);
							
								
							
						}*/
					}/*,{
						header: "Data de Cadastro", 
						xtype:'datecolumn',
						format:'d/m/y H:i',
						width:20,
						dataIndex: 'dtcadastramento'
					},{
						header: "Inicio", 
						xtype:'datecolumn',
						format:'d/m/y H:i',
						width:20,
						dataIndex: 'data_inicio',
						renderer:fncolor
					},{
						header: "Término", 
						xtype:'datecolumn',
						format:'d/m/y H:i',
						width:20,
						dataIndex: 'data_termino',
					}*/,{
						header: "Sala", 
						dataIndex: 'nm_sala',
						width:30,
						renderer:fncolor
					},{
						header: "Instrutor", 
						width:60,
						dataIndex: 'nminstrutor',
						renderer:fncolor
					}]
				}),
			}],
		}).show();	
	}		
</script>