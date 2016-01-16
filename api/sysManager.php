<script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>

<script>
	$(function(){
		$('.add').click(function(){
				$('.addTab').toggle();
		});
		$('.xianshi').click(function(){
				$('.editTab').toggle();
		});
		$('.editrow').editable('editSys.php',{
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
	
	var sys=[["锅炉","汽机","电气","脱硫","脱硝","DCS"],
				 ["锅炉","汽机","电气","脱硫","脱硝","DCS"],
				 ["锅炉","汽机","电气","脱硫","脱硝","DCS"],
				 ["锅炉","汽机","电气","脱硫","脱硝","DCS"],
				 ["锅炉","汽机","电气","脱硫","脱硝","DCS"],
				 ["锅炉","汽机","电气","脱硫","脱硝","DCS"],
				 ["一期辅网","二期辅网","三期辅网"],
				 ];
	
	var sysnum=[["1","2","3","4","5","6"],
				 ["1","2","3","4","5","6"],
				 ["1","2","3","4","5","6"],
				 ["1","2","3","4","5","6"],
				 ["1","2","3","4","5","6"],
				 ["1","2","3","4","5","6"],
				 ["7","8","9"]
				 ];
	
	function getSys(){
		
				 
		//获得机组下拉框的对象
         var sltjizu=document.form1.addjizu;
         //获得系统下拉框的对象
         var sltsys=document.form1.addsys;         
         //得到对应机组系统的数组
         var sysname=sys[sltjizu.selectedIndex -1 ];
		 var syscode=sysnum[sltjizu.selectedIndex -1 ];
 
         //清空系统下拉框，仅留提示选项
         sltsys.length=1;
 
         //将系统数组中的值填充到城市下拉框中
         for(var i=0;i<sysname.length;i++){
             sltsys[i+1]=new Option(sysname[i],syscode[i]);
         }		 
	}
	
	function edSys(){
		
				 
		//获得机组下拉框的对象
         var sltjizu=document.form1.jizu;
         //获得系统下拉框的对象
         var sltsys=document.form1.sys;         
         //得到对应机组系统的数组
         var sysname=sys[sltjizu.selectedIndex -1 ];
		 var syscode=sysnum[sltjizu.selectedIndex -1 ];
 
         //清空系统下拉框，仅留提示选项
         sltsys.length=1;
 
         //将系统数组中的值填充到城市下拉框中
         for(var i=0;i<sysname.length;i++){
             sltsys[i+1]=new Option(sysname[i],syscode[i]);
         }		 
	}
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
	
	echo "<h2 style='text-align:center; color: #8B2323'>系统管理</h2>";
	
	
	echo '<form action="" method="post" class="editForm" name="form1">
			<div style="margin-left:50px;">
			<h4 class="add">添加</h4>
			<table class="addTab" >
			<tr><td>名称：</td><td><input type="text" name="name" size="40" /></td></tr>
			<tr><td>机组：</td>
			<td><select name="addjizu" onChange="getSys()">
				<option value="0">请选择</option>
				<option value="1">1号机</option>
				<option value="2">2号机</option>
				<option value="3">3号机</option>
				<option value="4">4号机</option>
				<option value="5">5号机</option>
				<option value="6">6号机</option>
				<option value="7">辅网</option>
				</select>
			<select name="addsys">
				<option value="0">请选择系统</option>
				
				</select></td>
			<td>&nbsp;<input type="submit" value="添加" class="addBtn" name="add"></td>
			</tr></table>
			<h4 class="xianshi">请选择需要编辑的系统后点击显示</h4>
			<table class="editTab" >
			<tr>
			<td><select name="jizu" onChange="edSys()">
				<option value="0">请选择</option>
				<option value="1">1号机</option>
				<option value="2">2号机</option>
				<option value="3">3号机</option>
				<option value="4">4号机</option>
				<option value="5">5号机</option>
				<option value="6">6号机</option>
				<option value="7">辅网</option>
				</select></td>
			<td><select name="sys">
				<option value="0">请选择系统</option>
				</select></td>
			<td><input type="submit" value="显示" class="editBtn" name="edit"></td>
			</tr></table>
			</div>
			</form>';
	
	if(isset($_POST))
	{
			
		if(isset($_POST['add'])){
			
			$name = $_POST['name'];
			$addjizu = $_POST['addjizu'];
			$addm_sys = $_POST['addsys'];
			//echo $name.$addjizu.$addm_sys;
			//添加系统
			if($name == null){
				echo "名称不能为空";    
			} else {
				$sqladd = "insert into sys (name,jizu,mainsys) values ('$name','$addjizu','$addm_sys')";
			
				$b = $sqlHelper -> execute_dml($sqladd);
				if($b==1){
					echo "添加成功";
				} else {
					echo "添加失败";
				}
			}
			
			
			
		}		
		else if(isset($_POST['edit'])){
			
			$jizu = $_POST['jizu'];
			$m_sys = $_POST['sys'];
			
			$sql="select * from sys where jizu=$jizu and mainsys=$m_sys";
			
			$res = $sqlHelper -> execute_dql($sql); 
			
			//$row_cnt=$res->num_rows ;
			$i=1;
			
			//$row_cnt = $res -> num_rows;
			
			echo "<table class='gridtable' style='margin-left:50px;'><tr>";
			while ( $row  =  $res -> fetch_row ()) {
				 echo  "<td><input type='checkbox' name='gid[]' value='$row[0]' ></td><td class='editrow' id='$row[0]'>";
				 echo $row [ 1 ];
				 echo "</td>";
				 if($i%4==0)
				 {
					echo "</tr><tr>";
				 }
				 $i++;
			}
			
			$res -> free();
			
			echo "</tr><tr><td colspan='4'>";
			echo '<form action="delSys.php" id="delForm" method="post">
					<input type="hidden" name="action" value="del" />
					<input type="hidden" name="gid" value="" />
					<input type="submit" value="删除选中数据" />
				  </form></td></tr></table>';
			echo '<div>使用帮助：点击系统名称可直接进行编辑，选中后点击“删除”按钮则删除该系统（可多选）</div>';	  
		}
	
	}
?>