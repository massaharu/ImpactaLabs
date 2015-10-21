<?
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$tipo = get('tipo');

$a = Sql::arrays('FOCUS','Simpac',"sp_comitenovostreinamentos_list '$tipo'");

?>
<style media="all" type="text/css">
* { font-family:Arial, Helvetica, sans-serif; font-size:11px; }
body, html { margin:0 !important; padding:0 !important; }
h1 { font-size:13px; }
#content { margin:10px !important; }
.bold { font-weight: bold; }
.bg_cinza { background-color:#E0E0E0; }
.class_cancelado {
	color:#F00;
}
</style>
<title>Relatorio</title>
<div id="content">
  <h1>Relatorio
  </h1>
  <table class="zebra" width="100%" border="0" cellspacing="2" cellpadding="2">
    <thead>
      <tr class="bold">
        <td>Nome do Treinamento</td>
        <td>Prioridade</td>
        <td>Divis&atilde;o</td>
        <td>Previs&atilde;o de Entrega</td>
        <td>Status</td>
        <td>Andamento</td>
      </tr>
    </thead>
    <tbody>
    <?
	$vltotal = 0;
    foreach($a as $a1){
	?>
      <tr>
        <td><?=trim($a1['nmcurso']);?></td>
		<?
        	if($a1['inprioridade'] == 1){
				echo("<td><img src='/simpacweb/images/ico/16/flag_blue.png' /> Prioridade 1</td>");
			} else {
				echo("<td><img src='/simpacweb/images/ico/16/flag_red.png' /> Prioridade 2</td>");
			}
		?>	       
        <td><?=trim($a1['desdivisao']);?></td>
        <td><?=$a1['dtprevisao'];?></td>
        <?
        	if($a1['instatus'] == 1){
				echo("<td><img src='/simpacweb/images/ico/16/clock_go.png' /> Em Andamento</td>");
			} else if($a1['instatus'] == 2) {
				echo("<td><img src='/simpacweb/images/ico/16/accept.png' /> Concluido</td>");
			} else {
				echo("<td><img src='/simpacweb/images/ico/16/stop.png' /> Parado</td>");
			}
		?>
        <td><?=$a1['desstatus'];?></td>
      </tr>
    <?
    }
	?>
    </tbody>
  </table>
  <p>SimpacWeb - <?=$_SESSION['nmlogin'];?> - <?=date('d/m/Y H:i:s');?></p>
</div>
<script type="text/javascript">
	window.print();
</script>