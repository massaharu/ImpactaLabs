<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
if(Ext.getCmp("win.instrutor.liberaravfinal")){
	Ext.getCmp('win.instrutor.liberaravfinal').show();
} else {
	
	var store = new Ext.data.JsonStore({
		url: '/simpacweb/labs/Massaharu/extjsTelas/02.Liberação de Avaliação Final/get_liberacao_de_avaliacao_final.php',
		root:'myData',
		fields: ['idcursoagendado','inpreenchido','descurso',{name:'dtinicio', type:'date', dateFormat:'timestamp'},
										   {name:'dttermino', type:'date', dateFormat:'timestamp'}]
	});
	new Ext.Window({
		id:'win.instrutor.liberaravfinal',
		title:'Liberação de Avaliação Final',
		width:540,
		height:300,
		modal:true,
		layout:'fit',
		tbar:['Escolha o Periodo:',{
			xtype:'datefield',
			fieldLabel:'De',
			id:'dateStart',
			format:'d/m/y',
			allowBlank:false
		},'A:',{
			xtype:'datefield',
			fieldLabel:'Até',
			id:'dateEnd',
			format:'d/m/y',
			allowBlank:false
		},{
			xtype:'button',
			iconCls:'ico_search',
			text:'Pesquisar',
			handler:function(){
				if(Ext.getCmp('dateStart').isValid() && Ext.getCmp('dateEnd').isValid()){
					store.reload({
						params:{
							idinstrutor:SimpacWeb.vars.instrutor,
							dt1:Ext.getCmp('dateStart').getValue().format('Y-m-d'),
							dt2:Ext.getCmp('dateEnd').getValue().format('Y-m-d'),
						}
					});
				}
			}
		}],
		bbar:[{
			text:'Liberar',
			id:'btnliberar',
			disabled:true,			
			iconCls:'ico_accept',
			handler:function(){
				Ext.Ajax.request({
				    url: '/simpacweb/labs/Massaharu/extjsTelas/02.Liberação de Avaliação Final/set_liberacao_de_avaliacao_final.php',
					success:function(){
						store.reload({
							params:{
								idinstrutor:SimpacWeb.vars.instrutor,
								dt1:Ext.getCmp('dateStart').getValue().format('Y-m-d'),
								dt2:Ext.getCmp('dateEnd').getValue().format('Y-m-d'),
							}
						});
					},
				   	params: { 
						idcursoagendado:Ext.getCmp('gridliberaravaliacao').getSelectionModel().getSelected().get('idcursoagendado')
					}
				});												
			}
		}],							
		items:[{
			xtype:'grid',
			store: store,
			id:'gridliberaravaliacao',
			loadMask:true,
			columns:[{
				header:'',
				width:30,
				dataIndex:'inpreenchido',
				renderer:function(v){				
				if(v == 1){
					return '<img src="/simpacweb/images/ico/16/accept.png"/>';
				  }
				else{
					return '<img src="/simpacweb/images/ico/16/remove.png"/>';
					}														  
				}					
			},{
				header:'Nome do Curso',
				width:250,			
				dataIndex:'descurso'
			},{
				xtype:'datecolumn',
				width:120,
				header:'Inicio',
				dataIndex:'dtinicio',
				format:'d/m/Y H:i:s'
			},{
				xtype:'datecolumn',
				width:120,
				header:'Termino',
				dataIndex:'dttermino',
				format: 'd/m/Y H:i:s'
			}],
			height:250,
			width:600,
			border:true,
			defaults:{
				anchor:'100%',				
			},
			listeners:{
				'rowclick':function(){
					if (this.getSelectionModel().getSelected().get('inpreenchido')==0){
						Ext.getCmp('btnliberar').disable();
					}else{
						Ext.getCmp('btnliberar').enable();
					}			
				}
			}					
		}],
		buttons:[{
			text:'Fechar',
			iconCls: 'ico_fechar',
			buttonAlign:'left',
			handler:function(){
				Ext.getCmp('win.instrutor.liberaravfinal').close();
			}					
		}],
	}).show();
}
</script>