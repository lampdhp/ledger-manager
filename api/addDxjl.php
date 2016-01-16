<?php
	
	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('valiuser.php');
	//验证用户		
	checkUserValidate();
	
	$eid=$_GET['eid'];
	
	
	
	$sqlHelper= new SqlHelper();
	
	
	
	echo '<form enctype="multipart/form-data" name="dxuplaod" action="" method="post" class="addForm">
			<table border="0" style="margin-left:20px; margin-top:30px;">
			<tr height="40px">
			<td>大修时间：</td><td><input type="text" name="dxtime" size="50" /><span style="color:red">*</span></td>
			</tr>
			<tr>
			<td>概述：</td><td><textarea name="jilu" rows="4" cols="60"></textarea><span style="color:red">*</span></td>
			</tr>
			<tr><td align="right">上传文件：</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="100000000" >
						<input name="dxfile" type="file"></td></tr>
			<tr>
			<td colspan="2" align="right"><br /><input type="submit" value="确定" class="addBtn"><td>
			<tr>
			</table></form>';

	if($_POST)
	{
		$dxtime = $_POST['dxtime'];
		$jilu = $_POST['jilu'];
		
		if($dxtime==null||$jilu==null){
				echo "不能为空";
				
		} else {
			
			if(is_uploaded_file($_FILES['dxfile']['tmp_name'])){
				
				$dxfile=$_FILES['dxfile'];
				//设置超时限制时间，缺省为30秒，设置0时为不限时
				$time_limit=60;
				set_time_limit($time_limit);
				
				
				//文件格式，名字，大小
				$file_type=$dxfile['type'];
				$file_name=$dxfile['name'];
				$file_size=$dxfile['size'];
				//die($file_type);
				$file_time= date('y-m-d');
				$uploads_dir = '../dxjl';
				if(move_uploaded_file($_FILES['dxfile']['tmp_name'],"$uploads_dir/".iconv("UTF-8","gbk",$file_name))){
					
				} else {
					echo 'shibai';
				}			
				//把文件放到模拟单文件夹下
			
			
				$sql = "insert into dxjl (dxtime,jilu,file_type,file_name,file_size,file_time,eid) values ('$dxtime','$jilu','$file_type','$file_name',$file_size,'$file_time',$eid)";
				
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

	}

?>