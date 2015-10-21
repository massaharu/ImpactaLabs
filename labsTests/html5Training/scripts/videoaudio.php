<!DOCTYPE html> 
<html> 
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script> 
		
		$(function(){
			var myVideo = document.getElementById("video1"); 
			console.log(myVideo);
			function playPause(){ 
				if (myVideo.paused) 
				  myVideo.play(); 
				else 
				  myVideo.pause(); 
			} 
			
			function makeBig(){ 
				myVideo.width=560; 
			} 
			
			function makeSmall(){ 
				myVideo.width=320; 
			} 
			
			function makeNormal(){ 
				myVideo.width=420; 
			} 
		});
	</script> 
</head>
<body> 

<div style="text-align:center"> 
  <button onclick="playPause()">Play/Pause</button> 
  <button onclick="makeBig()">Big</button>
  <button onclick="makeSmall()">Small</button>
  <button onclick="makeNormal()">Normal</button>
  <br> 
  <video id="video1" width="420" controls>
    <source src="http://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
    <source src="http://www.w3schools.com/html/mov_bbb.ogg" type="video/ogg">
    Your browser does not support HTML5 video.
  </video>
</div> 



<p>Video courtesy of <a href="http://www.bigbuckbunny.org/" target="_blank">Big Buck Bunny</a>.</p>
</body> 
</html>
