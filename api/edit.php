<?php
	
	require_once 'SqlHelper.class.php';
	require_once('valiuser.php');
			
	checkUserValidate();
	
	header("content-type:text/html;charset=utf-8");
	
	$uname=$_SESSION['tzname'];
	
	$id=$_POST['id'];
	$val=$_POST['value'];
	$edtime=date('Y-m-d');
	//echo $id;
	//echo $val;
	
	$sqlHelper= new SqlHelper ();
	
	$sql="update beipin set num=$val where id=$id";
	$sqlhis="insert into alterbpnum (name,num,edtime,bpid) values ('$uname','$val','$edtime',$id)";
	//if(empty($val)){
	//	echo "不能为空";    //加上这句修改数量为0的时候会报错
		
	//}else{
		$b=$sqlHelper->execute_dml($sql);
		$s=$sqlHelper->execute_dml($sqlhis);
		
		if($b==1&&$s==1)
		{
			echo $val;
		} else{
			echo "修改失败";
		}
	//}
	
	
	
?>