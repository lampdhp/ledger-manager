<?php
	
	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('valiread.php');
	//验证用户		
	checkUserValidate();
	
	$sqlHelper= new SqlHelper();
	
	//session_start();
	
	$uid = $_SESSION['tzid'];		//从session获取
	echo '<form action="" method="post" class="changepwd">
			<table style="margin:100px auto;">
			<tr><td>旧密码：</td><td><input type="password" name="oldpwd" size="30" /><span style="color:red;">*</span></td></tr>
			<tr><td>新密码：</td><td><input type="password" name="newpwd" size="30" /><span style="color:red;">*</span></td></tr>
			<tr><td>请重新输入：</td><td><input type="password" name="renewpwd" size="30" /><span style="color:red;">*</span></td></tr>
			<tr><td colspan="2" align="right" ><input type="submit" value="确定" class="addBtn"><a href="user.php" style="text-decoration:none; color:black; font-size:11px; padding-left:5px;">返回</a></td></tr>
			</table>
			
			</form>';
	
	if($_POST){
		
		$oldpwd = md5($_POST['oldpwd']);
		$newpwd = md5($_POST['newpwd']);
		$renewpwd = md5($_POST['renewpwd']);
		
		if($oldpwd=="" || $newpwd=="" || $renewpwd==""){
			echo "密码不能为空";	
		} else {
			if(!($newpwd==$renewpwd)){
				echo "两次输入必须相同";
			} else {
				
				//取出旧密码
				$sql = "select pwd from users where id = $uid";
				$res = $sqlHelper -> execute_dql($sql);
				$row = $res ->fetch_array();
				if($row['pwd']==$oldpwd){
					
					$sqlupdate = "update users set pwd='$newpwd' where id=$uid";
					$b = $sqlHelper -> execute_dml($sqlupdate);
					if($b==1){
						echo "修改成功,请关闭或返回";
					} else {
						echo "修改失败";
					}
				}
			}
		}	
			
	}
	
	



?>