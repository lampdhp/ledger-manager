<?php

	class connect {
		
	
		private $mysqli;
		//将来这里写的会配置到一个文件里
		private static $host="localhost";
		private static $user="root";
		private static $pwd="";
		private static $db="tzm";
		
		
		public function __construct(){
			//完成初始化任务
			$this->mysqli=new Mysqli(self::$host,self::$user,self::$pwd,self::$db);
			if($this->mysqli->connect_error){
				die("连接数据库失败".$this->mysqli->connect_error);
			}

			$this->mysqli->query("set names utf8");
		}
	}
	
	header("Content-Type: text/html; charset=utf-8");
?>
