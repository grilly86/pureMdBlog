<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			nodb - blog
		</title>
		<!--<link rel="stylesheet" type="text/css" href="css/site.css" />-->
		<link rel="stylesheet/less" type="text/css" href="css/site.less">
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/less.js" type="text/javascript"></script>
		<style type="text/css">
			#guy
			{
				display:inline-block;
				width:104px;
				height:149px;
				background-image:url(css/img/guy.png);
				background-position:0 0;
				/*background-color:#ddd;*/
			}
			
			
			#guy.right
			{
				background-position:0 -301px;
			}
			#guy.right.walk
			{
				background-position:0 0;
			}
			#guy.left
			{
				background-position:-104px -301px;
			}
			#guy.left.walk
			{
				background-position:0 -154px;
			}
		</style>
		<script type="text/javascript" >
			
			var $guy,posX;
			var x=0;
			var backgroundWidth = 624;
			var pixelsPerFrame = 32,
				animationSpeed = 96;	//ms
			
			var holdLeft=false;
			var holdRight=false;
			
			$().ready(function() {
				$guy = $('#guy');
				posX=0;	
				setInterval(function(){nextFrame()}, animationSpeed);
				
				
				$(window).keydown(function(e) {
					if (e.which == 37)
					{
						if (!holdLeft)
						{
							$guy.removeClass("right").addClass("left");
							holdLeft = true;
						}
						return false;
					}
					if (e.which == 39)
					{
						if (!holdRight)
						{
							$guy.removeClass("left").addClass("right");
							holdRight = true;
						}
						return false;
					}
				}).keyup(function(e) {
					if (e.which == 37)
					{
						if (holdLeft)
						{
							$guy.css('backgroundPosition','');
							holdLeft = false;
						}
					}
					if (e.which == 39)
					{
						if(holdRight)
						{
							$guy.css('backgroundPosition','');
							holdRight = false;
						}
					}
					if (e.which==32)
						{
							console.log("right " + holdRight + "  left " + holdLeft);
						}
				});
			});
			
			function nextFrame()
			{
				if (holdRight || holdLeft)
				{
					posX = posX-104;
					if (posX <= backgroundWidth * (-1)) posX=0;
					if (holdRight && !holdLeft)
					{
						x=x+pixelsPerFrame;
						$guy.css({backgroundPosition:posX+"px 0px",'margin-left':x+"px"});
					}
					else if (holdLeft && !holdRight)
					{
						x=x-pixelsPerFrame;
						$guy.css({backgroundPosition:posX+"px -150px",'margin-left':x+"px"});
					}
					else
					{
						$guy.css({backgroundPosition:""});
					}
				}
			}
		</script>
	</head>
	<body>
		<!--<a href="./"><img src="css/img/header.png" /></a>-->
		<span id="guy" class="right"></span>
		
		<div id="contentContainer">
		<?php ob_flush(); include "content.php"; ?>
		</div>
	</body>
</html>