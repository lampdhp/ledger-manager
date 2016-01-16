<style type="text/css">
	.addForm
	{
		margin:20px;
	}
	.addBtn
	{
		margin-top:20px;
		margin-left:280px;
	}
</style>


<?php

	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('validate.php');
	//验证管理员		
	checkUserValidate();
	
	$jizu=$_GET['jz'];
	$m_sys=$_GET['sys'];

	
	$sqlHelper= new SqlHelper();
	
	//echo $sys;
	
	echo '<form action="" method="post" class="addForm">
			<table class="addTab">
			<tr><td>系统名称：</td><td><input type="text" name="name" size="40" /><span style="color:red">*</span></td></tr>

			</table>
			<input type="submit" value="确定" class="addBtn">
			</form>';
	
	if($_POST)
	{
		$name = $_POST['name'];
		
		if($name==null){
				echo "不能为空";
				
		} else {
			//echo $name.$type.$num;
			$sql = "insert into sys (e_name,jizu,mainsys) values ('$name',$jizu,$m_sys)";
			
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