<?php
	
	require_once 'SqlHelper.class.php';
	require_once('valiuser.php');
			
	checkUserValidate();
	
	header("content-type:text/html;charset=utf-8");
	
	$id=$_POST['id'];
	$val=$_POST['value'];
	//修改备注

	
	$sqlHelper= new SqlHelper ();
	
	$sql="update beipin set tip='$val' where id=$id";
	
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