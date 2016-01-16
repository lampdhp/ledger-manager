<?php

	require_once('SqlHelper.class.php');

	header("content-type:text/html;charset=utf-8");
	
	$sqlHelper= new SqlHelper();
	
	
	
	if(isset($_POST['num'])&&isset($_POST['pwd'])){
		$num=$_POST['num'];
		$pwd=md5($_POST['pwd']);
		
		//echo $num.$pwd;
		$sql="select id,num,name,pwd,grade from users where num='$num'";
		
		$res = $sqlHelper -> execute_dql($sql);

		if($row = $res ->fetch_array() ){
			if($row['pwd'] == $pwd){
				//把登录信息写入cookies
				session_start();
				$_SESSION['tzid']=$row['id'];
				$_SESSION['tznum']=$row['num'];
				$_SESSION['tzname']=$row['name'];
				$_SESSION['tzgrade']=$row['grade'];
				//跳转
				if($row['grade']==0){ //管理员
					header('Location:../test1.php');
				} else { // if($row['grade']==1 || ){  //编辑
					header('Location:../test.php');
				} 	
			} else {
				echo "输入的密码有误";
			}
		} else {
			echo "用户名有误";
		}
		
	}

?>