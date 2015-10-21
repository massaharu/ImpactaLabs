<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		var w;

		function startWorker(){
			if(typeof(Worker)!=="undefined"){
				if(typeof(w)=="undefined"){

					w=new Worker("js/demo_worker.js");
				}
				
				w.onmessage = function (event) {
					document.getElementById("result").innerHTML=event.data;
				};
			}else{
				document.getElementById("result").innerHTML="Sorry, your browser does not support Web Workers...";
			}
		}

		function stopWorker()
		{ 
			w.terminate();
		}
	</script>
</head>
<body>
	<p>Count numbers: <output id="result"></output></p>
	<button onclick="startWorker()">Start Worker</button> 
	<button onclick="stopWorker()">Stop Worker</button>
</body>
</html>