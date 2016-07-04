<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title>任务列表</title>

<!-- Javascript goes in the document HEAD -->
<script type="text/javascript">
function altRows(id){
	if(document.getElementsByTagName){  
		
		var table = document.getElementById(id);  
		var rows = table.getElementsByTagName("tr"); 
		 
		for(i = 0; i < rows.length; i++){          
			if(i % 2 == 0){
				rows[i].className = "evenrowcolor";
			}else{
				rows[i].className = "oddrowcolor";
			}      
		}
	}
}

window.onload=function(){
	altRows('alternatecolor');
}
</script>


<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.altrowstable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #a9c6c9;
	border-collapse: collapse;
}
table.altrowstable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
table.altrowstable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
.oddrowcolor{
	background-color:#d4e3e5;
}
.evenrowcolor{
	background-color:#c3dde0;
}
</style>
</head>
<body>
<a href="?m=home&a=addTask">添加任务</a>
<table class="altrowstable" id="alternatecolor">
	<tr>
		<td>ID</td>
		<td>描述</td>
		<td>服务器地址</td>
		<td>CMD</td>
		<td>创建人</td>
		<td>创建时间</td>
		<td>是否在执行</td>
		<td>最后一次执行时间</td>
		<td>是否开启</td>
		<td>运行日志</td>
		<td>操作</td>
	</tr>
	<?php if(is_array($taskList)): foreach($taskList as $key=>$item): ?><tr>
		<td><?php echo ($item["id"]); ?></td>
		<td><?php echo ($item["desc"]); ?></td>
		<td><?php echo ($item["address"]); ?></td>
		<td><?php echo ($item["cmd"]); ?></td>
		<td><?php echo ($item["create_user"]); ?></td>
		<td><?php echo (date('Y-m-d H:i:s',$item["create_time"])); ?></td>
		<td><?php echo ($item["is_running"]); ?></td>
		<td><?php echo (date('Y-m-d H:i:s',$item["last_runtime"])); ?></td>
		<td><?php echo ($item["is_open"]); ?></td>
		<td><a href="?m=home&a=runRecord&task_id=<?php echo ($item["id"]); ?>">查看</a></td>
		<td><a href="?m=home&a=deleteTask&task_id=<?php echo ($item["id"]); ?>">删除</a>｜<a href="?m=home&a=modifyTask&task_id=<?php echo ($item["id"]); ?>">修改</a></td>
	</tr><?php endforeach; endif; ?>
</table>
</body>
</html>