<!DOCTYPE HTML>
<html>
<head>
	<style type="text/css">
	#div1, #div2{
		float:left; width:150px; height:55px; margin:10px;padding:10px;border:1px solid #aaaaaa;
	}
	</style>
	<script>
		function allowDrop(ev)
		{
			ev.preventDefault();
		}

		function drag(ev)
		{
			ev.dataTransfer.setData("Text",ev.target.id);
		}

		function drop(ev)
		{
			ev.preventDefault();
			var data=ev.dataTransfer.getData("Text");
			ev.target.appendChild(document.getElementById(data));
		}
	</script>
</head>
<body>

	<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
		<img src="img/palmeiras.png" draggable="true" ondragstart="drag(event)" id="drag1" width="48" height="51">
	</div>
	<div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

</body>
</html>