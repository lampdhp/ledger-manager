<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php

	require_once('api/validate.php');
			
	checkUserValidate();	

?>

<head>
    <title></title>
	<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="js/jquery.jeditable.js"></script>
	
	<script type="text/javascript" src="layer/layer.js"></script>
	<link rel="stylesheet" href="css/content.css" type="text/css" />
	
    <script type="text/javascript">
		//Tab切换
        function nTabs(thisObj, Num) {
            if (thisObj.className == "active") return;
            var tabObj = thisObj.parentNode.id;
            var tabList = document.getElementById(tabObj).getElementsByTagName("li");
            for (i = 0; i < tabList.length; i++) {
                if (i == Num) {
                    thisObj.className = "active";
                    document.getElementById(tabObj + "_Content" + i).style.display = "block";
                } else {
                    tabList[i].className = "normal";
                    document.getElementById(tabObj + "_Content" + i).style.display = "none";
                }
            }
        }
    </script>

	<script type="text/javascript">
		//jQuery获取地址栏参数		
		function GetQueryString(name)
		{
			 var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
			 var r = window.location.search.substr(1).match(reg);
			 if(r!=null)return  unescape(r[2]); return null;
		}
	</script>
	<script type="text/javascript">
		var eid=GetQueryString('eid');
		var curPage = 1; //当前页码
		var total,pageSize,totalPage,p;
//----------------------------------------------获取数据------------------------------------------------------------	
		//获取备品备件数据
		function getData(page){ 
			$.ajax({
				type: 'POST',
				url: 'api/pages.php',
				data: {'eid':eid,'pageNum':page-1},
				dataType:'json',
				beforeSend:function(){
					$("#beipin").append("<tr>loading...</tr>");
				},
				success:function(json){
					$("#beipin tr").eq(0).nextAll().empty();
					total = json.total; //总记录数
					pageSize = json.pageSize; //每页显示条数
					curPage = page; //当前页
					totalPage = json.totalPage; //总页数
					var tr = "";
					var list = json.list;
					var i=(curPage-1)*pageSize+1;
					if(total==0){
						tr += "<tr><td align='center' >1</td><td align='center'>无</td><td align='center'>无</td><td align='center' >无</td><td align='center' >无</td><td align='center' >无</td><td align='center' >无</td><td align='center' >无</td><td align='center'></td></tr>";
					}
					else{
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center' >"+i+"</td><td align='center'>"+array['name']+"</td><td align='center'>"+array['type']+"</td><td align='center' class='edit' id='"+array['id']+"'>"+array['num']+"</td><td align='center' class='oledit' id='"+array['id']+"'>"+array['olnum']+"</td><td align='center' class='localedit' id='"+array['id']+"'>"+array['local']+"</td><td align='center' class='tipedit' id='"+array['id']+"'>"+array['tip']+"</td><td align='center' ><a href='javascript:showhis("+array['id']+")' class='cghis' style='color:#666'>查看</a></td><td align='center'><a href='api/delBeipin.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['name']+'?"'+");'>删除</a></td></tr>";
							i++;						
					});
					}
					$("#beipin").append(tr);
					$('.edit').editable('api/edit.php',{
						width:30,
						height:18,
						cancel:'取消',
						submit:'确定',
						//indicator:,
						tooltip:'单击可以修改',
						style:'display:inline'
					});
					$('.oledit').editable('api/oledit.php',{
						width:30,
						height:18,
						cancel:'取消',
						submit:'确定',
						//indicator:,
						tooltip:'单击可以修改',
						style:'display:inline'
					});
					$('.localedit').editable('api/editlocal.php',{
						width:100,
						height:18,
						cancel:'取消',
						submit:'确定',
						//indicator:,
						tooltip:'单击可以修改',
						style:'display:inline'
					});
					$('.tipedit').editable('api/tipedit.php',{
						width:100,
						height:18,
						cancel:'取消',
						submit:'确定',
						//indicator:,
						tooltip:'单击可以修改',
						style:'display:inline'
					});
				},
				complete:function(){ //生成分页条
					getPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		function showhis(bid){
			//查看修改历史	
			layer.open({
				type:2,
				title:'修改记录',
				//maxmin:true,
				//skin:'layer-layer-rim',
				area:['500px','600px'],
				offset:['100px','700px'],
				shadeClose:true,
				content:'api/showhis.php?bid='+bid	
			});
		}
		//获取事故数据分页
		function getsgData(page){ 
			$.ajax({
				type: 'POST',
				url: 'api/sgpages.php',
				data: {'eid':eid,'pageNum':page-1},
				dataType:'json',
				beforeSend:function(){
					$("#shigu").append("<tr>loading...</tr>");
				},
				success:function(json){
					$("#shigu tr").eq(0).nextAll().empty();
					total = json.total; //总记录数
					pageSize = json.pageSize; //每页显示条数
					curPage = page; //当前页
					totalPage = json.totalPage; //总页数
					var tr = "";
					var list = json.list;
					var j=(curPage-1)*pageSize+1;
					if(total==0){
						tr += "<tr><td align='center'>1</td><td align='center'>无</td><td align='center'>无</td></tr>";
					}
					else {
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center'>"+j+"</td><td align='center'>"+array['sgtime']+"</td><td align='center'>"+array['reason']+"</td><td align='center'><a href='api/delShigu.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['sgtime']+'这条记录?"'+");'>删除</a></td></tr>";
							j++;						
						});
					}
					
					
					$("#shigu").append(tr);
					
				},
				complete:function(){ //生成分页条
					getsgPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		//获取零部件数据分页
		function getlbjData(page){ 
			$.ajax({
				type: 'POST',
				url: 'api/lbjpages.php',
				data: {'eid':eid,'pageNum':page-1},
				dataType:'json',
				beforeSend:function(){
					$("#bujian").append("<tr>loading...</tr>");
				},
				success:function(json){
					$("#bujian tr").eq(0).nextAll().empty();
					total = json.total; //总记录数
					pageSize = json.pageSize; //每页显示条数
					curPage = page; //当前页
					totalPage = json.totalPage; //总页数
					var tr = "";
					var list = json.list;
					var j=(curPage-1)*pageSize+1;
					if(total==0){
						tr += "<tr><td align='center'>1</td><td align='center'>无</td><td align='center'>无</td><td align='center'>无</td><td align='center'>无</td><td align='center'>无</td><td align='center'>无</td></tr>";
					}
					else {
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center'>"+j+"</td><td align='center'>"+array['name']+"</td><td align='center'>"+array['tuhao']+"</td><td align='center'>"+array['cgtime']+"</td><td align='center'>"+array['xorh']+"</td><td align='center'>"+array['litime']+"</td><td align='center'>"+array['reason']+"</td><td align='center'><a href='api/delLbj.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['name']+'?"'+");'>删除</a></td></tr>";
							j++;						
						});
					}
					
					
					$("#bujian").append(tr);
					
				},
				complete:function(){ //生成分页条
					getbjPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		//获取大修记录数据分页
		function getdxData(page){ 
			$.ajax({
				type: 'POST',
				url: 'api/dxpages.php',
				data: {'eid':eid,'pageNum':page-1},
				dataType:'json',
				beforeSend:function(){
					$("#daxiu").append("<tr>loading...</tr>");
				},
				success:function(json){
					$("#daxiu tr").eq(0).nextAll().empty();
					total = json.total; //总记录数
					pageSize = json.pageSize; //每页显示条数
					curPage = page; //当前页
					totalPage = json.totalPage; //总页数
					var tr = "";
					var list = json.list;
					var j=(curPage-1)*pageSize+1;
					if(total==0){
						tr += "<tr><td align='center'>1</td><td align='center'>无</td><td align='center'>无</td><td align='center'>无</td></tr>";
					}
					else {
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center'>"+j+"</td><td align='center'>"+array['dxtime']+"</td><td align='center'>"+array['jilu']+"</td><td align='center'><a href='dxjl/"+array['file_name']+"' download='"+array['file_name']+"'>下载</a></td><td align='center'><a href='api/delDxjl.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['dxtime']+'这条记录?"'+");'>删除</a></td></tr>";
							j++;						
						});
					}
					
					
					$("#daxiu").append(tr);
					
				},
				complete:function(){ //生成分页条
					getdxPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		//获取技术资料数据分页
		function getjsData(page){ 
			$.ajax({
				type: 'POST',
				url: 'api/jszlpages.php',
				data: {'eid':eid,'pageNum':page-1},
				dataType:'json',
				beforeSend:function(){
					$("#jszl").append("<tr>loading...</tr>");
				},
				success:function(json){
					$("#jszl tr").eq(0).nextAll().empty();
					total = json.total; //总记录数
					pageSize = json.pageSize; //每页显示条数
					curPage = page; //当前页
					totalPage = json.totalPage; //总页数
					var tr = "";
					var list = json.list;
					var k=(curPage-1)*pageSize+1;
					if(total==0){
						tr += "<tr><td align='center'>1</td><td align='center'>无</td></tr>";
					}
					else {
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center' width='200'>"+k+"</td><td align='center'><a href='jszl/"+array['file_name']+"' download='"+array['file_name']+"'>"+array['file_name']+"</a></td><td align='center'><a href='api/delJszl.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['file_name']+'?"'+");'>删除</a></td></tr>";  //<a href='monidan/$row_mnd[2]' download='$row_mnd[2]' >
							k++;						
						});
					}
					
					
					$("#jszl").append(tr);
					
				},
				complete:function(){ //生成分页条
					getjszlPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		//获取异动单数据分页
		function getydData(page){ 
			$.ajax({
				type: 'POST',
				url: 'api/yidongpages.php',
				data: {'eid':eid,'pageNum':page-1},
				dataType:'json',
				beforeSend:function(){
					$("#yidong").append("<tr>loading...</tr>");
				},
				success:function(json){
					$("#yidong tr").eq(0).nextAll().empty();
					total = json.total; //总记录数
					pageSize = json.pageSize; //每页显示条数
					curPage = page; //当前页
					totalPage = json.totalPage; //总页数
					var tr = "";
					var list = json.list;
					var y=(curPage-1)*pageSize+1;
					if(total==0){
						tr += "<tr><td align='center' width='200'>1</td><td align='center'>无</td></tr>";
					}
					else {
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center' width='200'>"+y+"</td><td align='center'>"+array['num']+"</td><td align='center'>"+array['name']+"</td><td align='center'>"+array['profile']+"</td><td align='center'><a href='yidongdan/"+array['file_name']+"' download='"+array['file_name']+"'>下载</a></td><td align='center'><a href='api/delYidong.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['file_name']+'?"'+");'>删除</a></td></tr>";  
							y++;						
						});
					}
					
					
					$("#yidong").append(tr);
					
				},
				complete:function(){ //生成分页条
					getydPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		//获取模拟单数据分页
		function getmnData(page){ 
			$.ajax({
				type: 'POST',
				url: 'api/monipages.php',
				data: {'eid':eid,'pageNum':page-1},
				dataType:'json',
				beforeSend:function(){
					$("#moni").append("<tr>loading...</tr>");
				},
				success:function(json){
					$("#moni tr").eq(0).nextAll().empty();
					total = json.total; //总记录数
					pageSize = json.pageSize; //每页显示条数
					curPage = page; //当前页
					totalPage = json.totalPage; //总页数
					var tr = "";
					var list = json.list;
					var m=(curPage-1)*pageSize+1;
					if(total==0){
						tr += "<tr><td align='center' width='200'>1</td><td align='center'>无</td></tr>";
					}
					else {
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center' width='200'>"+m+"</td><td align='center'>"+array['name']+"</td><td align='center'>"+array['mntime']+"</td><td align='center'><a href='monidan/"+array['file_name']+"' download='"+array['file_name']+"'>下载</a></td><td align='center'><a href='api/delMoni.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['file_name']+'?"'+");'>删除</a></td></tr>";  
							m++;						
						});
					}
					
					
					$("#moni").append(tr);
					
				},
				complete:function(){ //生成分页条
					getmnPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
//----------------------------------------------分页条------------------------------------------------------------		
		//备品备件分页条
		function getPageBar(){
			//页码大于最大页数
			if(curPage>totalPage) curPage=totalPage;
			//页码小于1
			if(curPage<1) curPage=1;
				pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
			//如果是第一页
			if(curPage==1){
				pageStr += "<span><a>1</a></span>";
				for(p=2;p<=totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
				}
			} else {
				//pageStr += "<span><a href='javascript:' rel='"+(parseInt(curPage)+1)+"'>下一页</a></span><span><a href='javascript:' rel='"+totalPage+"'>尾页</a></span>";
				
				//如果是最后页
				if(!(curPage>=totalPage)){
					for(p=1;p<=totalPage;p++){
						pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";	
					}
				} else {
					for(p=1;p<totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
					}
					pageStr += "<span><a>"+totalPage+"</a></span>";
				}
				//pageStr += "<a href='javascript:getData("+totalPage+")'>"+totalPage+"</a></span>";
			}
				
			$("#pagecount").html(pageStr);
		}
		
		//技术资料分页条
		function getjszlPageBar(){
			//页码大于最大页数
			if(curPage>totalPage) curPage=totalPage;
			//页码小于1
			if(curPage<1) curPage=1;
			pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
			
			//如果是第一页
			if(curPage==1){
				pageStr += "<span><a>1</a></span>";
				for(p=2;p<=totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
				}
			} else {				
				//如果是最后页
				if(!(curPage>=totalPage)){
					for(p=1;p<=totalPage;p++){
						pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";	
					}
				} else {
					for(p=1;p<totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
					}
					pageStr += "<span><a>"+totalPage+"</a></span>";
				}
			}
	
			$("#jszlpagecount").html(pageStr);
		}

		//重要事故分页条
		function getsgPageBar(){
			//页码大于最大页数
			if(curPage>totalPage) curPage=totalPage;
			//页码小于1
			if(curPage<1) curPage=1;
			pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
			
			//如果是第一页
			if(curPage==1){
				pageStr += "<span><a>1</a></span>";
				for(p=2;p<=totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
				}
			} else {				
				//如果是最后页
				if(!(curPage>=totalPage)){
					for(p=1;p<=totalPage;p++){
						pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";	
					}
				} else {
					for(p=1;p<totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
					}
					pageStr += "<span><a>"+totalPage+"</a></span>";
				}
			}
	
			$("#sgpagecount").html(pageStr);
		}
		
		//部件更换分页条
		function getbjPageBar(){
			//页码大于最大页数
			if(curPage>totalPage) curPage=totalPage;
			//页码小于1
			if(curPage<1) curPage=1;
			pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
			
			//如果是第一页
			if(curPage==1){
				pageStr += "<span><a>1</a></span>";
				for(p=2;p<=totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
				}
			} else {				
				//如果是最后页
				if(!(curPage>=totalPage)){
					for(p=1;p<=totalPage;p++){
						pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";	
					}
				} else {
					for(p=1;p<totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
					}
					pageStr += "<span><a>"+totalPage+"</a></span>";
				}
			}
	
			$("#bjpagecount").html(pageStr);
		}
		
		//大修记录分页条
		function getdxPageBar(){
			//页码大于最大页数
			if(curPage>totalPage) curPage=totalPage;
			//页码小于1
			if(curPage<1) curPage=1;
			pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
			
			//如果是第一页
			if(curPage==1){
				pageStr += "<span><a>1</a></span>";
				for(p=2;p<=totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
				}
			} else {				
				//如果是最后页
				if(!(curPage>=totalPage)){
					for(p=1;p<=totalPage;p++){
						pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";	
					}
				} else {
					for(p=1;p<totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
					}
					pageStr += "<span><a>"+totalPage+"</a></span>";
				}
			}
	
			$("#dxpagecount").html(pageStr);
		}
		
		//异动执行分页条
		function getydPageBar(){
			//页码大于最大页数
			if(curPage>totalPage) curPage=totalPage;
			//页码小于1
			if(curPage<1) curPage=1;
			pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
			
			//如果是第一页
			if(curPage==1){
				pageStr += "<span><a>1</a></span>";
				for(p=2;p<=totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
				}
			} else {				
				//如果是最后页
				if(!(curPage>=totalPage)){
					for(p=1;p<=totalPage;p++){
						pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";	
					}
				} else {
					for(p=1;p<totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
					}
					pageStr += "<span><a>"+totalPage+"</a></span>";
				}
			}
	
			$("#ydpagecount").html(pageStr);
		}
		
		//模拟单分页条
		function getmnPageBar(){
			//页码大于最大页数
			if(curPage>totalPage) curPage=totalPage;
			//页码小于1
			if(curPage<1) curPage=1;
			pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
			
			//如果是第一页
			if(curPage==1){
				pageStr += "<span><a>1</a></span>";
				for(p=2;p<=totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
				}
			} else {				
				//如果是最后页
				if(!(curPage>=totalPage)){
					for(p=1;p<=totalPage;p++){
						pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";	
					}
				} else {
					for(p=1;p<totalPage;p++){
					pageStr += "<span><a href='javascript:getData("+p+")'>"+p+"</a></span>";
					}
					pageStr += "<span><a>"+totalPage+"</a></span>";
				}
			}
	
			$("#mnpagecount").html(pageStr);
		}
		
		$(function(){
			getData(1);
			getsgData(1);
			getlbjData(1);
			getdxData(1);
			getjsData(1);
			getydData(1);
			getmnData(1);
			//$("#pagecount span a").on('click',function(){
			//	var rel = $(this).attr("rel");
			//	if(rel){
			//		getData(rel);
			//	}
			//});
			//上传技术资料
			$('.add_js').on('click',function(){
				layer.open({
					type:2,
					title:'技术资料',
					//maxmin:true,
					//skin:'layer-layer-rim',
					area:['540px','180px'],
					//offset:['100px','200px'],
					shadeClose:true,
					content:'api/jsSubmit.php?eid='+eid
					
				});
			});
			//添加备品
			$('.actionBtn').on('click',function(){
				layer.open({
					type:2,
					title:'添加备品',
					//maxmin:true,
					//skin:'layer-layer-rim',
					offset:['100px','700px'],
					area:['600px','420px'],
					shadeClose:true,
					content:'api/addBeipin.php?eid='+eid
					
				});
			});
			//添加事故
			$('.add_sg').on('click',function(){
				layer.open({
					type:2,
					title:'添加',
					//maxmin:true,
					//skin:'layer-layer-rim',
					area:['540px','240px'],
					offset:['100px','700px'],
					shadeClose:true,
					content:'api/addShigu.php?eid='+eid
					
				});
			});
			//添加大修记录
			$('.add_dx').on('click',function(){
				layer.open({
					type:2,
					title:'添加大修记录',
					//maxmin:true,
					//skin:'layer-layer-rim',
					area:['600px','300px'],
					offset:['100px','700px'],
					shadeClose:true,
					content:'api/addDxjl.php?eid='+eid
					
				});
			});
			//添加部件更换记录
			$('.add_bj').on('click',function(){
				layer.open({
					type:2,
					title:'添加部件更换记录',
					//maxmin:true,
					//skin:'layer-layer-rim',
					offset:['100px','700px'],
					area:['600px','420px'],
					offset:['100px','700px'],
					shadeClose:true,
					content:'api/addLbj.php?eid='+eid
					
				});
			});
			//上传异动单
			$('.add_yd').on('click',function(){
				layer.open({
					type:2,
					title:'异动单',
					//maxmin:true,
					//skin:'layer-layer-rim',
					area:['650px','480px'],
					offset:['100px','700px'],
					shadeClose:true,
					content:'api/ydSubmit.php?eid='+eid
					
				});
			});
			//上传模拟单
			$('.add_mn').on('click',function(){
				layer.open({
					type:2,
					title:'模拟单',
					//maxmin:true,
					//skin:'layer-layer-rim',
					area:['600px','350px'],
					offset:['100px','700px'],
					shadeClose:true,
					content:'api/mnSubmit.php?eid='+eid
					
				});
			});
		})
	</script>
</head>
<body>
    

<?php
	
	
	
	$file_to_require=realpath('api/SqlHelper.class.php'); 
	require_once $file_to_require;
	//header("content-type:text/html;charset=utf-8");
	//if(empty($_SESSION['tznum'])){
	//	header("Location: login.htm");
	//}
	
	
	$eid=$_GET['eid'];

	$sqlHelper= new SqlHelper ();
	
	
	$sql_title="select * from equipments where id=$eid";

	$res_title = $sqlHelper->execute_dql($sql_title);

	$title = $res_title->fetch_row();
	echo '
		<div style="text-align: center;">
		<a href="equipment1.php?sys='.$title[2].'" style="font-size:10px; " ><<返回列表</a>
        <h2 style="font-size:2.5em;">';
    echo   $title [1];
	$res_title -> free();
    echo   '</h2>
    </div>
	
    <div class="nTab">
        <!-- 标题开始 -->
        <div class="TabTitle">
            <ul id="myTab0">
                <li class="active" onclick="nTabs(this,0);">技术资料</li>
                <li class="normal" onclick="nTabs(this,1);">备品备件</li>
                <li class="normal" onclick="nTabs(this,2);">重要事故</li>
                <li class="normal" onclick="nTabs(this,3);">部件更换</li>
                <li class="normal" onclick="nTabs(this,4);">大修记录</li>
                <li class="normal" onclick="nTabs(this,5);">异动执行</li>
                <li class="normal" onclick="nTabs(this,6);">模拟单</li>
            </ul>
		</div>';
	
	echo '<!-- 内容开始 -->
        <div class="TabContent">';
			//技术资料
			echo    "<div id='myTab0_Content0' >
					<a href='javascript:' class='add_js'>上传</a>
					<table width='99%' border='0' cellpadding='8' cellspacing='0' class='tableBasic' id='jszl'>
					<tr>
						<th width='200'>序号</th>
						<th>文件名</th>
						<th width='50' align='center'>操作</th>
					</tr>";
		
			echo	"</table>";
			echo	'<div class="clear"></div>
					
						<div id="jszlpagecount"></div>
					
					</div>';
			//备品备件	
			echo    '<div id="myTab0_Content1" class="none">
					<a href="javascript:" class="actionBtn add" >添加</a>
					<table width="99%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="beipin">
					<tr>
						<th width="80" align="center">序号</th>
						<th align="center">名称</th>
						<th width="200" align="center">型号</th>
						<th width="150" align="center">数量</th>
						<th width="150" align="center">在装数量</th>
						<th width="200" align="center">存放位置</th>
						<th width="200" align="center">备注</th>
						<th width="80" align="center">修改记录</th>
						<th width="50" align="center">操作</th>
					</tr>';

					echo "</table>";
					echo '<div class="clear"></div>
					
					<div id="pagecount"></div>
					
					</div>';
			//重要事故
			echo '<div id="myTab0_Content2" class="none">
					<a href="javascript:" class="add_sg">添加</a>
					<table width="99%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="shigu">
					<tr>
						<th width="80" align="center">序号</th>
						<th width="180" align="center">事故发生时间</th>
						<th align="center">主 要 原 因</th>
						<th width="50" align="center">操作</th>
					</tr>';	
											
					echo "</table>";					
					
			echo	'<div class="clear"></div>
					
						<div id="sgpagecount"></div>
					
					</div>';
			
			//部件更换				
			echo '<div id="myTab0_Content3" class="none">
						<a href="javascript:" class="add_bj" >添加</a>
					<table width="99%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="bujian">
					<tr>
						<th width="80" align="center">序号</th>
						<th align="center">零部件名称</th>
						<th width="200" align="center">图号</th>
						<th width="150" align="center">更换日期</th>
						<th width="80" align="center">修或废</th>
						<th width="100" align="center">累计使用时间</th>
						<th width="600" align="center">原因</th>
						<th width="50" align="center">操作</th>
					</tr>';
					
			echo	'</table>
					<div class="clear"></div>
					
						<div id="bjpagecount"></div>
						
					</div>';
			
			//大修记录			
			echo '<div id="myTab0_Content4" class="none">
						<a href="javascript:" class="add_dx">添加</a>
					<table width="99%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="daxiu">
					<tr>
						<th width="80" align="center">序号</th>
						<th width="240" align="center">时间</th>
						<th align="center">概  述</th>
						<th width="80" align="center">下载</th>
						<th width="50" align="center">操作</th>
					</tr>';
					
			echo	'</table>
					<div class="clear"></div>
					
						<div id="dxpagecount"></div>
						
					</div>';
			
			//异动执行
			echo "<div id='myTab0_Content5' class='none'>
						<a href='javascript:' class='add_yd'>添加</a>
					<table width='99%' border='0' cellpadding='8' cellspacing='0' class='tableBasic' id='yidong'>
					<tr>
						<th width='100'>序号</th>
						<th width='300'>申请书编号</th>
						<th width='450'>名称</th>
						<th>简要内容</th>
						<th width='50'>下载</th>
						<th width='50' align='center'>操作</th>
					</tr>";
					
			echo	"</table>";
			echo 	'<div class="clear"></div>
					
						<div id="ydpagecount"></div>
						
					</div>';
			
			//模拟单
			echo "<div id='myTab0_Content6' class='none'>
					<a href='javascript:' class='add_mn'>上传</a>
					<table width='99%' border='0' cellpadding='8' cellspacing='0' class='tableBasic' id='moni'>
					<tr>
						<th width='200'>序号</th>
						<th>名称</th>
						<th width='400'>模拟时间</th>
						<th width='100'>下载</th>
						<th width='50' align='center'>操作</th>
					</tr>";

				
			echo	"</table>";
			echo 	'<div class="clear"></div>
					
						<div id="mnpagecount"></div>
						
					</div>';
				  
		echo '</div>';
	
	echo '</div>';
?> 
	<div class="footer" style="text-align:center; margin-top:20px; color:gray; font-size:14px;"><span>华能福州电厂台帐管理系统<br /><br />检修部-热工专业</span></div>
</body>
</html>
