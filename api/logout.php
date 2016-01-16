<?php

	session_start();
	
	session_destroy();
	
	echo "<div><table style='margin:50px auto;'>
			<tr><td align='center'><img src='../images/clearicon.png' width='100px'></td></tr>
			<tr><td align='center'>已退出,请关闭页面</td></tr>
			</table></div>";
	
	

	

?>