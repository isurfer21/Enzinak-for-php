<?php

# CLASS ------------------------------------
#	Title: File Handler
#	Decription: To handle file.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class CFile
{
	public function getFileExtension($iFile)
	{
		$iExtension = strrpos($iFile, ".");
		$oExtension = substr($iFile, $iExtension, strlen($iFile));
		$oString = strtolower($oExtension);
		return $oString;
	}

	public function getFileName($iFile)
	{
		$iExtension = strrpos($iFile, ".");
		$oFileName = substr($iFile, 0, $iExtension);
		return $oFileName;
	}

	public function getFileExtensionAlt($str) 
	{
		$i = strrpos($str,".");
		if (!$i) { return ""; }
	
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
	
		return $ext;
	}
	
	public function getFileNameAlt($str) 
	{
		$i = strrpos($str,".");
		if (!$i) { return ""; }
	
		$filename = substr($str,0,$i);
	
		return $filename;
	}
	
	public function WriteOnFile($iFileName, $iContent)
	{
		// Make sure the file exists and is writable first.
		if (is_writable($iFileName))
		{
		  if (!$handle = fopen($iFileName, 'w'))
		  {
			  $output = "Error: Cannot open file ($iFileName).";
		  }
		  else
		  {
			  // Write $iContent to this opened file.
			  if (fwrite($handle, $iContent) === false)
			  {
				  $output = "Error: Cannot write to file ($iFileName).";
			  }
			  else
			  {
				  $output = true;			  
				  fclose($handle);
			  }
		  }
		}
		else
		{
		  	$output = "Error: The file ($iFileName) is not writable.";
		}
		
		return $output;
	}  
	
	public function ReadFromFile($iFileName)
	{
		// Make sure the file exists and is readable.
		if (is_readable($iFileName)) 
		{
			if (!$handle = fopen($iFileName, "r"))
			{
			  	$output = "Error: Cannot open file ($iFileName).";
			}
			else
			{
				$output = fread($handle, filesize($iFileName));
				if ($output === false)
				{
				  	$output = "Error: Cannot read from file ($iFileName).";
				}
				else
				{
				  	fclose($handle);
				}
			}
		} 
		else 
		{
			$output = "Error: The file ($iFileName) is not readable.";
		}

		return $output;
	}
	
	public function ReadFromRemoteFile($iFileUrl, $iMethod)
	{
		switch($iMethod)
		{
			case 'OLD':
				$handle = fopen($iFileUrl, "rb");
				$contents = '';
				while (!feof($handle)) 
				{
					$contents .= fread($handle, 8192);
				}
				fclose($handle);
				break;
			default:
				$handle = fopen($iFileUrl, "rb");
				$contents = stream_get_contents($handle);
				fclose($handle);
				break;
		}
	}

	public function AppendInFile($iFileName, $iContent)
	{
		// Make sure the file exists and is writable first.
		if (is_writable($iFileName))
		{
		  if (!$handle = fopen($iFileName, 'a'))
		  {
			  $output = "Error: Cannot open file ($iFileName).";
		  }
		  else
		  {
			  // Write $iContent to this opened file.
			  if (fwrite($handle, $iContent) === false)
			  {
				  $output = "Error: Cannot write to file ($iFileName).";
			  }
			  else
			  {
				  $output = true;			  
				  fclose($handle);
			  }
		  }
		}
		else
		{
		  	$output = "Error: The file ($iFileName) is not writable.";
		}
		
		return $output;
	}  
}
  
/* EXAMPLE:

$obj = new CFile();
echo $obj->ReadFromFile('config.xml');

*/

?>