<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
if (Ext.getCmp('firstExtWindow')){
	Ext.getCmp('firstExtWindow').show();
}else{
	
		var win = new Ext.Window({
			id:'winAssinPenden',
			height:150,
			width:300,
			modal:true,
			title:'',
			layout:'hbox',
			layoutConfig:{
				align:'middle'
			},
			defaults:{xtype:'button', margins:'10', height:30 },
			items:[{
				id:'assinado',
				iconCls:'ico_action_check',
				text:'Assinado',
				flex:1
				
			},{
				id:'pendente',
				text:'Pendente',
				iconCls:'ico_Abort',
				flex:1
			}],
			buttons:[{
				text:'Fechar',
				iconCls:'ico_fechar',
				handler:function(){
					win.close();
				}
			}]
		}).show();
	}
</script>
				
		
			
			
			