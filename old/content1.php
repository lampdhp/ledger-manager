<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.jeditable.js"></script>
	<link rel="stylesheet" href="css/content.css" type="text/css" />
    <script type="text/javascript">
		//Tab切换
        function nTabs(thisObj, Num) {
            if (thisObj.className == "active") return;
            var tabObj = thisObj.parentNode.id;
            var tabList = document.getElementById(tabObj).getElementsByTagName("li");
            for (i = 0; i < tabList.length; i++) {
                if (i == Num) {
                    thisObj.className = "active";
                    document.getElementById(tabObj + "_Content" + i).style.display = "block";
                } else {
                    tabList[i].className = "normal";
                    document.getElementById(tabObj + "_Content" + i).style.display = "none";
                }
            }
        }
    </script>
	<script type="text/javascript">
		//表格编辑
		$(function(){
			$('.edit').editable('api/edit.php',{
				width:30,
				height:18,
				cancel:'取消',
				submit:'确定',
				//indicator:,
				tooltip:'单击可以编辑',
				style:'display:inline'
			});
			
		});
	</script>
</head>
<body>
    

<?php
	
	
	
	$file_to_require=realpath('api/SqlHelper.class.php'); 
	//require "api/SqlHelper.class.php";
	require_once $file_to_require;
	//header("content-type:text/html;charset=utf-8");
	
	$eid=$_GET['eid'];
	
	//echo $e_sys;

	$sqlHelper= new SqlHelper ();
	
	$sql_bp="select * from beipin where eid=$eid";
	$sql_title="select * from equipments where id=$eid";
	$sql_sg="select * from shigu where eid=$eid";
	//$sql_lbj="select * from lingbujian where eid=$eid";
	
	$res = $sqlHelper->execute_dql($sql_bp);
	$res_title = $sqlHelper->execute_dql($sql_title);
	$res_sg= $sqlHelper->execute_dql($sql_sg);
	//$res_lbj= $sqlHelper->execute_dql($sql_lbj);
	
	$title = $res_title->fetch_row();
	echo '
		<div>
		<a href="equipment.php?sys='.$title[2].'" style="font-size:10px; " ><<返回列表</a>
        <h2>';
    echo   $title [1];    
    echo   '</h2>
    </div>
	
    <div class="nTab">
        <!-- 标题开始 -->
        <div class="TabTitle">
            <ul id="myTab0">
                <li class="active" onclick="nTabs(this,0);">技术资料</li>
                <li class="normal" onclick="nTabs(this,1);">备品备件</li>
                <li class="normal" onclick="nTabs(this,2);">重要事故</li>
                <li class="normal" onclick="nTabs(this,3);">部件更换</li>
                <li class="normal" onclick="nTabs(this,4);">大修记录</li>
                <li class="normal" onclick="nTabs(this,5);">异动执行</li>
                <li class="normal" onclick="nTabs(this,6);">模拟单</li>
            </ul>
		</div>';
	
	echo '<!-- 内容开始 -->
        <div class="TabContent">';
		
			echo    '<div id="myTab0_Content0">
						<a href="#" target="_blank">技术资料</a>
					</div>';
			//备品备件	
			echo    '<div id="myTab0_Content1" class="none">
					<a href="product_category.php?rec=add" class="actionBtn add">添加</a>
					<table width="98.5%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
					<tr>
						<th width="80" align="center">序号</th>
						<th align="center">名称</th>
						<th width="180" align="center">型号</th>
						<th width="150" align="center">数量</th>
						<th width="50" align="center">操作</th>
					</tr>';
					$i=1;
		
					while ( $row  =  $res -> fetch_row ()) {
						 echo '<tr><td align="center">';
						 echo $i;
						 $i=$i+1;
						 echo '</td><td align="center">';
						 echo $row [ 1 ];
						 echo '</td><td align="center">';
						 echo $row [2];
						 echo '</td><td class="edit" id="'.$row[0].'" align="center">';
						 echo $row [3];
						 echo '</td><td align="center">
							   <a href="article_category.php?rec=del&cat_id=1">删除</a>
							   </td></tr>';
						
					}
					echo "</table>";
					$res->free();

		
		
					echo '<div class="clear"></div>
					
						<div class="pager">
							总计 6 个记录，共 1 页，当前第 1 页 | <a href="product.php?page=1">第一页</a> 上一页 下一页 <a href="product.php?page=1">
							最末页</a></div>
					
					</div>';
				//重要事故
			echo '<div id="myTab0_Content2" class="none">
					<a href="product_category.php?rec=add" class="actionBtn add">添加</a>
					<table width="98.5%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
					<tr>
						<th width="80" align="center">序号</th>
						<th width="180" align="center">事故发生时间</th>
						<th align="center">主 要 原 因</th>
					</tr>';	
					$j=1;
					if($res_sg -> num_rows ==0)
					{
						echo '<tr><td align="center">1</td><td align="center">无</td><td align="center">无</td></tr>';						
					} 
					else {
						while($row_sg = $res_sg -> fetch_row()){
						 echo '<tr><td align="center">';
						 echo $i;
						 $j=$j+1;
						 echo '</td><td align="center">';
						 echo $row [ 1 ];
						 echo '</td><td align="center">';
						 echo $row [2];
						 echo '</td></tr>';						
						}						
					}						
					echo "</table>";					
					$res_sg -> free();
			echo	'</div>';
			
			//部件更换				
			echo '<div id="myTab0_Content3" class="none">
						<a href="#">部件更换</a></div>';
						
			echo '<div id="myTab0_Content4" class="none">
						<a href="#">大修记录</a></div>';
			
			//异动执行
			echo '<div id="myTab0_Content5" class="none">
						<a href="#">异动执行</a></div>';
			
			//模拟单
			echo '<div id="myTab0_Content6" class="none">
						<a href="#">模拟单</a></div>';
	
		echo '</div>';
	
	echo '</div>';
?>            
				
                  
                    
  
			
                
            
            
            
            
            
        
    
	

</body>
</html>
