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
	
	$eid = $_GET['eid'];
	
	$sqlHelper= new SqlHelper ();
	
	echo "<br /><br /><form enctype='multipart/form-data' name='yduplaod' action='' method='post' class='addForm'>
					<table>
						<tr><td align='right'>申请书编号：</td><td><input type='text' name='num' size='50' /><span style='color:red'>*</span></td></tr>
						<tr><td align='right'>名称：</td><td><input type='text' name='name' size='50' /><span style='color:red'>*</span></td></tr>
						<tr><td align='right'>简要内容：</td><td><textarea name='profile' rows='2' cols='55'></textarea><span style='color:red'>*</span></td></tr>
						<tr><td align='right'>上传文件：</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='hidden' name='MAX_FILE_SIZE' value='100000000' >
						<input name='ydfile' type='file'></td></tr>
					</table>
					<input name='submit' value='添加' type='submit' class='addBtn'>
					</form>";
	
	if($_POST){
		
		if(is_uploaded_file($_FILES['ydfile']['tmp_name'])){
			
			if(isset($_POST['num'])){
			
				$num = $_POST['num'];
				$name =$_POST['name'];
				$profile = $_POST['profile'];
			}
			
			$ydfile=$_FILES['ydfile'];
			//设置超时限制时间，缺省为30秒，设置0时为不限时
			$time_limit=60;
			set_time_limit($time_limit);
			
			//文件格式，名字，大小
			$file_type=$ydfile['type'];
			$file_name=$ydfile['name'];
			$file_size=$ydfile['size'];
			//die($file_type);
			$file_time= date('y-m-d');
			$uploads_dir = '../yidongdan';
			if(move_uploaded_file($_FILES['ydfile']['tmp_name'],"$uploads_dir/".iconv("UTF-8","gbk",$file_name))){
				
			} else {
				echo 'shibai';
			}			
			//把文件放到模拟单文件夹下
			
			
			//把文件存到数据库中
			$sql="insert into yidongdan (num,name,profile,file_type,file_name,file_size,file_time,eid) values ('$num','$name','$profile','$file_type','$file_name',$file_size,'$file_time',$eid)";
			//die($sql);
			
			$b=$sqlHelper -> execute_dml($sql);
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
			
		} else {
			echo "没有上传任何文件";
		}
	}
?>