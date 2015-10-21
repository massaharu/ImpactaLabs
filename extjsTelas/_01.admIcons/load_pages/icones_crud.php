<? require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
/*
* # @AUTOR = massaharu
*/

$icone = new Icone(0);

$icones = $icone->IconeList();
?>
<style type="text/css">
	#icone-container{
		position:relative;
		float:left;
		padding:5px;
		transition:all 0.5s;
	}
	#icone-container:hover{
	
	}
	.icons-list{
		height:70px;
		width:70px;
		background-repeat:no-repeat;
		transition:all 0.5s;
	}
	.icons-list:hover{
		
		transform:rotate(30deg);
		-ms-transform:rotate(30deg); /* IE 9 */
		-webkit-transform:rotate(30deg); /* Safari and Chrome */
	}
</style>
<script type="text/javascript">
$(function(){
	$('#icone-main .icons-list').on('click', function(){
		
		$this = $(this);
		
		if($this.attr('data-selected') == "false"){
			$this.css({
				"-webkit-transform" : "rotateY(120deg)" ,
				"background-color" : "rgb(203, 203, 255)"
			});
			$this.attr('data-selected', 'true');
		}else{
			$this.css({
				"-webkit-transform" : "rotateY(0deg)" ,
				"background-color" : "transparent"
			});
			$this.attr('data-selected', 'false');
		}
	});
});

</script>

<div id="icone-main">
	<?
    foreach($icones as $val){
		echo "<div id='icone-container'>
			<a href='javascript:void(0)' onDblClick='".$val['dbclick']."'>
				<div class='icons-list' style='background-image:url(/simpacweb/images/".$val["desico"].");' title='".$val['desicone']."' alt='".$val['desicone']."' data-selected='false'>
				</div>
			</a>
		</div>";
	}
	?>

</div>

