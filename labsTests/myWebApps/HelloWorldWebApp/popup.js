//// JavaScript Document
//$(document).ready(function() {
//	
//	var segundos = 10; //inicio do cronometro
//	var interval = "";
//	
//	function formatatempo(segs) {
//		if (segs < 10) {segs = "0"+segs}
//		
//		fin = segs
//		
//		return fin;
//	}
//	
//	/*function conta() {
//		segundos--;
//		if(segundos == 0){
//			zera();
//			alert('ALERTA ALERTA!');
//			
//		}
//		$('#cronometer').html("<span style='font-size:40px'>"+formatatempo(segundos)+'</span>')
//	}*/
//	
//	function inicia(){
//		//interval = setInterval("conta();",1000);
//		interval = setInterval(function(){
//			segundos--;
//			console.log(segundos);
//			if(segundos == 0){
//				
//				clearInterval(interval);
//				alert('OLA');
//				
//			}
//			$('#cronometer').html("<span style='font-size:40px'>"+formatatempo(segundos)+'</span>')				
//		}, 1000)
//	}
//	
//	function para(){
//		clearInterval(interval);
//	}
//	
//	function zera(){
//		clearInterval(interval);
//		segundos = 0;
//		$('#cronometer').html("<span style='font-size:40px'>"+formatatempo(segundos)+'</span>');
//	}
//	///////////////////////////////////////////////////////////////////////////////////
//	$('#start').on('click', function(){
//		inicia();
//	});
//	$('#pause').on('click', function(){
//		para();
//	})
//	$('#restart').on('click', function(){
//		zera();
//	})
//})

chrome.browserAction.onClicked.addListener(function(tab){
		console.log('ok');
		
		
		if(tab.url == "https://simpac.impacta.com.br/simpacweb/modulos/ponto/marcarPonto.php"){
			
			chrome.tabs.executeScript(tab.id, {file:"jquery-1.8.3.js"}, function(){
				
				chrome.tabs.executeScript(tab.id, {file:"script.js"}, function(){
					console.log('loaded scripts');
				});
			});
			
			
		}
		
		
		
		
		/*chrome.tabs.getCurrent(function(tab){
			console.log(tab);
		})*/
	});