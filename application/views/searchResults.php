<?php


function just_clean($string)  
{
//$string = mb_convert_encoding($string,"ISO-8859-1","UTF-8");
$string = preg_replace('/[^[:punct:][:alpha:][:blank:]0-9\-]/', '', $string);  

return $string;  
}

if($bigMp3Size != "")
{
	if(!$controlCount) echo '<div align="center" style="margin-top: 10px; margin-bottom: 30px; color: #009a9a; font-family: Georgia; font-weight: bold;"> Unlucky. Please try again :) <img src="images/hoopss_icon_h20px.png"></div>';
	else echo '<div align="center" style="margin-top: 10px; margin-bottom: 30px; color: #009a9a; font-family: Georgia; font-weight: bold;"> Limited results for random mp3 search</div>';
}
else echo '<div align="center" style="margin-top: 10px; margin-bottom: 30px;"> '. $numberOfRecordsFound .' record(s) found for "<b style="color: #009a9a;">'. str_replace("%20"," ",stripslashes($keyword)) .'</b>" in '.$searchType.'</div>';


$record_file_types =  array("mp3","MP3","wma","WMA","ogg","OGG","flac","FLAC","au","AU");
$playlist = "";
$titles = "";
$counter = 0;
foreach($searchResults as $counter=>$record)
{
	$filename_array = explode("/",$record->link);
	$filename = $filename_array[count($filename_array) - 1];
	$filename_undecoded = $filename;
	$filename = urldecode($filename);
	foreach($record_file_types as $key_mft => $value_mft)
	{
		$filename = str_replace(".".$value_mft,"",$filename);
	}


	$player_link = urlencode($record->link);

	if($record->filesize > (1024*1024)) $filesize = round( ((int)$record->filesize)/(1024*1024),1) . "MB";
	else if($record->filesize > 1024)  $filesize = round( ((int)$record->filesize)/(1024),1) . "KB";
	else $filesize = $record->filesize . "B";
	$file_type = $record->file_type;
	if($searchType == "music")
	{
		$artist = str_replace('"',"",str_replace("'","",addslashes(just_clean($record->artist))));
		$title = str_replace('"',"",str_replace("'","",addslashes(just_clean($record->title))));
		$album = str_replace('"',"",str_replace("'","",addslashes(just_clean($record->album))));
		$year = str_replace('"',"",str_replace("'","",addslashes(just_clean($record->year))));

		if(($record->title != '') && !strstr(just_clean($record->title),"www.")) $listTitle = just_clean($record->title);
		else $listTitle = $filename;
		
		if($record->artist != "") $search = just_clean($record->artist);
		else if($record->title != "") $search = just_clean($record->title);
		else $search = $filename;
	}
	else $search = $filename;

				
?>
				<div style="width: 980px; margin-top: 5px; padding-left: 20px;">
				
				<div style="verticle-align: middle;">
					<button style="float: left; width: <?php if($searchType == "torrent") echo "50px"; else echo "30px";?>; background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; text-align: center;  border: none; margin-top: 2px;"><?php echo $file_type;?></button> 
				</div>
<?php
			if(($searchType == "music" && $record->artist != '') || ($filename != ''))
			{
?>
				<div style="verticle-align: middle;">
<?php 
				if($searchType == "music")
				{
?>
					<button class="wikiButton" onclick="window.open('http://www.wikipedia.org/search-redirect.php?search=<?php echo $search; ?>&language=en&go=Go');" onmouseover="overlib('<div class=floatingInfo><p>Click for <i>Wikipedia</i> information about  <b><?php if($searchType == "music") echo $artist; else echo $filename; ?></b> </p></div>',TEXTCOLOR, '#ffffff', WIDTH, 232, HEIGHT, 54,  PADX, 60, 20, PADY, 20, 20); return true;" onmouseout="nd(); return true;" style="float: left; width: <?php echo ($searchType == "torrent") ? "50px":"30px"; ?>; background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; text-align: center;  border: none; margin-top: 2px;"> i </button>
<?php 
				}
				
				if(isset($searchType) && $searchType == "document" && $file_type == "pdf")
				{
					?>
					<div id="pdfDiv<?php echo $counter; ?>" style="display: none;"><a id="pdf<?php echo $counter; ?>" href="<?php echo $record->link; ?>" class="embed"></a></div>
					<button class="pdfButton" onclick="$('#pdfDiv<?php echo $counter; ?>').dialog({width: 800, height: 600}); $('#pdf<?php echo $counter; ?>').gdocsViewer({width: 600, height: 750});" onmouseover="overlib('<div class=floatingInfo><p>Click to read</p></div>',TEXTCOLOR, '#ffffff', WIDTH, 232, HEIGHT, 54,  PADX, 60, 20, PADY, 20, 20); return true;" onmouseout="nd(); return true;" style="float: left; width: 30px; background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; text-align: center;  border: none; margin-top: 2px;"> view </button>
					
					
				<?php 
				}

				
				if(isset($searchType) && $searchType == "image" && $file_type != "psd" && $file_type != "eps" && $file_type != "ai")
				{
					?>
					<div id="imgDiv<?php echo $counter; ?>" style="display: none;"><img id="img<?php echo $counter; ?>" class="embed" src="" /></div>
					<button class="pdfButton" onclick="$('#img<?php echo $counter; ?>').attr('src','<?php echo $record->link; ?>'); $('#imgDiv<?php echo $counter; ?>').dialog({width: 1000, height: 500});" onmouseover="overlib('<div class=floatingInfo><img id=img<?php echo $counter; ?> href=<?php echo $record->link; ?> class=embed src=<?php echo $record->link; ?> style=\'height: 300px;\' /></div>',TEXTCOLOR, '#ffffff', WIDTH, 232, HEIGHT, 54,  PADX, 60, 20, PADY, 20, 20); return true;" onmouseout="nd(); return true;" style="float: left; width: 30px; background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; text-align: center;  border: none; margin-top: 2px;"> view </button>
				<?php 
				}
				?>
				</div>
<?php
				if(isset($username) && $username != "" && $username != "guest")
			}

				echo '	<div style="float:left; width: 600px; padding-left: 5px;"><a href="'.addslashes($record->link).'" target="_blank"';
                echo ' onmouseover="overlib(\'<div class=floatingInfo>';
                if($searchType == "music")
                	echo ' <p><u><b>Artist:</b></u> '.$artist.'</p><p><u><b>Title:</b></u> '.$title.'</p><p><u><b>Album:</b></u> '.$album.'</p><p><u><b>Year:</b></u> '.$year.'</p>';
                echo ' <p><u><b>Filesize:</b></u> '. $filesize .'</p></div>';
				echo '\',TEXTCOLOR, \'#ffffff\', WIDTH, 432, HEIGHT, 124,  PADX, 60, 20, PADY, 20, 20); return true;" onmouseout="nd(); return true;">';
				if($searchType == "music") echo $listTitle;
				else echo $filename;
				echo '</a> </div> ';

				if($searchType == "music")
				{
					if ($this->agent->is_browser())
					{
					    $agent = $this->agent->browser();
					}
					elseif ($this->agent->is_robot())
					{
					    $agent = $this->agent->robot();
					}
					elseif ($this->agent->is_mobile())
					{
					    $agent = $this->agent->mobile();
					}
					else
					{
					    $agent = 'Unidentified User Agent';
					}
					
					$this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)
				    
					if($browser != "MSIE" && $browser != "Safari")
				    {
				?>
					
						<div>
							<div id="flashplayer<?php echo $record->id; ?>" style=" float:left; padding:0px;"></div> 
							<div class="audio-js-box wp-css" style="float:left; padding:0px;">
								<audio class="audio-js" controls preload data-description="<?php echo ($record->file_type == "mp3" && $record->artist != '') ? $record->artist . ' - ' .  $record->title : $filename;  ?>">
							      <source src="<?php echo $record->link;?>" type="audio/<?php echo $record->file_type; ?>">
							
									<!-- Minimum width of player is 81px -->
									<object type="application/x-shockwave-flash" name="flashplayer<?php echo $record->id; ?>" style="outline: none" data="<?php echo $baseUrl; ?>flash/player.swf" width="290" height="24" id="flashplayer<?php echo $record->id; ?>">
									<param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent">
							      	<param name="menu" value="false">
							      	<param name="flashvars" value="initialvolume=100&amp;leftbg=009a9a&amp;lefticon=ffffff&amp;rightbg=f15a19&amp;righticon=ffffff&amp;rightbghover=006767&amp;righticonhover=ffffff&amp;loader=009a9a&amp;track=cdcdcd&amp;tracker=ababab&amp;border=ffffff&amp;text=323232&amp;volslider=00fdfd&amp;voltrack=ffffff&amp;skip=f15a19&amp;soundFile=<?php echo $playlist; ?>&amp;titles=<?php echo $filename_undecoded; ?>&amp;noinfo=no&amp;encode=no&amp;playerID=flashplayer<?php echo $record->id; ?>">
							      	<param name="quality" value="high">
									<param name="menu" value="false">
									<param name="wmode" value="transparent">
							      </object>
								</audio>
							</div>
						</div>					
				<?php
					
				    }
				    else
				    {
				?>
						<div>
							<object type="application/x-shockwave-flash" name="playlist" style="outline: none" data="<?php echo $baseUrl; ?>flash/player.swf" width="290" height="24" id="playlist"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><param name="menu" value="false"><param name="flashvars" value="initialvolume=100&amp;leftbg=009a9a&amp;lefticon=ffffff&amp;rightbg=f15a19&amp;righticon=ffffff&amp;rightbghover=006767&amp;righticonhover=ffffff&amp;loader=009a9a&amp;track=cdcdcd&amp;tracker=ababab&amp;border=ffffff&amp;text=323232&amp;volslider=00fdfd&amp;voltrack=ffffff&amp;skip=f15a19&amp;soundFile=<?php echo $record->link;?>&amp;titles=<?php echo $filename_undecoded; ?>&amp;noinfo=no&amp;encode=no&amp;playerID=playlist"></object>
					<param name="quality" value="high">
					<param name="menu" value="false">
					<param name="wmode" value="transparent">
						</div>
				<?php        
				    }
				}
	?>

					<div style="clear:both;"></div>
				</div>
<?php
				if(!(int)$counter)
				{
					$playlist .= $player_link;
					$titles .= $filename_undecoded;
				}
				else
				{
					$playlist .= "," . $player_link;
					$titles .= "," . $filename_undecoded;
				}
} // foreach($record = $db->result($record_que))


?>
<script>
		var sd = $('#search_div');
		var sb = $('#searchbox');
		$('#searchbox_mask').css({ "position": "absolute", "z-index": -200, "left": sb.css('left'), "top": sb.css('top'), "background": "white", "color": "#666", "width": sb.css('width'), "height": sb.css('height') });
		var myTop = sb.offset().top+3;
		var myLeft = sb.offset().left+2;
</script>
<?php 


?>
