<?php
	
	define("CONTENT","../content/");

	function getFileContent($file)
	{
		$fh = fopen($file, 'r');
		$data = fread($fh, filesize($file)+1);
		fclose($fh);
		return $data;
	}
	function saveFileContent($file,$content)
	{
		file_put_contents($file,$content);
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
							$file = pathinfo($file,PATHINFO_FILENAME);	// cut .ext from filename end
							$arr[] = $file;
						}
					}
					else
					{
						$arr[]  = $file;
					}
				}
			}
		}
		return $arr;
	}