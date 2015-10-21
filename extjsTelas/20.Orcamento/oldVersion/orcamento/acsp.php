<?php
$GLOBALS['menu'] = false; $GLOBALS['wallpaper'] = false; $GLOBALS['ext_theme'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
Ext.onReady(function() { 
		var win_acsp = new Ext.Window({
			title:"Pendencia",
			modal:true,
			border:false,
			plain:false,
			width:310,
			height:150,
			items:[{
				xtype:'form',
				bodyStyle: 'padding:10px;',
				height:80,
				labelWidth:60,
				border:false,
				items:[{
					xtype:'textfield',
					fieldLabel: 'CPF',
					width:200,
					id: 'busca_cpf'
				}/*,{
					xtype:'textfield',
					fieldLabel: 'Valor (R$)',
					width:190,
					id: 'busca_valor'
				}*/],
				buttons:[{
					text:'Verificar',
					handler: function(){
						Ext.getCmp("resposta").load({ url: '/simpacweb/json/pendencia.php',
							params:{cpf: Ext.getCmp("busca_cpf").getValue()/*, valor: Ext.getCmp("busca_valor").getValue()*/},
							method: 'GET',
							waitMsg: 'Carregando informa&#231;&#245;es...'
						});	
					}	
				}]
			},{
				id: 'resposta',
				html: 'resposta',
				height:80,
				border:false,
				autoScroll:true
			}]
		}).show();	
});
</script>