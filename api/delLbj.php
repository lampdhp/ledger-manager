<?php
	
	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('validate.php');
	//验证管理员		
	checkUserValidate();
	
	$id=$_GET['id'];
	
	$sqlHelper= new SqlHelper();
	
	$sql = "delete from lingbujian where id=$id";
	
	$b = $sqlHelper -> execute_dml($sql);

	if($b==1){
		echo '删除成功,将在3秒后返回';
		echo '<script type="text/javascript">
				window.setTimeout(backpage,3000);
					function backpage(){
					window.history.go(-1);	
				}				
			  </script>
			';
	} else {
		echo '删除失败';
	}

?>