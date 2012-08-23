<?php
include "core/lib.php";
include "core/markdown.php";

$fileList = getFilelist("content/","md");
foreach ($fileList as $file)
{
			$filename = "content/". $file["name"] . ".md";
			echo '<div class="article">';
			echo "<h1 id='".$file["name"]."' class='section'>" . $file["name"] . "</h1>";
			echo Markdown(loadFile($filename));
			echo '</div>';
}
function readFileContent($myFile)
{
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	fclose($fh);
	return $theData;
}