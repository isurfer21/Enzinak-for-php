<?php

# CLASS ------------------------------------
#	Title: Xml To Array
#	Decription: To convert xml into array.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class CXmlToArray
{
	private $parser;
	private $pointer;
	public $dom;
	
	public function __construct($data)
	{
	  $this->pointer =& $this->dom;
	  $this->parser = xml_parser_create();
	  xml_set_object($this->parser, $this);
	  xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
	  xml_set_element_handler($this->parser, "tag_open", "tag_close");
	  xml_set_character_data_handler($this->parser, "cdata");
	  xml_parse($this->parser, $data);
	}
	
	private function tag_open($parser, $tag, $attributes)
	{
	  if (isset($this->pointer[$tag]['@attributes']))
	  {
		  $content = $this->pointer[$tag];
		  $this->pointer[$tag] = array(0 => $content);
		  $idx = 1;
	  }
	  elseif (isset($this->pointer[$tag]))
		  $idx = count($this->pointer[$tag]);
	  
	  if (isset($idx))
	  {
		  $this->pointer[$tag][$idx] = array('@idx' => $idx, '@parent' => &$this->pointer);
		  $this->pointer =& $this->pointer[$tag][$idx];
	  }
	  else
	  {
		  $this->pointer[$tag] = array('@parent' => &$this->pointer);
		  $this->pointer =& $this->pointer[$tag];
	  }
	  if (!empty($attributes))
		  $this->pointer['@attributes'] = $attributes;
	}
	
	private function cdata($parser, $cdata)
	{
	  $this->pointer['@data'] = $cdata;
	}
	
	private function tag_close($parser, $tag)
	{
	  $current = &$this->pointer;
	  if (isset($this->pointer['@idx']))
		  unset($current['@idx']);
	  
	  $this->pointer = &$this->pointer['@parent'];
	  
	  unset($current['@parent']);
	  if (isset($current['@data']) && count($current) == 1)
		  $current = $current['@data'];
	  elseif (empty($current['@data']) || $current['@data'] == 0)
		  unset($current['@data']);
	}
}
  
/* EXAMPLE:

	// Obtain the exact path to the xml file
	$xmlfile = "config.xml";
	$fp = fopen($xmlfile, "r");				// open the xml file
	$xml = fread($fp, filesize($xmlfile));	// read in the size of the file into the variable xml
	fclose($fp);							// close the stream
	
	$parseXml = new CXmlToArray($xml);		// create a new xml class instance
	$dom = $parseXml->dom;					// make a variable that holds the entire dom
	
	print_r($dom);
	
*/

?>