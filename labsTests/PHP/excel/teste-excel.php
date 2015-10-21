<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 1000);
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$ETAPAS_PAI_1 = "1, 3";
$ETAPAS_PAI_2 = "2, 4";

$excel = new SimpleXLSX('2014-2_PAI2/nota-pai9.xlsx');
$idperiodo = 125;
$etapas = $ETAPAS_PAI_2;

$i = 1;
$j = 1;

?>
<html>
<head>
	<title>Importação de Notas do PAI</title>
    <style>
		table{
			margin:0 auto;
			border-collapse: collapse;
		}
		table td,
		table th{
			border: 1px solid black;
		}
		table th{
			background:gray;
			padding:5px;
		}
		table th.th-ra,
		table th.th-ra-excel{
			width:70px;
		}
		table th.th-nome-sophia,
		table th.th-nome-excel{
			width:300px;
		}
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>	
            	<th>Nº</th>
                <th class='th-ra'>RA(sophia)</th>
                <th class='th-ra-excel'>RA(excel)</th>
                <th class='th-nome-sophia'>Nome (Sophia)</th>
                <th class='th-nome-excel'>Nome (excel)</th>
                <th>Iguais?</th>
                <th>Stat. Mat.</th>
                <th>Procedure</th>
                <th>Success</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($excel->rows() as $key=>$val){
                if(trim($val[0]) != "" && trim($val[2]) != ""){
                    //$data = Sql::arrays("SATURN", "FIT_NEW", "SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = '".$val[0]."'", false);
					$data = Sql::arrays("SATURN", "FIT_NEW", "SELECT NOME, CODEXT, STATUS, * FROM SONATA.SOPHIA.SOPHIA.FISICA a INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO WHERE a.CODEXT = '".$val[0]."' AND b.PERIODO = ".$idperiodo." AND STATUS in(0, 5)", false);		
					
                    $retorno = Sql::arrays("SATURN", "FIT_NEW","sp_notaspai_save '".$val[0]."', '".number_format(((is_numeric($val[2]))? $val[2] : '0,00'), 2)."', ".$idperiodo.", '".$etapas."'", false);
					
					if($retorno['updated'] == 1){
						$updated = "SIM";
						$background_ret = "style='background: rgb(57, 197, 136)'";
					}else if($retorno['updated'] == 0){
						$updated = "NÃO";
						$background_ret = "style='background:rgb(223, 92, 92);'";
					}
					
					if(strtolower($data['NOME']) == trim(strtolower($val[1]))){
						$iguais = "SIM";
						$background = "";
					}else{
						$iguais = "NÃO";
						$background = "style='background:rgb(223, 92, 92);'";
					}
					
					switch($data['STATUS']){
						case 0:
							$STATUS = "Ativo";
							break;
						case 1:
							$STATUS = "Trancado";
							break;
						case 2:	
							$STATUS = "Cancela";
							break;
						case 3:
							$STATUS = "Transferido";
							break;
						case 4:
							$STATUS = "Evadido";
							break;
						case 5:
							$STATUS = "Concluído";
							break;
						default:
							$STATUS = "Indefinido";
					}
					
                    echo 
                    "<tr>
						<td $background>".$i."</td>
                        <td $background>".$data['CODEXT']."</td>
						<td $background>".$val[0]."</td>
                        <td $background>".$data['NOME']."</td>
                        <td $background>".$val[1]."</td>
						<td $background>".$iguais."</td>
						<td $background>".$STATUS."</td>
						<td $background>sp_notaspai_save '".$val[0]."', '".number_format(((is_numeric($val[2]))? $val[2] : '0,00'), 2)."', ".$idperiodo.", '".$etapas."'</td>
						<td $background_ret>".$updated."</td>
                    </tr>";
					
					$i = $i + 1;
                }else{
					$j = $j + 1;
				}
            } ?>
        </tbody>
    </table>
<?

echo "<hr /><br />FOI CARAMBA! ".($i-1)." registros lidos e ".($j-1)." registros não lidos.";
?>
</body>
</html>