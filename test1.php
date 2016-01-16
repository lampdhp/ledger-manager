<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>华能福州电厂台账管理系统</title>
	<meta name="description" content="Responsive Multi-Level Menu: Space-saving drop-down menu with subtle effects" />
	<meta name="keywords" content="multi-level menu, mobile menu, responsive, space-saving, drop-down menu, css, jquery" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/component.css" />

	<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
	<script src="js/modernizr.custom.js"></script>
	<script src="js/jquery.dlmenu.js"></script>

	<script type="text/javascript" src="layer/layer.js"></script>
	
	<script type="text/javascript">
		$(function(){
			$(".sysManager").on('click',function(){
				layer.open({
					type:2,
					title:'系统管理',
					//maxmin:true,
					skin:'layui-layer-rim',
					area:['900px','600px'],
					//offset:['100px','200px'],
					shadeClose:true,
					content:'api/sysManager.php'
					
				});
			});
			$(".user").on('click',function(){
				layer.open({
					type:2,
					title:'请选择',
					//maxmin:true,
					//skin:'layer-layer-rim',
					area:['540px','400px'],
					//offset:['100px','200px'],
					shadeClose:true,
					content:'api/admin.php'
					
				});
			});
		})
	
	</script>
</head>
<body>
<?php

			$file_to_require=realpath('api/SqlHelper.class.php'); 
			//require "api/SqlHelper.class.php";
			require_once $file_to_require;
			require_once('api/validate.php');
			
			checkUserValidate();
			
			$username=$_SESSION['tzname'];
			
			$sqlHelper= new SqlHelper ();
			
			echo	'<div class="header" style="height: 50px; position: absolute; background-color: black; width: 100%;">
					
					<a href="javascript:" class="user" target="contentFrame" style="float:right; margin-right:20px; margin-top:-1px; "><img src="images/user.png" title="用户设置" ></a>
					<a href="api/search.php" target="contentFrame" style="float:right; margin-right:10px; "><img src="images/search15.png" title="搜索"></a>
					<span style="float:right; font-size:13px; margin-top:25px; margin-right:25px;">欢迎，'; echo $username; echo'！</span>
				</div>
				<div class="container demo-1">
					
					<div class="column">';


			for($j=1;$j<=6;$j++){
				for($m=1;$m<=6;$m++){
					$sql = "select id,name from sys where jizu=$j and mainsys=$m";
					$res[$j][$m] = $sqlHelper -> execute_dql($sql);
					$row_cnt[$j][$m] = $res[$j][$m] ->num_rows;
					$height[$j][$m] = ($row_cnt[$j][$m]/4+2)*50;
				}
			}
			for($m=7;$m<=9;$m++){
					$sql = "select id,name from sys where jizu=7 and mainsys=$m";
					$res[7][$m] = $sqlHelper -> execute_dql($sql);
					$row_cnt[7][$m] = $res[7][$m] ->num_rows;
					$height[7][$m] = ($row_cnt[7][$m]/4+2)*50;
			}
			echo "<div id='dl-menu' class='dl-menuwrapper'>
				<button class='dl-trigger'>Open Menu</button>
				<ul class='dl-menu'>";
				//1号机
				echo	"<li>
						<a href='#'>1号机</a>
						<ul class='dl-submenu'>
							<li>
								<a href='#'>1号锅炉</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[1][1]);echo"px;'>";
									while ( $row11  =  $res[1][1] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row11[0]' target='contentFrame'>";
										 echo $row11 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[1][1]->free();
						echo	"</ul>
							</li>
							<li>
								<a href='#'>1号汽机</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[1][2]);echo"px;'>";
									while ( $row12  =  $res[1][2] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row12[0]' target='contentFrame'>";
										 echo $row12 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[1][2]->free();
						echo	"</ul></li>";
								
						echo	"
							<li>
								<a href='#'>1号电气</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[1][3]);echo"px;'>";
									while ( $row13  =  $res[1][3] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row13[0]' target='contentFrame'>";
										 echo $row13 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[1][3]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>1号脱硫</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[1][4]);echo"px;'>";
									while ( $row14  =  $res[1][4] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row14[0]' target='contentFrame'>";
										 echo $row14 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[1][4]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>1号脱硝</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[1][5]);echo"px;'>";
									while ( $row15  =  $res[1][5] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row15[0]' target='contentFrame'>";
										 echo $row15 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[1][5]->free();
						echo	"</ul>
							</li>";
							
						echo	"
							<li>
								<a href='#'>1号DCS</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[1][6]);echo"px;'>";
									while ( $row16  =  $res[1][6] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row16[0]' target='contentFrame'>";
										 echo $row16 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[1][6]->free();
						echo	"</ul>
							</li>";	
													
					echo '</ul>
				</li>';
					
				//2号机	
				echo	"<li>
						<a href='#'>2号机</a>
						<ul class='dl-submenu'>
							<li>
								<a href='#'>2号锅炉</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[2][1]);echo"px;'>";
									while ( $row21  =  $res[2][1] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row21[0]' target='contentFrame'>";
										 echo $row21 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[2][1]->free();
						echo	"</ul>
							</li>
							<li>
								<a href='#'>2号汽机</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[2][2]);echo"px;'>";
									while ( $row22  =  $res[2][2] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row22[0]' target='contentFrame'>";
										 echo $row22 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[2][2]->free();
						echo	"</ul></li>";
								
						echo	"
							<li>
								<a href='#'>2号电气</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[2][3]);echo"px;'>";
									while ( $row23  =  $res[2][3] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row23[0]' target='contentFrame'>";
										 echo $row23 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[2][3]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>2号脱硫</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[2][4]);echo"px;'>";
									while ( $row24  =  $res[2][4] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row24[0]' target='contentFrame'>";
										 echo $row24 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[2][4]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>2号脱硝</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[2][5]);echo"px;'>";
									while ( $row25  =  $res[2][5] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row25[0]' target='contentFrame'>";
										 echo $row25 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[2][5]->free();
						echo	"</ul>
							</li>";
							
						echo	"
							<li>
								<a href='#'>2号DCS</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[2][6]);echo"px;'>";
									while ( $row26  =  $res[2][6] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row26[0]' target='contentFrame'>";
										 echo $row26 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[2][6]->free();
						echo	"</ul>
							</li>";	
													
					echo '</ul>
				</li>';

				//3号机	
				echo	"<li>
						<a href='#'>3号机</a>
						<ul class='dl-submenu'>
							<li>
								<a href='#'>3号锅炉</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[3][1]);echo"px;'>";
									while ( $row31  =  $res[3][1] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row31[0]' target='contentFrame'>";
										 echo $row31 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[3][1]->free();
						echo	"</ul>
							</li>
							<li>
								<a href='#'>3号汽机</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[3][2]);echo"px;'>";
									while ( $row32  =  $res[3][2] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row32[0]' target='contentFrame'>";
										 echo $row32 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[3][2]->free();
						echo	"</ul></li>";
								
						echo	"
							<li>
								<a href='#'>3号电气</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[3][3]);echo"px;'>";
									while ( $row33  =  $res[3][3] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row33[0]' target='contentFrame'>";
										 echo $row33 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[3][3]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>3号脱硫</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[3][4]);echo"px;'>";
									while ( $row34  =  $res[3][4] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row34[0]' target='contentFrame'>";
										 echo $row34 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[3][4]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>3号脱硝</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[3][5]);echo"px;'>";
									while ( $row35  =  $res[3][5] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row35[0]' target='contentFrame'>";
										 echo $row35 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[3][5]->free();
						echo	"</ul>
							</li>";
							
						echo	"
							<li>
								<a href='#'>3号DCS</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[3][6]);echo"px;'>";
									while ( $row36  =  $res[3][6] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row36[0]' target='contentFrame'>";
										 echo $row36 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[3][6]->free();
						echo	"</ul>
							</li>";	
										
				echo '</ul>
				</li>';
					
				//4号机	
				echo	"<li>
						<a href='#'>4号机</a>
						<ul class='dl-submenu'>
							<li>
								<a href='#'>4号锅炉</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[4][1]);echo"px;'>";
									while ( $row41  =  $res[4][1] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row41[0]' target='contentFrame'>";
										 echo $row41 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[4][1]->free();
						echo	"</ul>
							</li>
							<li>
								<a href='#'>4号汽机</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[4][2]);echo"px;'>";
									while ( $row42  =  $res[4][2] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row42[0]' target='contentFrame'>";
										 echo $row42 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[4][2]->free();
						echo	"</ul></li>";
								
						echo	"
							<li>
								<a href='#'>4号电气</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[4][3]);echo"px;'>";
									while ( $row43  =  $res[4][3] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row43[0]' target='contentFrame'>";
										 echo $row43 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[4][3]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>4号脱硫</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[4][4]);echo"px;'>";
									while ( $row44  =  $res[4][4] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row44[0]' target='contentFrame'>";
										 echo $row44 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[4][4]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>4号脱硝</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[4][5]);echo"px;'>";
									while ( $row45  =  $res[4][5] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row45[0]' target='contentFrame'>";
										 echo $row45 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[4][5]->free();
						echo	"</ul>
							</li>";
							
						echo	"
							<li>
								<a href='#'>4号DCS</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[4][6]);echo"px;'>";
									while ( $row46  =  $res[4][6] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row46[0]' target='contentFrame'>";
										 echo $row46 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[4][6]->free();
						echo	"</ul>
							</li>";	
								
				echo '</ul>
				</li>';	

				//5号机	
				echo	"<li>
						<a href='#'>5号机</a>
						<ul class='dl-submenu'>
							<li>
								<a href='#'>5号锅炉</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[5][1]);echo"px;'>";
									while ( $row51  =  $res[5][1] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row51[0]' target='contentFrame'>";
										 echo $row51 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[5][1]->free();
						echo	"</ul>
							</li>
							<li>
								<a href='#'>5号汽机</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[5][2]);echo"px;'>";
									while ( $row52  =  $res[5][2] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row52[0]' target='contentFrame'>";
										 echo $row52 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[5][2]->free();
						echo	"</ul></li>";
								
						echo	"
							<li>
								<a href='#'>5号电气</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[5][3]);echo"px;'>";
									while ( $row53  =  $res[5][3] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row53[0]' target='contentFrame'>";
										 echo $row53 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[5][3]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>5号脱硫</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[5][4]);echo"px;'>";
									while ( $row54  =  $res[5][4] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row54[0]' target='contentFrame'>";
										 echo $row54 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[5][4]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>5号脱硝</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[5][5]);echo"px;'>";
									while ( $row55  =  $res[5][5] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row55[0]' target='contentFrame'>";
										 echo $row55 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[5][5]->free();
						echo	"</ul>
							</li>";
							
						echo	"
							<li>
								<a href='#'>5号DCS</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[5][6]);echo"px;'>";
									while ( $row56  =  $res[5][6] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row56[0]' target='contentFrame'>";
										 echo $row56 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[5][6]->free();
						echo	"</ul>
							</li>";	
								
				echo '</ul>
				</li>';
					
				//6号机	
				echo	"<li>
						<a href='#'>6号机</a>
						<ul class='dl-submenu'>
							<li>
								<a href='#'>6号锅炉</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[6][1]);echo"px;'>";
									while ( $row61  =  $res[6][1] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row61[0]' target='contentFrame'>";
										 echo $row61 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[6][1]->free();
						echo	"</ul>
							</li>
							<li>
								<a href='#'>6号汽机</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[6][2]);echo"px;'>";
									while ( $row62  =  $res[6][2] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row62[0]' target='contentFrame'>";
										 echo $row62 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[6][2]->free();
						echo	"</ul></li>";
								
						echo	"
							<li>
								<a href='#'>6号电气</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[6][3]);echo"px;'>";
									while ( $row63  =  $res[6][3] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row63[0]' target='contentFrame'>";
										 echo $row63 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[6][3]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>6号脱硫</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[6][4]);echo"px;'>";
									while ( $row64  =  $res[6][4] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row64[0]' target='contentFrame'>";
										 echo $row64 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[6][4]->free();
						echo	"</ul>
							</li>";
						
						echo	"
							<li>
								<a href='#'>6号脱硝</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[6][5]);echo"px;'>";
									while ( $row65  =  $res[6][5] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row65[0]' target='contentFrame'>";
										 echo $row65 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[6][5]->free();
						echo	"</ul>
							</li>";
							
						echo	"
							<li>
								<a href='#'>6号DCS</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[6][6]);echo"px;'>";
									while ( $row66  =  $res[6][6] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row66[0]' target='contentFrame'>";
										 echo $row66 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[6][6]->free();
						echo	"</ul>
							</li>";	
								
				echo '</ul>
				</li>';	
				
				//辅网	
				echo	"<li>
						<a href='#'>辅网</a>
						<ul class='dl-submenu'>
							<li>
								<a href='#'>一期辅网</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[7][7]);echo"px;'>";
									while ( $row77  =  $res[7][7] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row77[0]' target='contentFrame'>";
										 echo $row77 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[7][7]->free();
						echo	"</ul>
							</li>
							<li>
								<a href='#'>二期辅网</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[7][8]);echo"px;'>";
									while ( $row78  =  $res[7][8] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row78[0]' target='contentFrame'>";
										 echo $row78 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[7][8]->free();
						echo	"</ul></li>";
								
						echo	"
							<li>
								<a href='#'>三期辅网</a>
								<ul class='dl-submenu' style='width:1000px; height:";print($height[7][9]);echo"px;'>";
									while ( $row79  =  $res[7][9] -> fetch_row ()) {
										 echo  "<li style='float:left; width:25%;'><a href='equipment1.php?sys=$row79[0]' target='contentFrame'>";
										 echo $row79 [ 1 ];
										 echo "</a></li>";
										
									}
									$res[7][9]->free();
						echo	"</ul>
							</li>";
								
				echo '</ul>
				</li>';
					
				//设置	
				echo	'<li>
						<a class="sysManager"><img src="images/setting2.png" /></a>
					</li>
				</ul>
			</div><!-- /dl-menuwrapper -->';
			
			//}
?>
		<script>
			$(function() {
				$( '#dl-menu' ).dlmenu();
			});
		</script>
		</div>
		
	</div>
	
	<div id="content">
			
            <iframe id="mainFrame" name="contentFrame" width="100%"  scrolling="auto" height="960px" frameborder="false"
                allowtransparency="true" style="border: medium none; overflow-x: hidden; " src="api/search.php" 
                ></iframe>
    </div>
</body>