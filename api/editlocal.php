<?php
	
	require_once 'SqlHelper.class.php';
	require_once('valiuser.php');
			
	checkUserValidate();
	
	header("content-type:text/html;charset=utf-8");
	
	$id=$_POST['id'];
	$val=$_POST['value'];

	//echo $id;
	//echo $val;
	
	$sqlHelper= new SqlHelper ();
	
	$sql="update beipin set local='$val' where id=$id";

	//if(empty($val)){
	//	echo "不能为空";    //加上这句修改数量为0的时候会报错
		
	//}else{
		$b=$sqlHelper->execute_dml($sql);
		
		if($b==1)
		{
			echo $val;
		} else{
			echo "修改失败";
		}
	//}
	
	
	
?>