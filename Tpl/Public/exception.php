<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>考评牛马</title>
	<style>
		h1 {
			font-family:"Microsoft Yahei","微软雅黑","Helvetica Neue",Arial,"Liberation Sans",FreeSans,sans-serif;
		}
	</style>
</head>
<body>
	<h1 style="margin:200px;text-align:center;" id="msg">
	<?php 
		if(isset($error) && is_string($error)) {
			echo $error;
		} else {
			echo "抱歉，您访问的页面不存在 :-(";
		}
	?>
	</h1>
</body>
</html>