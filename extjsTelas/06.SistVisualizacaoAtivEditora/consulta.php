<?
# @AUTOR = bbarbosa #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
topoPagina('drawing_board.png','Consulta de Novos Treinamentos');
?>
<script type="text/javascript">
	Ext.onReady(function(){
		var store = new Ext.data.JsonStore({
			url: 'ajax/loadandamento.php',
			root: 'myData',
			fields: [{name:'id', type:'int'}, {name:'nmcurso', type:'string'}, {name:'inprioridade', type:'int'}, {name:'indivisao', type:'int'}, {name:'desdivisao', type:'string'}, {name:'dtprevisao', type:'date'}, {name:'dtcadastro', type:'date'}, {name:'nmusuario', type:'string'}, {name:'inposicao', type:'int'}, {name:'instatus', type:'int'}, {name:'desstatus', type:'string'}, {name:'dtfinalizado', type:'date'}, {name:'inrelatorio', type:'int'},, {name:'desdescricao', type:'string'}]
		
		});
		store.load();
		
		function fnprioridade(v){
			if(v == '1'){
				return '<img src="/simpacweb/images/ico/16/flag_blue.png" />'
			} else if (v == '2'){
				return '<img src="/simpacweb/images/ico/16/flag_red.png" />'
			}
			
		}
		
		function fn(v){
			if(v == '1'){
				return '<img src="/simpacweb/images/ico/16/clock_go.png" /> Em Andamento'
			} else if (v == '2'){
				return '<img src="/simpacweb/images/ico/16/accept.png" /> Concluido'
			}
			
		}
		function fncolor(value, metaData, record, rowIndex, colIndex, store){
			if(record.get('inrelatorio') == 0){
				return '<span style="color:#999999">'+value+'</span>'
			} else {
				return value
			}
		}
		
		var grid = new Ext.grid.GridPanel({
			store: store,
			border:false,
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true
			}),
			id:'grid',
			height:Page.height-150,
			loadMask:true,
			columns: [
				new Ext.grid.RowNumberer({width: 30}),
				{width: 200,id:'nmcurso',header: "Nome de Treinamento", sortable: true, dataIndex: 'nmcurso', renderer:fncolor},
				{id:'inprioridade',header: "Prioridade", sortable: true, dataIndex: 'inprioridade', renderer:fnprioridade},
				{id:'desstatus',header: "% Concluida", sortable: true, dataIndex: 'desstatus'},
				{id:'dtprevisao',header: "Previs&atilde;o para Conclus&atilde;o", sortable: true, dataIndex: 'dtprevisao', renderer: Ext.util.Format.dateRenderer('d/m/Y')},
				{id:'instatus',header: "Status", sortable: true, dataIndex: 'instatus', renderer:fn},
				{header: "Divis&atilde;o", sortable: true, dataIndex: 'desdivisao'}
			],
			viewConfig: {
				forceFit:true
			},
			stripeRows: true,
			autoScroll:true
		});
		
		var formPanel = new Ext.FormPanel({
			renderTo:'tela',
			title:'Lista de Treinamentos em desenvolvimento ou concluído',
			items:[grid]
		});
		
	});	
</script>
<div id="tela"></div>