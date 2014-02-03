<?php
/*
Sean Huber CURL library

This library is a basic implementation of CURL capabilities.
It works in most modern versions of IE and FF.

==================================== USAGE ====================================
It exports the CURL object globally, so set a callback with setCallback($func).
(Use setCallback(array('class_name', 'func_name')) to set a callback as a func
that lies within a different class)
Then use one of the CURL request methods:

get($url);
post($url, $vars); vars is a urlencoded string in query string format.

Your callback function will then be called with 1 argument, the response text.
If a callback is not defined, your request will return the response text.
*/

class CURL {
    var $callback = false;
	var $filesize = 0;

	function setCallback($func_name) {
	$this->callback = $func_name;
	}
	
	function doRequest($method, $url, $vars) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 10); 
	//curl_setopt($ch, CURLOPT_COOKIEJAR, '../cookies/cookie.txt');
	//curl_setopt($ch, CURLOPT_COOKIEFILE, '../cookies/cookie.txt');
	if ($method == 'POST') {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
	}
	else
	{
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
	}
	$data = curl_exec($ch);
	curl_close($ch);
	if ($data) {
		if ($this->callback)
		{
		$callback = $this->callback;
		$this->callback = false;
		return call_user_func($callback, $data);
		} else {
		return $data;
		}
		} else {
			//return curl_error($ch);
		}
		unset($ch);
	}
	
	function query($url,$port=80)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt ($ch, CURLOPT_PORT , $port);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10); 
		//curl_setopt($ch, CURLOPT_COOKIEJAR, '../cookies/cookie.txt');
		//curl_setopt($ch, CURLOPT_COOKIEFILE, '../cookies/cookie.txt');
		$data = curl_exec($ch);
		curl_close($ch);

		if ($data) {
			if ($this->callback)
			{
			$callback = $this->callback;
			$this->callback = false;
			return call_user_func($callback, $data);
			} else {
				return $data;
			}
		} else {
			//return curl_error($ch);
		}
		unset($ch);
	}

	function get($url) {
		return $this->doRequest('GET', $url, 'NULL');
	}
	
	function post($url, $vars) {
		return $this->doRequest('POST', $url, $vars);
	}

	function file_download($file, $local_path, $newfilename) 
	{ 
		$err_msg = ''; 
		//echo "<br>Attempting message download for $file<br>"; 
		$out = fopen($newfilename, 'w+'); 
		if ($out == FALSE)
		{ 
			print $out. "File not opened<br>"; 
			exit; 
		} 
    
		$ch = curl_init(); 
            
    		curl_setopt($ch, CURLOPT_URL, $file); 
    		curl_setopt($ch, CURLOPT_HEADER, 0); 
    		curl_setopt($ch, CURLOPT_FILE, $out); 
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 100000); 
                
    		$data = curl_exec($ch); 
    		curl_close($ch); 
    		fclose($out); 

		if(!$data)
    		echo "<br>Error is : ".curl_error ( $ch); 

	}//end function

	function remoteFileExists($url) {
		$curl = curl_init($url);

		//don't fetch the actual page, you only want to check the connection is ok
		curl_setopt($curl, CURLOPT_NOBODY, true);
		    
		//do request
		$result = curl_exec($curl);
		    
		    
		//if request did not fail
		if ($result !== false) {
			//if request was ok, check response code
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			if ($statusCode == 200) {
		        	$ret = true;   
		        }
				else $ret = false;
		}
		else $ret = false;
		    
		curl_close($curl);
		    
		return $ret;
	}
		
	function getFileSize($url) {
		$remoteFile = $url;
		$ch = curl_init($remoteFile);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
		$data = curl_exec($ch);
		curl_close($ch);
		if ($data === false) {
		  //echo 'cURL failed';
		  return 0;
		}
		
		$contentLength = 0;
		$status = 'unknown';
		if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches)) {
		  $status = (int)$matches[1];
		}
		if (preg_match('/Content-Length: (\d+)/', $data, $matches)) { $contentLength = (int)$matches[1];
		}
		
		//echo 'HTTP Status: ' . $status . "\n";
		//echo 'Content-Length: ' . $contentLength;
		return $contentLength;
	}

	function spyFuQuery($url,$port=80)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt ($ch, CURLOPT_PORT , $port);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10); 
		//curl_setopt($ch, CURLOPT_COOKIEJAR, '../cookies/cookie.txt');
		//curl_setopt($ch, CURLOPT_COOKIEFILE, '../cookies/cookie.txt');
		$data = curl_exec($ch);
		curl_close($ch);

		if ($data) {
			if ($this->callback)
			{
			$callback = $this->callback;
			$this->callback = false;
			return call_user_func($callback, $data);
			} else {
				return $data;
			}
		} else {
			//return curl_error($ch);
		}
		unset($ch);
	}


}

	
?>
