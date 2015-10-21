<?
$GLOBALS['BOOTSTRAP'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$turmas = Sql::arrays("SONATA", "SOPHIA", "SELECT a.CODIGO, a.NOME FROM SOPHIA.TURMAS a INNER JOIN SOPHIA.CURSOS b ON b.PRODUTO = a.CURSO WHERE a.PERIODO = 125 AND NIVEL IN(1, 2)");

//pre($turmas);	



?>
<style>
	.container{
		padding:5px;
	}
	
	.table{
		width:100%;
		float: left;
		border: 2px solid black;
	}
	
	#table-gerada tfoot button{
		width: 90%;	
	}
</style>
<script>
	$(function(){
		
		/////////////// FUNCTIONS /////////////////////////////////////////////
		function blockTable(table){
			table.css({
				background : '#EDEDED'
			}).attr('data-blocked', 1);			
			table.find("input[type='checkbox']").attr('disabled', 'disabled');
		}
		
		function unblockTable(table){
			table.css({
				background : '#FFFFFF'
			}).attr('data-blocked', 0);				
			table.find("input[type='checkbox']").removeAttr('disabled').attr('checked', false);
		}
		
		function toggleBlockTable(table){
			
			blockTable(table);
			
			var isBothSelected = true;
			
			$.each($('.selectable-table'), function(){
				if($(this).attr('data-blocked') == "0"){
					isBothSelected = false;
				}
			});
			
			if(isBothSelected){
				var cm = confirm("Deseja vincular estas turmas selecionadas?");
				
				//Se for cancelado
				if(!cm){
					unblockTable($('#table-sophia'));
					unblockTable($('#table-idigital'));
					return false;
				}
				
				var trSelectedSophia = $("#table-sophia tbody td input['type=checkbox']:checked").closest('tr');
				var trSelectedIdigital = $("#table-idigital tbody td input['type=checkbox']:checked").closest('tr');
				
				var cod_sophia = trSelectedSophia.find('.td-codigo').text();
				var nm_sophia = trSelectedSophia.closest('tr').find('.td-nome').text();
				var cod_idigital = trSelectedIdigital.find('.td-codigo').text();
				var nm_idigital = trSelectedIdigital.find('.td-nome').text();
				
				$('#table-gerada tbody').append(
					"<tr>"+
					    "<td><input type='checkbox' /></td>"+
						"<td>"+cod_sophia+"</td>"+
						"<td>"+nm_sophia+"</td>"+
						"<td>"+cod_idigital+"</td>"+
						"<td>"+nm_idigital+"</td>"+
						"<td><button class='btn btn-small btn-danger remove-selected'><i class='icon-remove-sign icon-white'></i></button></td>"+
					"</tr>"
				);
				
				unblockTable($('#table-sophia'));
				unblockTable($('#table-idigital'));
				
				$('.remove-selected').off().on('click', function(){
					$(this).closest('tr').remove();
				});
			}
		}
		
		
		
		/////////////// EVENTS /////////////////////////////////////////////
		
		//For checkboxes
		$(".selectable-table tbody input[type='checkbox']").on('click', function(){
			toggleBlockTable($(this).closest('table'));
		});
		
		//Unblock tables
		$('.btn-unblock-table').on('click', function(){
			unblockTable($(this).closest('table'));
		});
		
		
	});
</script>
<body>
	<div class="container">
    	<div class="row-fluid">
        
        	<!--------------------------- SOPHIA ------------------------------------->
        	<div class="span3">    
                <table id="table-sophia" class="table table-bordered selectable-table" data-blocked="0">
                    <thead>
                        <tr>
                        	<th style="text-align:center;"><button class="btn btn-unblock-table"><i class="icon-remove-circle"></i></button></th>
                            <th colspan="2" style="text-align:center;">Sophia</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>CODIGO</th>
                            <th>NOME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            foreach($turmas as $turma){
                                echo 
                                "<tr>
                                    <td><input type='checkbox' data-codigo='".$turma["CODIGO"]."' /></td>
                                    <td class='td-codigo'>".$turma["CODIGO"]."</td>
                                    <td class='td-nome'>".$turma["NOME"]."</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!--------------------------- IDIGITAL CLASS ------------------------------------->      
            <div class="span3">
                <table id="table-idigital" class="table table-bordered selectable-table" data-blocked="0">
                    <thead>
                        <tr>
                            <th style="text-align:center;"><button class="btn btn-unblock-table"><i class="icon-remove-circle"></i></button></th>
                            <th colspan="2" style="text-align:center;">IDigital Class</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>CODIGO</th>
                            <th>NOME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            foreach($turmas as $turma){
                                echo 
                                "<tr>
                                    <td><input type='checkbox' data-codigo='".$turma["CODIGO"]."' /></td>
                                    <td class='td-codigo'>".$turma["CODIGO"]."</td>
                                    <td class='td-nome'>".$turma["NOME"]."</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!--------------------------- TABELA GERADA PARA CRIAR O XML ------------------------------------->
            <div class="span6">    
                <table id="table-gerada" class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>CODIGO (IDigital)</th>
                            <th>NOME (IDigital)</th>
                            <th>CODIGO (Sophia)</th>
                            <th>NOME (Sophia)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="text-align:center;"><button class="btn btn-info btn-large">Criar XML</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>   
		</div>                
	</div>        
</body>
