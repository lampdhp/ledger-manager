<?php
	
	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('validate.php');
	//验证管理员		
	checkUserValidate();
	
	$id=$_GET['id'];
	
	$sqlHelper= new SqlHelper();
	

	
	if(isset($_GET['id'])){
		$uid = $_GET['id'];

		$sql = "delete from users where id =$uid";
		
		//echo $sql;
		$b = $sqlHelper -> execute_dml($sql);

		if($b==1){
			echo '<div style="margin:50 auto; text-align:center;">
					<img src="../images/clearicon.png" style="width:200; margin-bottom:30px;"><br /><span>删除成功!</span><a href="">点此返回</a>
				  </div>';     

		} else {
			echo '删除失败';
		}
	}
	
	

?>