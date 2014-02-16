<div id="menu4" class="footer" style="cursor: pointer; bottom: 30px; height: 30px; width: 200px; left: 9px; text-align: left; background: #fff; border-left: 1px solid #f15a19; border-top: 1px solid #f15a19; border-right: 1px solid #f15a19;  color: #006767; display: none;">
	<div style="padding: 5px; float: left;"><img style="height: 20px;" src="<?php echo $baseUrl; ?>images/hoopss_icon_h20px.png"><span style="padding-bottom: 0px; padding-left: 5px; height: 20px;">Logout</span></div>
</div>

<script>
		$("#menu4").click(function() {
			if(4 != 2)
				window.location='logout.php';
			else {
				$("#login").css("display","block");
				$("#login").dialog({
								title: "Hoopss Login",
								width: 350,
								height: 200,
								position: 'middle',
								closeOnEscape: true,
								modal: true,
								hide: {effect: "fadeOut", duration: 300},
								show: {effect: "fadeIn", duration: 300},
								close: function() {
									$(this).dialog("destroy");
								}
  						});
			}
		});
		
		$("#menu4").mouseover(function() {
			$(this).css({ "background":"#f15a19", "color":"#fff" });
			$(this).mouseout(function() {
				$(this).css({ "background":"#fff", "color":"#009a9a" });
			});
		});

		menu_items.push({"item": "menu4", "visible":1});
	</script>
<div id="menu3" class="footer" style="cursor: pointer; bottom: 60px; height: 30px; width: 200px; left: 9px; text-align: left; background: #fff; border-left: 1px solid #f15a19; border-top: 1px solid #f15a19; border-right: 1px solid #f15a19; border-bottom: 1px solid #f15a19; color: #006767; display: none;">
	<div style="padding: 5px; float: left;"><img style="height: 20px;" src="<?php echo $baseUrl; ?>images/hoopss_icon_h20px.png"><span style="padding-bottom: 0px; padding-left: 5px; height: 20px;">FAQ</span></div>
</div>

<script>
		$("#menu3").click(function() {
			if(3 != 2)
				window.location='/';
			else {
				$("#login").css("display","block");
				$("#login").dialog({
								title: "Hoopss Login",
								width: 350,
								height: 200,
								position: 'middle',
								closeOnEscape: true,
								modal: true,
								hide: {effect: "fadeOut", duration: 300},
								show: {effect: "fadeIn", duration: 300},
								close: function() {
									$(this).dialog("destroy");
								}
  						});
			}
		});
		
		$("#menu3").mouseover(function() {
			$(this).css({ "background":"#f15a19", "color":"#fff" });
			$(this).mouseout(function() {
				$(this).css({ "background":"#fff", "color":"#009a9a" });
			});
		});

		menu_items.push({"item": "menu3", "visible":1});
	</script>

<div id="faq" style="display: none;">

</div>

<script>
		$("#menu5").click(function() {
			if(5 != 2)
				window.location='http://www.last.fm/api/auth/?api_key=5aa046f1f3f2b397dd7cbc768d2515ea';
			else {
				$("#login").css("display","block");
				$("#login").dialog({
								title: "Hoopss Login",
								width: 350,
								height: 200,
								position: 'middle',
								closeOnEscape: true,
								modal: true,
								hide: {effect: "fadeOut", duration: 300},
								show: {effect: "fadeIn", duration: 300},
								close: function() {
									$(this).dialog("destroy");
								}
  						});
			}
		});
		
		$("#menu5").mouseover(function() {
			$(this).css({ "background":"#f15a19", "color":"#fff" });
			$(this).mouseout(function() {
				$(this).css({ "background":"#fff", "color":"#009a9a" });
			});
		});

		menu_items.push({"item": "menu5", "visible":1});
	</script>
<div id="menu2" class="footer" style="cursor: pointer; bottom: 90px; height: 30px; width: 200px; left: 9px; text-align: left; background: #fff; border-left: 1px solid #f15a19; border-top: 1px solid #f15a19; border-right: 1px solid #f15a19; border-bottom: 1px solid #f15a19; color: #006767; display: none;">
	<div style="padding: 5px; float: left;"><img style="height: 20px;" src="<?php echo $baseUrl; ?>images/hoopss_icon_h20px.png"><span style="padding-bottom: 0px; padding-left: 5px; height: 20px;">Login</span></div>
</div>


<script>
		$("#menu2").click(function() {
			if(2 != 2)
				window.location='/';
			else {
				$("#login").css("display","block");
				$("#login").dialog({
								title: "Hoopss Login",
								width: 350,
								height: 200,
								position: 'middle',
								closeOnEscape: true,
								modal: true,
								hide: {effect: "fadeOut", duration: 300},
								show: {effect: "fadeIn", duration: 300},
								close: function() {
									$(this).dialog("destroy");
								}
  						});
			}
		});
		
		$("#menu2").mouseover(function() {
			$(this).css({ "background":"#f15a19", "color":"#fff" });
			$(this).mouseout(function() {
				$(this).css({ "background":"#fff", "color":"#009a9a" });
			});
		});

		menu_items.push({"item": "menu2", "visible":1});
	</script>
	
<div id="menu1" class="footer" style="cursor: pointer; bottom: 120px; height: 30px; width: 200px; left: 9px; text-align: left; background: #fff; border-left: 1px solid #f15a19; border-top: 1px solid #f15a19; border-right: 1px solid #f15a19; border-bottom: 1px solid #f15a19; color: #006767; display: none;">
	<div style="padding: 5px; float: left;"><img style="height: 20px;" src="<?php echo $baseUrl; ?>images/hoopss_icon_h20px.png"><span style="padding-bottom: 0px; padding-left: 5px; height: 20px;">Hoopss</span></div>
</div>

<script>
		$("#menu1").click(function() {
			if(1 != 2)
				window.location='/';
			else {
				$("#login").css("display","block");
				$("#login").dialog({
								title: "Hoopss Login",
								width: 350,
								height: 200,
								position: 'middle',
								closeOnEscape: true,
								modal: true,
								hide: {effect: "fadeOut", duration: 300},
								show: {effect: "fadeIn", duration: 300},
								close: function() {
									$(this).dialog("destroy");
								}
  						});
			}
		});
		
		$("#menu1").mouseover(function() {
			$(this).css({ "background":"#f15a19", "color":"#fff" });
			$(this).mouseout(function() {
				$(this).css({ "background":"#fff", "color":"#009a9a" });
			});
		});

		menu_items.push({"item": "menu1", "visible":1});
	</script>
<div id="login" style="display: none;">
		<input type="hidden" name="login" value="1" />
		<input type="hidden" name="keyword" value="" />
		<input type="hidden" name="searchType" value="" />
			<div id="username"><span style="font-size: 16px; font-weight: bold;">Username: </span><span style="padding-left: 10px;"><input id="usernameInput" type="text" name="username" /></span></div>
			<div id="password" style="margin-top: 10px;"><span style="font-size: 16px; font-weight: bold;">Password: </span><span style="padding-left: 15px;"><input id="passwordInput" type="password" name="password" /></span></div>
			<div id="send" style="text-align: right; margin-top: 20px;"><button id="login_button" class="button">Login</button></div>
</div>

<script>
		$("#login_button").click(function(){
			var username = $("#usernameInput").val();
			var password = $("#passwordInput").val();

			if(username == '') {
				alert("Please enter a username");
				return false;
			}
			else if(password == '') {
				alert("Please enter a password");
				return false;
			}
			else {
				$.post("<?php echo $baseUrl; ?>login",{"username": username, "password": password},function(returned) {
 					if(returned.success) {
						$("#userInfo").html(returned.data.name + ' ' + returned.data.surname);
						var index = 0;
						for(var i = menu_items.length - 1; i >= 0; i--) {
						    if(menu_items[i].item === 'menu2') {
								index = i;
						     	menu_items[i].visible = 0;
						    }
						}
						$("#menu2").hide();
					}
 				},"json");
				$("#login").dialog("destroy");
			}
		});
</script>

<div id="footer" class="footer" align="center">
	<span id="start" style="display: inline-block; border: 3px solid white; float: left; background: white; width: 40px; margin-left: 10px; position: absolute; top: -1px; left: 0px;"><img src="<?php echo $baseUrl; ?>images/hoopss_sonsuzluk.png" style="height: 20px;"></span>
	<span id="userInfo" style="display: inline-block; float: left; width: auto; position: absolute; top: 7px; left: 70px;"></span>
						
	<span>&copy; HOOPSS.com &nbsp;&nbsp; </span>
	<span>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	</span>
	<span style="float: right; margin-right: 4px;">
		<div style="float: left; position:relative; top: -4px;"><button style="padding-top: 3px; background: #fff; color: #009a9a; font-size: 9px; width: 22px; height: 23px; font-weight: bold; border-collapse: collapse; border: none;" id="random_mp3" title="Random MP3 search">mp3</button></div>
<!--		<div style="float: left; width: 4px;">&nbsp;</div>
		<div style="float: left; position:relative; top: -4px;"><button style="padding-top: 3px; background: #fff; color: #009a9a; font-size: 9px; width: 22px; height: 23px; font-weight: bold; border-collapse: collapse; border: none;" id="random_pdf" title="Random PDF search">pdf</button></div>
		<div style="float: left; width: 4px;">&nbsp;</div>
		<div style="float: left; position:relative; top: -4px;"><button style="padding-top: 3px; background: #fff; color: #009a9a; font-size: 9px; width: 22px; height: 23px; font-weight: bold; border-collapse: collapse; border: none;" id="random_rar" title="Random RAR search">rar</button></div>
		<div style="float: left; width: 4px;">&nbsp;</div>
		<div style="float: left; position:relative; top: -4px;"><img src="http://www.exporena.com/images/torrent_logo.png" style="padding-top: 3px; background: #fff; color: #009a9a; font-size: 9px; height: 20px; font-weight: bold; border-collapse: collapse; border: none;" id="random_torrent" title="Random torrent video search"></div>-->
		<div style="float: left; width: 4px;">&nbsp;</div>
		<div style="float: left;"><img style="height: 19px;" src="<?php echo $baseUrl; ?>favicon.ico"></div>
	</span>
</div>

<script>
	$(document).ready(function() {
		window.mySubmit = function() {
			
			if($('#searchbox').attr('value') == '')
			{
				alert('Hoopss, cannot search the void! :)');
				return false;
			}
			else
			{
				window.location = '<?php echo $baseUrl; ?>search/searchResults/'+$('input[name=searchType]:checked').val()+'/'+$('#searchbox').val();
				return true;
			}
		}

		$("#searchbox").autocomplete({
			source: "<?php echo $baseUrl; ?>search/ajaxKeywordlist/",
			autoFill: true
		});

		$("#searchbox").keyup(function(e) {
			if(e.keyCode == '13')
			{
				window.mySubmit();
			}
		});

		$("#search_button").click(function() {
			window.mySubmit();
		});

		$("#random_mp3").click(function() {
				$("#searchbox").attr("value","");
				$("#music_radio").attr("checked",'true');
				$("#music_types").parent().hide();
				$("#search_results").html('<div align="center" style="width: 100%; margin-top: 40px;"><img src="<?php echo $baseUrl; ?>images/loading.gif"></div>');
				var keyword = "";
				/*
				$.post("<?php echo $baseUrl; ?>search/searchResults/", { "searchType":"music", "keyword":"" },
					function(returned) {
						$("#search_results").html(returned.replace("&amp;","&"));
					}
				);
				*/
				window.location='<?php echo $baseUrl; ?>search/searchResults/music/';
		});

		$("#random_pdf").click(function() {
				$("#searchbox").attr("value","");
				$("#document_radio").attr("checked",'true');
				$("#document_types").parent().hide();
				$("#search_results").html('<div align="center" style="width: 100%; margin-top: 40px;"><img src="<?php echo $baseUrl; ?>images/loading.gif"></div>');
				var keyword = "  Sexual Eruption";
				$.post("secici.php", { "searchType":"document", "keyword":"" },
					function(returned) {
						$("#search_results").html(returned.replace("&amp;","&"));
					}
				);
		});

		$("#random_rar").click(function() {
				$("#searchbox").attr("value","");
				$("#archive_radio").attr("checked",'true');
				$("#archive_types").parent().hide();
				$("#search_results").html('<div align="center" style="width: 100%; margin-top: 40px;"><img src="<?php echo $baseUrl; ?>images/loading.gif"></div>');
				var keyword = "  Sexual Eruption";
				$.post("secici.php", { "searchType":"archive", "keyword":"" },
					function(returned) {
						$("#search_results").html(returned.replace("&amp;","&"));
					}
				);
		});

		$("#random_torrent").click(function() {
				$("#searchbox").attr("value","");
				$("#torrent_radio").attr("checked",'true');
				$("#document_types").parent().hide();
				$("#search_results").html('<div align="center" style="width: 100%; margin-top: 40px;"><img src="<?php echo $baseUrl; ?>images/loading.gif"></div>');
				var keyword = "  Sexual Eruption";
				$.post("secici.php", { "searchType":"document", "keyword":"" },
					function(returned) {
						$("#search_results").html(returned.replace("&amp;","&"));
					}
				);
		});

		
		var start_clicked = false;
		$("#start").click(function() {
			if(!start_clicked)
				for(var j in menu_items) {
					if(menu_items[j].visible) $("#"+menu_items[j].item).show();
				}
			else
				for(var j in menu_items) $("#"+menu_items[j].item).hide();
			start_clicked = !start_clicked;
		});

		$(document).click(function(e) {
			if( (e.pageY < $("#start").offset().top) || (e.pageX > ($("#start").offset().left + $("#start").width())) ) {
				for(var j in menu_items) $("#"+menu_items[j].item).hide();
				start_clicked = false;
			}
		});

		$("#"+searchType+"_radio").click();
	});
</script>

  <script>
    // Run the script on page load.

    // If using jQuery
    // $(function(){
    //   AudioJS.setup();
    // });

    // If using Prototype
    // document.observe("dom:loaded", function() {
    //   AudioJS.setup();
    // });

    // If not using a JS library
    // (function(){
    //   AudioJS.setup();
    // });

    // Since I'm calling this at the end of the HTML, I can probably get away
    // with executing the setup without waiting for a load event. 
    AudioJS.setup(false, {controlsAtStart: true});
  </script>
 
<script type="text/javascript" src="http://coinurl.com/script/jquery.cookie.js"></script>
<script type="text/javascript" src="http://coinurl.com/script/md5.js"></script>

</body>
</html>
