<?php

# CLASS ------------------------------------
#	Title: XML Beautifier
#	Decription: To beautify xml.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class CXmlBeautifier
{
	// you can user also \t or more/less spaces
	var $how_to_ident = "    ";
	// wrap long tekst ? 
	var $wrap = true;
	// where wrap words 
	var $wrap_cont = 90;
	
	// gives ident to string
	function ident(&$str, $level)
	{
		$level--;
		for ($a = 0; $a < $level; $a++)
		  	$spaces .= $this->how_to_ident;
		return $spaces .= $str;
	}
	
	
	// main funcion
	function format_xml($str)
	{
		// extracting string into array
		$tmp = explode("\n", $str);
		
		// cleaning string from spaces and other stuff like \n \r \t
		for ($a = 1, $c = count($tmp); $a < $c; $a++)
		  	$tmp[$a] = trim($tmp[$a]);
		
		// joining to string ;-)
		$newstr = join("", $tmp);
		
		// adding \n lines where tags ar near 
		$newstr = str_replace("><", ">\n<", $newstr);
		
		// exploding - each line is one XML tag
		$tmp = explode("\n", $newstr);
		
		// preparing array for list of tags
		$stab = array('');
		
		// lets go :-)
		for ($a = 1, $c = count($tmp); $a <= $c; $a++)
		{
			$add = true;
			
			preg_match("/<([^\/\s>]+)/", $tmp[$a], $match);
			
			$lan = trim(strtr($match[0], "<>", "  "));
			
			$level = count($stab);
			
			if (in_array($lan, $stab) && substr_count($tmp[$a], "</$lan") == 1)
			{
				$level--;
				$s = array_pop($stab);
				$add = false;
			}
			
			if (substr_count($tmp[$a], "<$lan") == 1 && substr_count($tmp[$a], "</$lan") == 1)
				$add = false;
			
			$tmp[$a] = $this->ident($tmp[$a], $level);
			
			if ($this->wrap)
			  	$tmp[$a] = wordwrap($tmp[$a], $this->wrap_cont, "\n" . $this->how_to_ident . $this->how_to_ident . $this->how_to_ident);
			
			if ($add && !@in_array($lan, $stab) && $lan != '')
			  	array_push($stab, $lan);
		}
		
		return join("\n", $tmp);
	}
	
	function initialize($xmlfile)
	{
		$xmlString = join("", file($xmlfile));
		return $this->format_xml($xmlString);
	}  
}
  
/* EXAMPLE:

$beautifyXml = new CXmlBeautifier();
echo $beautifyXml->initialize('config.xml');

*/

?>