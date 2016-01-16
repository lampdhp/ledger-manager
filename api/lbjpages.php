<?php
require_once('SqlHelper.class.php');
header("content-type:text/html;charset=utf-8");

$eid = $_POST['eid'];
$page = intval($_POST['pageNum']);

$sqlHelper= new SqlHelper ();

$sql_bp="select * from lingbujian where eid=$eid";  


$result = $sqlHelper->execute_dql($sql_bp);;
$total = $result->num_rows;//总记录数

$pageSize = 12; //每页显示数
$totalPage = ceil($total/$pageSize); //总页数

$startPage = $page*$pageSize;
$arr['total'] = $total;
$arr['pageSize'] = $pageSize;
$arr['totalPage'] = $totalPage;
$firstPage="select id,name,tuhao,cgtime,xorh,ljtime,reason from lingbujian where eid=$eid order by id asc limit $startPage,$pageSize";
$query = $sqlHelper->execute_dql($firstPage);
while($row=$query->fetch_array()){
	 $arr['list'][] = array(
	 	'id' => $row['id'],
		'name' => $row['name'],
		'tuhao' => $row['tuhao'],
		'cgtime'  => $row['cgtime'],
		'xorh'  => $row['xorh'],
		'ljtime'  => $row['ljtime'],
		'reason'  => $row['reason']
	 );

}

//print_r($arr);
echo json_encode($arr);
?>