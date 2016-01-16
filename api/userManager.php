<script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>

<script>
	$(function(){
		$('.edgrade').editable('editgrade.php',{
			data   : " {'0':'管理员','1':'编辑','2':'用户'}",
			type   : 'select',
			cancel: '取消',
			submit: '确定',
			tooltip: '单击可以编辑'
		});

	});
</script>

<style type="text/css">

</style>


<?php

	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('validate.php');
	//验证管理员		
	checkUserValidate();
	
	$sqlHelper= new SqlHelper();
	
	echo "<h2 style='text-align:center;'>用户管理</h2>";
	
	
	echo '<form action="" method="post" class="editForm">
			<div style="margin-left:0px; text-align:center;">
			<h4>添加</h4>
			<table class="addTab" style="margin:0 auto;">
			<tr><td>员工编号：</td><td><input type="text" name="num" size="40" /><span style="color:red;">*</span></td></tr>
			<tr><td>员工姓名：</td><td><input type="text" name="name" size="40" /></td></tr>
			<tr><td>密码：</td><td><input type="password" name="pwd" size="40"  /><span style="color:red;">*</span></td></tr>
			<tr><td>权限：</td><td><select name="grade"><option>请选择</option><option value="0">管理员</option><option value="1">编辑</option><option value="2">用户</option></select><span style="color:red;">*</span></td></tr>
			<tr><td colspan="2" align="right"><input type="submit" value="添加" name="add" /><a href="admin.php" style="font-size:12px; text-decoration:none; padding-left:5px; color:black;">返回</a></td></tr>
			</table>
			<br />
			<h4>管理</h4>
			</form>';
			
	$sqls = "select id,num,name,grade from users";
	
	$res = $sqlHelper -> execute_dql($sqls);
	
	echo	'<table class="editTab" style="margin:0 auto;"><th width="100px;" >员工号</th><th width="100px;" >员工姓名</th><th width="100px;" >权限</th><th>操作</th>';
			;
			while($row = $res->fetch_row()){
				echo "<tr><td align='center'>$row[1]</td><td align='center'>$row[2]</td>";
				if($row[3]==0){
					echo "<td align='center' class='edgrade' id='$row[0]'>管理员</td>";
				} else if($row[3]==1){
					echo "<td align='center' class='edgrade' id='$row[0]'>编辑</td>";
				} else if($row[3]==2){
					echo "<td align='center' class='edgrade' id='$row[0]'>用户</td>";
				}
				echo "<td align='center'><a href='delUser.php?id=$row[0]' onClick='return confirm(";echo'"确认删除';echo $row[2];echo'？"';echo")' >删除</a></td></tr>";
			}
	echo 	'</table>
			</div>';
			
	
	if(isset($_POST['add']))
	{
			
		if(isset($_POST['add'])){
			
			$num = $_POST['num'];
			$name = $_POST['name'];
			$pwd = md5($_POST['pwd']);
			$grade = $_POST['grade'];
			
			//添加用户
			if($num == null){
				echo "员工号不能为空";    
			} else {
				$sqladd = "insert into users (num,name,pwd,grade) values ('$num','$name','$pwd','$grade')";
			
				$b = $sqlHelper -> execute_dml($sqladd);
				if($b==1){
					echo "添加成功";
					$num=null;$name=null;$pwd=null;$grade=null;
				} else {
					echo "添加失败";
				}
			}
				
		}
	
	}
?>