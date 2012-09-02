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
			$filename = CONTENT . $_POST['file'] . ".md";
			$isNew = (int)$_POST['isNew'];
			$text = $_POST['text'];
			if ($isNew)
			{
				if (file_exists($filename))
				{
					die("filename already exists!");
				}
			}
			saveFileContent($filename,$text);
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
			$oldFilename = CONTENT . urlencode($_POST['oldFilename']) . '.md';
			$newFilename = CONTENT . urlencode($_POST['newFilename']) . '.md';
			if (file_exists($oldFilename))
			{
				rename($oldFilename,$newFilename);
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