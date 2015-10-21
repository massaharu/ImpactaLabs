<?php require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idpedido = post('idpedido');
?>
<style type="text/css">
	div.opcoes{
		height:25px;
		width:130px;
		margin-bottom:5px;
		margin-top:5px;
	}
	div.opcoes span,
	div.opcoes span a{
		display:block;
	}
	.mybtn {
		display: inline-block;
		padding: 4px 10px 4px;
		margin-bottom: 0;
		font-size: 13px;
		line-height: 18px;
		color: #333333;
		text-align: center;
		text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
		vertical-align: middle;
		cursor: pointer;
		background-color: #f5f5f5;
		background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
		background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6);
		background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
		background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
		background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
		background-image: linear-gradient(top, #ffffff, #e6e6e6);
		background-repeat: repeat-x;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#e6e6e6', GradientType=0);
		border-color: #e6e6e6 #e6e6e6 #bfbfbf;
		border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
		border: 1px solid #cccccc;
		-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
		-moz-box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
		box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
	}
</style>

<div class="opcoes mybtn">
	<?php echo linkpermissao('javascript:orcamento_executaRobo();', '', 'Executar Robô', '', '', 'arrow_refresh.png',false);?>
</div>
<div class="opcoes mybtn">
	<?php echo linkpermissao('javascript:orcamento_alterarVendedor();', '', 'Alterar Vendedor', '', '', 'usuario.png',false);?>
</div>

<script type="text/javascript">
	function orcamento_executaRobo()
	{
		
		Ext.MessageBox.confirm("", "Deseja realmente enviar o or\u00e7amento para ser processado pelo rob\u00f4\u003f OBS\u003a Esta a\u00e7\u00e3o pode gerar duplicidade\u002e", function(btn){
			
			if(btn == 'yes')
			{
				
				var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"Enviando solici\u00e7\u00e3o para o Rob\u00f4..."});
					myMask.show();
					
				var parametros = {idpedido:"<?=$idpedido;?>"};
				$.ajax({
				   type: "POST",
				   url: "/simpacweb/modulos/orcamento/orcamento_executar.php?code=true",
				   data: $.param(parametros),
				   success: function(msg){
					 myMask.hide();
					 Ext.MessageBox.alert("","A solicita\u00e7\u00e3o foi enviada com sucesso\u0021 Dentro de alguns instantes o or\u00e7amento ser\u00e1 processado\u0021");
				   }
				});
				
			}
			
		});
		
	}
	
	function orcamento_alterarVendedor(){
	
		var store_atendentes = new Ext.data.SimpleStore({
			fields: ['idusuario', 'desusuario'],
			data : Ext.simpacweb.atendentes
		});
		
		var win_alterarVendedor = new Ext.Window({
			title:'Alterar Vendedor',
			width:360,
			height:110,
			border:false,
			modal:true,
			frame:true,
			items:[{
				xtype:'form',
				padding:10,
				id:'win_alterarVendedor',
				labelWidth:60,
				items:[{
					xtype:'hidden',
					name:'idpedido',
					value:<?=$idpedido;?>
				},{
					xtype:'hidden',
					name:'idvendedor',
					id:'form_alterar_idvendedor'
				},{
					xtype:'combo',
					width:260,
					allowBlank:false,
					fieldLabel:'Atendente',
					id:'form_alterar_vendedor',
					store: store_atendentes,
					displayField:'desusuario',
					valueField:'idusuario',
					typeAhead: true,
					mode: 'local',
					forceSelection: true,
					emptyText:'Selecione o Atendentes...',
					selectOnFocus:true
				}]
			}],
			buttons:[{
				text:'Cancelar',
				handler:function(){
					win_alterarVendedor.close();
				}
			},{
				text:'Ok',
				handler:function(){
					if(Ext.getCmp('win_alterarVendedor').getForm().isValid()){
						
						//alert(Ext.getCmp('form_alterar_vendedor').getValue());
						
						Ext.getCmp('form_alterar_idvendedor').setValue(Ext.getCmp('form_alterar_vendedor').getValue());
						
						Ext.getCmp('win_alterarVendedor').getForm().submit({
							url:'ajax/setVendedor.php?code=true',
							success: function(response, opts){
								
								Ext.MessageBox.alert('','Vendedor alterado com sucesso!',function(){ win_alterarVendedor.close(); });
								
							}
						});
						
					}
				}
			}]
		});
		
		win_alterarVendedor.show();
		
	}
</script>