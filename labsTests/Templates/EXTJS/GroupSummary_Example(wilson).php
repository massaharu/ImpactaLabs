<?php
# @AUTOR = Wilson #
//$GLOBALS['JSON'] = true;
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
topoPagina('Chart.png','SCD - Avalia&ccedil;&otilde;es');
?>

<script type="text/javascript">
var itemsUsuario = [];

Ext.onReady(function () {

    $.getScript("/simpacweb/extjs/ext-3.3.1/examples/ux/GroupSummary.js", function () {
        <!----------------------------------------------------------- >
        var storeGrafico = new Ext.data.JsonStore({

            root: 'myChart',
            fields: [{
                name: 'resultado'
            }, {
                name: 'total',
                type: 'int'
            }, ],
            url: 'relatorioGrafico.php',
        });

        <!------------------Store Grid---------------------------- -->
        var storeBuscarResultado = new Ext.data.GroupingStore({
            reader: new Ext.data.JsonReader({
                root: 'myData',
                fields: [{name: 'nome',type: 'string'}, 
						 {name: 'data',type: 'date',format: 'Y-m-d'}, 
						 {name: 'solicitante',type: 'string'}, 
						 {name: 'chamado',type: 'string'}, 
						 {name: 'resultado',type: 'int'}],
            }),
            url: 'consultaData.php',
            autoLoad: false,
            sortInfo: {
                field: 'nome',
                direction: "ASC"
            },
            groupField: 'nome',
        });
		
		<!--------------- Store Radio Group Dinamico ----------------->
		
		var storeRadioGroup = new Ext.data.JsonStore({
			root:'myData',
			fields:[{
				name:'idusuario',
			},{
				name:'nmlogin',
			}],
			url:'ConsultaUsuario.php',
			
		}); 
		
		<!----------------------------------------------------------->
		
        var group = new Ext.ux.grid.GroupSummary({});

         new Ext.Panel({
     id: 'frmPanelAvaliacoes',
     renderTo: Ext.getBody(),
     tbar: [{
         xtype: 'tbtext',
         text: 'De:',
     }, {
         xtype: 'tbspacer',
         width: 10
     }, {
         xtype: 'datefield',
         id: 'dtinicio',
         format: 'd/m/Y',
         allowBlank: false,
         maxValue: new Date(),
         listeners: {
             select: function (a, b) {
                 xt('dttermino').setMinValue(b);
             }
         }
     }, {
         xtype: 'tbtext',
         text: 'At&eacute'
     }, {
         xtype: 'tbspacer',
         width: 10
     }, {
         xtype: 'datefield',
         id: 'dttermino',
         format: 'd/m/Y',
         maxValue: new Date(),
         allowBlank: false,
         listeners: {
             select: function (a, b) {
                 xt('dtinicio').setMaxValue(b);
             }
         }
     }, {
         xtype: 'tbspacer',
         width: 10
     }, '-',
     {
         xtype: 'button',
         text: 'Buscar',
         iconCls: 'ico_busca2',
         width: 60,
         height: 20,
         handler: function () {
             if (xt('dtinicio').isValid() && xt('dttermino').isValid()) {
                 xt('gridBuscarResultado').getStore().load({
                     params: {
                         dtinicio: xt('dtinicio').getValue().format('Y-m-d'),
                         dttermino: xt('dttermino').getValue().format('Y-m-d'),
                     },
                 });
             } else {
                 Ext.Msg.alert('Alerta', 'Preencha os Campos');
             }
         },

     }, '-',
     {
         xtype: 'tbspacer',
         width: 10,
     }, '-',
     {
         xtype: 'button',
         text: 'Relat&#243;rio',
         iconCls: 'ico_pie_chart_128',
         width: 60,
         height: 20,
         handler: function () {
             storeRadioGroup.load({
                 callback: function (record) {
                     $.each(record, function (a, b) {
                         itemsUsuario.push({
                             boxLabel: b.json.nmlogin,
                             inputValue: b.json.idusuario,
                             name: 'a',
                             id: b.json.id,
                             checked: a == 0 ? true : false,
                         });
                     });
                     // Colocar Janela
                     if (xt('frmRelatorioChamado')) {
                         xt('frmRelatorioChamado').show();
                     } else {
                         new Ext.Window({
                             id: 'frmRelatorioChamado',
                             title: 'Relatório de Chamados',
                             iconCls: 'ico_pie_chart_128',
                             width: 750,
                             height: 600,
                             resizable: false,
                             modal: true,
                             plain: true,
                             listeners: {
                                 'close': function () {
                                     storeGrafico.removeAll();
                                 }
                             },
                             layout: 'border',
                             items: [{
                                 title: 'Filtros',
                                 region: 'west',
                                 width: 230,
                                 split: true,
                                 items: [{
                                     xtype: 'form',
                                     border: false,
                                     padding: 10,
                                     id: 'frmBuscaRelatorio',
                                     labelWidth: 50,
                                     items: [{
                                         xtype: 'fieldset',
                                         title: 'Periodo',
                                         items: [{
                                             xtype: 'datefield',
                                             fieldLabel: 'Inicio',
                                             id: 'dtRelatorioInicio',
                                             format: 'd/m/Y',
                                             allowBlank: false,
                                             maxValue: new Date(),
                                             listeners: {
                                                 select: function (a, b) {
                                                     xt('dtRelatorioTermino').setMinValue(b);
                                                 } // Fim Function Select
                                             } // Fim Listeners
                                         }, {
                                             xtype: 'datefield',
                                             fieldLabel: 'Termino',
                                             id: 'dtRelatorioTermino',
                                             format: 'd/m/Y',
                                             maxValue: new Date(),
                                             allowBlank: false,
                                             listeners: {
                                                 select: function (a, b) {
                                                     xt('dtRelatorioInicio').setMaxValue(b);
                                                 } // Fim Function Select
                                             } // Fim Listeners
                                         }]
                                     }, {
                                         xtype: 'fieldset',
                                         title: 'Funcionarios',
										 autoHeight:true,
                                         items: [{
                                             xtype: 'radiogroup',
                                             id: 'rgIdFuncionarios',
                                             fieldLabel: 'Funcionarios',
                                             columns: 2,
                                             hideLabel: true,
                                             items: itemsUsuario,
                                             listeners: {
                                                 'change': function () {
                                                     storeGrafico.removeAll();
                                                 },

                                             } // Fim Listeners
                                         }],
                                         // Fim Items Fieldset Funcionarios
                                     }],
                                     // Items Form
                                     buttons: [{
                                         text: 'Consultar',
                                         iconCls: 'ico_busca2',
                                         width: 100,
                                         height: 30,
                                         handler: function () {
                                             if (xt('dtRelatorioInicio').isValid() && xt('dtRelatorioTermino').isValid()){
                                                 storeGrafico.load({
                                                     params: {
                                                         dtInicioRelatorio: xt('dtRelatorioInicio').getValue().format('Y-m-d'),
                                                         dtTerminoRelatorio: xt('dtRelatorioTermino').getValue().format('Y-m-d'),
                                                         vlrfuncionario: xt('rgIdFuncionarios').getValue(),
                                                     },
                                                 });
                                             } else {
												Ext.Msg.alert('Aviso','Preencha os Campos');	
											}
                                         } // Fim do Handler
                                     }, {
                                         text: 'Fechar',
                                         iconCls: 'ico_cancel',
                                         width: 100,
                                         height: 30,
                                         handler: function () {
                                             xt('frmRelatorioChamado').close();
                                         } // Fim Handler
                                     }],
                                     // Fim Buttons
                                 }],
                                 // Fim da Items Fieldset
                             }, {
                                 title: 'Gráfico',
                                 region: 'center',
                                 items: [{
                                     xtype: 'piechart',
                                     id: 'graficoChamado',
                                     dataField: 'total',
                                     categoryField: 'resultado',
                                     store: storeGrafico,
                                     url: '/simpacweb/extjs/ext-3.3.1/resources/charts.swf',
                                     extraStyle: {
                                         legend: {
                                             display: 'bottom',
                                             padding: 5,

                                             font: {
                                                 family: 'Arial',
                                                 size: 13,
                                             } // Fim da Font
                                         } // Fim da Legend
                                     } // Fim extraStyle
                                 }],
                                 // Fim Items Grafico
                             }],
                             // Fim da Items Window
                         }).show(); // Fim do Window
                     } // Fim do Else
                 },

             }) // Fim Store
         } // Fim do Handler
     }, '-', ],
     // Fim da Tbar
     items: [{
         xtype: 'grid',
         id: 'gridBuscarResultado',
         store: storeBuscarResultado,
         width: Page.width,
         height: Page.height * 0.77,
         plugins: group,
         view: new Ext.grid.GroupingView({
             forceFit: true,
             showGroupName: true,
             enableNoGroups: false,
             enableGroupingMenu: false,
             hideGroupedColumn: true,
             startCollapsed: true,
         }),
		 listeners:{
			'groupclick':function(grid,field,value,e){
			 console.log(grid,field,value,e);
			 }
		 },
         columns: [{
             id: 'nome',
             header: 'Nome',
             width: Page.width / 5,
             sortable: true,
             dataIndex: 'nome',
         }, {
             xtype: 'datecolumn',
             format: 'd/m/Y',
             id: 'data',
             header: 'Data',
             width: Page.width / 7,
             sortable: true,
             dataIndex: 'data',
             summaryType: 'count',
             summaryRenderer: function (v, params, data) {
                 return ((v === 0 || v > 1) ? '(' + v + ' Chamados)' : '(1 Chamado)');
             },
         }, {
             id: 'solicitante',
             header: 'Solicitante',
             width: Page.width / 7,
             sortable: true,
             dataIndex: 'solicitante',
         }, {
             id: 'chamado',
             header: 'Chamado',
             width: Page.width / 2.5,
             sortable: true,
             dataIndex: 'chamado',
         }, {
             id: 'resultado',
             header: 'Resultado',
             width: Page.width / 10,
             sortable: true,
             dataIndex: 'resultado',
             renderer: function (value) {
                 if (value == 10) {
                     return '<img src="/simpacweb/images/ico/16/avaliacao_10.png" />';

                 } else if (value == 5) {

                     return '<img src="/simpacweb/images/ico/16/avaliacao_5.png" />';

                 } else if (value == 0) {

                     return '<img src="/simpacweb/images/ico/16/avaliacao_0.png" />';
                 }
             },
         }],
         // Fim Columns Grid
     }],
     // Fim da Items Grid
 }).show(); // Fim do Panel
 });
 }) // Ext.onReady
</script>