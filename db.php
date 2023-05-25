<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8'); // utf-8?�코??

	$db = new mysqli("localhost","say2them","Say2Them##","dise");
	$db->set_charset("utf8");
    
	function mq($sql)
	{
		global $db;
		return $db->query($sql);
	}
?>
<link rel="stylesheet" href="css/bootstrap.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
