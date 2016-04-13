<?php

# CLASS ------------------------------------
#	Title: Flash Manager
#	Decription: It manages flash object.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

include("..\Configuration\CConfig.php");

include($RelativePath."CTemplate.php");

class FlashManager
{
	private $HandleTemplate;
	
	public function __construct()
	{
		$this->HandleTemplate = new TemplateHandler();
		$this->HandleTemplate->setTemplatePath('Assets\template\\');		
	}

	public function __destruct()
	{
		unlink($this->HandleTemplate);
	}

	public function FlashObject($id,$src,$width,$height,$bgcolor,$wmode,$flashvars)
	{
		$TemplateArguments = $this->getAssociativeArrayOfArguments($id,$src,$width,$height,$bgcolor,$wmode,$flashvars);
		return $this->HandleTemplate->ModifyAndDump('T010D_FlashObject', $TemplateArguments);
	}

	public function FlashCommObject($id,$src,$width,$height,$bgcolor,$wmode,$flashvars)
	{
		$TemplateArguments = $this->getAssociativeArrayOfArguments($id,$src,$width,$height,$bgcolor,$wmode,$flashvars);
		return $this->HandleTemplate->ModifyAndDump('T011D_FlashCommObject', $TemplateArguments);
	}
	
	private function getAssociativeArrayOfArguments($id,$src,$width,$height,$bgcolor,$wmode,$flashvars)
	{
		$oArray = array();
		
		$oArray['id'] = $id; 
		$oArray['src'] = $src; 
		$oArray['width'] = $width; 
		$oArray['height'] = $height; 
		$oArray['bgcolor'] = $bgcolor; 
		$oArray['wmode'] = $wmode; 
		$oArray['flashvars'] = $flashvars;
		
		return $oArray;
	}
}

/* Example: 

$FlashHandler = new FlashManager();
$FlashHandler->FlashObject("UpDownIcon","Assets/swf/AscDescIcon.swf","10","10","#FFFFFF","transparent","Link=".$link);

*/

?>