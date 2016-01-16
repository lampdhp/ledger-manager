<?php

	//mysqli改写
	class SqlHelper {
		
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
			//
			//mysql_select_db($this->$db,$this->conn);
			$this->mysqli->query("set names utf8");
		}
		
		
		//完成 select
		public function execute_dql($sql){
			
			$res=$this->mysqli->query($sql) or die($this->mysqli->error);  //出错后把出错信息打出来
			
			return $res; 
		}		
		
		
		//完成 insert update deleted 
		public function execute_dml($sql){
			
			$res=$this->mysqli->query($sql) or die($this->mysqli->error); //
			if(!$res){
				return 0; //失败
			} else {
				if($this->mysqli->affected_rows>0){
					return 1; //成功
				} else {
					return 2; //没有行数受影响
				}
			}
			
		} 

	}

?>