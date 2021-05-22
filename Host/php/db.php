<?php
	session_start();
	$host = 'localhost:3306';
	$dbuser = 'helper';
	$dbpw = 'BGuyLg_E5lxoQds8x';
	$dbname = 'DrawAttention';

	$_SESSION['link'] = mysqli_connect($host, $dbuser, $dbpw, $dbname);

	if ($_SESSION['link']){
		mysqli_query($_SESSION['link'], "SET NAMES utf8");
	}else{
		echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
	}
?>