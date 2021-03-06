<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title>任务运行日志</title>

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
<table class="altrowstable" id="alternatecolor">
	<tr>
		<td>ID</td>
		<td>运行时间</td>
		<td>消耗时间</td>
		<td>是否成功</td>
		<td>返回信息</td>
	</tr>
	<?php if(is_array($recordList)): foreach($recordList as $key=>$item): ?><tr>
		<td><?php echo ($item["id"]); ?></td>
		<td><?php echo ($item["runtime"]); ?></td>
		<td><?php echo ($item["use_time"]); ?></td>
		<td><?php echo ($item["run_status"]); ?></td>
		<td><?php echo ($item["err_msg"]); ?></td>
	</tr><?php endforeach; endif; ?>
</table>
</body>
</html>