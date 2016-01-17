<?php

	function checkUserValidate(){
		
		session_start();
		
		if(empty($_SESSION['tznum'])){
		
			header("Location: /tzm/login.htm");
		
		}
		$grade=$_SESSION['tzgrade'];
		if(!($grade==1)&&!($grade==0)){ //验证是否是管理员或编辑
			
			session_destroy();
			header("Location: /tzm/login.htm");
			
		}			
	}


?>