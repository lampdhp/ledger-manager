<?php
	
	require_once 'SqlHelper.class.php';
	header("content-type:text/html;charset=utf-8");
	require_once('validate.php');
	//验证管理员		
	checkUserValidate();
		
	$id=$_POST['id'];
	$val=$_POST['value'];

	//echo $id;
	//echo $val;
	
	$sqlHelper= new SqlHelper ();
	
	$sql="update sys set name='$val' where id=$id";
	
	if(empty($val)){
		echo "不能为空";
		
	}else{
		$b=$sqlHelper->execute_dml($sql);
		if($b)
		{
			echo $val;
		} else{
			echo "修改失败";
		}
	}
	
	
	
?>