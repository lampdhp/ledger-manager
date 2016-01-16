<style type="text/css">
	.addForm
	{
		margin:40px;
		margin-top:20px;
	}
	.addBtn
	{
		margin-top:20px;
		margin-left:420px;  /*350*/
		padding:10px 20px;
		font-size: 9pt;
		color: #003399;
		border: 1px #003399 solid;
		color: #006699;
		border-bottom: #93bee2 1px solid;
		border-left: #93bee2 1px solid;
		border-right: #93bee2 1px solid;
		border-top: #93bee2 1px solid;
		background-image: url(../images/bluebuttonbg.gif);
		background-color: #e8f4ff;
		cursor: hand;
		font-style: normal;
		width: 66px;
		height: 44px;
	}
	tr{
		line-height:30px;
	}
</style>

<?php

	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('valiuser.php');
	//验证用户		
	checkUserValidate();	
	
	$eid=$_GET['eid'];
	
	
	
	$sqlHelper= new SqlHelper();
	
	
	
	echo '<form action="" method="post" class="addForm">
			<table>
			<tr><td align="right">零部件名称：</td><td><input type="text" name="name" size="50" /><span style="color:red">*</span></td></tr>
			<tr><td align="right">图号：</td><td><input type="text" name="tuhao" size="50" /></td></tr>
			<tr><td align="right">更换日期：</td><td><input type="text" name="cgtime" /><span style="color:red">*</span></td></tr>
			<tr><td align="right">修或废：</td><td><input type="text" name="xorh" /></td></tr>
			<tr><td align="right">累计使用时间：</td><td><input type="text" name="ljtime" /></td></tr>
			<tr><td align="right">原因：</td><td><input type="text" name="reason" size="50" /><span style="color:red">*</span></td></tr>
			</table>
			<input type="submit" value="确定" class="addBtn">
			</form>';

	if($_POST)
	{
		$name = $_POST['name'];
		$tuhao = $_POST['tuhao'];
		$cgtime = $_POST['cgtime']; 
		$xorh = $_POST['xorh']; 		
		$ljtime = $_POST['ljtime'];
		$reason = $_POST['reason'];
		
		if($name==null||$cgtime==null||$reason==null){
				echo "带*号的不能为空";
				
		} else {
			//echo $name.$type.$num;
			$sql = "insert into lingbujian (name,tuhao,cgtime,xorh,ljtime,reason,eid) values ('$name','$tuhao','$cgtime','$xorh','$ljtime','$reason',$eid)";
			
			$b = $sqlHelper -> execute_dml($sql);
			if($b==1){
				echo "添加成功,本页面将在3秒后关闭";
				echo '
					<script type="text/javascript">					
					
					window.setTimeout(closeWin,3000);
					function closeWin(){
						var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						parent.layer.close(index); //再执行关闭
						
					}
					</script>
					';
			} else {
				echo "添加失败";
			}
								
		}

	}
	
?>