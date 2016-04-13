<?php

# CLASS ------------------------------------
#	Title: Content Table
#	Decription: To create a content table.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once("Core\AkPhpLib\TemplateHandler.php");

class ContentTable
{
	private $V001O;
	
	public function __construct()
	{
		$this->V001O = new TemplateHandler();
		$this->V001O->setTemplatePath('Assets\template\Tables\\');
	}

	public function __distruct()
	{
		unlink($this->V001O);
	}
	
	public function CreateWindow($iTitle, $iContent)
	{
		return $this->V001O->ModifyAndDump('T008D', array('Title'=>$iTitle, 'Content'=>$iContent ));
	}
	
	public function CreateStaticTextbox($iContent, $iStyle)
	{
		return $this->V001O->ModifyAndDump('T017D', array('Style'=>$iStyle, 'Content'=>$iContent ));
	}
	
	public function CreateRowWithoutTitle($iList, $iStyle)
	{
		$iContent = "";
		
		for($i=0; $i<count($iList); $i++)
		{
			$iContent .= $this->V001O->ModifyAndDump('T015D', array('Style'=>$iStyle, 'Content'=>$iList[$i] ));
		}
		
		return $this->V001O->ModifyAndDump('T011D', array('Content'=>$iContent ));
	}
	
	public function CreateColumnWithoutTitle($iList, $iStyle)
	{
		$iContent = "";
		
		for($i=0; $i<count($iList); $i++)
		{
			$iContent .= $this->V001O->ModifyAndDump('T016D', array('Style'=>$iStyle, 'Content'=>$iList[$i] ));
		}
		
		return $this->V001O->ModifyAndDump('T014D', array('Content'=>$iContent ));
	}
	
	public function WrapAround($iContent)
	{
		return $this->V001O->ModifyAndDump('T013D', array('Content'=>$iContent ));
	}
	
	public function ErrorWindow($iTitle, $iError, $iLink)
	{
		return $this->V001O->ModifyAndDump('T012D', array('Title'=>$iTitle, 'Link'=>$iLink, 'Error'=>$iError ));	
	}
	
	public function CreateRowSubjective($iList, $iStyle)
	{
		$iContent = "";
		
		foreach($iList as $i=>$iValue)
		{
			$iContent .= $this->V001O->ModifyAndDump('T015D', array('Style'=>$iStyle, 'Content'=>$iValue ));
		}
		
		return $this->V001O->ModifyAndDump('T011D', array('Content'=>$iContent ));
	}
	
	public function WindowWithoutHeader($iContent, $iColor)
	{
		return $this->V001O->ModifyAndDump('T010D', array('Color'=>$iColor, 'Content'=>$iContent ));
	}
	
	public function Enclose($iTitle, $iContent, $iStyle)
	{
		return $this->V001O->ModifyAndDump('T009D', array('Title'=>$iTitle, 'Content'=>$iContent, 'Style'=>$iStyle ));
	}
}
  
/* EXAMPLE:

	
*/

?>