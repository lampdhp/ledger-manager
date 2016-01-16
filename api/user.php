<style>
	a {
		text-decoration:none;
		color:black;
	}
</style>


<?php

	require_once('valiread.php');
	//验证用户		
	checkUserValidate();
	

	echo "<div>

			<table style='margin:80px auto; '>
			<tr><td align='center'  ><a href='changepwd.php'><img src='../images/changpwd.png'></a></td><td align='center' ><a href='logout.php'><img src='../images/logout.png'></a></td></tr>
			<tr><td align='center' ><a href='changepwd.php'>修改密码</a></td><td align='center' ><input type='hidden' name='tuichu'><a href='logout.php'  >退出登录</a></td></tr>
			</table>

		</div>";


?>