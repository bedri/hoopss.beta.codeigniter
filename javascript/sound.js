/* Cool Javascript MP3 Playback in Web Page with Custom Controls
Version 1.2b
By Jeff Baker 
Created October 12, 2007
Copyright 2007 by Jeff Baker
www.seabreezecomputers.com
*/
var folder = ''; // if your songs are in a different folder specify it here
// example: var folder = 'music/'; 

var t; // for volume timer
var t2; // for song time display timer
var t3; // used for fast_reverse in media player

var current_song = 0; // start at song 0 in playlist
var fade_out = 0; // 0 = no fade out when stopping or changing songs
// change to fade_out = 1 for fade volume between songs
// or you can use the fade out button

var songs = new Array(); // will hold the playlist of songs
var media; // holds the filename of the current song

function loadsongs()
{
	
	var songs_list = document.getElementById('songlist').innerHTML;
	var songs_list_length = songs_list.length;

	
	// Remove all CRs (13) from IE's textarea
	songs_list = songs_list.replace(/\r/gi, "");
	// first remove first carriage return if there is one
	// IE = CRLF (1310)
	// Firefox + Netscape = LF (10)
	// Safari = LFLF (1010)
	// So the first if statement is for IE and Safari
	// to check for LF on the second character
	if (songs_list.charAt(1) == '\n')
		songs_list = songs_list.substr(1);
	if (songs_list.charAt(0) == '\n')
		songs_list = songs_list.substr(1);
	// now remove carriage return from the end of string if there is one
	// first if needed for Safari
	// second if needed for netscape and firefox
	if (songs_list.charAt(songs_list_length-3) == '\n')
		songs_list = songs_list.substr(0, songs_list_length-3);
	if (songs_list.charAt(songs_list_length-2) == '\n')
		songs_list = songs_list.substr(0, songs_list_length-2);
	if (songs_list.charAt(songs_list_length-1) == '\n')
		songs_list = songs_list.substr(0, songs_list_length-1);

		
	// Note: IE will only split a TEXTAREA by \n. It will not
	// work with a DIV
	songs = songs_list.split('\n');
	
	media = songs[0]; // media becomes first song in list
	
	display_song();

}  // function loadsongs()



// Make a DIV to hold the player and place it off the screen
// so that we don't see it
document.write('<DIV ID="player"'
+ 'style="position:absolute;left:-1000px;top:-1000px"'
+ '></DIV>');

function load(media)
{  

media = folder + media;

var player = document.getElementById('player'); 

if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
{ 
player.innerHTML = '<object id="sound"' 
+ 'classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6"'
+ 'codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"'
+ 'standby="Loading Microsoft® Windows® Media Player components..."'  
+ 'type="application/x-oleobject" width="160" height="144">'                
+ '<param name="url" value="'+media+'">'      
+ '<param name="volume" value="100">'            
+ '<embed id="sound" type="application/x-mplayer2" src="'+media+'"' 
+ 'classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6"'
+ 'pluginspage="http://www.microsoft.com/Windows/MediaPlayer/"'
+ 'type="application/x-mplayer2"'
+ 'url="'+media+'"' 
+ 'volume="100"' 
+ 'width="160" height="144">'               
+ '<\/embed>'
+ '<\/object>';
}
else // if Safari or Firefox, then load Quicktime controls
{
player.innerHTML = '<object '
+ 'classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" '
+ 'width="160" height="144" id="sound"'
+ 'style="position:absolute;left:-1000px;top:-1000px"'
+ 'codebase="http://www.apple.com/qtactivex/qtplugin.cab">'
+ '<param name="SRC" value="'+media+'">'
+ '<param name="AUTOPLAY" value="true">'
+ '<param name="CONTROLLER" value="false">'
+ '<param name="VOLUME" value="100">'
+ '<param name="ENABLEJAVASCRIPT" value="true">'
+ '<param name="TYPE" value="audio/wav">'
+ '<embed classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"' 
+ 'name="sound"'
+ 'id="sound"' 
+ 'src="'+media+'"' 
+ 'pluginspage="http://www.apple.com/quicktime/download/"'
+ 'volume="100"' 
+ 'enablejavascript="true" '
+ 'type="audio/wav" '
+ 'height="16" '
+ 'width="200"'
+ 'style="position:absolute;left:-1000px;top:-1000px"'
+ 'autostart="true"'
+ '> </embed>'
+ '</object>';
}

} // end function load(media)

function play_song()
{
	// Check to see if current song has stopped
	if (document.getElementById('player').innerHTML == '')
	{
		load(media);
		setTimeout('display_time();', 1000);
		setTimeout('display_info();', 1000);
		display_song();	
	}
	else // otherwise wait until it has 
		setTimeout('play_song()', 500);
}  // end function play

function stop_song()
{
	var done;
	var mseconds; // milliseconds
	var player = document.getElementById('player'); 
	
	// if IE or Netscape then Media Player Pause Controls
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
		mseconds = 500;
	else // if Firefox
		mseconds = 200;
	
	if (document.getElementById('player').innerHTML != '')
	if (fade_out == 1) // if we are fading the volume
	{
		done = fader();
		if (!done)
		{	
			setTimeout('stop_song();', mseconds);
			return;
		}	
	}	
	
	// Call stop function if available in quicktime player
	//document.getElementById('message').innerHTML = (typeof document.sound.Stop);
	if (document.sound)
	if (typeof document.sound.Stop == 'function')
	{
		if (document.getElementById('message'))
		document.getElementById('message').innerHTML = "QT Stop.";
		document.sound.Stop();
	}
	// Call stop function if available in Media player
	//document.getElementById('message').innerHTML = (typeof document.sound.controls);
	if (document.sound)
	if (typeof document.sound.controls == 'object')
	{
		if (document.getElementById('message'))
		document.getElementById('message').innerHTML = "WMP Stop.";
		document.sound.controls.Stop();
	}
	
	
	// Stop time display timer
	clearTimeout(t2);
	// Stop fast_reverse timer
	clearTimeout(t3);
	
	// Wipe out contents of player DIV
	player.innerHTML = '';
	
	// set speed display to 1X
	if (document.getElementById('speed'))
	document.getElementById('speed').innerHTML = '1X';
} // end function stop()

function pause_song()
{

	// if a song is not playing then just return
	if (document.getElementById('player').innerHTML == '')
		return;

	
// if IE or Netscape then Media Player Pause Controls
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
{ 	
	if (!document.sound.controls)
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support pause control.';
		return;
	}
	
	// if pause
	if (document.getElementById('pause_btn').innerText == 'Pause')
	{
		document.sound.controls.pause();
		document.getElementById('pause_btn').innerText = 'Unpause';
	}
	else // if unpause
	{
		document.sound.controls.play();
		document.getElementById('pause_btn').innerText = 'Pause';
	}
}
else // If Firefox or Safari then use Quicktime Stop (Pause)	
{

	// Check to see if Stop is a function
	// If not then return
	// So far Safari does not support Stop
	if (typeof document.embeds['sound'].Stop != 'function')
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support pause control.';
		return;
	}
	
	// if pause
	if (document.getElementById('pause_btn').innerHTML == 'Pause')
	{
		document.embeds['sound'].Stop();
		document.getElementById('pause_btn').innerHTML = 'Unpause';
	}
	else // if unpause
	{
		document.embeds['sound'].Play();
		document.getElementById('pause_btn').innerHTML = 'Pause';
	}
}

}  // end function pause_song()


function detect_browser()
{
	var browser_name = navigator.userAgent;
	// We have to check for Opera first because
	// at the beginning of the userAgent variable
	// Opera claims it is MSIE. 
	
	if (browser_name.indexOf("Opera")!= -1)
		browser_name = "Opera";
	else if (browser_name.indexOf("Firefox")!= -1)
		browser_name = "Firefox";
	else if (browser_name.indexOf("MSIE")!= -1)
		browser_name = "MSIE";
	else if (browser_name.indexOf("Netscape")!= -1)
		browser_name = "Netscape";
	else if (browser_name.indexOf("Safari")!= -1)
		browser_name = "Safari";
	
	return browser_name;
	

} // end function detect_browser()

function next_song(dir)
{
	playlist_length = songs.length - 1;
	
	// stop the current song if playing
	if (document.getElementById('player').innerHTML != '')
		stop_song();
	
	if (dir == 1) // previous
	{
		current_song--;
		if (current_song < 0) 
			current_song = playlist_length; // loop to last song
	}
	else // next
	{
		current_song++;
		if (current_song > playlist_length)
			current_song = 0; // loop to first song
	}
	media = songs[current_song];

	play_song();

} // end function next_song(dir)

function display_song()
{
	// display the name of the mp3
	// displays only if songname DIV exists
	if (document.getElementById('songname'))
	document.getElementById('songname').innerHTML = 'Current song: '
	+ media;
}  // end function display_song()

function volume(dir)
{
	var current_volume;
	
	// if a song is not playing then just return
	if (document.getElementById('player').innerHTML == '')
		return;

	// if IE or Netscape then Media Player Volume Controls
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
{ 
	if (!document.sound.settings)
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support volume control.';
		return;
	}
		
	current_volume = document.sound.settings.volume;
	
	
	
	if (document.getElementById('vol_display'))
		document.getElementById('vol_display').innerHTML = current_volume;
	

	if (dir == 1 || dir == 5) // left or down
	{	
		document.sound.settings.volume = current_volume-10;
		//document.embeds['sound'].SetVolume(current_volume-10);
		if (dir == 1)
			t = setTimeout('volume('+dir+')', 100);
	}
	else if (dir == 2) // right or up
	{
		document.sound.settings.volume = current_volume+10;
		//document.embeds['sound'].SetVolume(current_volume+10);
		t = setTimeout('volume('+dir+')', 100);
	}
	else if (dir == 3) // stop changing volume
	{
		clearTimeout(t);
	}
}
else // if Firefox or Safari then Quicktime volume controls
{
	// Check to see if GetVolume is a function
	// If not then return
	// So far Safari does not support GetVolume
	if (typeof document.embeds['sound'].GetVolume != 'function')
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support volume control.';
		return;
	}
		
	current_volume = document.embeds['sound'].GetVolume();
		
	
	if (document.getElementById('vol_display'))
		document.getElementById('vol_display').innerHTML = current_volume;
	

	if (dir == 1 || dir == 5) // left or down
	{	
		//document.sound.settings.volume = current_volume-10;
		document.embeds['sound'].SetVolume(current_volume-10);
		if (dir == 1)
			t = setTimeout('volume('+dir+')', 100);
	}
	else if (dir == 2) // right or up
	{
		//document.sound.settings.volume = current_volume+10;
		document.embeds['sound'].SetVolume(current_volume+10);
		t = setTimeout('volume('+dir+')', 100);
	}
	else if (dir == 3) // stop changing volume
	{
		clearTimeout(t);
	}
	
}	
	return current_volume;
} // end function volume(dir)


function fade()
{

	// if fade_display span exists
	if (document.getElementById('fade_display'))
	{
		if (document.getElementById('fade_display').innerHTML == ': Off')
		{
			fade_out = 1;
			document.getElementById('fade_display').innerHTML = ': On';
		}
		else
		{
			fade_out = 0;
			document.getElementById('fade_display').innerHTML = ': Off';
		}
}

} // end function fade()

function fader()
{
	var current_volume;
	
	// if IE or Netscape then Media Player Volume Controls
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
{ 
	if (!document.sound.settings)
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support volume control.';
		return 1; // done because no fade support
	}
}
else // if Firefox or Safari then Quicktime volume controls
{
	// Check to see if GetVolume is a function
	// If not then return
	// So far Safari does not support GetVolume
	if (typeof document.embeds['sound'].GetVolume != 'function')
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support volume control.';
		return 1; // done because no fade support
	}
}	
	current_volume = volume(5);
	//document.getElementById('message').innerHTML = current_volume;
	if (current_volume <= 0)
	{
		volume(3); // end volume decrease
		return 1; // return done
	}
	else
		return 0;	

} // end function fader()

function display_time()
{
	// This function not only displays the current position
	// of time in the file, but it also get's the end time
	// so that if a song reaches the end it will play the
	// next song
	var time;
	var duration;
	var song_status;
	var buffer_status; // used for media player
	var mins; // used for quicktime
	var secs; // used for quicktime
	var scale; // used for quicktime
	
	// if IE or Netscape then Media Player 
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
	{
		//document.getElementById('message').innerHTML = typeof document.sound.settings;
		if (!document.sound.settings)
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support autoplay of next song in playlist.';
		return; // done because no fade support
	}		
		//song_status = document.sound.status;
		song_status = document.sound.playState;
		buffer_status = document.sound.network.bufferingProgress;
		
		
	if (buffer_status < 100) // 3 = playing; 1 = stopped
	{	
		t2 = setTimeout('display_time();', 20); // recall this function in 20ms
		return;
	}
	else 
	{
		if (document.getElementById('songtime'))
			document.getElementById('songtime').innerHTML = 'Buffering: '
			+ buffer_status + '%'; 
	}			
		//time = document.sound.controls.currentPosition;
		time = document.sound.controls.currentPositionString;
		//duration = document.sound.currentMedia.duration;
		duration = document.sound.currentMedia.durationString;
		
	}	
	else  // Firefox or Safari
	{
	
	// if quicktime GetVolume not supported
	if (typeof document.sound.GetVolume != 'function')
	{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support autoplay of next song in playlist.';
		return ; // done 
	}
	
	song_status = document.embeds['sound'].GetPluginStatus();
	

	if (song_status.toLowerCase() != 'playable' &&
		song_status.toLowerCase() != 'complete')
	{	
		t2 = setTimeout('display_time();', 250); // recall this function every 250 ms
		return;
	}
	else 
	{
		if (document.getElementById('songtime'))
		document.getElementById('songtime').innerHTML = song_status;
	} 
	
	time = document.embeds['sound'].GetTime();
	duration = document.embeds['sound'].GetDuration();
	scale = document.embeds['sound'].GetTimeScale();
	time = Math.floor(time*(1/scale));  // convert to seconds
	duration = Math.floor(duration*(1/scale));  // converts to seconds
	// convert seconds into mm:ss
	mins = Math.floor(time / 60);
	secs = time - (mins * 60);	
	time = mins + ':' + secs;
	mins = Math.floor(duration / 60);
	secs = duration - (mins * 60);	
	duration = mins + ':' + secs;
	
	
	}
	
	if (document.getElementById('songtime'))
		document.getElementById('songtime').innerHTML = 'Time: '
		+ time + ' of ' + duration;
	

	// This is for Firefox
	if (time == duration) // if at end of song
	{	
		next_song(2); // then play next song in playlist
		return;
	}
	// This is for Ie
	if (song_status == 1) // song stopped
	{	
		next_song(2);
		return;
	}
	t2 = setTimeout('display_time();', 250); // recall this function every 250ms
	
} // end function display_time()

function display_info()
{
	// Display info about the song
	var song_title;
	var song_artist;
	
	
	// if IE or Netscape then Media Player 
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
	{	
	//song_title = document.sound.currentMedia.name;
	song_title = document.sound.currentMedia.getItemInfo('Title');
	song_artist = document.sound.currentMedia.getItemInfo('Author');
	}
	else // Firefox Quicktime
	{
		// if quicktime GetVolume not supported
		if (typeof document.sound.GetVolume != 'function')
		{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support song ID3 information.';
		return ; // done 
		}
		
		song_title = document.sound.GetUserData('©nam');
		song_artist = document.sound.GetUserData('©ART');	
		/* Quicktime has a problem of not being able to load
		the song name and artist until most of the song is
		loaded, so if song_title == null we need to call this
		function again in a few milliseconds */
		if (song_title == null)
		{
			setTimeout('display_info();', 250);
			return;
		}
	}
	
	if (document.getElementById('message'))
	document.getElementById('message').innerHTML = "Title: "
	+ song_title 
	+ '<BR>'
	+ "Artist: "
	+ song_artist;
	
	
	
}  // end function song_info()

function fast_forward()
{
	var current_rate;
	
	// if song is stopped then just return
	if (document.getElementById('player').innerHTML == '')
		return;
	
	// Note: Only WMV and ASF files can go backwards with -.5 to -5
	// if IE or Netscape then Media Player 
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
	{	
	if (document.sound.settings.isAvailable('Rate'))
	{
		current_rate = parseFloat(document.sound.settings.rate);
		//document.getElementById('message').innerHTML = current_rate;
		if (current_rate == 1)
		    current_rate = 2;
		else if (current_rate == 2)
			current_rate = 3;
		else 
			current_rate = 1;
			
		document.sound.settings.rate = current_rate;    
	}
	else
	{	
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = "This"
			+ " browser does not support fast forward.";
	}
	}
	else // Firefox so quicktime
	{
		if (typeof document.sound.GetVolume != 'function')
		{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support fast forward.';
		return ; // done 
		}
		current_rate = document.sound.GetRate();
		if (current_rate == 1)
			current_rate = 2;
		else if (current_rate == 2)
			current_rate = 3;
		else
			current_rate = 1;
			
		document.sound.SetRate(current_rate);
	}
	
	if (document.getElementById('speed'))
	document.getElementById('speed').innerHTML = current_rate
		+ 'X';

} // end function fast_forward()


function fast_reverse(rewinding)
{
	var current_pos;
	var current_rate;
	clearTimeout(t3);
	// Note: Only WMV and ASF files can go backwards with -.5 to -5
	// in Media Player.  So instead of using controls.fastReverse
	// or settings.rate for reverse, I use controls.currentPosition
	// and make it go back two seconds.
	// var rewinding is used for media player with the setTimeout
	// becuase there is not a real rewind with MP3s in WMP
	
	// if song is stopped then just return
	if (document.getElementById('player').innerHTML == '')
		return;
	
	// if IE or Netscape then Media Player 
	if (detect_browser() == "MSIE" || 
		detect_browser() == "Netscape")
	{
	current_pos = document.sound.controls.currentPosition;
	if (document.getElementById('speed').innerHTML == '1X'
		&& rewinding != 1)
		current_rate = -2;
	else if (document.getElementById('speed').innerHTML == '-2X'
		&& rewinding != 1)
		current_rate = -3;
	else if (rewinding != 1)
		current_rate = 1;
	else 
		current_rate = parseFloat(document.getElementById('speed').innerHTML);

	current_pos = current_pos + current_rate;
		if (current_rate < 1)
		{	
		document.sound.controls.currentPosition = current_pos;
		t3 = setTimeout('fast_reverse(1);', 1000);
		}
	}
	else // Firefox so quicktime
	{
		if (typeof document.sound.GetVolume != 'function')
		{
		if (document.getElementById('message'))
			document.getElementById('message').innerHTML = 'This'
			+ ' browser does not support rewind.';
		return ; // done 
		}
		current_rate = document.sound.GetRate();
		if (current_rate == 1)
			current_rate = -2;
		else if (current_rate == -2)
			current_rate = -3;
		else
			current_rate = 1;
	
		document.sound.SetRate(current_rate);
	}
	
	document.getElementById('speed').innerHTML = current_rate
		+ 'X';
	
}

function shuffle()
{
	songs.sort(function() 
	{
	return 0.5 - Math.random()
	}) //Array elements now scrambled
	
	media = songs[current_song]; // media becomes the random song at current position
	display_song();
}  // end function shuffle()


window.onload = loadsongs;

window.onunload = stop_song;


