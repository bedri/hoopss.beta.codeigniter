<?php 

ob_start();
@error_reporting(E_ALL);
@ini_set("display_errors","1");

mb_internal_encoding("UTF-8");
mb_language("tr");
mb_substitute_character(197);

@set_time_limit(0);

?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=UTF-8" itemprop="charset" />
<title>Hoopss</title>
<link rel="shortcut icon" href="<?php echo $baseUrl; ?>favicon.ico" itemprop="favicon" />
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>css/hoopss.css" itemprop="stylesheet" />


<script type="text/javascript" src="<?php echo $baseUrl; ?>javascript/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>javascript/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo $baseUrl; ?>css/start/jquery-ui-1.8.16.custom.css" type="text/css" />


<!-- Global Variables -->
<script>
	var menu_items = new Array();
<?php 
if(isset($searchType) && $searchType != '') echo 'var searchType="'.$searchType.'";';
else echo 'var searchType = "music";';
?>
	var userid = "";
</script>


    
<script src="<?php echo $baseUrl; ?>kutuphane/audioplayer/audio-player-html5/js/audio.js"></script>
<script src="<?php echo $baseUrl; ?>javascript/modernizr.js"></script>
<link rel="stylesheet" href="<?php echo $baseUrl; ?>kutuphane/audioplayer/audio-player-html5/css/audio.css" type="text/css" />
   
<!-- 
<script type="text/javascript" src="<?php echo $baseUrl; ?>javascript/audio-player.js"></script>
<script type="text/javascript">  
	AudioPlayer.setup("<?php echo $baseUrl; ?>flash/player.swf", {  
		width: 290,  
		initialvolume: 100,  
		transparentpagebg: "yes",
		leftbg: "009a9a",
		lefticon: "ffffff",
		rightbg: "f15a19",
		righticon: "ffffff",
		rightbghover: "006767",
		righticonhover: "ffffff",
		loader: "009a9a",
		track: "cdcdcd",
		tracker: "ababab",
		border: "ffffff",
		text: "323232",
		volslider: "00fdfd",
		voltrack: "ffffff",
		skip: "f15a19"
	});
</script>
 -->

<script type="text/javascript" src="<?php echo $baseUrl; ?>javascript/sound.js"></script>

    <script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">
      google.load("swfobject", "2.1");
    </script>    

<script>


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-6068034-8']);
  _gaq.push(['_trackPageview']);

(function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();


</script>

<meta name="keywords" content="wikipedia,encyclopedia,free,mp3,music,document,manual,manuel,doc,pdf,free music,free mp3,free pdf,free doc,free document,free video,video,search,search free,<?php echo $keywordString; ?>" />

<?php 
if(isset($searchType) && $searchType == "document")
{
?>

<script type="text/javascript" src="<?php echo $baseUrl; ?>kutuphane/gdocsview/jquery.gdocsviewer.min.js"></script> 
<style type="text/css">
/* Style the second URL with a red border */
#test-gdocsviewer {
	border: 5px red solid;
	padding: 20px;
	width: 650px;
	background: #ccc;
	text-align: center;
}
/* Style all gdocsviewer containers */
.gdocsviewer {
	margin:10px;
}
</style>

<?php
}
?>

<!-- CoinURL script -->
<script type="text/javascript">
$(function() {
    var include = Array('.mp3','.MP3','.wma','.WMA','.ogg','.OGG','.flac','.FLAC','.au','.AU','.pdf','.PDF','.doc','.DOC','.mobi','.MOBI','.lit','.LIT','.docx','.DOCX','.txt','.TXT','.ps','.PS','.rtf','.RTF','.xls','.XLS','.ppt','.PPT','.pps','.PPS','.xlsx','.XLSX','.sql','.SQL','.sub','.SUB','.srt','.SRT','.djvu','.DJVU','.sit','.SIT','.webm','.WEBM','.ogv','.OGV','.mp4','.MP4','.m4v','.M4V','.avi','.AVI','.flv','.FLV','.mkv','.MKV','.divx','.DIVX','.mpeg','.MPEG','.mpg','.MPG','.wmv','.WMV','.asf','.ASF','.zip','.ZIP','.rar','.RAR','.iso','.ISO','.nrg','.NRG','.mdb','.MDB','.cue','.CUE','.dwg','.DWG','.torrent','.TORRENT','.apk','.APK','.TIFF','.BMP','.psd','.PSD','.eps','.EPS','.ai','.AI');
    //Leave empty to convert all links on the page or specify keywords
    //which URL must contain to be processed
    
    var exclude = Array();
    //Specify keywords which URL must not contain to be processed
    
    var id = "2fa7fdc714d115e041aad0992c8804b2";
    var redirect = "http://coinurl.com/redirect.php?id=" + id + "&url=";
    var links = $("a[href^='http']");
    
    for(var i = 0; i < links.length; i++) {
        var url = $(links[i]).attr("href");
        
        var deny = false;
        for(var j = 0; j < exclude.length; j++) {
            if(url.indexOf(exclude[j]) != -1) {
                deny = true;
                break;
            }
        }
        if(deny) {
            continue;
        }
        
        if(include.length > 0) {
            var allow = false;
            for(var j = 0; j < include.length; j++) {
                if(url.indexOf(include[j]) != -1) {
                    allow = true;
                    break;
                }
            }
            if(!allow) {
                continue;
            }
        }
        
        $(links[i]).attr("href",  redirect + encodeURIComponent(url));
    }
});
</script>
</head>
<body onload="$('#searchbox').focus();// $('#searchbox').val('<?php echo $keyword; ?>');">


<!-- Courtesy of SimplytheBest.net - http://simplythebest.net/scripts/ -->
<div id="overDiv" style="position:absolute; visibility:hide; z-index:1;">
</div>
<script src="<?php echo $baseUrl; ?>javascript/overlib.js"></script>


<div id="header" style="margin-top: 10px; text-align: center;">
<img src="<?php echo $baseUrl; ?>images/hoopss_logo.png" border="none" style="cursor: pointer;" onclick="window.location='<?php echo $baseUrl; ?>';" /></div>

<div style="margin-top: 20px; text-align: center;">

<input type="hidden" name="posta_adi" value="1" />
<div>
    <div style="color: #f95A19; font-weight: bold;">
    <input id="music_radio" class="button" style="width: 20px;"
        type="radio" name="searchType" value="music"
        onclick="if(this.checked) { $('#music_types').css('display','inline'); $('#video_types').css('display','none'); $('#document_types').css('display','none'); $('#archive_types').css('display','none'); $('#android_types').css('display','none'); $('#image_types').css('display','none'); $('#torrent_types').css('display','none'); } $('#searchbox').focus();" />
    Music
  
    <input id="document_radio" class="button" style="width: 20px;" type="radio"
        name="searchType" value="document"
        onclick="if(this.checked) { $('#document_types').css('display','inline'); $('#music_types').css('display','none'); $('#video_types').css('display','none'); $('#archive_types').css('display','none'); $('#android_types').css('display','none'); $('#image_types').css('display','none'); $('#torrent_types').css('display','none');} $('#searchbox').focus();" />

    Document

    <input id="archive_radio" class="button" style="width: 20px;" type="radio"
        name="searchType" value="archive"
        onclick="if(this.checked) { $('#archive_types').css('display','inline'); $('#music_types').css('display','none'); $('#document_types').css('display','none'); $('#video_types').css('display','none'); $('#android_types').css('display','none'); $('#image_types').css('display','none'); $('#torrent_types').css('display','none'); } $('#searchbox').focus();" />
   Archive

    <input id="video_radio" class="button" style="width: 20px;" type="radio"
        name="searchType" value="video"
        onclick="if(this.checked) { $('#video_types').css('display','inline'); $('#music_types').css('display','none'); $('#document_types').css('display','none'); $('#archive_types').css('display','none'); $('#android_types').css('display','none'); $('#image_types').css('display','none'); $('#torrent_types').css('display','none'); } $('#searchbox').focus();" />
   Video

    <input id="image_radio" class="button" style="width: 20px;" type="radio"
        name="searchType" value="image"
        onclick="if(this.checked) { $('#video_types').css('display','none'); $('#music_types').css('display','none'); $('#document_types').css('display','none'); $('#archive_types').css('display','none'); $('#image_types').css('display','inline'); $('#torrent_types').css('display','none'); $('#android_types').css('display','none'); } $('#searchbox').focus();" />
   Image

   <input id="android_radio" class="button" style="width: 20px;" type="radio"
        name="searchType" value="android"
        onclick="if(this.checked) {  $('#android_types').css('display','inline'); $('#image_types').css('display','none'); $('#torrent_types').css('display','none'); $('#music_types').css('display','none'); $('#document_types').css('display','none'); $('#video_types').css('display','none'); } $('#searchbox').focus();" />
   Android

   
   <input id="torrent_radio" class="button" style="width: 20px;" type="radio"
        name="searchType" value="torrent"
        onclick="if(this.checked) { $('#torrent_types').css('display','inline'); $('#image_types').css('display','none'); $('#music_types').css('display','none'); $('#document_types').css('display','none'); $('#archive_types').css('display','none'); $('#video_types').css('display','none'); $('#android_types').css('display','none'); } $('#searchbox').focus();" />
   Torrent

   </div>
   </div>
</div>

<div id="search_div" style="margin-top: 20px; ">
		<div style="width:700px; height:28px; margin: 0 auto; border-collapse: collapse; border: 1px solid #009a9a; ">
             <div id="search_button"></div>
			<input id="searchbox" type="text" name="keyword" value="" style="border:0px; margin-top: 20px auto 20px auto; color: #565656; background: transparent;" value=""/>
			<!--<button id="search_button" style="float: right; height: 26px; border: none; position: relative; background: transparent; <?php if(!isset($searchType) || !$controlCount) { ?> left: -24px; top: -24px; <?php } else { ?> left: -150px; top: 2px; <?php } ?>"><img src="<?php echo $baseUrl; ?>images/hoopss_icon_h20px.png"></button>-->
		</div>
<?php
	if(!isset($searchType))
	{
?>
			<div style="width:700px; margin: 10px auto; color: #676767; "> 
				<div id="music_types" style="display: inline;"><em>mp3,wma,ogg,flac,au</em></div>
				<div id="document_types" style="display: none;"><em>pdf,lit,mobi,doc,docx,txt,rtf,ps,odt</em></div>
				<div id="archive_types" style="display: none;"><em>zip,rar,tar,gz,z,bz2,7z,iso,nrg</em></div>
				<div id="video_types" style="display: none;"><em>avi,wmv,mpg,mpeg,flv,divx,mkv,asf,mp4</em></div>
				<div id="image_types" style="display: none;"><em>jpg,gif,esp,png,tiff,psd,svg</em></div>
				<div id="android_types" style="display: none;"><em>apk</em></div>
				<div id="torrent_types" style="display: none;"><em>torrent</em></div>
			</div>

</div>

<?php
	}
	else
	{
?>
<?php
	}
?>
<div id="coinUrlAd" style="width: 468px; height: 60px; clear: both; margin: 15px auto 3px; text-align: center; background-color:#333"><iframe scrolling="no" style="border: 0; width: 468px; height: 60px;" src="http://coinurl.com/get.php?id=17890"></iframe></div>
