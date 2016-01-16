<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script type="text/javascript">
	//jQuery获取地址栏参数		
	function GetQueryString(name)
	{
		 var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		 var r = window.location.search.substr(1).match(reg);
		 if(r!=null)return  unescape(r[2]); return null;
	}
</script>
<script type="text/javascript">
	var sys=GetQueryString('sys');
	$(function(){
		$(".editEquip").on('click',function(){
			layer.open({
				type:2,
				title:'设备管理',
				//maxmin:true,
				//skin:'layer-layer-rim',
				area:['900px','500px'],
				//offset:['100px','200px'],
				shadeClose:true,
				content:'api/EquipManager.php?sys='+sys
				
			});
		});
	})
	
</script>
<style type="text/css">
	body{
		background-color:#EDEDED;
		
	}
	a 
	{
		text-decoration: none;
		color:#0000EE;           /*#104E8B  #3A5FCD*/
	}
	
	table.gridtable {
		font-family: verdana,arial,sans-serif;
		font-size:15px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
		border-spacing: 0px;
		margin:50px auto;

	}
	table.gridtable th {
		border-width: 1px;
		padding: 10px 60px;
		border-style: solid;
		border-color: #666666;
		background-color: #dedede;
	}
	table.gridtable td {
		border-width: 1px;
		padding: 10px 60px;
		border-style: solid;
		border-color: #B3B3B3;
		/*background-color: #ffffff;*/
	}
</style>
	

<?php

	
	$file_to_require=realpath('api/SqlHelper.class.php'); 
	//require "api/SqlHelper.class.php";
	require_once $file_to_require;
	require_once('api/valiread.php');
	//验证用户		
	checkUserValidate();
	
	$grade=$_SESSION['tzgrade'];
	
	header("content-type:text/html;charset=utf-8");
		
	$e_sys=$_GET['sys'];
	
	//echo $e_sys;

	$sqlHelper= new SqlHelper ();
	
	$sql="select * from equipments where e_sys=$e_sys";
	
	$sqltitle="select name from sys where id=$e_sys";
	
	$res = $sqlHelper->execute_dql($sql);
	$res1 = $sqlHelper->execute_dql($sqltitle);
	
	//$row_cnt=$res->num_rows ;
	
	$row1 = $res1 -> fetch_row();
	
	$title=$row1[0];
	
	$i=1;
	echo "<h2 style='text-align:center; margin-top:50px;'>$title</h2>";
	echo "<table class='gridtable'><tr>";
	while ( $row  =  $res -> fetch_row ()) {
         if($grade==1){
			 echo  "<td><a href=content.php?eid=$row[0]>";
		 } else if($grade==2){
			 echo  "<td><a href=contentread.php?eid=$row[0]>";
		 } 
		 echo $row [ 1 ];
		 echo "</a></td>";
		 if($i%5==0)
		 {
			echo "</tr><tr>";
		 }
		 $i++;
    }
	echo "</tr></table>";
	
	$res->free();
	$res1->free();
	
?>