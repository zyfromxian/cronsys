<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title>添加任务</title>

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
<form action="?m=home&a=addTask" method="POST">
<table class="altrowstable" id="alternatecolor">
	<tr>
		<td>描述</td>
		<td><input type="text" name="desc"/></td>
		<td>例：xxxxx</td>
	</tr>
	<tr>
		<td>机器地址</td>
		<td><input type="text" name="address"/></td>
		<td>例：127.0.0.1:4730</td>
	</tr>
	<tr>
		<td>CMD</td>
		<td><input type="text" name="cmd"></td>
		<td>例：*/1 * * * * sh test.sh</td>
	</tr>
	<tr>
		<td>是否开启</td>
		<td><input type="radio" name="is_open" value="1">开启 <input type="radio" name="is_open" value="0">关闭</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="添加"></td>
		<td></td>
	</tr>
</table>
</form>
</body>
</html>