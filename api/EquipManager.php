<script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>

<script>
	$(function(){
		$('.add').click(function(){
				$('.addTab').toggle();
		});
		$('.show').click(function(){
				$('.gridtable').toggle();
		});
		$('.editrow').editable('editEquip.php',{
			width : 120,
			height: 24,
			cancel: '取消',
			submit: '确定',
			tooltip: '单击可以编辑'
		});
		//传递删除参数
		$('#delForm').submit(function(){
			var checkedNum = $("input[name='gid[]']:checked").length; 
			if(checkedNum == 0) {  
				alert("请选择至少一项！");  
				return false;  
			}
			if (confirm("是否确认删除？"))  {  //!confirm("是否确认删除？")
				//return false;
			
				var gid = '';
				/*$(':checkbox').each(function(){  //:checkbox
					if($(this).attr('checked')){  //$(this)
						var id = $(this).val();
						gid += id+',';
					}
				});*/
	 
				$("input[name='gid[]']:checked").each(function() {
					var id = $(this).val();
					gid += id+',';
				});
				gid = gid.substring(0,gid.length-1);
				$('[name=gid]').val(gid);
				return true;
			} else {
				return false;
			}
		});
	});
</script>

<style type="text/css">
	.addForm
	{
		margin:20px;
	}
	.addBtn
	{
		
		margin-left:20px;
	}
</style>


<?php

	require_once('SqlHelper.class.php');
	header("content-type:text/html;charset=utf-8");
	require_once('validate.php');
	//验证管理员		
	checkUserValidate();
	
	$e_sys=$_GET['sys'];

	
	$sqlHelper= new SqlHelper();
	
	echo "<h2 style='text-align:center;'>设备管理</h2>";
	
	echo '<form action="" method="post" class="addForm">
			<div >
			<h4 class="add" style="text-align:center;">添加</h4>
			<table class="addTab" style="margin:0 auto; " >
			<tr>
			 <td>名称：</td><td><input type="text" name="name" size="40" /><span style="color:red">*</span></td>
			 <td><input type="submit" value="确定" class="addBtn"></td></tr>

			</table>
			</div>
			</form>';
	
	$sqls="select * from equipments where e_sys=$e_sys";
	
	$ress = $sqlHelper->execute_dql($sqls);
	
	//设备编辑
	$i=1;
	echo "<h4 style='text-align:center;' class='show'>编辑</h4>";
	echo "<table class='gridtable' style='margin:20px auto;'><tr>";
	while ( $rows  =  $ress -> fetch_row ()) {
         echo  "<td><input type='checkbox' name='gid[]' value='$rows[0]' ></td><td class='editrow' id='$rows[0]'>";
		 echo $rows [ 1 ];
		 echo "</td>";
		 if($i%5==0)
		 {
			echo "</tr><tr>";
		 }
		 $i++;
    }
	
	$ress->free();
	
	//删除按钮
	echo "<form action='delEquip.php' id='delForm' method='post'>
					<tr><td colspan='10' style='text-align:center;'><input type='hidden' name='action' value='del' />
					<input type='hidden' name='gid' value='' />
					<input type='hidden' name='e_sys' value='$e_sys' />
					<input type='submit' value='删除选中数据' />
				  </form></td></tr></table>";
	echo '<div style="text-align:center;" >使用帮助：点击系统名称可直接进行编辑，选中后点击“删除”按钮则删除该系统（可多选）</div>';
	
	//操作
	if(isset($_POST['name']))
	{
		$name = $_POST['name'];
		
		if($name==null){
				echo "不能为空";
				
		} else {
			//echo $name.$type.$num;
			$sql = "insert into equipments (e_name,e_sys) values ('$name',$e_sys)";
			
			$b = $sqlHelper -> execute_dml($sql);
			if($b==1){
				echo "添加成功";
				
				//header ("location:EquipManager.php?sys=$e_sys"); 
			} else {
				echo "添加失败";
			}
								
		}

	}
	
	
?>