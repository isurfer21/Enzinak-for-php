<?php

# CLASS ------------------------------------
#	Title: Flash Component
#	Decription: To create flash component.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once("Core\AkPhpLib\FlashManager.php");

class FlashComponent
{
	private $FlashHandler;
	
	public function __construct()
	{
		$this->FlashHandler = new FlashManager();
	}
	
	public function __destruct()
	{
		unlink($this->FlashHandler);
	}
	
	public function Progressbar($percentage)
	{
		$output = $this->FlashHandler->FlashObject("progressbar","Assets/swf/progressbar.swf","100","10","#FFFFFF","transparent","percentage=".$percentage);
		
		return $output;
	}

	public function UpDownIcon($link)
	{
		$output = $this->FlashHandler->FlashObject("UpDownIcon","Assets/swf/AscDescIcon.swf","10","10","#FFFFFF","transparent","Link=".$link);
		
		return $output;
	}
}

?>