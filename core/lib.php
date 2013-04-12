<?php

define("CONTENT","../content/");
function loadFile($file)
{
	$fh = fopen($file, 'r');
	$data = fread($fh, filesize($file)+1);
	fclose($fh);
	return $data;
}
function saveFileContent($file,$content,$cacheFilename)
{
	file_put_contents($file,$content);
	// write html-cache:
	include_once "../core/markdown.php";
	
	$monthArray = array("Jänner","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
	
	$modified = date("j. ") . $monthArray[date("n")-1] .date(" Y");
	
	$c = filectime($file);
	
	$created = date("j. ",$c). $monthArray[date("n")-1] . date(" Y",$c);
	$createdHtml = '<div class="articleCreatedDate">' . $created . "</div>";
	
	$modifiedHtml ="";
	if ($modified != $created)
	{
		$modifiedHtml = '<div class="articleModifiedDate">Zuletzt bearbeitet am: ' . $modified . "</div>";
	}
	
	$html = $createdHtml . Markdown($content) . $modifiedHtml;
	
	
	
	
//	echo "Created:" . date("d.m.Y H:i:s", $created) . " | Modified: " . date("d.m.Y H:i:s", $modified);
	
	if (file_put_contents($cacheFilename,$html))
	{
		echo "cache gespeichert";
	}
	else
	{
		echo "cache nicht gespeichert";
	}
}
function getFilelist($directory,$extension="")
{
	if ($handle = opendir($directory)) 
	{
		$arr = array();
		while (false !== ($file = readdir($handle))) {
			if ($file !== "." && $file !== "..")
			{
				if ($extension !== "")
				{
					$ext = pathinfo($file,PATHINFO_EXTENSION);
					if ($ext == $extension)
					{
						$filename = pathinfo($file,PATHINFO_FILENAME);	// cut .ext from filename end
						$arr[] = array("name" => urldecode($filename), "created" => date("Y-m-d H:i:s",filectime($directory . $file)));
					}
				}
				else
				{
					$arr[]  = array("name" => urldecode($file), "created" => date("Y-m-d H:i:s", filectime($directory . $file)));
				}
			}
		}
	}
	return $arr;
}

