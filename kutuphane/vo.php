<?php
error_reporting(E_ALL);
@ini_set("display_errors","0");

require_once("veritabani.php");
require_once("oturum.php");
//require_once("izinler.php");

class login
{
var $username;
var $password;
var $userid;
var $user_enable;

function login()
{
global $db;
global $session;

    $db = new Database;
    $db->setUser("","");
    $db->setDatabase("hoopss_hoopss");

    $db->query("SET NAMES 'utf8'");
    $db->query("SET collation_connection = 'utf8_unicode_ci'");

	$session = new session;
}

	/*
	 * Genel kullanimda iki sozcugun match'i icin fonksiyon. Ozel olarak burada gonderilen username'in
	 * veritabanindaki sifresini gonderilen sifre ile match ediyor.
	 */
	function eslestirici($username,$password,$posta_adi="1")
	{
	global $db;
	global $session;
	$this->username = $username;
	$this->password = $password;

	$user_que = $db->query("SELECT * FROM users WHERE username='$this->username'");
	$user_list = $db->result();

	$this->userid = $user_list['id'];
	$this->username = $user_list['username'];
	$this->name_surname = $user_list['name'] . ' ' . $user_list['surname'];
	$this->user_enable = $user_list['enabled'];

		if( ( $posta_adi == "1" ) && ( $this->password != "" ) && ( $this->username != "" ) )
		{
			if( $this->password == $user_list['password'] )
			{
				$session->set("userid",$this->userid);
				$session->set("username",$this->username);
				$session->set("name_surname",$this->name_surname);
				$session->set("oturum",1);
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/*
	 *Oturum acilmismi kontrolu
	 */
	function kontrolcu()
	{
		global $db;
		global $session;
		if(!$session->session_id)
		{
			if($this->eslestirici("guest","guest")) header("Location: /");
		}
		else return false;
	}
}
?>
