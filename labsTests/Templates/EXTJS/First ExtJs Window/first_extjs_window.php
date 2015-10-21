<?php
# @AUTOR = Massaharu #
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['JSON'] = false;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<script type="text/javascript">
if (Ext.getCmp('firstExtWindow')){
	Ext.getCmp('firstExtWindow').show();
}else{
	var store = new Ext.data.ArrayStore({
		fields:[{name:'nome'},
				{name:'profissao'},
				{name:'idade',type:'int'}],
		data:[['Rodrigo Silva','Programador','21'],
			  ['Yukari Morishima','Secretaria','19'],
			  ['Kamui Kobayashi','Software Engineer','23'],
			  ['Robert de Niro','Actor','61'],
			  ['David Gilmour','Guitarrist','68']]
	});
	
	/*Ext.onReady(function(){*/
		var win = new Ext.Window({
			id:'firstExtWindow',
			height:550,
			width:900,
			modal:true,
			title:'First ExtJs Window',
			html:'<b>Sentence written by HTML string2</b>',
			tbar:['De: ',{
				xtype:'datefield',
				format:'d/m/y',
				width:150,
				allowBlank:false,
			},'A: ',{
				xtype:'datefield',
				format:'d/m/y',
				width:150,
				allowBlank:false,
			},{
				xtype:'button',
				iconCls: 'ico_search',
				text:'Pesquisar'
			}],	
			items:[{
				xtype:'form',
				padding:15,
				height:400,
				border:true,
				defaults:{hideLabel:true,anchor:100},	
					items:[{
						xtype:'button',
						text:'Simple Form',
						padding:20,
						handler:function(){
						Ext.getCmp('simpleForm').show()
						}
					},{
						xtype:'combo_cursosativos',
						typeAhead:true,
						triggerAction:'All',
						lazyRender: true,
						allowBlank:false,
						anchor:'100%'	
					},{
						xtype:'button',
						text:'Message',
						width:100,
						handler:function(){
							Ext.Msg.prompt('Name','Please Enter Your Name', function(btn,text){
								if(btn=='Ok'){
								}
							})
						}
					},{
						xtype:'datefield',
						fieldLabel:'message'					
					},{	
						xtype:'textfield',
						fieldLabel:'textfield',
						width:200					
					},{
						xtype:'grid',
						store: store,
						loadMask:true,
						title:'GRID 1',
						columns:[{
							header:'Nome',
							width:220,
							id:'nome',
							sortable:true,
							dataIndex: 'nome'
						},{
							header:'Profissão',
							width:220,
							id:'profissao',
							sortable:true,
							dataIndex:'profissao'
						},{
							header:'idade',
							width:60,
							id:'idade',
							sortable:true,
							dataIndex:'idade'						
						}],
						height:180,
						width:500,
						border:true,
						defaults:{anchor:true}				
					}],
				}],				
			buttons:[{
					text:'Fechar',
					iconCls:'ico_fechar',
					handler:function(){
						win.close();
					}
				},{
					text:'Message',			
					handler:function(){
					Ext.Msg.alert('This is a status line', 'This is a message line.');				
					}				
				}]			
			});
			Ext.get('btnClose').on('click',function(){		
			win.close();	
		});	
			Ext.get('btnOpen').on('click',function(){
			win.show();			
		});			
	/*});*/
}
//-----------------------------Simple Form-------------------------------//
Ext.onReady(function(){
    var win1 = new Ext.Window({
		id:'simpleForm',
        title: 'Simple Form',
		modal:true,
        padding:10,
        width: 350,
		items:[{
			xtype:'form',
			border:false,
			padding:10,
			defaults:{anchor:'100%'},
		  items: [{
			  xtype:'textfield',
			  fieldLabel: 'First Name',
			  name: 'first',
			  allowBlank:false,		
		  },{
			  xtype:'textfield',
			  fieldLabel: 'Last Name',
			  name: 'last'
		  },{
			  xtype:'textfield',
			  fieldLabel: 'Company',
			  name: 'company'
		  }, {
			  xtype:'textfield',
			  fieldLabel: 'Email',
			  name: 'email',
			  vtype:'email'
		  }, {
			  xtype: 'timefield',
			  fieldLabel: 'Time',
			  name: 'time',
			  minValue: '8:00am',
			  maxValue: '6:00pm'
		  	}]
		}],
        buttons: [{
            text: 'Save'			
        },{
            text: 'Cancel',
			handler:function(){
				win1.close()
			}
        }]
    });
});
</script>

