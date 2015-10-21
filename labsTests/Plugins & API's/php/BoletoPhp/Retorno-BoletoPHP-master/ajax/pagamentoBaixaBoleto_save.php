<? 
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$baixadados = post('baixadados');

$baixadados = json_decode($baixadados);

$recibo = array();

foreach($baixadados as $key=>$value){
	$sessionid = $value->sessionid;
	$dtconfirmpagto = $value->dtconfirmpagto;
	$hrconfirmpagto = $value->hrconfirmpagto;
	
	$idrecibo = Sql::select('SATURN','Ecommerce',"select idrecibo from tb_LojaVirtualRecibo where sessionid = '".$sessionid."'");
	
	//Se o recibo não for encontrado, fazer a baixa
	if(!$idrecibo['idrecibo']){
		
		Sql::query('SATURN','Ecommerce',"UPDATE tb_pagamentoItau SET dtpagamento = '".$dtconfirmpagto.' '.$hrconfirmpagto."' WHERE sessionid = ".$sessionid);
		
		$pagamento = Sql::select('SATURN','Ecommerce',"SELECT nrparcelas, a.idformapagto, c.nome_cli, idstatus, vltotal, idpedido FROM tb_pagamento a inner join tb_formapagamento b ON a.idformapagto = b.idformapagto inner join impacta4.dbo.tb_ecommercecliente c ON a.cod_cli = c.cod_cli WHERE sessionid = '".$sessionid."'");
		
		if($pagamento['idpedido']){
			
			$pedidoParcelas = Sql::select('SATURN','Ecommerce',"select COUNT(*) AS total from tb_pagamentopedidoparcela where sessionid = ".$sessionid);
			
			if($pedidoParcelas['total']==0){
				
				foreach(Sql::arrays('SATURN','Simpac',"select IdPedidoParcela, NrParcela from tb_PedidoParcela where IdPedido = ".($pagamento['idpedido']-15000)) as $p){
				
					Sql::query('SATURN','Ecommerce', "sp_pagamentopedidoparcela_save ".($pagamento['idpedido']-15000).", ".$sessionid.", ".$p['IdPedidoParcela'].", ".$p['NrParcela']);
				
				}
					
			}
				
		}
		
		Sql::query('SATURN','Ecommerce',"update tb_status set idtipostatus = 1 where idstatus = ".$pagamento['idstatus']);
		
		Sql::query('SATURN','Ecommerce',"sp_SalvaReciboEcommerce '".$sessionid."','',".$pagamento['vltotal'].",".$pagamento['nrparcelas'].",".$pagamento['idformapagto'].",'".$pagamento['nome_cli']."'");
		
		Sql::query('SATURN','Ecommerce',"INSERT INTO tb_LojaVirtualBoletoBaixa (sessionid, dtpagamento, idusuario) VALUES(".$sessionid.", '".$dtconfirmpagto.' '.$hrconfirmpagto."', ".$_SESSION['idusuario'].")");
		
		$transacao = Sql::select('SATURN','Ecommerce', "sp_afiliados_transacao_get_sessionid ".$sessionid);
		
		if($transacao['idtransacao']) Sql::query('SATURN','Ecommerce',"sp_afiliados_transacaostatus_add ".$transacao['idtransacao'].", 2");
		unset($transacao);
		
		$idrecibo = Sql::select('SATURN','Ecommerce',"select idrecibo from tb_LojaVirtualRecibo where sessionid = '".$sessionid."'");
		
		Sql::query('SATURN','Simpac',"DELETE FROM tb_LojaVirtualBaixaRecibo WHERE idrecibo = ".$idrecibo['idrecibo']);
		
		envia_email('Baixa itau feita com sucesso com session ID '.$sessionid,'','bbarbosa@impacta.com.br;massaharu@impacta.com.br');
		
	}
	
	array_push($recibo, array(
		'idrecibo'=>(int)$idrecibo['idrecibo']
	));
}




echo json_encode(array(
	'success'=>true, 
	'data'=>$recibo
));
?>