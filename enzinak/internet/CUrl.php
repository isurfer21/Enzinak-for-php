<?php

# CLASS ------------------------------------
#	Title: Url Juggler
#	Decription: It juggles with url.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class CUrl
{
	public function AltExtractFileNameFromURL($url)
	{
		if($url) 
		{
			$url = strrev($url);
			$last_slash = strlen($url) - strpos($url,'/') - 1;
			$url = strrev($url);
			if( $last_slash ) 
			{
				$file_name = ltrim(substr($url,$last_slash), '/\\');
			}
		}
		return $file_name;
	}
	
	public function ExtractFileNameFromURL($url)
	{
		$path = explode('/', $url);
		$filename = $path[count($path)-1];
		return $filename;
	}
	
	public function SkipArgFromURL($match)
	{
		$url = $_SERVER['REQUEST_URI'];
		
		list($path, $arg) = (explode('?', $url));
		
		if($arg != null)
		{
			$arg_list = explode('&', $arg);
			for($i=0; $i<count($arg_list); $i++)
			{
				list($var, $val) = explode('=', $arg_list[$i]);	
				if(strcasecmp($var, $match) != 0)
				{			
					$new_arg .= $arg_list[$i].'&';
				}
			}
			//$new_arg = ltrim($new_arg, '&');
		}
		
		$path = explode('/', $path);
		$filename = $path[count($path)-1];
		
		$output = $filename.'?'.$new_arg;
	
		return $output;
	}
}

?>