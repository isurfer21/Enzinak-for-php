<?php

# CLASS ------------------------------------
#	Title: Template Handler
#	Decription: To set content in template.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once(APPROOT."System\CFile.php");
		
class CTemplate
{
	private $HandleFile;
	private $Template;
	private $TemplatePath;
	
	public function __construct()
	{
		$this->HandleFile = new CFile();
	}
	
	public function __destruct()
	{
		unlink($this->HandleFile);
	}

	public function FitIn($iTemplate, $iTemplateArgument)
	{
		$this->Template = $iTemplate;
		$this->Template = $this->setTemplate($iTemplateArgument);
		return $this->Template;
	}

	public function ModifyAndDump($iTemplateName, $iTemplateArgument)
	{
		$this->Template = $this->getTemplate($iTemplateName);
		$this->Template = $this->setTemplate($iTemplateArgument);
		return $this->Template;
	}
	
	public function Dump($iTemplateName)
	{
		$this->Template = $this->getTemplate($iTemplateName);
		return $this->Template;
	}
	
	public function setTemplatePath($iPath)
	{
		$this->TemplatePath = $iPath;
	}

	private function getTemplate($iTemplateName)
	{
		return $this->HandleFile->ReadFromFile($this->TemplatePath.''.$iTemplateName);	
	}

	private function setTemplate($iTemplateArgument)
	{
		$iCache = $this->Template;
		foreach($iTemplateArgument as $iKey => $iValue)
		{
			$iTag = $this->createTag($iKey);
			$iCache = str_replace($iTag, $iValue, $iCache);
		}
		return $iCache;
	}
	
	private function createTag($iTagName)
	{
		return '['.$iTagName.']';
	}
}

/* EXAMPLE:

$handleTemplate = new CTemplate();
echo $handleTemplate->ModifyAndDump('Template001', array('Title'=>'Wow', 'Content'=>'What an idea!'));

*/

?>