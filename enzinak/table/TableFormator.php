<?php

# CLASS ------------------------------------
#  Title: Table Formator
#  Decription: To manage contents in table.
#  Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------
  
require_once(APPROOT."Table\TableExtractor.php");

class TableFormator extends TableExtractor
{
  public function FormatTable($iCache)
  {
	  $oCache = array();
	  $row = 0;
	  
	  foreach ($iCache as $i => $iValue)
	  {
		  $column = 0;
		  
		  if ($row == 0)
		  {
			  $oCache[$row][$column] = "Sr.No.";
			  
			  foreach ($iValue as $j => $jValue)
			  {
				  $oCache[$row][++$column] = str_replace("_", " ", $j);
			  }
			  
			  $row++;
			  $column = 0;
		  }
		  
		  $oCache[$row][$column] = $row;
		  
		  foreach ($iValue as $j => $jValue)
		  {
			  $oCache[$row][++$column] = $jValue;
		  }
		  
		  $row++;
	  }
	  
	  return($oCache);
  }
  
  public function FormatTable1($iCache, $iconList)
  {
	  $FlashCom = new FlashComponent();
	  
	  $oCache = array();
	  $row = 0;
	  
	  foreach ($iCache as $i => $iValue)
	  {
		  $column = 0;
		  
		  if ($row == 0)
		  {
			  $oCache[$row][$column] = "Sr.No.";
			  
			  foreach ($iValue as $j => $jValue)
			  {
				  if ($j != "Id")
					  $oCache[$row][++$column] = str_replace("_", " ", $j);
				  else
					  $oCache[$row][++$column] = "Controls";
			  }
			  
			  $row++;
			  $column = 0;
		  }
		  
		  $oCache[$row][$column] = $row;
		  
		  foreach ($iValue as $j => $jValue)
		  {
			  if ($j != "Id" && $j != "Complete")
				  $oCache[$row][++$column] = $jValue;
			  elseif ($j == "Complete")
				  $oCache[$row][++$column] = $FlashCom->Progressbar($jValue);
			  else
				  $oCache[$row][++$column] = $this->ListIcon($iconList, $jValue);
		  }
		  
		  $row++;
	  }
	  
	  unlink($FlashCom);
	  
	  return($oCache);
  }
  
  private function ListIcon($list, $id)
  {
	  $handleFile = new FileHandler();
	  $xml = $handleFile->ReadFromFile('Assets\setting\CommandVsImage.xml');
	  unlink($handleFile);
	  
	  $parseXml = new XmlToArray($xml);
	  $dom = $parseXml->dom;
	  unlink($parseXml);
	  
	  $handleImage = new ImageManager();
	  
	  $output = "";
	  for ($i = 0; $i < count($list); $i++)
	  {
		  for ($j = 0; $j < count($dom['CommandVsImage']['Command']); $j++)
		  {
			  $CmdName = $dom['CommandVsImage']['Command'][$j]['@attributes']['Name']; 
			  $ThisCmd = $list[$i]['Command'];
			  
			  if ($CmdName == $ThisCmd)
			  {
			  	  $CmdImg = $dom['CommandVsImage']['Command'][$j]['@attributes']['Image'];				  
				  $output .= $handleImage->CreateIcon($list[$i]['Link'] . "&id=" . $id, $CmdImg, $CmdName);
			  }
		  }
	  }
	  
	  unlink($handleImage);
	  
	  return $output;
  }
}

?>