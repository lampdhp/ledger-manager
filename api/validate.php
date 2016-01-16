<?php

	function checkUserValidate(){
		
		session_start();
		
		if(empty($_SESSION['tznum'])){
		
			header("Location: /tzm/login.htm");
		
		}
		$grade=$_SESSION['tzgrade'];
		if(!($grade==0)){ //验证是否是管理员
			
			session_destroy();
			header("Location: /tzm/login.htm");
			
		}
					
	}


?>