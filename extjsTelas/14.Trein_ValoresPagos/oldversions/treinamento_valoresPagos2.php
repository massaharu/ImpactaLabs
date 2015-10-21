<?php
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['ext_theme'] = false; 
//////////////////////////////////////////////////////////////////////////////////////////////
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
//////////////////////////////////////////////////////////////////////////////////////////////
lockpage();
//////////////////////////////////////////////////////////////////////////////////////////////
$idcursoagendado = get('idcursoagendado');
//////////////////////////////////////////////////////////////////////////////////////////////


$lista = Sql::select('FOCUS','Simpac',"sp_cursoagendadovalorespagos_get $idcursoagendado");
$lista_valores = Sql::arrays('FOCUS','Simpac',"sp_ValoresPagosAgendados $idcursoagendado");
//////////////////////////////////////////////////////////////////////////////////////////////
switch ($lista['idperiodo'])
{
case 1:
  $qdte_horas = 8;
  break;
case 2:
  $qdte_horas = 4;
  break;
case 3:
  $qdte_horas = 8;
  break;
case 4:
  $qdte_horas = 8;
  break;
case 5:
  $qdte_horas = 8;
  break;
case 6:
  $qdte_horas = 4;
  break;
case 7:
  $qdte_horas = 4;
  break;
}
//////////////////////////////////////////////////////////////////////////////////////////////
$qdte_dias = $lista['QtCargaHoraria']/$qdte_horas;
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<script>
Ext.onReady(function(){

	new Ext.Viewport({
		border:false,
		layout:'border',
		items:[{
			region: 'center',
			contentEl:'content_html',
			autoScroll:true,
			border: false,
			style:'padding-bottom:25px; padding-top:25px;'
		}]
	});

});
</script>
<style media="print">
body {
	font-family:Arial, Helvetica, sans-serif!important;
}
#content_html * {
	font-size:12px!important;	
}
</style>
<div style="margin:5px;" id="content_html">
  <?php topopagina('money_bag_256.png','Valores Pagos');?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="120" height="25">Treinamento:</th>
            <td><?php echo linkpermissao('modulos/cursosagendados/treinamento_dados.php', 'idcursoagendado='.$lista['idcursoagendado'], $lista['DesCurso'].' - '.formatdatetime($lista['Dtinicio']).' à '.formatdatetime($lista['DtTermino']), '', '', 'turma.png');?></td>
          </tr>
          <tr>
            <th height="25">Valor Tabela:</th>
            <td><?php echo formatcurrency($lista['VlTotal']);?></td>
          </tr>
        </table></td>
      <td width="190"><div id="calendario"></div></td>
    </tr>
  </table>
  <hr style="width:auto;" color="#CCCCCC" noshade="noshade" size="1">
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td width="100"><b>Or&ccedil;amento</b></td>
      <td width="100" height="25"><b>Matricula</b></td>
      <td ><b>Aluno</b></td>
	  <td ><b>Tipo</b></td>
      <td ><b>Obs</b></td>
      <td width="90" style="text-align:right;" ><b>Unit&aacute;rio</b></td>
      <td width="90" style="text-align:right;" ><b>Valor Total</b></td>
    </tr>
    <?php 
	foreach($lista_valores as $r){
	$qtd_alunos += 1;
	?>
    <tr>
      <td style="border-bottom:#CCC 1px dashed;"><?php echo linkpermissao('modulos/orcamento/orcamento_dados.php', 'idpedido='.$r['idpedido'], $r['idpedido'], '', '', 'orcamento.png');?></td>
      <td style="border-bottom:#CCC 1px dashed;" height="25"><?php echo linkpermissao('modulos/matricula/matricula_dados.php', 'matricula='.$r['matricula'], $r['matricula'], '', '', 'matricula.png');?></td>
      <td style="border-bottom:#CCC 1px dashed;" align="left"><?php echo linkpermissao('modulos/aluno/aluno_dados.php', 'idaluno='.$r['idaluno'], utf8_decode($r['Aluno']), '', '', 'aluno.png');?></td>
      <td style="border-bottom:#CCC 1px dashed;" height="18"><?php echo utf8_encode($r['InTipo']=='F'?'Física':'Jurídica')?></td>
      <td style="border-bottom:#CCC 1px dashed;" height="18"><?php
	  	if(instr($r['DesOBS'],'REPOSIÇÃO') > 0)
		{
			echo 'Reposi&ccedil;&atilde;o';
		}
		else
		{
			if(left($r['matricula'],2) == '03')
			{
				echo 'Funcion&aacute;rio';	
			}
			elseif(left($r['matricula'],2) == '13')
			{
				echo 'Permuta';	
			}
			elseif(left($r['matricula'],2) == '52')
			{
				echo 'Permuta';	
			}
			elseif(left($r['matricula'],2) == '70')
			{
				echo 'Cortesia';	
			}
			elseif(left($r['matricula'],2) == '99')
			{
				echo 'Sorteio';	
			}
			else
			{
				echo utfe($r['DesOBS']);
			}
		}
	  ?></td>
      <?php 
	  $unitario = $r['Unitario'];
	  if(! is_numeric($unitario)){$unitario = 0;}	
	  
	  if($unitario == 0)
	  {		
	  		
			if($r['idcurso1'] != $r['idcurso2'] && left($r['matricula'],2) != '70' && left($r['matricula'],2) != '03')
			{
				$lista_valorReal = Sql::arrays('FOCUS','Simpac',"sp_orcamentocursos_get ".($r['idpedido']-15000));		
				$listaLojaVirtual = Sql::arrays('FOCUS','Simpac',"sp_lojavirtualcarrinho_list ".$r['idcurso1'].", '".trim($r['NrCPF'])."'");
								
				if(count($listaLojaVirtual) == 0){
					
					foreach($lista_valorReal as $vlreal){
			
						if($r['idcurso1'] == $vlreal['idcurso']){							
							$unitario = $vlreal['unitario'];
							$unitario_text = '<span style="color:#9900FF;">'.formatcurrency($vlreal['unitario']).'</span>';
						}
					}
				}else{
					$LojaVirtual = $listaLojaVirtual[0];
					
					$unitario = $LojaVirtual['unitario'];
					$unitario_text = formatcurrency($LojaVirtual['unitario']);
				}
			}else{
				$unitario_text = formatcurrency($unitario);
			}
	   
	   }else{			
		   	$unitario_text = formatcurrency($unitario);
	   }
	  ?>
      <td style="border-bottom:#CCC 1px dashed;text-align:right;" height="18"><?php echo $unitario_text;?></td>
      <?php
      $valor_total = $r['Valor_Total'];
	  if(! is_numeric($valor_total)){$valor_total = 0;}
	  ?>
      <td style="border-bottom:#CCC 1px dashed;text-align:right;" height="18"><?php echo formatcurrency($valor_total);?></td>
    </tr>
    <?php 
		$valor_total_1 += $unitario;
		$valor_total_2 += $valor_total;
	}
	?>
    <tr>
      <td >&nbsp;</td>
      <td height="25" >&nbsp;</td>
      <td height="20" >&nbsp;</td>
      <td height="20" >&nbsp;</td>
      <td  height="20" style="text-align:right;" ><b>TOTAL&nbsp;&nbsp;</b></td>
      <td height="20" style="text-align:right;" ><b><?php echo formatcurrency($valor_total_1);?></b></td>
      <td height="20" style="text-align:right;" ><b><?php echo formatcurrency($valor_total_2);?></b></td>
    </tr>
  </table>
  <hr style="width:auto;" color="#CCCCCC" noshade="noshade" size="1">
  <?php

$lista_valorHora = Sql::select('FOCUS','Simpac',"sp_instrutorcursosministrados_get_idcurso ".$lista['IdInstrutor'].", ".$lista['IdCurso']);

$lista_valorApostila = Sql::arrays('FOCUS','Simpac',"sp_apostilaslivrosvalores_list ".$lista['IdCurso']);

?>
  <table border="0" align="left" cellpadding="4" cellspacing="0">
    <tr>
      <td width="200" height="25">Instrutor - Valor Hora</td>
      <td width="100" style="text-align:right;"><?php echo formatcurrency($lista_valorHora['valor']);?></td>
      <td width="105" style="text-align:right;"><?php echo formatcurrency($lista_valorHora['valor']*$lista['QtCargaHoraria']);?></td>
    </tr>
    <?php
  $lucro_total = $lista_valorHora['valor']*$lista['QtCargaHoraria'];
  if(count($lista_valorApostila) > 0){
	  
	  
	  $lista_va = $lista_valorApostila[0];
	  
  ?>
    <tr>
      <td height="25">Apostilas</td>
      <td style="text-align:right;"><?php echo formatcurrency($lista_va['vltotal']);?></td>
      <td style="text-align:right;"><?php echo formatcurrency($lista_va['vltotal']*$qtd_alunos);?></td>
    </tr>
    <?php 
  	$lucro_total += $lista_va['vltotal']*$qtd_alunos;
	
  }else{
	
	$lista_valorApostila2 = Sql::arrays('FOCUS','Simpac',"sp_apostilaslivrosvaloresrelacao_list ".$lista['IdCurso']);
	
	if(count($lista_valorApostila2) > 0){
		
		$lista_va2 = $lista_valorApostila2[0];
		
  ?>
    <tr>
      <td height="25">Apostilas</td>
      <td style="text-align:right;"><?php echo formatcurrency($lista_va2['vltotal']);?></td>
      <td style="text-align:right;"><?php echo formatcurrency($lista_va2['vltotal']*$qtd_alunos);?></td>
    </tr>
    <?php }else{?>
    <tr>
      <td height="25">Apostilas</td>
      <td style="text-align:right;">-</td>
      <td style="text-align:right;">-</td>
    </tr>
    <?php
  	}
  }
  ?>
    <tr>
      <td height="25">Diversos</td>
      <td style="text-align:right;"><?php echo formatcurrency(1.5);?></td>
      <td style="text-align:right;"><?php echo formatcurrency((1.5*$qtd_alunos)*$qdte_dias);?></td>
    </tr>
    <?php $lucro_total += (1.5*$qtd_alunos)*$qdte_dias;?>
    <tr>
      <td height="25">Comiss&atilde;o de Vendas</td>
      <td style="text-align:right;">2,66%</td>
      <td style="text-align:right;"><?php echo formatcurrency(calc_porcento(2.66,$valor_total_1));?></td>
    </tr>
    <?php $lucro_total += calc_porcento(2.66,$valor_total_1);?>
    <tr>
      <td height="25">Risco</td>
      <td style="text-align:right;">2%</td>
      <td style="text-align:right;"><?php echo formatcurrency(calc_porcento(2,$valor_total_1));?></td>
    </tr>
    <?php $lucro_total += calc_porcento(2,$valor_total_1);?>
    <tr>
      <td height="25">Custo Fixo</td>
      <td style="text-align:right;">17%</td>
      <td style="text-align:right;"><?php echo formatcurrency(calc_porcento(17,$valor_total_1));?></td>
    </tr>
    <?php $lucro_total += calc_porcento(17,$valor_total_1);?>
    <tr>
      <td height="25">Impostos</td>
      <td style="text-align:right;">10%</td>
      <td style="text-align:right;"><?php echo formatcurrency(calc_porcento(10,$valor_total_1));?></td>
    </tr>
    <?php $lucro_total += calc_porcento(10,$valor_total_1);?>
    <tr>
      <td style="padding:5px;" colspan="2" bgcolor="#EEEEEE"><strong>Despesas com <?php echo $qtd_alunos;?> alunos</strong></td>
      <td height="40" bgcolor="#EEEEEE" style="text-align:right;padding:5px;"><strong><?php echo formatcurrency($lucro_total);?></strong></td>
    </tr>
    <?php 
  $lucro_total = $valor_total_1 - $lucro_total;
  
  if($lucro_total > 0)
  {
	$bgcolor = "#E6FFE6";
	$fontcolor = "#006600";
  }
  else
  {
	$bgcolor = "#FFE8E8";
	$fontcolor = "#990000";
  }
  ?>
    <tr>
      <td style="padding:5px; color:<?php echo $fontcolor;?>;" bgcolor="<?php echo $bgcolor;?>"><b>Total (lucro)</b></td>
      <td style="padding:5px; color:<?php echo $fontcolor;?>;text-align:right;" bgcolor="<?php echo $bgcolor;?>">&nbsp;</td>
      <td height="40" bgcolor="<?php echo $bgcolor;?>" style="text-align:right;padding:5px; color:<?php echo $fontcolor;?>;"><b><?php echo formatcurrency($lucro_total);?></b></td>
    </tr>
  </table><div id="btn_button_print"></div>
  </div>

<script>
Ext.onReady(function(){var button_print = new Ext.Button({text:"Imprimir", handler:function(){

button_print.hide();

//$("#content_html").printArea();

var winPrint = window.open();
winPrint.document.write($('#content_html').html());
winPrint.print();
winPrint.close();

button_print.show();

}});button_print.render("btn_button_print");});
</script>
