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
		break;
	case 'filelist':
		$filelist = getFilelist("../content/","md");
		die(json_encode($filelist));
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
