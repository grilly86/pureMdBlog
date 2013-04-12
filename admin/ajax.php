<?php

include '../core/lib.php';
$action = '';
if (isset($_GET['action']))
{
	$action = $_GET['action'];
}

switch ($action)
{
	case 'preview':
		if (isset($_POST['text']))
		{
			include "../core/markdown.php";
			$text = $_POST['text'];
			die(Markdown($text));
		}
		else
		{
			die ('no text given');
		}
		break;
	case 'save':
		if (isset($_POST['file']) && isset($_POST['isNew']) && isset($_POST['text']))
		{
			$file = $_POST['file'];
			
			// SAVE MD FILE
			$filename = CONTENT . $file . ".md";
			
			$isNew = (int)$_POST['isNew'];
			$text = $_POST['text'];
			if ($isNew)
			{
				if (file_exists($filename))
				{
					die("filename already exists!");
				}
			}
			$cacheFilename = CONTENT . "cache/" . $file . ".html";
			saveFileContent($filename,$text,$cacheFilename);
		}
		//dieFilelist();
		break;
		
	case 'add':
		if (isset($_POST['file']))
		{
			$filename = CONTENT . $_POST['file'] . ".md";
			if (file_exists($filename))
			{
				die("filename already exists!");
			}
			saveFileContent($filename,"");
		}
		else
		{
			die("no filename specified");
		}
		dieFilelist();
		break;
	case 'delete':
		if (isset($_POST['file']))
		{
			$filename = CONTENT . $_POST['file'] . ".md";
			if (file_exists($filename))
			{
				unlink($filename);
			}
		}
		dieFilelist();
		break;
	case 'rename':
		if (isset($_POST['oldFilename']) && isset($_POST['newFilename']))
		{
			$oldFilename = CONTENT . urldecode($_POST['oldFilename']) . '.md';
			$newFilename = CONTENT . urldecode($_POST['newFilename']) . '.md';
			
			$oldFilenameCache = CONTENT ."cache/" .  urldecode($_POST['oldFilename']) . '.html';
			$newFilenameCache = CONTENT ."cache/". urldecode($_POST['newFilename']) . '.html';
			
			if (file_exists($oldFilename))
			{
				rename($oldFilename,$newFilename);
				rename($oldFilenameCache,$newFilenameCache);
				
			}
			else
			{
				die('{error:"ERROR:file ' . $oldFilename . ' not found!"}');
			}
		}
		dieFilelist();
		break;
	case 'filelist':
		dieFilelist();
		break;
	default:
		// load file:
		if (isset($_POST['file']))
		{
			$filename = $_POST['file'];
			$filename = CONTENT . $filename . ".md";
			if (file_exists($filename))
			{
				$content = loadFile($filename);
				die($content);
			}
			else
			{
				die ("file not found: " . $filename);
			}
		}
		else
		{
			die("no filename specified");
		}
		break;
}
function dieFilelist()
{
	$filelist = getFilelist("../content/","md");
	die(json_encode($filelist));
}