// Author : @Massaharu
var ms = Ext.MessageBox;
var xt = Ext.GetCmp;

if(xt('id_win_adm_icons')){
	xt('id_win_adm_icons').show();
}else{
	
	var win_adm_icons = new Ext.Window({
		title:'Admin. Ícones SimpacWeb',
		id:'id_win_adm_icons',
		height:500,
		width:600
	}).show();
}
