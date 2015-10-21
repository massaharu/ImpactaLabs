<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>

<script type="text/javascript">
	Ext.onReady(function(){	
		new Ext.Window({
			title:'Alteração de curso',
			width:500,
			id:'winalterarcurso',
			height:150,
            items:[{   
            	xtype:'form',
                padding:10,
				id:'formalterarcurso',
                border:false,
				defaults:{
					anchor:'100%',
					hideLabel:true
				},
                items:[{
                	xtype:'combo_cursosativos',
					typeAhead: true,
					triggerAction: 'all',
					lazyRender:true,
					allowBlank:false,
					name:'idcurso',
					hiddenName:'idcurso'
               	}],
			}],
			buttons:[{
				text:'Salvar',
				iconCls:'ico_save',
				handler:function(){
					if(Ext.getCmp('formalterarcurso').getForm().isValid()){
						Ext.getCmp('formalterarcurso').getForm().submit({
							url:'test.php'
						})
					}
				}
			},{
				text:'Fechar',
				iconCls:'ico_fechar',
				handler:function(){
					Ext.getCmp('winalterarcurso').close();
				}
			}]			
		}).show();
	});
</script>



