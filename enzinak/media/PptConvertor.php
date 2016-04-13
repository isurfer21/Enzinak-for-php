<?php

class PptConvertor 
{
	private $powerpnt = null;
	private $ppt = null;
	private $powerpnt_version = "";

	private $PpSaveAsFileType = array(
		'AddIn'=>8, 
		'BMP'=>19,
		'Default'=>11, 
		'EMF'=>23, 
		'GIF'=>16,
		'HTML'=>12,
		'HTMLDual'=>14, 
		'HTMLv3'=>13, 
		'JPG'=>17, 
		'MetaFile'=>15, 
		'PNG'=>18, 
		'PowerPoint3'=>4, 
		'PowerPoint4'=>3, 
		'PowerPoint4FarEast'=>10, 
		'PowerPoint7'=>2, 
		'Presentation'=>1, 
		'PresForReview'=>22, 
		'RTF'=>6, 
		'Show'=>7, 
		'Template'=>5, 
		'TIF'=>21, 
		'WebArchive'=>20 
	);
	
	function __construct($visible, $filename = "") 
	{
		$this->powerpnt = new COM("powerpoint.application");
		$this->powerpnt->Visible = $visible;
		$this->powerpnt_version = $this->powerpnt->Version;
		if(strlen($filename) == 0) 
		{
			$this->ppt = $this->powerpnt->Presentations->Add();
		} 
		else 
		{
			$this->ppt = $this->powerpnt->Presentations->Open($filename, true, true, $visible);
		}
	}
	
	function __destruct() 
	{
		$this->powerpnt->quit();
	}
	
	function pptVersion() 
	{
		return $this->powerpnt_version;
	}

	function saveAs($fileName)
	{
		try 
		{ 
			$this->powerpnt->Presentations[1]->SaveAs($fileName);
		} 
		catch(com_exception $e) 
		{ 
			return $e->getMessage(); 
		}
	}
	
	function ppt2xxx($dirPath, $typeFile)
	{
		try 
		{ 
			$this->powerpnt->Presentations[1]->SaveAs($dirPath, $this->PpSaveAsFileType[$typeFile]);
		} 
		catch(com_exception $e) 
		{ 
			return $e->getMessage(); 
		}
	}
}

/*
// Example:
$openFilename = "e:\\vc.ppt";
$saveDirectory = "e:\\zxcx";
$saveFilename = "e:\\out.ppt";

$ppt = new PptConvertor(true, $openFilename);
$ppt->ppt2xxx($saveDirectory, 'JPG');
//$ppt->saveAs($saveFilename);
$ppt = NULL;
*/

?>