<?php
	
	require_once 'SqlHelper.class.php';
	header("content-type:text/html;charset=utf-8");
	
	$id=$_POST['id'];
	$val=$_POST['value'];

	//echo $id;
	//echo $val;
	
	$sqlHelper= new SqlHelper ();
	
	$sql="update users set grade=$val where id=$id";
	
	//if(empty($val)){
	//	echo "不能为空";    //加上这句修改数量为0的时候会报错
		
	//}else{
		$b=$sqlHelper->execute_dml($sql);
		if($b==1)
		{
			if($val==0){
				echo "管理员";
			} else if($val==1){
				echo "编辑";
			} else if($val==2){
				echo "用户";
			}
		} else{
			echo "修改失败";
		}
	//}
	
	
	
?>