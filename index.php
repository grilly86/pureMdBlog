<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<base href="http://<?=$_SERVER['SERVER_NAME']?><?=substr($_SERVER['PHP_SELF'],0,strlen($_SERVER['PHP_SELF'])-9)?>">
		
		<title><?php 
			$title = "";
			if (isset($_GET["file"]))
			{
				$title = urldecode($_GET["file"]);
				$title .= " &bull; ";
			}
			$title .= "grilly's blog";
			
			echo $title;
		?></title>
		<link rel="stylesheet" type="text/css" href="css/site.css" />
		<!--link rel="stylesheet/less" type="text/css" href="css/site.less"-->
		
		<script src="js/jquery.js" type="text/javascript"></script>"
		<script type="text/javascript" src="js/jquery.socialshareprivacy.min.js"></script>
		<script>
			$().ready(function() {
					$('.socialshareprivacy').each(function() {
						
						// URI FÜR PLUGIN VON ÜBERSCHRIFT KLAUEN
						
						var uri = $(this).parent().find("h1 a")[0].href;
						
						$(this).socialSharePrivacy({
							services : {
								facebook : {
									dummy_img:'js/socialshareprivacy/images/dummy_facebook.png'
								}, 
								twitter : {
									dummy_img:'js/socialshareprivacy/images/dummy_twitter.png'
								},
								gplus : {
									dummy_img:'js/socialshareprivacy/images/dummy_gplus.png'
								}
							},
							css_path:'js/socialshareprivacy/socialshareprivacy.css',
							uri:uri
						}); 
						
					});
			});
		</script>
	</head>
	<body>
		<h1><a href="./">grilly's blog</a></h1>
		
		<div id="contentContainer">
		<?php include "content.php"; ?>
		</div>
	</body>
</html>