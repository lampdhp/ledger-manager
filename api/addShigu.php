<?php
	
	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('valiuser.php');
	//验证用户		
	checkUserValidate();
	
	$eid=$_GET['eid'];
	
	
	
	$sqlHelper= new SqlHelper();
	
	
	
	echo '<form action="" method="post" class="addForm">
			<table border="0">
			<tr height="40px">
			<td>事故发生时间：</td><td><input type="text" name="sgtime" size="50" /><span style="color:red">*</span></td>
			</tr>
			<tr>
			<td>&nbsp;主要原因：</td><td><textarea name="reason" rows="3" cols="60"></textarea><span style="color:red">*</span></td>
			</tr>
			<tr>
			<td colspan="2" align="right"><br /><input type="submit" value="确定" class="addBtn"><td>
			<tr>
			</table></form>';

	if($_POST)
	{
		$sgtime = $_POST['sgtime'];
		$reason = $_POST['reason'];
		
		if($sgtime==null||$reason==null){
				echo "不能为空";
				
		} else {
			
			$sql = "insert into shigu (sgtime,reason,eid) values ('$sgtime','$reason',$eid)";
			
			$b = $sqlHelper -> execute_dml($sql);
			if($b==1){
				echo "添加成功,本页面将在3秒后关闭";
				echo '
					<script type="text/javascript">					
					
					window.setTimeout(closeWin,3000);
					function closeWin(){
						var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						parent.layer.close(index); //再执行关闭
						getsgData(1);
					}
					</script>
					';
			} else {
				echo "添加失败";
			}
								
		}

	}

?>