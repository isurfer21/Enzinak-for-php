<?php

# CLASS ------------------------------------
#	Title: Directory Handler
#	Decription: To handle directory.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class CDirectory
{
	private function deleteDir($dir) 
	{ 
		if (substr($dir, strlen($dir)-1, 1) != '/') 
			$dir .= '/'; 
		
		if ($handle = opendir($dir)) 
		{ 
			while ($obj = readdir($handle)) 
			{ 
				if ($obj != '.' && $obj != '..') 
				{ 
					if (is_dir($dir.$obj)) 
					{ 
					   if (!$this->deleteDir($dir.$obj)) 
						   return false; 
					} 
					elseif (is_file($dir.$obj)) 
					{ 
					   if (!unlink($dir.$obj)) 
						   return false; 
					} 
				} 
			} 
			
			closedir($handle); 
		
			if (!@rmdir($dir))
				return false; 
		
			return true; 
		}
		
		return false; 
	}
	
	public function Directory($iCommand, $iDir) 
	{ 
		switch($iCommand)
		{
			case 'CREATE': 
				mkdir($iDir, 0700);
				$oStatus = true;
				break;
			case 'REMOVE': 
				rmdir($iDir);
				$oStatus = true;
				break;
			case 'DELETE': 
				$this->deleteDir($iDir);
				$oStatus = true;
				break;
			default:
				$oStatus = false;
		}
		
		return $oStatus;
	}
}
  
/* EXAMPLE:

$handleDir = new CDirectory();
$handleDir->Directory('CREATE','e:/dirname');
$handleDir->Directory('DELETE','e:/dirname');

*/

?>
