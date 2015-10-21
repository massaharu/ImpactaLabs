<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idcursoagendado = post('idcursoagendado');

$data = Sql::arrays("SATURN", "Simpac", "sp_ValoresPagosAgendados $idcursoagendado");


foreach($data as &$a){
	$a['obsstatus'] = 'something';
	if(instr($a['DesOBS'],'REPOSIÇÃO') > 0){
		
		$a['obsstatus'] = 'Reposi&ccedil;&atilde;o';
		
	}else{
		if(left($a['matricula'],2) == '03')
		{
			$a['obsstatus'] = 'Funcion&aacute;rio';	
		}
		elseif(left($a['matricula'],2) == '13')
		{
			$a['obsstatus'] = 'Permuta';	
		}
		elseif(left($a['matricula'],2) == '52')
		{
			$a['obsstatus'] = 'Permuta';	
		}
		elseif(left($a['matricula'],2) == '70')
		{
			$a['obsstatus'] = 'Cortesia';	
		}
		elseif(left($a['matricula'],2) == '99')
		{
			$a['obsstatus'] = 'Sorteio';	
		}
		else
		{
			$a['obsstatus'] =  utfe($a['DesOBS']);
		}
	}
	
	$a['LojaVirtual'] = 1;
	
	if($a['Unitario'] == 0)
	  {		
		if($a['idcurso1'] != $a['idcurso2'] && left($a['matricula'],2) != '70' && left($a['matricula'],2) != '03')
		{
			$lista_valorReal = Sql::arrays('FOCUS','Simpac',"sp_orcamentocursos_get ".($a['idpedido']==0?0:$a['idpedido']-15000));		
			$listaLojaVirtual = Sql::arrays('FOCUS','Simpac',"Select vlitem as unitario from v_valor_pago_compra_site_list where idcurso = ".$a['idcurso1']." and cpf_cli =  '".trim($a['NrCPF'])."'");
							
			if(count($listaLojaVirtual) == 0){
				
				foreach($lista_valorReal as $vlreal){
		
					/*if($a['idcurso1'] == $vlreal['idcurso']){							
						$a['Unitario'] = $vlreal['unitario'];						
						$a['LojaVirtual'] = count($listaLojaVirtual);
						
			
						//$unitario_text = '<span style="color:#9900FF;">'.formatcurrency($vlreal['unitario']).'</span>';
					}*/
					
					if($a['idcurso1'] == $vlreal['idcurso']){							
							$a['Valor_Total'] = $vlreal['unitario'];
							$a['Unitario'] = '<span style="color:#9900FF;">'.formatcurrency($vlreal['unitario']).'</span>';
						}

				}
			}else{
				$LojaVirtual = $listaLojaVirtual[0];
				$a['Valor_Total'] = $LojaVirtual['unitario'];
				$a['Unitario'] = $LojaVirtual['unitario'];
				//$unitario_text = formatcurrency($LojaVirtual['unitario']);
			}
		}else{
			$a['Unitario'] = $a['Unitario'];
			//$unitario_text = formatcurrency($unitario);
		}
   }else{
	     if ($a['InTipo']=='J')
			$a['Unitario'] = formatcurrency($a['Unitario'] = 0.00);
		else
			$a['Unitario'] =($a['idpedido']==0?$a['Unitario']:formatcurrency($a['Unitario']));
		 //a['Unitario'] = $a['Unitario'];
		//$unitario_text = formatcurrency($unitario);
   }
   
	$valor_total_1 += $a['Unitario'];
	$valor_total_2 += $a['Valor_Total'];
	
	$a['valor_total_1'] = $valor_total_1;
	$a['valor_total_2'] = $valor_total_2;
}

success(TRUE, array("myData"=>$data));
?>