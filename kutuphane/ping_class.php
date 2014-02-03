<?php

class Ping {

function __construct(){
}

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

function makePing($site) {

// Making the package
$type= "\x08";
$code= "\x00";
$checksum= "\x00\x00";
$identifier = "\x00\x00";
$seqNumber = "\x00\x00";
$data= "Scarface";
$package = $type.$code.$checksum.$identifier.$seqNumber.$data;
$checksum = $this->icmpChecksum($package); // Calculate the checksum
$package = $type.$code.$checksum.$identifier.$seqNumber.$data;
// And off to the sockets
$socket = socket_create(AF_INET, SOCK_RAW, SOCK_STREAM);
socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec'=>3, 'usec'=>500000));
socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec'=>3, 'usec'=>500000));
socket_connect($socket, $site, null);
// If you're using below PHP 5, see the manual for the microtime_float
// function. Instead of just using the microtime() function.
$startTime = microtime(true);
socket_send($socket, $package, strLen($package), 0);
if (socket_read($socket, 255)) {
$ping_result = round(microtime(true) - $startTime, 4);
}
socket_close($socket);

return $ping_result;
}

// Checksum calculation function
function icmpChecksum($data)
{
if (strlen($data)%2)
$data .= "\x00";
 
$bit = unpack('n*', $data);
$sum = array_sum($bit);
 
while ($sum >> 16)
$sum = ($sum >> 16) + ($sum & 0xffff);
 
return pack('n*', ~$sum);
}

}

?>
