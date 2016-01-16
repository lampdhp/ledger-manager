//Ajax获取数据
//2015-12-17




		//var eid=GetQueryString('eid');
		var curPage = 1; //当前页码
		var total,pageSize,totalPage,p;
		//获取数据
		function getData(eid,page){ 
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
						tr += "<tr><td align='center'>1</td><td align='center'>无</td><td align='center'>无</td><td align='center' >无</td><td align='center'></td></tr>";
					}
					else{
						$.each(list,function(index,array){ //遍历json数据列
							tr += "<tr><td align='center'>"+i+"</td><td align='center'>"+array['name']+"</td><td align='center'>"+array['type']+"</td><td align='center' class='edit' id='"+array['id']+"'>"+array['num']+"</td><td align='center'><a href='api/delBeipin.php?id="+array['id']+"' onClick='return confirm("+'"确认删除'+array['name']+'?"'+");'>删除</a></td></tr>";
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
				},
				complete:function(){ //生成分页条
					getPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		
		function getsgData(eid,page){ 
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
							tr += "<tr><td align='center'>"+j+"</td><td align='center'>"+array['sgtime']+"</td><td align='center'>"+array['reason']+"</td></tr>";
							j++;						
						});
					}
					
					
					$("#shigu").append(tr);
					
				},
				complete:function(){ //生成分页条
					//getPageBar();
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert("数据加载失败");
					
				}
			});
		}
		
		//获取分页条
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

