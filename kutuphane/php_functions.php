<?php

function getAddressPort($url) {

        $url_array = explode("/",$url);
        if(strstr($url_array[2],"@"))
				        {
                $user_pass_array = explode("@",$url_array[2]);
                $address_port_part = $user_pass_array[1];
                $user_pass_part = $user_pass_array[0];

                $user_pass_sep_array = explode(":",$user_pass_part);
                $user = $user_pass_sep_array[0];
                $pass = $user_pass_sep_array[1];
                if(empty($user)) $user = 'anonymous';

                $address_port_array = explode(":",$address_port_part);
                $address = $address_port_array[0];
                $port = $address_port_array[1];
                if(empty($port)) $port = "80";
                $address_port = array('address'=>$address,'port'=>$port,'user'=>$user,'pass'=>$pass);
        }
        else
        {
                $address_port_array = explode(":",$url_array[2]);
                $address = $address_port_array[0];
                @$port = $address_port_array[1];
                if(empty($port)) $port = "80";
                $address_port = array('address'=>$address,'port'=>$port,'user'=>'anonymous','pass'=>'');
        }
        return $address_port;
}


function utf8_to_iso_8959_1($string)
{
	
	$new_string = "";
	$convert = array("Ä°"=>"Ã„Â°","Ä±"=>"Ã„Â±","ÄŸ"=>"Ã„Å¸","Äž"=>"Ã„Å¾","Ãœ"=>"ÃƒÅ“","Ã¼"=>"ÃƒÂ¼","Ã‡"=>"Ãƒâ€¡","Ã§"=>"ÃƒÂ§","Åž"=>"Ã…Å¾","ÅŸ"=>"Ã…Å¸","Ã–"=>"Ãƒâ€“","Ã¶"=>"ÃƒÂ¶");
	//$convert = array("Ä°"=>"Ã„Â°","Ä±"=>"Ã„Â±","ÄŸ"=>"Ã„Å¸","Äž"=>"Ã„Å¾","Ãœ"=>"ÃƒÅ“","Ã¼"=>"ÃƒÂ¼","Ã‡"=>"Ãƒâ€¡","Ã§"=>"ÃƒÂ§","Åž"=>"Ã…Å¾","ÅŸ"=>"Ã…Å¸","Ã–"=>"Ãƒâ€“","Ã¶"=>"ÃƒÂ¶");
	$tr_chars = array("Ä°","Ä±","ÄŸ","Äž","Ãœ","Ã¼","Ã‡","Ã§","Åž","ÅŸ","Ã–","Ã¶");

	if(mb_detect_encoding($string) == 'UTF-8')
	{
		if(strstr($string,"Ã‡") || strstr($string,"ÅŸ") || strstr($string,"ÄŸ") || strstr($string,"Åž"))	$new_string = strtr($string,$convert);
		else $new_string = mb_convert_encoding($string,"UTF-8","ISO-8859-9");
		//if(strstr($string,"ÅŸ")) $newsting= str_replace("ÅŸ","Ã…ï¿½",$string);

		return $new_string;
	}
	else return $string;
}

// Åž ÃŠÃ°Ã Ã±Ã­Ã Ã¿ Ã�Ã«Ã¥Ã±Ã¥Ã­Ã¼ 

function just_clean($string)  
{
//$string = mb_convert_encoding($string,"ISO-8859-1","UTF-8");
$string = preg_replace('/[^[:punct:][:alpha:][:blank:]0-9\-]/', '', $string);  


/*
// Replace other special chars  
$specialCharacters = array(  
//'#' => '',  
'ï¿½' => '', 
'`' => '', 
'\'' => '', 
'$' => '',  
'%' => '',  
//'&' => '',  
//'@' => '',  
//'.' => '',  
'ï¿½' => '',  
'+' => '',  
'=' => '',  
'\\' => '',  
'/' => '',
'Ã¿.' => '',
'`' => ''
);

while (list($character, $replacement) = each($specialCharacters)) {  
$string = str_replace($character, '', $string);  
}  
$string = strtr($string,  
"ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½",  
"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"  
);  

 // Remove all remaining other unknown characters  
$string = preg_replace('/[^[:punct:]a-zA-Z0-9\-]/', ' ', $string);  
$string = preg_replace('/^[\-]+/', '', $string);  
$string = preg_replace('/[\-]+$/', '', $string);  
$string = preg_replace('/[\-]{2,}/', ' ', $string);  
//$string = clean_url($string);
*/

return $string;  
}

function clean_url($text)
{
$text=strtolower($text);
$code_entities_match = array( '&quot;' ,'!' ,'@' ,'#' ,'$' ,'%' ,'^' ,'&' ,'*' ,'(' ,')' ,'+' ,'{' ,'}' ,'|' ,':' ,'"' ,'<' ,'>' ,'?' ,'[' ,']' ,';' ,"'" ,',' ,'.' ,'_' ,'/' ,'*' ,'+' ,'~' ,'`' ,'=' ,'---' ,'--','--','-','ï¿½','`','ï¿½');
$code_entities_replace = array(' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ' ,' ',' ',' ',' ',' ',' ',' ');
$text = str_replace($code_entities_match, $code_entities_replace, $text);
$text = trim($text," ");
$text=str_replace(" ","-",$text);
$text = cleanUnderScores($text);
return $text;
}

function cleanUnderScores($text)
{
$tst = $text;
$under = "--";
$pos = 0;

    while(strpos($tst, $under) != false )
    {
    //$pos = strpos($tst, $under);
    $tst = str_replace("--", "-", $tst);        
    }
return $tst;
}

function iOSDetect() {
   $browser = strtolower($_SERVER['HTTP_USER_AGENT']); // Checks the user agent
   if(strstr($browser, 'iphone') || strstr($browser, 'ipod')) {
      $device = 'iPhone';
   } else { $device = 'default'; }	
   return($device);
}
 
iOSDetect();
 
// To use it in you page, use:
if(iOSDetect() == 'iPhone') {
   // iPhone stuff here
} 
if(iOSDetect() == 'default') {
   // Normal stuff here
}


?>
