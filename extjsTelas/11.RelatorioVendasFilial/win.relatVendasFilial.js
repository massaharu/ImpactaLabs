/*	@AUTOR = renan*/

var xt = Ext.getCmp;
var date = new Date();
date.setDate(1);
if(xt('win.relatVendasFilial_id'))
	xt('win.relatVendasFilial_id').show();
else{
	
	var storage = new Ext.data.JsonStore({
		root:'mydata',
		url:'/simpacweb/modulos/atendimento/relatorios/vendasfilial/json/getVendas.php',
		fields:[{name:'Matricula',	type:'String'},
				{name:'VlTotal',	type:'float'},
				{name:'DtCadastramento',	type:'date',	dateFormat:'d/m/Y H:i'},
				{name:'NmAluno',	type:'String'},
				{name:'DesPagto', type:'string'},
				{name:'DesTransacao', type:'string'},
				{name:'NrParcelas', type:'int'}],
		listeners:{
			'load':function(s){
				xt('vltotal_vendasfilial').setText('R$ ' + number_format(s.sum("VlTotal"),2,',','.'));
			}
		}
	});
	
	new Ext.Window({
	
		title:'Relatório Vendas Filial',
		width:1000,
		height:507,
		id:'win.relatvendasFilial_id',
		border:false,
		minimizable:true,
		maximizable:true,
		resizable:true,
		iconCls:'ico_book',
		layout:'fit',
		tbar:['De',{
			xtype:'datefield',
			id:'vendasFilial_inicio',
			width:100,
			minValue:date,
			listeners:{
				'select':function(a){
					xt('vendasFilial_final').setMinValue(a.getValue());
				}
			}
		},'Até',{
			xtype:'datefield',
			id:'vendasFilial_final',
			width:100,
			minValue:date,
			listeners:{
				'select':function(a){
					xt('vendasFilial_inicio').setMaxValue(a.getValue());
				}
			}
		},'Atendente: ',{
			xtype:'combo',
			id:'combo_filial',
			width:200,
			triggerAction:'all',
			mode:'local',
			allowBlank:false,
			displayField:'filialName',
			valueField:'idFilial',
			store: new Ext.data.JsonStore({
					root: 'ComboBox2',
					fields:[{name:'filialName', type:'String'},
							{name:'idFilial',	type:'int'}],
					data:{
						ComboBox2:[{idFilial: "1",filialName: 'ImpactaOnline'}
								  ,{idFilial: "2",filialName: 'ImpactaRecord'}]
						},
					}),	
		},{
			text:'Pesquisar',
			iconCls:'ico_search',
			handler:function(){
				if(xt('combo_filial').isValid()){
					storage.load({
						params:{
							idusuario: xt('combo_filial').getValue(),
							dt1:	xt('vendasFilial_inicio').getValue().format("Y-m-d"),
							dt2:	xt('vendasFilial_final').getValue().format("Y-m-d")
						}
					});
				}else{
					Ext.Msg.alert('Aviso',"Selecione algo na combo");
				}
			}
		
		}],
		bbar:['<span style="font-weight:bold">Valor Total</span>',{
			xtype:'tbtext',
			id:'vltotal_vendasfilial',
			text:'R$ 0,00'
		},'->',{
			text:'Exportar/Imprimir',
			iconCls:'',
			menu:[{
				text:'Imprimir',
				iconCls:'ico_imprimir',
				handler:function(){
					
						var id = 'grid_'+new Date().getTime();
						
						var toprinter = $('<div id="'+id+'" />');
						
						toprinter.append($('#grid_filialAluno .x-panel-body').clone());
						toprinter.append($('.x-window-bbar').clone());
						
						$('body').append(toprinter);
						
						printer(id);
						
						toprinter.remove();
				}
			},{
				text:'Gerar Planilha',
				iconCls:'ico_excel',
				handler:function(){
					exporter(xt('grid_filialAluno'));
				}
			}]
		}],
		items:[{
			xtype:'grid',
			id:'grid_filialAluno',
			border:false,
			height:343,
			stripeRows:true,
			loadMask:true,
			store:storage,
			viewConfig:{
				forceFit:true,
			},
			columns:[{header:'Aluno',	dataIndex:'NmAluno',width:190},
					 {header:'Data Vendido',	dataIndex:'DtCadastramento',	xtype:'datecolumn', format:"d/m/Y H:i", width:118},
					 {header:'Valor Total',	dataIndex:'VlTotal',	width:78,  renderer:Ext.util.Format.brMoney},
					 {header:'Matrícula',	dataIndex:'Matricula',	width:83},					 
					 {header:'Forma de Pagamento', dataIndex:'DesPagto', width:133},
					 {header:'Nº Parcelas', dataIndex:'NrParcelas', width:76},
					 {header:'Curso',dataIndex:'DesTransacao', width:285}]
		}],
	
	}).show();
}