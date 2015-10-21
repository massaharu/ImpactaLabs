<? require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
# @AUTOR = massaharu #//////////////////////////////////////////////////////////////////////////////////////////////
lockpage();
//////////////////////////////////////////////////////////////////////////////////////////////
$idpedido = post('idpedido');
if($idpedido == ''){$idpedido = 0;}

//////////////////////////////////////////////////////////////////////////////////////////////
$r1 = Sql::select('Saturn','Simpac','sp_OrcamentoAtend_e_Cliente '.($idpedido-15000));


//////////////////////////////////////////////////////////////////////////////////////////////
if($idpedido == 0 || ! is_numeric($idpedido)){
?>
	<script type="text/javascript">
        Ext.MessageBox.alert("SimpacWeb","ID do or&ccedil;amento inv&aacute;lido!", function(){ window.location.href = '/simpacweb/index.php'; });
    </script>
<?
	exit();	
}
?>
<style type="text/css">
	#div_ajax_status_orcamento > #content_aba_1 table{
		margin:auto;
		margin-top:5%;
		margin-bottom:5%;
		box-shadow: 5px 9px 32px 2px rgb(187, 187, 187);
	}
	#div_ajax_status_orcamento > #content_aba_1 table th{
		border: 3px dashed #FFFFFF;
		height:35px;
		background:rgb(209, 225, 238);
	}
	#div_ajax_status_orcamento > #content_aba_1 table td{
		border: 3px dashed #FFFFFF;
		height:35px;
		background: rgb(232, 243, 252);
	}
	#div_ajax_status_orcamento > #content_aba_1 table th:hover,
	#div_ajax_status_orcamento > #content_aba_1 table td:hover{
		background:#FEFEFE;
		border:3px solid #FFFFFF;
	}
</style>
<script type="text/javascript">
//////////////GLOBAL VARIABLES ////////////////////////////////////////
	var $orcamento_recepcao = false;
	var $orcamento_aceito = false;
	var $orcamento_baixa = false;
	var $recepcao_usuario = "";
	var $recepcao_idusuario = "";
	var $recepcao_computador = "";
	var $recepcao_cadastro = "";		
	var $orcamento_aceito_data = "";
	var $NrCPF = "";
	var $mask;
////////////// GENERAL FUNCTIONS /////////////////////////////////////////
	function fn_getDateString(data){
			
		var dataRetorno;
		
		if(data.getDate() < 10){
			dataRetorno = "0"+data.getDate()+"/".toString();
		}else{			
			dataRetorno = data.getDate()+"/".toString();
		}
		
		if(data.getMonth() < 10){
			dataRetorno+= "0"+(data.getMonth()+1)+"/".toString();
		}else{
			dataRetorno+= (data.getMonth()+1)+"/".toString();
		}
		
		dataRetorno+= data.getFullYear()+" ";
		
		if(data.getHours() < 10){
			dataRetorno+= "0"+(data.getHours())+":".toString();
		}else{
			dataRetorno+= (data.getHours())+":".toString();
		}
		
		if(data.getMinutes() < 10){
			dataRetorno+= "0"+(data.getMinutes())+":".toString();
		}else{
			dataRetorno+= (data.getMinutes())+":".toString();
		}
		
		if(data.getSeconds() < 10){
			dataRetorno+= "0"+(data.getSeconds()).toString();
		}else{
			dataRetorno+= (data.getSeconds()).toString();
		}
		
		return dataRetorno;
	}
	


	function fn_checked($x, $inverter, $click){
		
		$inverter = typeof $inverter !== 'undefined' ? $inverter : false;
  		$click = typeof $click !== 'undefined' ? $click : false;
		
		if($click)
			$click = 'checked';
	
		if(!$inverter){
			if($x == 1 || $x == true){				
				return '<img style="float:left; margin-right:3px;" class="'+$click+'" src="/simpacweb/images/ico/16/tick.png" width="16" height="16" />';				
			}else{				
				return '<img style="float:left; margin-right:3px;" class="'+$click+'" src="/simpacweb/images/ico/16/cross.png" width="16" height="16" />';				
			}
		}else{			
			if($x == 0 || $x == false){				
				return '<img style="float:left; margin-right:3px;" class="'+$checkedCls+'" src="/simpacweb/images/ico/16/tick.png" width="16" height="16" />';
				
			}else{				
				return '<img style="float:left; margin-right:3px;" class="'+$checkedCls+'" src="/simpacweb/images/ico/16/cross.png" width="16" height="16" />';				
			}
		}
	}
	
	function fn_maskCPF(cpf){
		return cpf.substring(0, 3)+'.'+cpf.substring(3, 6)+'.'+cpf.substring(6, 9)+'-'+cpf.substring(9);
	}
	
	function fn_hide_tr($tr_id){
		$($tr_id).parent().hide();
	}
								
////////////// JSONs /////////////////////////////////////////	
	var storeOrcamentoAtend_cliente_list = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/orcamentoAtend_cliente_list.php',
		root: 'myData',
		fields: [
		   {name: 'idpedido', 	type:'int'},
		   {name: 'idcontato',  type:'int'},
		   {name: 'idusuario',	type:'int'},
		   {name: 'idvendedor', type:'int'},
		   {name: 'nrramal', 	type:'int'},
		   {name: 'nome'},
		   {name: 'email'},
		   {name: 'nmCompleto'},
		   {name: 'cdemail'},
		   {name: 'cdemail2'},
		   {name: 'nmCompleto2'},
		   {name: 'dtcadastro', type:'date', dateFormat:'timestamp'}
		]
	});
		
	var storeContato_get = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/contato_get.php',
		root:'myData',
		fields:[
			 {name: 'IdContato', type:'int'}, 
			 {name: 'NmContato'}, 
			 {name: 'NrTelefone'}, 
			 {name: 'DesEnderecoComplemento'}, 
			 {name: 'NrCEP'}, 
			 {name: 'DtCadastramento', type:'date', dateFormat:'timestamp'}, 
			 {name: 'CdEMail'}, 
			 {name: 'DtNascimento', type:'date', dateFormat:'timestamp'}, 
			 {name: 'NrCPF'}, 
			 {name: 'NrRG'}, 
			 {name: 'NrTelefoneResidencial'}, 
			 {name: 'NrCelular'},
			 {name: 'DesSexo'},
			 {name: 'NumeroEndereco'},
			 {name: 'DesEndereco'},
			 {name: 'DesEnderecoComplemento'},
			 {name: 'DesBairro'},
			 {name: 'DesCidade'},
			 {name: 'SgEstado'},
			 {name: 'Endereco'},
			 {name: 'Complemento'},
			 {name: 'TipoEndereco'},
			 {name: 'InResidencial', type:'bit'}
		]
	});
	
	var storePedidoAceitoRecepcao = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/pedidoaceitorecepcao_get.php',
		root:'myData',
		fields:[
			{name:'idpedidorecepcao', type:'int'},
			{name:'idpedido', type:'int'},
			{name:'IdUsuario', type:'int'},
			{name:'NmLogin'},
			{name:'descomputador'},
			{name:'dtcadastro', type:'date', dateFormat:'timestamp'}
		]
	});
	
	var storeOrcamentosAceitos_get = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/orcamentosAceitos_get.php',
		root:'myData',
		fields:[
			{name:'baixarobo', type:'bit'},
			{name:'cod_cli', type:'int'},
			{name:'nome_cli'},
			{name:'cpf_cli'},
			{name:'dtcadastro', type:'date', dateFormat:'timestamp'}
		]
	});
	
	var storeOrcamentoTreinamentos_list = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/20.Orcamento/json/orcamentoTreinamentos_list.php',
		root:'myData',
		fields:[
			{name:'nrtreinamentos', type:'int'},
			{name:'matricula'}
		]
	});
	
	
////////////////// STORES BEING CALLED //////////////////////////	
	//DADOS DO ORÇAMENTO (MATRICULAS)
	storeOrcamentoTreinamentos_list.reload({
		params:{
			idpedido:<?=$idpedido?>
		},
		callback:function(){
			var $count = this.getCount();
			
			//Se tiver matrícula
			if($count){
				
				$('#linkpermissaomatricula').html('');
				
				$.each(this.data.items, function(){
					
					var $LinkPermissaoMatricula = LinkPermissao.matricula.apply({
						matricula:this.get('matricula')
					});					
					
					var $html = "";
					var $txt_nrtreinamentos = "";
					var $nrtreinamentos = this.get('nrtreinamentos');
					
					$txt_nrtreinamentos = ($nrtreinamentos > 1)? $nrtreinamentos+' (Treinamentos)' : ($nrtreinamentos == 0)? $nrtreinamentos+' (Nenhum treinamento)' : $nrtreinamentos+' (Treinamento)';
 					$html = ('<div>'+$LinkPermissaoMatricula+' '+$txt_nrtreinamentos+'</div>');
					
					$('#linkpermissaomatricula').append($html);
				});
				
			//Se NÃO tiver matrícula	
			}else{
				fn_hide_tr('#linkpermissaomatricula');	
			}
		}
	});
	
	//DADOS DO ORÇAMENTO
	storeOrcamentoAtend_cliente_list.reload({
		params:{
			idpedido:<?=$idpedido?>
		},
		callback:function(){
			$mask = new Ext.LoadMask(xt('orcamento_mainwindow').body,{msg:'Aguarde...'});
			$mask.show();
				
			var $storeOrcamentoAtend_cliente_list = storeOrcamentoAtend_cliente_list.getAt(0);
			
			///////////////////////////////////////////////////////////////////////
			var $LinkPermissaoContato = LinkPermissao.contato.apply({
				idcontato: $storeOrcamentoAtend_cliente_list.get('idcontato'),
				nmcontato: $storeOrcamentoAtend_cliente_list.get('nome')
			});	
			
			var $LinkPermissaoUsuario = LinkPermissao.usuario.apply({
				idusuario: $storeOrcamentoAtend_cliente_list.get('idusuario'),
				desusuario: $storeOrcamentoAtend_cliente_list.get('nmCompleto2')
			});	
			
			var $LinkPermissaoVendedor = LinkPermissao.usuario.apply({
				idusuario: $storeOrcamentoAtend_cliente_list.get('idvendedor'),
				desusuario: $storeOrcamentoAtend_cliente_list.get('nmCompleto')
			});	
			
			var $LinkPermissaoEmail = LinkPermissao.email.apply({
				email: $storeOrcamentoAtend_cliente_list.get('email')
			});
			///////////////////////////////////////////////////////////////////////
			
			$('#linkpermissaocontato').html($LinkPermissaoContato);
			$('#linkpermissaoemail').html($LinkPermissaoEmail);
			$('#dtorcamento').html(fn_getDateString($storeOrcamentoAtend_cliente_list.get('dtcadastro')));
			$('#linkpermissaousuario').html($LinkPermissaoUsuario);
			$('#linkpermissaovendedor').html($LinkPermissaoVendedor);
			
			
			storeContato_get.reload({
				params:{
					idcontato:$storeOrcamentoAtend_cliente_list.get('idcontato')
				},
				callback:function(){
					$storeContato_get = this.getAt(0);
					$NrCPF = $.trim($storeContato_get.get('NrCPF'));
					
					$('#nrcpf').html(fn_maskCPF($NrCPF));
					
					storeOrcamentosAceitos_get.reload({
						params:{
							idpedido:<?=$idpedido?>
						},
						callback:function(){
							$storeOrcamentosAceitos_get = this.getAt(0);
							$count = this.getCount();
							
							//Se o orçamento NÃO foi aceito
							if(!$count > 0){
								storePedidoAceitoRecepcao.reload({
									params:{
										idpedido:<?=$idpedido?>
									},
									callback:function(a, b, c){
										$count = this.getCount();
										
										if($NrCPF == ""){
											$('#nrcpf').html("N/A");
										}
										
										//Se o orçamento foi aceito pela RECEPÇÃO
										if($count > 0){
											
											$storePedidoAceitoRecepcao = this.getAt(0);
											$orcamento_recepcao  = true;
											$recepcao_usuario	 = $storePedidoAceitoRecepcao.get('NmLogin');
											$recepcao_idusuario	 = $storePedidoAceitoRecepcao.get('IdUsuario');
											$recepcao_computador = $storePedidoAceitoRecepcao.get('descomputador');
											$recepcao_cadastro 	 = $storePedidoAceitoRecepcao.get('dtcadastro');
											
											var $LinkPermissaoUsuarioRecepcao = LinkPermissao.usuario.apply({
												idusuario: $recepcao_idusuario,
												desusuario: $recepcao_usuario
											});
											
											fn_hide_tr('#linkpermissaoaccount');
											
											$('#orcamentoaceitointernet').html(fn_checked($orcamento_aceito));
											$('#orcamentobaixarobo').html(fn_checked($orcamento_baixa));
											$('#orcamentorecepcao').html(fn_checked($orcamento_recepcao));											
											$('#orcamentorecepcaousuario').html($LinkPermissaoUsuarioRecepcao);
											$('#orcamentorecepcaocomputador').html($recepcao_computador);
											$('#orcamentorecepcaocadastro').html(fn_getDateString($recepcao_cadastro));
										
										//Se o orçamento NÃO foi aceito pela RECEPÇÃO	
										}else{
											
											$('#orcamentoaceitointernet').html(fn_checked($orcamento_aceito));
											$('#orcamentobaixarobo').html(fn_checked($orcamento_baixa));
											$('#orcamentorecepcao').html(fn_checked($orcamento_recepcao));
											
											fn_hide_tr('#linkpermissaoaccount');
											fn_hide_tr('#orcamentorecepcaousuario');
											fn_hide_tr('#orcamentorecepcaocomputador');
											fn_hide_tr('#orcamentorecepcaocadastro');
										}
										
										$mask.hide();
									}
								})
							//Se o orçamento FOI aceito
							}else{
								var $LinkPermissaoAccount = LinkPermissao.account.apply({
									cod_cli: $storeOrcamentosAceitos_get.get('cod_cli'),
									nome_cli: $storeOrcamentosAceitos_get.get('nome_cli')
								});		
								
								$orcamento_aceito = true;
								$orcamento_aceito_data = fn_getDateString($storeOrcamentosAceitos_get.get('dtcadastro'));
								
								$NrCPF = $.trim($storeContato_get.get('NrCPF'));
								
								if($NrCPF == ""){ 
									$NrCPF = $.trim($storeOrcamentosAceitos_get.get('cpf_cli'));
									$('#nrcpf').html(fn_maskCPF($NrCPF));
									
									if($NrCPF == ""){
										$('#nrcpf').html("N/A");
									}
								}
								
								if($storeOrcamentosAceitos_get.get('baixarobo')){
									$orcamento_baixa = true;
								}
								
								fn_hide_tr('#orcamentorecepcaousuario');
								fn_hide_tr('#orcamentorecepcaocomputador');
								fn_hide_tr('#orcamentorecepcaocadastro');
								fn_hide_tr('#linkpermissaoaccountnotfound');
								
								$('#orcamentoaceitointernet').html(fn_checked($orcamento_aceito)+' '+$orcamento_aceito_data);
								$('#orcamentobaixarobo').html(fn_checked($orcamento_baixa));
								$('#orcamentorecepcao').html(fn_checked($orcamento_recepcao));
								$('#linkpermissaoaccount').html($LinkPermissaoAccount);
								
								$mask.hide();
							}
						}
					});
				}
			});
		}
	});
</script>
<div id="div_ajax_status_orcamento" style="height:auto; overflow:auto;">
    <div id="content_aba_1">
      <table width="90%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th width="130" height="25" align="right" class="th">Contato:</th>
          <td id="linkpermissaocontato"></td>
        <tr>
           <th width="130" height="25" align="right" class="th">E-mail:</th>
           <td id="linkpermissaoemail"></td>
        </tr>
          <th height="25" align="right" class="th">CPF:</th>
          <td id="nrcpf"></td>
        </tr>
        <tr>
          <th height="25" align="right" class="th">Data do Orçamento:</th>
          <td id="dtorcamento"></td>
        </tr>
        <tr>
          <th height="25" align="right" class="th">Aceito (Internet):</th>
          <td id="orcamentoaceitointernet"></td>
        </tr>
        <tr>
          <th height="25" align="right" class="th">Baixa Robô:</th>
          <td id="orcamentobaixarobo"></td>
        </tr>
        <tr>
          <th height="25" align="right" class="th">Recepção:</th>
          <td id="orcamentorecepcao"></td>
        </tr>
        <tr>
            <th height="25" align="right" class="th">Usuário <br />(Recepção):</th>
            <td id="orcamentorecepcaousuario"></td>
        </tr>
        <tr>
            <th height="25" align="right" class="th">Computador <br />(Recepção):</th>
            <td id="orcamentorecepcaocomputador"></td>
        </tr>
        <tr>
            <th height="25" align="right" class="th">Cadastro <br />(Recepção):</th>
            <td id="orcamentorecepcaocadastro"></td>
        </tr>
        <tr>
          <th height="25" align="right" class="th">Usuário (logado):</th>
          <td id="linkpermissaousuario"></td>
        <tr>
          <th height="25" align="right" class="th">Vendedor:</th>
          <td id="linkpermissaovendedor"></td>
        </tr>
        <tr>
          <th height="25" align="right" class="th">Account:</th>
          <td id="linkpermissaoaccount"></td>
        </tr>
        <tr>
          <th height="25" align="right" class="th">Account:</th>
          <td id="linkpermissaoaccountnotfound">Não foi possível encontrar o account.</td>
        </tr>
        <tr>
          <th width="130" height="25" align="right" class="th" valign="top">Matricula:</th>
          <td id="linkpermissaomatricula"></td>
        </tr>
       </tr>                       
      </table>
   </div>
</div>
