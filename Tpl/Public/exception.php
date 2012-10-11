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
	<div style="margin:60px auto;text-align:center;">
		<div style="margin-bottom:140px;"><img src="/Utility/Public/images/slogan2.png"></div>
		<h1 id="msg">
		<?php 
			if(isset($error) && is_string($error)) {
				echo $error;
			} else {
				echo "抱歉，您访问的页面不存在 :-(";
			}
		?>
		</h1>
	</div>
</body>
</html>