<?php


/*
 *
 *
 *	Database Class
 *
 *
 *  Haz�rlayan : �zg�r �ayc� (ozgur@bilgisayarkariyeri.com)
 *
 *
 */


class database
{
    var $host;                   /* Database Host */
    var $user;                   /* Database User */
    var $password;               /* Database Password. */
    var $database;               /* Database Name. */
    var $conn_id;                /* Connection ID of the database. */
    
    var $query;                  /* Query Var (Not Query String) */
    var $query_id;               /* ID of the Last Query */
    var $last_query;             /* Last Query String */
    
    var $log_file;               /* File to log the errors & warnings. */
    var $display_errors;         /* Whether to display the errors & warnings to the user screen or not. */
    
    
    /*	Constructor	*/
    function database()	
    {

	/*
	 * Default Values.
	 */
	$this->host     = "localhost";
	$this->user     = "";
	$this->password = "";
	$this->database = "hoopss_hoopss";
	
	$this->setUser($this->user,$this->password);
	$this->setDatabase($this->database);

	/*
	 * Do not change the settings below.
	 */
	$this->conn_id  = 0;
	$this->query_id = 0;
	
	$this->log_file     = FALSE;
	$this->display_errors = TRUE;
    }

    function setLogFile($filename)          {   $this->log_file = $filename;  }
    function setDisplayErrors($val)         {   $this->display_errors = $val; }
    
    function setHost($v_host)	            {	$this->host = $v_host;	}
    function setUser($v_name,$v_password)   {	$this->user = $v_name;	$this->password = $v_password;	}
    
    function setDatabase($v_database)
    {
	if ($v_database != $this->database)  /* Change if the database name has really changed. */
	{
	    $this->database = $v_database;
	    
	    if ($this->conn_id)
	      if (!@mysql_select_db($this->database, $this->conn_id))
		$this->stop("Could not select the database " . $this->database . " !");
	}
    }


    function connect()	{

	if ($this->database == "")
	  $this->stop("Please select a database.");
	
	$this->conn_id = @mysql_connect( $this->host, $this->user, $this->password );
	
	if (!$this->conn_id)
	  $this->stop("Connection to the database server failed.");
	
	if (!@mysql_select_db($this->database, $this->conn_id))
	  $this->stop("Could not select the database " . $this->database . " !");
    }


    function close()	{
	if ($this->conn_id)
	  mysql_close($this->conn_id);
    }

    
    function query($v_query)	{
	if (! $this->conn_id )
	  $this->connect();
	
	$this->last_query = $v_query;
	
	$this->query[++$this->query_id] = @mysql_query($this->last_query,$this->conn_id);
	
	if (!$this->query[$this->query_id])
	  $this->stop(mysql_error());
	
	return $this->query_id;
    }


    function num_rows($query_id = -1)	{
	if ($query_id == -1)	$query_id = $this->query_id;
	
	if (  (!$this->conn_id )  ||  (!$this->query[$query_id])  )
	  $this->stop("To find the number of rows, please make a query first.");
	
	return mysql_num_rows($this->query[$query_id]);
    }

    function affected_rows()	{
	if (!$this->conn_id )
	  $this->stop("To find the number of affected rows, please make a query first.");
	
	return mysql_affected_rows($this->conn_id);
    }


    function result($query_id = -1)	{
	if ($query_id == -1)	$query_id = $this->query_id;
	
	if (  (!$this->conn_id )  ||  (!$this->query[$query_id])  )
	  $this->stop("To find the result set, please make a query first.");
	
	return mysql_fetch_array($this->query[$query_id]);
    }


    function insert_id()	{
	if (  (!$this->conn_id )  ||  (!$this->query[$this->query_id])  )
	  $this->stop("To find the insert id, please make a query first.");
	
	return mysql_insert_id();
    }


    /*
     * Terminate Execution And Log If Necessary.
     */
    function stop($v_message)	
    {
	if ($this->log_file)
	{
	    $f = fopen($this->log_file,"a");
	
	    $error_msg = "[" . date("d.m.Y H:i") . "][" . $_SERVER["PHP_SELF"];
	
	    if (strlen($_SERVER["QUERY_STRING"]) > 0)
	      $error_msg .= "?$_SERVER[QUERY_STRING]";
	
	    $error_msg .=  "] ";
	
	    if (strlen($this->last_query) > 0)
	    {
		$error_msg .= "Error on the query string \"";
		$error_msg .= $this->last_query;
		$error_msg .= "\" with the error message \"$v_message \"";
	    }
	    else
	    {
		$error_msg .= "Error: $v_message";
	    }
	
	    fwrite($f,"$error_msg\n");
	    fclose($f);
	}
	
	if ($this->display_errors)
	{
	    echo "<B>Sorry, a problem has occured with our database connectivity.</B><BR>".
	      "<B>The error is:</B> <i>$v_message</i><BR>";
	}	
	
	exit();
    }
    
}

?>
