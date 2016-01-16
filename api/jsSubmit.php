<?php

	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('valiuser.php');
	//验证用户		
	checkUserValidate();
	
	$eid = $_GET['eid'];
	
	$sqlHelper= new SqlHelper ();
	
	echo "<br /><br /><form enctype='multipart/form-data' name='jsuplaod' action='' method='post'>
						&nbsp;&nbsp;&nbsp;&nbsp;<input type='hidden' name='MAX_FILE_SIZE' value='100000000' >
						选择上传文件<input name='jsfile' type='file'>&nbsp;&nbsp;<input name='submit' value='上传' type='submit'>
					</form>";
	
	if($_POST){
		if(is_uploaded_file($_FILES['jsfile']['tmp_name'])){
			
			$jsfile=$_FILES['jsfile'];
			//设置超时限制时间，缺省为30秒，设置0时为不限时
			$time_limit=60;
			set_time_limit($time_limit);
			
			
			//把文件内容读到字符串中
			//$fp=fopen($mnfile['tmp_name'], "rb");
			//if(!$fp) die("flie open error");
			//$file_data = addslashes(fread($fp,filesize($mnfile['tmp_name'])));
			//fclose($fp);
			//unlink($mnfile['tmp_name']);
			
			//文件格式，名字，大小
			$file_type=$jsfile['type'];
			$file_name=$jsfile['name'];
			$file_size=$jsfile['size'];
			//die($file_type);
			$file_time= date('y-m-d');
			$uploads_dir = '../jszl';
			if(move_uploaded_file($_FILES['jsfile']['tmp_name'],"$uploads_dir/".iconv("UTF-8","gbk",$file_name))){
				
			} else {
				echo 'shibai';
			}			
			//把文件放到模拟单文件夹下
			
			
			//把文件存到数据库中
			$sql="insert into jszl (file_type,file_name,file_size,file_time,eid) values ('$file_type','$file_name',$file_size,'$file_time',$eid)";
			//die($sql);
			
			$b=$sqlHelper -> execute_dml($sql);
			if($b==1){
				echo "上传成功,本页面将在3秒后关闭";
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
				echo "上传失败";
			}
			
		} else {
			echo "没有上传任何文件";
		}
	}
?>