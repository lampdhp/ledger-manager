<style type="text/css">
	.addForm
	{
		margin:40px;
		margin-top:20px;
	}
	.addBtn
	{
		margin-top:30px;
		margin-left:380px;  /*350*/
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
			<tr><td>产品名称：</td><td><input type="text" name="name" size="50" /><span style="color:red;">*</span></td></tr>
			<tr><td>&nbsp;&nbsp;型号：</td><td><input type="text" name="type" size="50" /><span style="color:red;">*</span></td></tr>
			<tr><td>&nbsp;&nbsp;数量：</td><td><input type="text" name="num" /><span style="color:red;">*</span></td></tr>
			<tr><td>在装数量：</td><td><input type="text" name="olnum" /><span style="color:red;">*</span></td></tr>
			<tr><td>存放位置：</td><td><input type="text" name="local" size="50" /><span style="color:red;">*</span></td></tr>
			<tr><td>&nbsp;&nbsp;备注：</td><td><input type="text" name="tip" size="50" /></td></tr>
			</table>
			<input type="submit" value="确定" class="addBtn">
			</form>';

	if($_POST)
	{
		$name = $_POST['name'];
		$type = $_POST['type'];
		$num = $_POST['num'];  //intval($_POST['num'])
		$olnum = $_POST['olnum'];
		$local = $_POST['local'];
		$tip = $_POST['tip'];
		$addtime = date("Y-m-d");
		
		if($tip==null){
			$tip='无';
		}
		
		if($name==null||$type==null||$num==null){
				echo "不能为空";
				
		} else {
			//echo $name.$type.$num;
			$sql = "insert into beipin (name,type,num,olnum,local,tip,addtime,eid) values ('$name','$type',$num,$olnum,'$loacl','$tip','$addtime',$eid)";
			
			$b = $sqlHelper -> execute_dml($sql);
			if($b==1){
				echo "添加成功,本页面将在3秒后关闭";
				echo '
					<script type="text/javascript">					
					
					window.setTimeout(closeWin,3000);
					function closeWin(){
						var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						parent.layer.close(index); //再执行关闭
						getData(1);
					}
					</script>
					';
			} else {
				echo "添加失败";
			}
								
		}

	}
	
?>