<?php
include "core/lib.php";
include "core/markdown.php";

if (isset($_GET['file']))
{
	$file = $_GET['file'];
	echo renderFile($file);
}
else
{
	$fileList = getFilelist("content/","md");
	foreach ($fileList as $file)
	{
		$f = $file['name'];
		echo renderFile($f);
	}
}

function renderFile($file)
{
	$html ="";
	$filename = "content/cache/". $file . ".html";

	if (file_exists($filename))
	{
		$html .= '<div class="article">';
		$html .= '<h1 id="'.$file.'" class="section"><a href="article/' . $file . '">' . $file . "</a></h1>";
		$html .= loadFile($filename);
		$html .= '<div class="socialshareprivacy"></div>';
		$html .= '</div>';
	}
	else
	{
		header("HTTP/1.0 404 Not Found");
		
		$html .= '<div class="error">404 - File "'.$filename.'" not found</div>';
		
	}
	return $html;
}

function readFileContent($myFile)
{
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	fclose($fh);
	return $theData;
}