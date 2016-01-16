<style type="text/css">
	
	a {	
		text-decoration: none;
		color:#0000EE;           /*#104E8B  #3A5FCD*/			
	};
 
body{
	font-size:16px;
	
} 


	/* CSS Document */
	 
	body {
	    font: normal 16px auto; /*"Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;*/
	    color: #4f6b72;
	    /*background: #E6EAE9;*/

	}
	
	h1{ font-size:3em;}
	
	a {
	    color: #c75f3e;
	}
	 
	.gridtable{
	    width: 900px;
	    padding: 0;
	    margin: 0;
	}
	 
	caption {
	    padding: 0 0 5px 0;
	    width: 900px;     
	    font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	    text-align: right;
	}
	 
	th {
	    font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	    color: #4f6b72;
	    border-right: 1px solid #C1DAD7;
	    border-bottom: 1px solid #C1DAD7;
        border-top: 1px solid #C1DAD7;
	    letter-spacing: 2px;
	    text-transform: uppercase;
	    text-align: center;
	    padding: 6px 6px 6px 12px;
	    background: #CAE8EA url(images/bg_header.jpg) no-repeat;
	}
	 
	th.nobg {
	    border-top: 0;
	    border-left: 0;
	    border-right: 1px solid #C1DAD7;
	    background: none;
	}
	 
	td {
	    border-right: 1px solid #C1DAD7;
	    border-bottom: 1px solid #C1DAD7;
	    background: #fff;
	    font-size:11px;
	    padding: 6px 6px 6px 12px;
	    color: #4f6b72;
	}
	 
	 
	td.alt {
	    background: #F5FAFA;
	    color: #797268;
	}
	 
	th.spec {
	    border-left: 1px solid #C1DAD7;
	    border-top: 0;
	    background: #fff url(images/bullet1.gif) no-repeat;
	    font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	}
	 
	th.specalt {
	    border-left: 1px solid #C1DAD7;
		border-top: 0;
	    background: #f5fafa url(images/bullet2.gif) no-repeat;
	    font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	    color: #797268;
	}
	/*---------for IE 5.x bug*/
	html>body td{ font-size:18px;}

</style>


<?php

	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	
	session_start();
	
	$grade=$_SESSION['tzgrade'];
	
	$sqlHelper= new SqlHelper();
	
	echo '<form action="" method="post" class="searchForm">
			<div >';
	//echo	'<h1 style="text-align:center; margin-top:120px;">搜<img src="../images/search17.png">索</h1>';
	echo	'<table class="sTab" style="margin:40 auto;" >
			<tr>
			<td>
				<select name="catalog" style="line-height:30px; font-size:20px;">
					<option>请选择</option>
					<option>设备</option>
					<option value="1">备品备件</option>
					<option value="2">异动单</option>
					<option value="3">模拟单</option>
				</select>
			 </td>
			 <td><input type="text" name="name" size="50" style="line-height:30px; font-size:20px;" /></td>
			 
			 <td><input type="submit" value="搜索" class="searchBtn" style="line-height:30px; font-size:20px;"></td></tr>

			</table>
			</div>
			</form>';
	
	
	if(isset($_REQUEST['name'])){
	
		$name=$_REQUEST['name'];
		$c=$_REQUEST['catalog'];
		
		$pageSize=12;
		
		if($name == null){
			
			echo "<div style='text-align:center; color:red;'>请输入需要查询的内容</div>";
			
		} else {
			
			//插入到最近查询列表
			$sqlinsert="insert into recentsearch (name,catalog) values ('$name','$c')";
			$b=$sqlHelper->execute_dml($sqlinsert);
			
			if($c==1){
				//查找备品
				if(isset($_GET['page'])){
					$page=intval($_GET['page']);
				} else {
					$page=1;
				} //获取分页
				$offset=$pageSize*($page-1);
				$prepage=$page-1;
				$nextpage=$page+1;
				//获得所有结果列数
				$sqlcnt1="select count(*) from beipin where name like '%$name%'";
				$rescnt1=$sqlHelper -> execute_dql($sqlcnt1);
				$cntrow1 = $rescnt1->fetch_array();
				$numrow1=$cntrow1[0];
				//分页取出
				$sql1 = "select * from beipin where name like '%$name%' limit $offset,$pageSize";
				$res1 = $sqlHelper -> execute_dql($sql1);
				//总页数
				$totalpage = ceil($numrow1/$pageSize);
				if($numrow1==0)
				{
					echo "<div style='text-align:center; margin-top:30px; color:red;'>找不到该结果</div>";
				} else {

					$i=1;
					echo "<table class='gridtable' style='margin:0 auto; line-height:30px;'>
						 <tr><th width='60px;'>序号</th><th width='600px;'>名称</th><th width='200px;'>型号</th><th width='100px;'>数量</th><th width='100px;'>在装数量</th><th width='100px;'>所属设备</th></tr>
						 ";
					while ( $row1  =  $res1 -> fetch_array ()) {
						$eid1 = $row1['eid'];
						$sqle1 = "select e_name from equipments where id=$eid1";
						$rese1 = $sqlHelper -> execute_dql($sqle1);
						$rowe1 = $rese1 -> fetch_row();
						$ename1 = $rowe1[0];
						if($grade==0){
							echo  "<tr><td align='center'>$i</td><td align='center'><a href='../content2.php?eid=".$row1['eid']."'>";
						} else if($grade==1) {
							echo  "<tr><td align='center'>$i</td><td align='center'><a href='../content.php?eid=".$row1['eid']."'>";
						} else if($grade==2) {
							echo  "<tr><td align='center'>$i</td><td align='center'><a href='../contentread.php?eid=".$row1['eid']."'>";
						}
						 echo $row1 ['name'];
						 echo "</a></td><td align='center'>";
						 echo $row1['type'];
						 echo "</td><td align='center'>";
						 echo $row1['num'];
						 echo "</td><td align='center'>";
						 echo $row1['olnum'];
						 echo "</td><td align='center'>$ename1</td></tr>";
						 $i++;		
					}
					echo "</table>";
					$rescnt1 -> free();
					$res1 -> free();
					$rese1 -> free();
					//分页栏
					echo "<div align='center' style='margin-top:10px;'>";
					if($page!=1){
						echo "<a href='searchpages.php?page=".$prepage."&name=$name&catalog=1'>[上一页]</a>";
					}
					for($i=1;$i<$page;$i++){
						echo "<a href='searchpages.php?page=".$i."&name=$name&catalog=1'>[".$i."]</a>";
					}
					echo "[".$page."]";
					for($i=$page+1;$i<=$totalpage;$i++){
						echo "<a href='searchpages.php?page=".$i."&name=$name&catalog=1'>[".$i."]</a>";
					}
					if(!($page==$totalpage)){
						echo "<a href='searchpages.php?page=".$nextpage."&name=$name&catalog=1'>[下一页]</a>";
					}
					echo "</div>";
				}
			} else if($c==2){
				//查找异动单（可以直接下载）
				if(isset($_GET['page'])){
					$page=intval($_GET['page']);
				} else {
					$page=1;
				} //获取分页
				$offset=$pageSize*($page-1);  //
				$prepage=$page-1; //上一页
				$nextpage=$page+1; //下一页
				$sqlcnt2="select count(*) from yidongdan where name like '%$name%'";
				$rescnt2=$sqlHelper -> execute_dql($sqlcnt2);
				$cntrow2 = $rescnt2->fetch_array();
				$numrow2=$cntrow2[0];
				//总页数
				$totalpage = ceil($numrow2/$pageSize);
				//分页取出
				$sql2 = "select * from yidongdan where name like '%$name%' limit $offset,$pageSize";
				$res2 = $sqlHelper -> execute_dql($sql2);
				$row2_cnt = $res2 -> num_rows;
				if($row2_cnt==0)
				{
					echo "<div style='text-align:center; margin-top:30px; color:red;'>找不到该结果</div>";
				} else {
					
					$j=1;
					echo "<table class='gridtable' style='margin:0 auto;'>
						 <tr><th width='60px;'>序号</th><th width='600px;'>名称</th><th width='200px;'>所属设备</th><th width='50px;'>下载</th></tr>
						 ";
					while ( $row2  =  $res2 -> fetch_row ()) {
						 $eid2 = $row2[8];
						 $sqle2 = "select e_name from equipments where id=$eid2";
						 $rese2 = $sqlHelper -> execute_dql($sqle2);
						 $rowe2 = $rese2 -> fetch_row();
						 $ename2 = $rowe2[0];
						 echo  "<tr><td align='center'>$j</td><td align='center'>";print_r($row2[2]);echo"</td><td align='center'>$ename2</td><td align='center'><a href='../yidongdan/$row2[5]' download='$row2[5]'>";
						 echo "下载</a></td></tr>";
						 $j++;		
					}
					echo "</table>";
					$rescnt2 -> free();
					$res2 -> free();
					$rese2 -> free();
					//分页栏
					echo "<div align='center' style='margin-top:10px;'>";
					if($page!=1){
						echo "<a href='searchpages.php?page=".$prepage."&name=$name&catalog=2'>[上一页]</a>";
					}
					for($i=1;$i<$page;$i++){
						echo "<a href='searchpages.php?page=".$i."&name=$name&catalog=2'>[".$i."]</a>";
					}
					echo "[".$page."]";
					for($i=$page+1;$i<=$totalpage;$i++){
						echo "<a href='searchpages.php?page=".$i."&name=$name&catalog=2'>[".$i."]</a>";
					}
					if(!($page==$totalpage)){
						echo "<a href='searchpages.php?page=".$nextpage."&name=$name&catalog=2'>[下一页]</a>";
					}
					echo "</div>";
				}
				
			} else if($c==3){
				//查找模拟单（可以直接下载）
				if(isset($_GET['page'])){
					$page=intval($_GET['page']);
				} else {
					$page=1;
				} //获取分页
				$offset=$pageSize*($page-1);  //
				$prepage=$page-1; //上一页
				$nextpage=$page+1; //下一页
				$sqlcnt3="select count(*) from monidan where name like '%$name%'";
				$rescnt3=$sqlHelper -> execute_dql($sqlcnt3);
				$cntrow3 = $rescnt3->fetch_array();
				$numrow3=$cntrow3[0];
				//总页数
				$totalpage = ceil($numrow3/$pageSize);
				//分页取出
				$sql3 = "select * from monidan where name like '%$name%' limit $offset,$pageSize";
				$res3 = $sqlHelper -> execute_dql($sql3);
				$row3_cnt = $res3 -> num_rows;
				if($row3_cnt==0)
				{
					echo "<div style='text-align:center; margin-top:30px; color:red;'>找不到该结果</div>";
				} else {
					
					$k=1;
					echo "<table class='gridtable' style='margin:0 auto;'>
						 <tr><th width='60px;'>序号</th><th width='600px;'>名称</th><th width='200px;'>模拟时间</th><th width='200px;'>所属设备</th><th width='100px;'>下载</th></tr>
						 ";
					while ( $row3  =  $res3 -> fetch_row ()) {
						 $eid3 = $row3[7];
						 $sqle3 = "select e_name from equipments where id=$eid3";
						 $rese3 = $sqlHelper -> execute_dql($sqle3);
						 $rowe3 = $rese3 -> fetch_row();
						 $ename3 = $rowe3[0];
						 echo  "<tr><td align='center'>$k</td><td align='center'>";
						 echo $row3[1];
						 echo "</td><td align='center'>";
						 echo $row3[2];
						 echo"</td><td align='center'>$ename3</td><td  align='center'><a href='../monidan/$row3[4]' download='$row3[4]'>";
						 echo "下载</a></td></tr>";
						 $k++;		
					}
					echo "</table>";
					$rescnt3 -> free();
					$res3 -> free();
					$rese3 -> free();
					//分页栏
					echo "<div align='center' style='margin-top:10px;'>";
					if($page!=1){
						echo "<a href='searchpages.php?page=".$prepage."&name=$name&catalog=3'>[上一页]</a>";
					}
					for($i=1;$i<$page;$i++){
						echo "<a href='searchpages.php?page=".$i."&name=$name&catalog=3'>[".$i."]</a>";
					}
					echo "[".$page."]";
					for($i=$page+1;$i<=$totalpage;$i++){
						echo "<a href='searchpages.php?page=".$i."&name=$name&catalog=3'>[".$i."]</a>";
					}
					if(!($page==$totalpage)){
						echo "<a href='searchpages.php?page=".$nextpage."&name=$name&catalog=3'>[下一页]</a>";
					}
					echo "</div>";
				}
			}
		/*	else if($c==4){
				//查找设备
				$sql4 = "select * from equipments where e_name like '%$name%'";
				$res4 = $sqlHelper -> execute_dql($sql4);
				$row4_cnt = $res4 -> num_rows;
				if($row4_cnt==0)
				{
					echo "<div style='text-align:center; margin-top:30px; color:red;'>找不到该结果</div>";
				} else {
					
					$k=1;
					echo "<table class='gridtable' style='margin:0 auto;'>
						 <tr><th width='60px;'>序号</th><th width='600px;'>名称</th></tr>
						 ";
					while ( $row4  =  $res4 -> fetch_array ()) {
						 if($grade==0){
							 echo  "<tr><td align='center'>$k</td><td align='center'><a href='content2.php?eid=".$row4['id']."'>";
						 } else if($grade==1){
							 echo  "<tr><td align='center'>$k</td><td align='center'><a href='content.php?eid=".$row4['id']."'>";
						 } else if($grade==2){
							 echo  "<tr><td align='center'>$k</td><td align='center'><a href='contentread.php?eid=".$row4['id']."'>";
						 }
						 echo $row4['e_name'];
						 echo "</a></td>";
						 </tr>";
						 $k++;	
					}
					echo "</table>";
					$res4 -> free();
					
				}
			}*/
			else {
				echo "<div style='text-align:center; color:red;'>请选择需要查询的项目</div>";
			}
		}
		
		
		
		
	}

	echo	'<div class="footer" style="text-align:center; margin-top:580px; color:gray; font-size:10px;">华能福州电厂台帐管理系统-检修部-热工专业</div>';

?>