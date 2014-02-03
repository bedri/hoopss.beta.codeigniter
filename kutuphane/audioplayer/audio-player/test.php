 <html>  
	     <head>  
		         <title>Your website</title>
		 <script type="text/javascript" src="audio-player.js"></script>  
		         <script type="text/javascript">  
 AudioPlayer.setup("player.swf", {  
	         width: 290,  
	         initialvolume: 100,  
	         transparentpagebg: "yes",  
	         left: "000000",  
	         lefticon: "FFFFFF"  
	     });
			         </script>

		 </head>  
	     <body>  
		   
		         <p id="audioplayer_1">Alternative content</p>  
		         <script type="text/javascript">  
AudioPlayer.embed("audioplayer_1", {soundFile: "<?php echo urldecode('http://www2.muzikdinle.co.uk/Arsiv/a/Ayca-Sen/Astronot/Ay%C3%A7a%20Pen%20-%20Aptal%20Gibi.mp3'); ?>"});  
			         </script>  
		   
		         <p id="audioplayer_2">Alternative content</p>  
		         <script type="text/javascript">  
			         AudioPlayer.embed("audioplayer_2", {soundFile: "<?php echo urldecode('http://www2.muzikdinle.co.uk/Arsiv/o/Ozan-Dogulu/130BPM/02.%20Unutmamal%C4%B1%20feat.%20Tarkan.mp3'); ?>"});  
			         </script>  
		   
		     </body>  
	 </html>
