<?
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['BOOTSTRAP'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
Ext.onReady(function(){
	
	var storelastchildsmenu = new Ext.data.JsonStore({
		url:'/simpacweb/labs/Massaharu/extjsTelas/_01.admIcons/json/lastchildsmenu_load.php',
		root:'myData',
		fields:[
			{name:'idmenu', 	type:'int'},
			{name:'text', 		type:'string'},
			{name:'parent', 	type:'int'},
			{name:'handler', 	type:'string'},
			{name:'nrordem',	type:'int'},
			{name:'iconCls', 	type:'string'},
			{name:'desc', 		type:'string'}
		],
		autoLoad:true
	});

	if(xt('id_win_adm_icons')){
		xt('id_win_adm_icons').show();
	}else{
		
		var win_adm_icons = new Ext.Window({
			title:'Admin. Ícones SimpacWeb',
			id:'id_win_adm_icons',
			height:500,
			width:600,
			items:[{
				xtype:'tabpanel',
				id:'idadmiconstabpanel',
				margins:'2 2 2 2', 
				activeTab: 0,
				height:465,
				tabPosition:'bottom',
				autoScroll:false,
				border:false,
				items:[{
					title:'Ícones',
					id:'idtabicones',
					layout:'border',
					tbar:[{
						text:'Adicionar',
						id:'idadmiconsbtntoggleadd',
						tooltip:'Adicionar um novo ícone',
						iconCls:'ico_add',
						enableToggle:true,
						toggleHandler: function(button,state){
							var $btn = Ext.getCmp('idadmiconsbtntoggleadd');
							if (state == true) {	
								$btn.setText('Ícones');
								$btn.setIconClass('ico_text_list_bullets');	
								$btn.setTooltip('Ver a lista de ícones');
								xt('idadmiconsiconesadd').expand();
							}else{
								$btn.setText('Adicionar')
								$btn.setIconClass('ico_add');	
								$btn.setTooltip('Adicionar um novo ícone');
								xt('idadmiconsiconesadd').collapse();
							}
						}
					},'-','->','-',{
						text:'Deletar',
						id:'idadmiconsbtndel',
						tooltip:'Selecione os ícones que queira excluir',
						iconCls:'ico_cross'
					}],
					items:[{
						title:'Ícones',
						region: 'center',
						id:'idadmiconsiconeslist',
						split: true,
						collapsed:false,
						collpasible:true,
						collapseMode:'mini',
						border:false,
						autoScroll:true,
						listeners:{
							'afterrender':function(){
								xt('idadmiconsiconeslist').load({
									url:'/simpacweb/labs/Massaharu/extjsTelas/_01.admIcons/load_pages/icones_crud.php?code=true', 
									scripts:true
								});
							}
						}
					},{
						title:'Adicionar',
						region: 'south',
						id:'idadmiconsiconesadd',
						split: true,
						collapsed:true,
						collpasible:true,
						collapseMode:'mini',
						height:385,
						border:false,
						autoScroll:true,
						items:[{
							xtype:'form',
							id:'idfrmiconadd',
							padding:10,
							border:false,
							buttonAlign:'center',
							defaults:{
								width:300
							}, 
							items:[{
								xtype:'combo',
								id:'idcmblastchildsmenu',
								name:'lastchildsmenu',
								hideLabel:true,
								autoHeight:true,
								store:storelastchildsmenu,
								displayField:'desc',
								valueField:'idmenu',
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								mode:'local',
								width:200,
								style:'margin-bottom:20px;',
								emptyText:'Lista de menus...',
								listeners:{
									'select':function(store, selectedStore, i){
										
										var $desid = selectedStore.get('text').toLowerCase();
										var regex = new RegExp(' ', 'g');
										$desid = "ico_"+$desid.replace(regex, '_'); 
										
										xt('idtxtdesid').setValue($desid);
										xt('idtxtdesicone').setValue(selectedStore.get('text'));
										xt('idtxtdblclick').setValue(selectedStore.get('handler'));
									}
								}
							},{
								xtype:'textfield',
								fieldLabel:'Descrição ID ',
								name:'txtdesid',
								id:'idtxtdesid',
								allowBlank:false
							},{
								xtype:'textfield',
								fieldLabel:'Nome Ícone ',
								name:'txtdesicone',
								id:'idtxtdesicone',
								allowBlank:false
							},{
								xtype:'textfield',
								fieldLabel:'X ',
								name:'txtX',
								id:'idtxtX',
								allowBlank:false,
								value:500
							},{
								xtype:'textfield',
								fieldLabel:'Y ',
								name:'txtY',
								id:'idtxtY',
								allowBlank:false,
								value:500
							},{
								xtype:'textfield',
								fieldLabel:'Ícone ',
								name:'txtX',
								id:'idtxtX',
								allowBlank:false
							},{
								xtype:'textfield',
								fieldLabel:'Evento(dblclick) ',
								name:'txtdblclick',
								id:'idtxtdblclick',
								allowBlank:false
							},{
								xtype:'button',
								text:'Salvar',
								iconCls:'ico_add',
								scale:'large',
								style:'margin-top:20px;'
							}]
						}]
					}]
				},{
					title:'Ícone X Usuário'
				}]
			}]
		}).show();
	}
});
	
</script>