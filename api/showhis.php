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

	
	$bid=$_GET['bid'];

	
	$sqlHelper= new SqlHelper();
	
	$sqltitle="select name from beipin where id = $bid";
	$restitle = $sqlHelper->execute_dql($sqltitle);
	$rowtitle = $restitle -> fetch_array();
	
	
	echo "<h2 style='text-align:center;'>".$rowtitle['name']."</h2>";
	
	$restitle -> free();
	
	$sql="select * from alterbpnum where bpid=$bid";
	
	$res = $sqlHelper->execute_dql($sql);
	
	//显示修改记录
	$i=1;

	echo "<table class='gridtable' style='margin:20px auto;'>";
	while ( $row  =  $res -> fetch_array ()) {
         echo  "<tr><td style='width:20px;'>（".$i."）</td><td>数量 于 ".$row['edtime']." 被 ".$row['name']." 修改成 ".$row['num']."</td></tr>";
		 $i++;
		 
    }
	echo "</table>";
	$res->free();
	
	/*删除按钮
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

	}*/
	
	
?>