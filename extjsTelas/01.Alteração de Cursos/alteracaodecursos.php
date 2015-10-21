<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>

<script type="text/javascript">
if(Ext.getCmp('winAlterarCursos')){
	Ext.getCmp('winAlterarCursos').show();
}else{ 
	var rec = SimpacWeb.vars.rec;
	new Ext.Window({
		id:'winAlterarCursos',
		title:'Alteração de Cursos',
		width:500,
		modal:false,
		height:120,
		items:[{
			xtype:'form',
			id:'formAlterarCursos',
			padding:15,
			border:false,
			defaults:{
				anchor:'100%',
				hideLabel:true
			},
			items:[{
				xtype:'combo_cursosativos',
				id:'combo',
				typeAhead:true,
				triggerAction:'all',
				lazyRender:true,
				allowBlank:false,//Não permite entradas vazias
				name:'idcurso',
				hiddenName:'idcurso',
				listeners:{
				'select':function(){
						console.log(Ext.getCmp('combo').lastSelectionText);
					}
				}
			}],
		}],
		buttons:[{
			text:'Salvar',
			iconCls:'ico_save',
			handler:function(){					
				if(Ext.getCmp('formAlterarCursos').getForm().isValid()){
					Ext.getCmp('formAlterarCursos').getForm().submit({
						url:'/simpacweb/labs/Massaharu/extjsTelas/01.Alteração de Cursos/alteracaodecursos_action.php',
						params:{
							//idcursoagendado:SimpacWeb.vars.idcursoagendado,
							descurso:Ext.getCmp('combo').lastSelectionText
						},
						success:function(){
							Ext.getCmp('grid_treinamentosMarcados').getStore().reload({
								callback:function(){
									Ext.MessageBox.alert('','Registro salvo com sucesso!');	
									Ext.getCmp('winAlterarCursos').close();
								}	
							});
						}
					})
				}
			}
		},{
			text:'Fechar',
			iconCls:'ico_fechar',
			handler:function(){
				Ext.getCmp('winAlterarCursos').close();
			}
		}]	
	}).show();
}
</script>