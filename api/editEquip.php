<?php
	
	require_once 'SqlHelper.class.php';
	header("content-type:text/html;charset=utf-8");
	
	$id=$_POST['id'];
	$val=$_POST['value'];

	//echo $id;
	//echo $val;
	
	$sqlHelper= new SqlHelper ();
	
	$sql="update equipments set e_name='$val' where id=$id";
	
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