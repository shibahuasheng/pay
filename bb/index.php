<?php
error_reporting(0); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/> 
<title>表白图片生成器</title>
<link type="text/css" rel="stylesheet" href="../css/frozen.css" />
	<link rel="stylesheet" href="../lib/weui.min.css">
	<link rel="stylesheet" href="../css/jquery-weui.css">
<style>
.ui-header-positive, .ui-footer-positive {
background-color: #f05557;
color: #fff;
}
a {
color: #f05557;
}
</style>
</head>
<body ontouchstart="">
<?php if($_GET['name']){?>
	<header class="ui-header ui-header-positive ui-border-b">
	<h1>长按下方图片点选保存图片</h1>
</header>
<div class="wrapper"><br><br>
	<img src="toutu.php?name=<?=$_GET['name']?>&id=<?=$_GET['id']?>" width="100%"/>
</div>

<?php }else{ ?>

<header class="ui-header ui-header-positive ui-border-b">
	<h1>表白图片生成器</h1>
</header>
<div class="wrapper"><br>
	<img src="icon.jpg" width="50%" style="margin:30px 25%;"/>
	<div class="ui-form">
    	<form action="">
			<div class="weui_cells weui_cells_form">
				<div class="weui_cell">
					<div class="weui_cell_hd"><label class="weui_label">姓名</label></div>
					<div class="weui_cell_bd weui_cell_primary">
						<input class="weui_input" type="input" name="name" placeholder="输入你的姓名">
					</div>
				</div>
				<div class="weui_cell weui_cell_select">
					<div class="weui_cell_bd weui_cell_primary">
						<select class="weui_select" name="id">
							<option selected="" value="0">性别</option>
							<option value="1">男</option>
							<option value="2">女</option>

						</select>
					</div>
				</div>
			</div>
			<button class="weui_btn weui_btn_primary" type="submit" value="确定">确定</button>

    	</form>
	</div><?php 
} 
//require_once '../foot.php';

?>
</body>
</html>