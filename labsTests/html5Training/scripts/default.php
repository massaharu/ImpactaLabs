<!DOCTYPE html>
<html>
	<head>
		<title>HTML Training</title>
		
		<style type="text/css">
			body *{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			}
			.pic{
				transition: all 2500ms;
			}
			.pic:hover{
				width:50px;
				-webkit-transform: scale(3) translate(50px, 50px) rotate(2060deg);
			}
			p:hover{
				color:red;
			}
			nav#main{
				border:1px solid ##FFEEFF;
				display:block;
				margin:0 auto;
				width:1050px;
			}
			nav#main > ul{
				list-style:none;
			}
			nav#main > ul li{
				display:inline-block;
				margin:-3px;
				background:purple;
				line-height:35px;
				transition: all 300ms;
			}
			nav#main > ul li:hover{
				opacity:0.5;
			}
			nav#main > ul li a{
				text-decoration: none;
				color: #FFFFFF;
				display: inline-block;
				width: 145px;
				font-weight:bold;
				text-align:center;
			}
			aside{
				padding:10px;
				margin-top:20px;
				float:left;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			aside nav ul{
				list-style:none;
				display:block;
			}
			aside nav > ul li{
				background:purple;
				transition: all 300ms;
				line-height:35px;
			}
			aside nav > ul li a{
				padding:20px;
				text-decoration: none;
				color: #FFFFFF;
				width: 140px;
				font-weight:bold;
				text-align:center;
			}
			aside nav > ul li:hover{
				opacity:0.5;
			}
			section{
				display:block;
			}
		</style>
	</head>
	<nav id="main">
		<ul>
			<li><a href="dragndrop.php">Drag'n Drop</a></li>
			<li><a href="geolocation.php">Geolocation</a></li>
			<li><a href="videoaudio.php">Video/Audio</a> </li>
			<li><a href="localstorage.php">Local Storage</a></li>
			<li><a href="worker.php">Web Worker</a></li>
			<li><a href="serversentevent.php">Server-Sent Events</a></li>
			<li><a href="canvas.php">Canvas</a></li>
		</ul>
	</nav>
	<aside>
		<nav>
			<ul>
				<li><a href="ajax_get.php">Ajax (GET)</a></li>
				<li><a href="ajax_post.php">Ajax (POST)</a></li>
				<li><a href="ajax_hint.php">Hint with Ajax</a> </li>
				<li><a href="localstorage.php">Local Storage</a></li>
				<li><a href="worker.php">Web Worker</a></li>
				<li><a href="serversentevent.php">Server-Sent Events</a></li>
				<li><a href="canvas.php">Canvas</a></li>
			</ul>
		</nav>
	</aside>
	<section>
		<hgroup>
			<h1>Markup</h1>
			<h2>Demo</h2>
		</hgroup>
		<p>Favorites: </p>
		<form>
			<input id="favUrl" type="url" required placeholder="http://www.example.com" />
			<input type="submit" value="Submit" />
		</form>
		<audio src="" id="claps"></audio>
		<div class="pic">
			<img src="img/palmeiras.png">
		</div>
	</section>
	<footer>
	</footer>
</html>