<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


?>
 <script type="text/javascript">
new Ext.data.ArrayStore({
		fields:[{name:'nome'},
				{name:'descurso'},
				{name:'inpreenchido',type:'int'}],
		data:[['Rodrigo Silva','Programador','21'],
			  ['Yukari Morishima','Secretaria','19'],
			  ['Kamui Kobayashi','Software Engineer','23'],
			  ['Robert de Niro','Actor','61'],
			  ['David Gilmour','Guitarrist','68']]
});	

</script>