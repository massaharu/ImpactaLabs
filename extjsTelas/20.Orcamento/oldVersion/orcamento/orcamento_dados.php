<?php 
$GLOBALS['menu'] = true; $GLOBALS['ext_theme'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//////////////////////////////////////////////////////////////////////////////////////////////
lockpage();
//////////////////////////////////////////////////////////////////////////////////////////////
$idpedido = get('idpedido');
if($idpedido == ''){$idpedido = 0;}
//////////////////////////////////////////////////////////////////////////////////////////////
$r1 = Sql::select('Saturn','Simpac','sp_OrcamentoAtend_e_Cliente '.($idpedido-15000));
//////////////////////////////////////////////////////////////////////////////////////////////
if($idpedido == 0 || ! is_numeric($idpedido)){
?>
<script>
Ext.onReady(function(){

	Ext.MessageBox.alert("SimpacWeb","ID do or&ccedil;amento inv&aacute;lido!", function(){ window.location.href = '/simpacweb/index.php'; });

});
</script>
<?php
exit();	
}
//////////////////////////////////////////////////////////////////////////////////////////////
$r_chequearetirar = Sql::select('Saturn','Simpac','exec sp_OrcamentoChequeARetirar '.($idpedido-15000));
//////////////////////////////////////////////////////////////////////////////////////////////
$r_opcoesdedata = Sql::select('Saturn','Simpac','exec sp_OrcamentoDataTreins '.($idpedido-15000));
//////////////////////////////////////////////////////////////////////////////////////////////
$lista9 = Sql::query('Saturn','Simpac',"sp_orcamentototaltreinamentos_list ".$idpedido);
//////////////////////////////////////////////////////////////////////////////////////////////
while($r9 = ors($lista9)){ 
	if($r9['nrtreinamentos'] > 1){ $nrtreinamentos = 's'; }
	
	$html_matriculas .= linkpermissao('modulos/matricula/matricula_dados.php', 'matricula='.$r9['matricula'], $r9['matricula'], '', '', 'matricula.png') . ' ( '.$r9['nrtreinamentos'].' treinamento'.$nrtreinamentos.' )<br/>';
}
//////////////////////////////////////////////////////////////////////////////////////////////
$r6 = Sql::select('Saturn','Atendimento',"sp_contato_get ".$r1['idcontato']);
$NrCPF = $r6['NrCPF'];
//////////////////////////////////////////////////////////////////////////////////////////////
$lista_aceito = Sql::arrays('Saturn','Orcamento',"sp_orcamentotosaceitos_get ".$idpedido);
$r7 = ors($lista_aceito);
//////////////////////////////////////////////////////////////////////////////////////////////
$orcamento_recepcao = false;
$orcamento_aceito 	= false;
$orcamento_baixa 	= false;
//////////////////////////////////////////////////////////////////////////////////////////////
if(count($lista_aceito) == 0)
{
	
	conecta('Saturn');
	
	$lista_matricularecepcao = Sql::arrays('Saturn','Simpac',"exec sp_matricularecepcao ".($idpedido-15000));
	
	if(count($lista_matricularecepcao) > 0)
	{
		$r10 = ors($lista_matricularecepcao);
		
		$orcamento_recepcao  = true;
		$recepcao_usuario	 = $r10['Usuario'];
		$recepcao_idusuario	 = $r10['IdUsuario'];
		$recepcao_computador = $r10['Computador'];
		$recepcao_cadastro 	 = $r10['dtCadastramento'];		
	}
	
	unset($lista_matricularecepcao);
}
else
{
	$orcamento_aceito = true;
	$orcamento_aceito_data = formatdatetime($r7['dtcadastro']);
	
	if(trim($NrCPF) == ''){ $NrCPF = $r7['cpf_cli']; }
	
	if($r7['baixarobo'] == 1)
	{
		$orcamento_baixa = true;
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<script>
Ext.onReady(function(){
	
	Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
	
	var matricula_dados = new Ext.Viewport({
    layout: "border",
	listeners: {
		'beforerender': function(){
			
			
			
		}
	},
	border:false,
    items: [{
        region: "center",
		border:false,
		autoScroll:true,
        items: [{
			heght:100,
			items:[{
			  layout : "column",
			  border:false,
			  items : [{
				  border:false,
				  columnWidth:.08,
				  html:'<img style="margin:5px;" src="/simpacweb/images/ico/72/orcamento.png" />'
			  },{
				border:false,
				columnWidth:.6,
				html:'<h1 class="topo_pagina">Or&ccedil;amento N&deg; <?php echo $idpedido;?></hi>'
			  },{
				  width : 'auto',
				  columnWidth:.3,
				  border:false,
				  items:[{
						xtype:'form',
						border:false,
						width:'auto',
						style:'margin-top:30px;',
						labelAlign:'right',
						items:[{
							xtype:'field',
							fieldLabel:'Or&ccedil;amento',
							id:'idpedido',
							width : 150,
							value:'<?php echo $idpedido;?>'	   
						}]
					}]
				 }]
			}],
			border:false
			},{
				border:false,
				items:[{
				  border:false,
				  xtype : "tabpanel",
				  items : [{
					  xtype : "panel",
					  title : "Or&ccedil;amento",
					  contentEl	: 'content_aba_1'
				  },{
					  xtype : "panel",
					  id:"id_painel_description",
					  title : "Descri&ccedil;&atilde;o do Servi&ccedil;o",
					  autoLoad:{url:'/simpacweb/modulos/orcamento/descricao_do_servico.php?code=true', params:'idpedido=<?php echo $idpedido;?>', scripts:true}
				  },{
					  xtype : "panel",
					  title : "Forma de Pagto.",
					  autoLoad:{url:'/simpacweb/modulos/orcamento/forma_de_pagto.php?code=true', params:'idpedido=<?php echo $idpedido;?>', scripts:true}
				  },<?php if($r_chequearetirar > 0){
					  	echo '{
					  xtype : "panel",
					  title : "Cheque &agrave; Retirar",
					  autoLoad:{url:"/simpacweb/modulos/orcamento/cheque_a_retirar.php?code=true", params:"idpedido='.$idpedido.'", scripts:true}
				  },';
					  }?>
					{
					  xtype : "panel",
					  disabled:<?php if($r_opcoesdedata == 0){echo 'true';}else{echo 'false';}?>,
					  title : "Op&ccedil;&otilde;es de Data",
					  autoLoad:{url:'/simpacweb/modulos/orcamento/opcoes_de_data.php?code=true', params:'idpedido=<?php echo $idpedido;?>', scripts:true}
				  },{
					  xtype : "panel",
					  title : "Hist&oacute;rico Atend.",
					  autoLoad:{url:'historico_atendimento.php?code=true', params:'idpedido=<?php echo $idpedido;?>&nrcpf=<?php echo $NrCPF;?>&idcontato=<?php echo $r1['idcontato'];?>&height='+(screen.height-pscreen(50,'h'))}
				  },{
					 xtype:'panel',
					 title:'Histórico Orçamento',
					 autoLoad:{url:'historico_orcamento.php?code=true', params:'idpedido=<?php echo $idpedido;?>', scripts:true}
				  }],
				  activeTab : 0
			  }]
			}]
		},
		{
			region: "north",
			border:false,
			style:'filter:alpha(opacity=50); -moz-opacity:.5; opacity:.5;',
			height: 25
		},
		{
			region: "west",
			title: "Op&ccedil;&otilde;es do Or&ccedil;amento",
			width: 200,
			split: true,
			collapseMode:'mini',
			collapsible: true,
			collapsed:true,
			titleCollapse: true,
			autoLoad:{url:'orcamento_dados_opcoes.php?code=true', params:{idpedido:'<?php echo $idpedido;?>'}, scripts:true},
			id:'region-options'
		}]
	});
	
	$(window).keyup(function(event){
		if (event.keyCode == 32){
			var w = Ext.getCmp('region-options');
            w.collapsed ? w.expand() : w.collapse();
		}
		return false;
	});
	
	$('#idpedido').keyup(function(event){
		if (event.keyCode == 13) {
			window.location.href = "?idpedido="+$('#idpedido').attr('value');
		}
	});
	
	$.post("/simpacweb/modulos/orcamento/historico.php?code=true", { idpedido: <?php echo $idpedido;?> });
	
});

function orcamento_executaRobo()
{
	
	Ext.MessageBox.confirm("", "Deseja realmente enviar o or\u00e7amento para ser processado pelo rob\u00f4\u003f OBS\u003a Esta a\u00e7\u00e3o pode gerar duplicidade\u002e", function(btn){
		
		if(btn == 'yes')
		{
			
			var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"Enviando solici\u00e7\u00e3o para o Rob\u00f4..."});
				myMask.show();
				
			var parametros = {idpedido:"<?php echo $idpedido;?>"};
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

function ajax_status_orcamento()
{
	
	if(!intervalOnline) clearInterval(setIntervalajax_status_orcamento);
	var parametros = {idpedido:<?php echo $idpedido;?>};
	$.ajax({
	   type: "POST",
	   url: "/simpacweb/modulos/orcamento/orcamento_dados_status.php?code=true",
	   data: $.param(parametros),
	   success: function(msg){
		 $("#div_ajax_status_orcamento").html(msg);
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
var setIntervalajax_status_orcamento;
$(document).ready(function(){

	ajax_status_orcamento();
	setIntervalajax_status_orcamento = setInterval("ajax_status_orcamento()",5000);

});


</script>

<div id="content_page"></div>
<div id="content_aba_1">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:10px; text-align:left;">
    <tr>
      <th width="130" height="25" align="right" class="th">Contato:</th>
      <td><?php echo linkpermissao('modulos/contato/contato_dados.php', 'idcontato='.$r1['idcontato'], $r1['nome'], '', '', 'contato.png');?></td>
    </tr>
    <tr>
      <th width="130" height="25" align="right" class="th">E-mail:</th>
      <td><?php echo linkpermissao('modulos/email/novo_email.php', 'to='.$r1['email'], $r1['email'], '', '', 'email.png');?></td>
    </tr>
    <tr>
      <th height="25" align="right" class="th">CPF:</th>
      <td><?php echo $NrCPF;?></td>
    </tr>
    <tr>
      <th height="25" align="right" class="th">Data do Or&ccedil;amento:</th>
      <td><?php echo formatdatetime($r1['dtcadastro']);?></td>
    </tr>
    <tr>
      <th height="25" align="right" class="th">Aceito (Internet):</th>
      <td><?php echo checked($orcamento_aceito).' '.$orcamento_aceito_data;?></td>
    </tr>
    <tr>
      <th height="25" align="right" class="th">Baixa Rob&ocirc;:</th>
      <td><?php echo checked($orcamento_baixa);?></td>
    </tr>
    <tr>
      <th height="25" align="right" class="th">Recep&ccedil;&atilde;o:</th>
      <td><?php echo checked($orcamento_recepcao);?></td>
    </tr>
    <?php if($orcamento_recepcao){ echo '<tr><th height="25" align="right" class="th">Usu&aacute;rio (Recep.):</th><td>'.linkpermissao('modulos/usuario/usuario_dados.php', 'idusuario='.$recepcao_idusuario, $recepcao_usuario, '', '', 'usuario.png').'</td></tr><tr><th height="25" align="right" class="th">Computador (Recep.):</th><td>'.utf8_encode($recepcao_computador).'</td></tr><tr><th height="25" align="right" class="th">Cadastro (Recep.):</th><td>'.formatdatetime($recepcao_cadastro).'</td></tr>';}?>
    <tr>
      <th height="25" align="right" class="th">Usu&aacute;rio (logado):</th>
      <td><?php echo linkpermissao('modulos/usuario/usuario_dados.php', 'idusuario='.$r1['idusuario'], $r1['nmCompleto2'], '', '', 'usuario.png');?></td>
    </tr>
    <tr>
      <th height="25" align="right" class="th">Vendedor:</th>
      <td><?php echo linkpermissao('modulos/usuario/usuario_dados.php', 'idusuario='.$r1['idvendedor'], $r1['nmCompleto'], '', '', 'usuario.png');?></td>
    </tr>
    <?php if($r7['cod_cli'] != ''){?>
    <tr>
      <th height="25" align="right" class="th">Account:</th>
      <td><?php echo linkpermissao('modulos/account/account_dados.php', 'cod_cli='.$r7['cod_cli'], $r7['nome_cli'], '', '', 'account.png');?></td>
    </tr>
    <?php }else{
		?>
	<tr>
      <th height="25" align="right" class="th">Account:</th>
      <td>N&atilde;o foi poss&iacute;vel encontrar o account.</td>
    </tr>
		<?php
		}
	if(trim($html_matriculas) != ''){?>
    <tr>
      <th width="130" height="25" align="right" class="th" valign="top">Matricula:</th>
      <td><?php echo $html_matriculas; ?>&nbsp;</td>
    </tr>
    <?php }?>
  </table>
  <hr style="margin:10px; width:auto;" color="#CCCCCC" noshade="noshade" size="1">
  <div id="div_ajax_status_orcamento" style="height:300px; overflow:auto;"></div>
</div>