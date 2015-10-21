if(Ext.getCmp('winrelatoriohoraslaunos')){
	Ext.getCmp('winrelatoriohoraslaunos').show();
}else{
	Ext.chart.Chart.CHART_URL = '/simpacweb/extjs/ext-3.3.1/resources/charts.swf';
	
	data = new Date();
	
	var storerelatorioHorasAlunosChart = new Ext.data.JsonStore({
		url:'/simpacweb/modulos/financeiro/relatorios/relatorioHorasAlunos/json/relatorioHorasAlunos-byano_chart_get.php',
		root:'myData',
		fields:[{name:'dtperiodo_data',type:'string'},
				{name:'nrquantidade_alun',type:'int'},
				{name:'nrtempo',type:'float'}],
		//autoLoad:true
	});
	
	
	var storerelatorioHorasAlunos = new Ext.data.GroupingStore({
		url:'/simpacweb/modulos/financeiro/relatorios/relatorioHorasAlunos/json/relatorioHorasAlunos-byano_get.php',													   
		reader: new Ext.data.JsonReader({	
			root:'myData',
			fields:[{name:'ano', type:'int'},
					{name:'MES1', type:'string'},
					{name:'MES2', type:'string'},
					{name:'MES3', type:'string'},
					{name:'MES4', type:'string'},
					{name:'MES5', type:'string'},
					{name:'MES6', type:'string'},
					{name:'MES7', type:'string'},
					{name:'MES8', type:'string'},
					{name:'MES9', type:'string'},
					{name:'MES10', type:'string'},
					{name:'MES11', type:'string'},
					{name:'MES12', type:'string'},
					{name:'IDENT', type:'string'}],
		}),
		sortInfo: {field: 'IDENT',direction: "ASC"},			
		groupField: 'ano',
	});
	
	function emptyValue(value){
		if(value == null || value == 0 || value == '0,00' || value == '' ){
			return 'N/A';
		}		
		return value;
	}
	
	function hoursToHrsMinSec(horas){
		var seconds = horas * 3600;
		var hours = seconds/3600;
		var minutos = (seconds - (3600*parseInt(hours)))/60;
		var segundos = (seconds - (3600*parseInt(hours)) - (minutos*60));
		
		return parseInt(hours)+' horas, '+parseInt(minutos)+' minutos e '+parseInt(segundos)+' segundos';
	}
	
	
////////////////////////////////////////CHART(SOUTH)///////////////////////////////////////////////////////////////////////////////////////////////////////////			
	var chartRelatorioHoras = new Ext.Panel({
		id:'idpanelchartrelatorio',
		region: 'south',
		//collapsible: true,
		split:true,
		collapsed:true,
		collapseMode:'mini',
		margins:'2 2 2 2',
		width:'99%',
		height:466,
		layout:'fit',
		frame:true,
		border:false,
		
		tbar:[{
			iconCls:'ico_down',
			tooltip:'Vizualizar a grid...',
			handler:function(){
				Ext.getCmp('idpanelchartrelatorio').collapse();
			}
		},'-','->','-',{
			text:'Pesquisar',
			iconCls:'ico_search',
			tooltip:'Pesquisar por um outro ano...',
			handler:function(){
				Ext.getCmp('idpanelchartrelatorio').collapse(),
				Ext.getCmp('idpanelmenusearch').expand()
			}
		},'-'],
		items: [{
			xtype: 'columnchart',
			store: storerelatorioHorasAlunosChart,
			url:'/simpacweb/extjs/ext-3.3.1/resources/charts.swf',
			xField: 'dtperiodo_data',
			yAxis: new Ext.chart.NumericAxis({
				displayName: 'Horas',
				labelRenderer : Ext.util.Format.numberRenderer('0,0')
			}),
			tipRenderer : function(chart, record, index, series){
				if(series.yField == 'nrquantidade_alun'){
					return record.data.nrquantidade_alun + ' Alunos em ' + record.data.dtperiodo_data;
				}else{
					
					return hoursToHrsMinSec(record.data.nrtempo) + ' em ' + record.data.dtperiodo_data;
				}
			},
			chartStyle: {
				padding: 10,
				animationEnabled: true,
				font: {
					name: 'Tahoma',
					color: 0x444444,
					size: 11
				},
				dataTip: {
					padding: 5,
					border: {
						color: 0x99bbe8,
						size:1
					},
					background: {
						color: 0xDAE7F6,
						alpha: .9
					},
					font: {
						name: 'Tahoma',
						color: 0x15428B,
						size: 10,
						bold: true
					}
				},
				xAxis: {
					color: 0x69aBc8,
					majorTicks: {color: 0x69aBc8, length: 4},
					minorTicks: {color: 0x69aBc8, length: 2},
					majorGridLines: {size: 1, color: 0xeeeeee}
				},
				yAxis: {
					color: 0x69aBc8,
					majorTicks: {color: 0x69aBc8, length: 4},
					minorTicks: {color: 0x69aBc8, length: 2},
					majorGridLines: {size: 1, color: 0xdfe8f6}
				}
			},
			series: [{
				type: 'column',
				displayName: 'Horas',
				yField: 'nrtempo',
				style: {
					image:'/simpacweb/extjs/ext-3.3.1/examples/chart/bar.gif',
					mode: 'stretch',
					color:0x99BBE8
				}
			},{
				type:'line',
				displayName: 'Quantidade Alunos',
				yField: 'nrquantidade_alun',
				style: {
					color: 0xCD2042
				}
			}]
		}]
	});
////////////////////////////////////////MENU SEARCH(WEST)///////////////////////////////////////////////////////////////////////////////////////////////////////////		
	var menuSearch = new Ext.Panel({
		id:'idpanelmenusearch',
		region: 'west',
		//collapsible: true,
		split:true,
		collapseMode:'mini',
		margins:'2 2 2 2',
		width:'99%',
		layout:'fit',
		border:false,
		items:[{
			xtype:'form',
			border:false,
			width:'100%',
			bodyStyle:'margin:10px;',
			items:[{
				xtype:'fieldset',
				title:'Filtro de Pesquisa',
				iconCls:'ico_search',
				autoHeight:true,
				collapsed:false,
				width:462,
				height:'100%',
				buttonAlign:'center',
				labelWidth:100,		
				html:"<style type='text/css'>"+
					"#idcomboano{"+
					"	margin-left: 109px;"+
					"	margin-bottom: 17px;"+
					"}"+
					"#idcomboano select {"+
					"	-webkit-appearance: button;"+
					"	-webkit-border-radius: 2px;"+
					"	-webkit-box-shadow: 11px 12px 14px rgba(38, 24, -120, 0.1);"+
					"	-webkit-padding-end: 20px;"+
					"	-webkit-padding-start: 2px;"+
					"	-webkit-user-select: none;"+
					"	height:40px;"+
					"	width:150px;"+
					"	background-image: url(../images/select-arrow.png), "+
					"	-webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);"+
					"	background-position: center right;"+
					"	background-repeat: no-repeat;"+
					"	border: 1px solid #AAA;"+
					"	color: #555;"+
					"	font-size: inherit;"+
					"	margin: 0;"+
					"	overflow: hidden;"+
					"	padding-top: 2px;"+
					"	padding-bottom: 2px;"+
					"	text-overflow: ellipsis;"+
					"	white-space: nowrap;"+
					"	text-align:center;"+
					"	font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"+
					"	font-size:14px;"+
					"	text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);"+
					"	font-weight:bold;"+
					"}"+
					"#idcomboano{"+
					"	font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"+
					"	font-size:24px;"+
						"font-weight:bold;"+
						"text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);"+
					"}"+
					"#combodrop{"+
					"	color:red;"+
					"}"+
				"</style>"+
				"<div id='idcomboano'>Ano :"+ 
						"<select id='selectano' class='span2' name='ano'>"+
							"<option value=''>Selecione um ano... v</option>"+
						"</select>"+
					  "</div>",
				listeners:{
					'afterrender':function(){
						$(function(){
							for(var ano = data.getFullYear();ano >= 1999; ano--){	   
								var combo = document.getElementById("selectano");
								var option = document.createElement("option");
								option.text = ano;
								option.value = ano;
							
								try{
									combo.add(option, null); // DEMAIS BROWSERS
								}catch(error){
									combo.add(option); // IE
								}	
							}	
						});
					}
				},
				buttons:[{
					text:'Pesquisar',
					scale:'large',
					iconCls:'ico_search',
					handler:function(){
						mainWinPos = Ext.getCmp('winrelatoriohoraslaunos').getPosition();
						
						Ext.getCmp('winrelatoriohoraslaunos').setSize(1010,500),
						Ext.getCmp('winrelatoriohoraslaunos').setPosition(mainWinPos[0]-255,mainWinPos[1]-120),
						Ext.getCmp('idpanelmenusearch').collapse(),
						
						$(function(){
							anovalue = $('#selectano').val();
						});
						
						//console.log('alert1',anovalue);
						Ext.getCmp('idgridRelatorioHoras').getStore().reload({
							params:{
								ano:anovalue
							},
							callback:function(){
								storerelatorioHorasAlunosChart.reload({
									params:{
										ano:anovalue
									}
								})
							}
						})
					}
				}]
			}]
		}],
		listeners:{
			'expand':function(){
				Ext.getCmp('winrelatoriohoraslaunos').setPosition(mainWinPos[0],mainWinPos[1]),
				Ext.getCmp('winrelatoriohoraslaunos').setSize(500,200),
				Ext.getCmp('winrelatoriohoraslaunos').setTitle('Relatório de horas utilizadas pelos Alunos')
			},
			'collapse':function(){
				Ext.getCmp('winrelatoriohoraslaunos').setSize(1010,500),
				Ext.getCmp('winrelatoriohoraslaunos').setPosition(mainWinPos[0]-255,mainWinPos[1]-120),
				Ext.getCmp('idpanelmenusearch').collapse()
			}
		}
	})
/////////////////////////////////////GRID VALORES PAGOS(CENTER)//////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	var gridRelatorioHoras = new Ext.Panel({
		id:'idpanelgridRelatorioHoras',
		region: 'center',
		margins:'2 2 2 0',
		layout:'fit',
		bbar:[{
			iconCls:'ico_Forward',
			id:'btnforward',
			tooltip:"Voltar para menu de pesquisa",
			handler:function(){
				Ext.getCmp('idpanelmenusearch').expand(),
				Ext.getCmp('winrelatoriohoraslaunos').setTitle('Relatório de horas utilizadas pelos Alunos')
			}
		},'-','->','-',{
			xtype: "export",
			target: 'idgridRelatorioHoras',
		},'-',{
			text:'Desagrupar',
			id:'btngroupreprovados',
			iconCls: 'ico_arrow_out',
			enableToggle:true,
			toggleHandler: function(button,state){
				if (state == true) {
					storerelatorioHorasAlunos.clearGrouping();
					Ext.getCmp('btngroupreprovados').setText('Agrupar');	
					Ext.getCmp('btngroupreprovados').setIconClass('ico_arrow_in');	
				} else {
					storerelatorioHorasAlunos.groupBy('ano');
					Ext.getCmp('btngroupreprovados').setText('Desagrupar');	
					Ext.getCmp('btngroupreprovados').setIconClass('ico_arrow_out');	
				}
			}
		},'-',{
			text:'Gráfico',
			iconCls:'ico_chart_bar',
			handler:function(){
				if(anovalue != "" && anovalue != null){
					setTimeout(
						function(){
							Ext.getCmp('idpanelchartrelatorio').expand()
						},250
					)
				}else{
					Ext.MessageBox.warning('Aviso!','Deve-se especificar o ano para vizualizar o gráfico.',
						function(btn){
							if(btn == 'ok'){
								$('#btnforward').click();
							}
						}
					);
					
				}
			}
		}],
		items:[{
			xtype:'grid',
			id:'idgridRelatorioHoras',
			store:storerelatorioHorasAlunos,
			autoScroll:true,
			height:400,
			loadMask:true,
			stripeRows:true,
			border:false,
			anchor:'100%',
			viewConfig:{
				forceFit:true,
			},
			sm: new Ext.grid.RowSelectionModel({
				singleSelect:true,
			}),					
			cm: new Ext.grid.ColumnModel({
				columns:
				[{header: 'Ano', dataIndex:'ano',hidden:true},
				{header: 'Tipo', width: 82, dataIndex: 'IDENT'},
				{header: 'Janeiro', width: 73, dataIndex:'MES1',renderer:emptyValue},
				{header: 'Fevereiro', width: 73, dataIndex:'MES2',renderer:emptyValue},
				{header: 'Março', width: 73, dataIndex:'MES3',renderer:emptyValue},
				{header: 'Abril', width: 73, dataIndex:'MES4',renderer:emptyValue},
				{header: 'Maio', width: 73, dataIndex:'MES5',renderer:emptyValue},
				{header: 'Junho', width: 73, dataIndex:'MES6',renderer:emptyValue},
				{header: 'Julho', width: 73, dataIndex:'MES7',renderer:emptyValue},
				{header: 'Agosto', width: 73, dataIndex:'MES8',renderer:emptyValue},
				{header: 'Setembro', width: 73, dataIndex:'MES9',renderer:emptyValue},
				{header: 'Outubro', width: 73, dataIndex:'MES10',renderer:emptyValue},
				{header: 'Novembro', width: 73, dataIndex:'MES11',renderer:emptyValue},
				{header: 'Dezembro', width: 73, dataIndex:'MES12',renderer:emptyValue}]
			}),
			height:Page.height-260,	
			view: new Ext.grid.GroupingView({
				id:'groupalunosaprovados',
				forceFit:true,
				showGroupName: true,
				enableNoGroups: true,
				enableGroupingMenu: false,
				//hideGroupedColumn: true,
				startCollapsed: false,
				//groupTextTpl: '{text}({[values.rs.length]} {[values.rs.length > 1 ? "Tipos" : "Tipos"]})'
			}),
		}]
	})
/////////////////////////////////////MAIN WINDOW//////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	var winMain = new Ext.Window({
		title:'Relatório de horas utilizadas pelos Alunos',
		id:'winrelatoriohoraslaunos',
		height:210,
		width:500,
		resizable:false,
		minimizable:true,	
		minWidth:200,
		minHeight:100,
		modal:true,
		border:false,
		collapsible:true,
		layout:'border',
		iconCls:'ico_money',
		items:[menuSearch, gridRelatorioHoras,chartRelatorioHoras]
	}).show();
}