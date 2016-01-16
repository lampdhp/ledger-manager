<?php

	function checkUserValidate(){
		
		session_start();
		
		if(empty($_SESSION['tznum'])){
		
			header("Location: /tzm/login.htm");
		
		}
		$grade=$_SESSION['tzgrade'];

					
	}


?>