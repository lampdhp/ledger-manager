<?php

	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");

	$sqlHelper= new SqlHelper();

	
	function getFenyePage($fenyePage){
		
		$sql1="select * from beipin where limit "
		.($fenyePage->pageNow-1)*$fenyePage->pageSize.","
		.$fenyePage->pageSize;
		
		$sql2="select count(id) from beipin";
		
		$sqlHelper->execute_dql_fenye($sql1,$sql2,$fenyePage);
	
	}
?>