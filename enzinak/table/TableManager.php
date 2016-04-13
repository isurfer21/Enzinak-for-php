<?php

# CLASS ------------------------------------
#  Title: Table Manager
#  Decription: To manage contents in table.
#  Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------
  
require_once("Core\AkPhpLib\TemplateHandler.php");
require_once("Core\AkPhpLib\FileHandler.php");
require_once("Core\AkPhpLib\FormatMachine.php");
require_once("Core\AkPhpLib\UrlJuggler.php");
require_once("Core\AkPhpLib\XmlToArray.php");
require_once("Core\AkPhpLib\ImageManager.php");

require_once("Core\AkPhpLib\FlashComponent.php");

class TableExtractor
{
  public function ExtractTable($database, $query, $format)
  {
	  $FormatMechanic = new FormatMachine();
	  $connect = odbc_connect($database, "root", "");
	  
	  if ($connect)
	  {
		  $result = odbc_exec($connect, $query);
		  
		  if (!$result)
		  {
			  $cache = "Error#002: " . odbc_errormsg();
		  }
		  else
		  {
			  $cache = array();
			  $row = 0;
			  
			  while (odbc_fetch_row($result))
			  {
				  for ($i = 1; $i <= odbc_num_fields($result); $i++)
				  {
					  $fn = odbc_field_name($result, $i);
					  $fv = odbc_result($result, $i);
					  $ft = odbc_field_type($result, $i);
					  
					  if ($format != null)
					  {
					  		if($fv != null)
						  		$fv = $FormatMechanic->FormatInformationAccordingToDataType($ft, $fv, $format);
							else
								$fv = $FormatMechanic->FormatInformationAccordingToDataType('NULL', $fv, $format);
					  }
					  
					  $cache[$row][$fn] = $fv;
					  //$cache[$row][$fn] = ($fv != null) ? $fv : "&nbsp;";					  
				  }
				  $row++;
			  }
			  
			  odbc_close($connect);
		  }
	  }
	  else
	  {
		  $cache = "Error#001: Could not connect to database!";
	  }
	  
	  unlink($FormatMechanic);
	  
	  return $cache;
  }
  
  public function ExtractColumn($database, $query, $column)
  {
	  $oCache = array();
	  
	  $iCache = $this->ExtractTable($database, $query);
	  
	  if ($column == null)
		  $column = $iCache[0][0];
	  
	  for ($row = 0; $row < count($iCache); $row++)
	  {
		  $oCache[$row] = $iCache[$row][$column];
	  }
	  
	  return $oCache;
  }
  
  public function ExtractRow($database, $query, $row)
  {
	  $oCache = array();
	  
	  $iCache = $this->ExtractTable($database, $query);
	  
	  $oCache = $iCache[$row];
	  
	  return $oCache;
  }
}

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

class TableDisplayer extends TableFormator
{
  private $V001O;
  private $V002O;
  
  public function __construct()
  {
  	$this->V001O = new FormatMachine();
	$this->V002O = new TemplateHandler();
	$this->V002O->setTemplatePath('Assets\template\Tables\\');
  }
  
  public function __destruct()
  {
  	unlink($this->V001O);
	unlink($this->V002O);
  }

  public function ShowTable($table)
  {
	  $output .= "<TABLE>";
	  for ($i = 0; $i < count($table); $i++)
	  {
		  $output .= "<TR>";
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  $output .= "<TD>" . $table[$i][$j] . "</TD>";
		  }
		  $output .= "</TR>";
	  }
	  $output .= "</TABLE>";
	  
	  return $output;
  }
  
  public function ShowTableV($table)
  {
	  $output = '';
	  for ($i = 1; $i < count($table); $i++)
	  {
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  $output .= "<tr>";
			  $bc = 2;
			  $output .= $this->V001O->Format_Cell($table[0][$j], $bc, 'left', false, true);
			  $bc = ($j == 0) ? 2 : $j % 2;
			  $output .= $this->V001O->Format_Cell($table[$i][$j], $bc, 'left', false, true);
			  $output .= "</tr>";
		  }
	  }
	   
	  return $this->V002O->ModifyAndDump('T001D', array('Content'=>$output));
  }
  
  public function ShowTableH($table)
  {
  	  $output = '';
	  for ($i = 0; $i < count($table); $i++)
	  {
		  $output .= "<tr>";
		  
		  $bc = ($i == 0) ? 2 : $i % 2;
		  
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  $output .= $this->V001O->Format_Cell($table[$i][$j], $bc, 'left', false, true);
		  }
		  
		  $output .= "</tr>";
	  }
	  
	  return $this->V002O->ModifyAndDump('T001D', array('Content'=>$output));
  }
  
  public function ShowTableH_SortingEnabled($table)
  {
	  $FlashCom = new FlashComponent();
	  $UrlHandler = new UrlJuggler();
	  
	  $output = '';
	  
	  for ($i = 0; $i < count($table); $i++)
	  {
		  $output .= "<tr>";
		  
		  $bc = ($i == 0) ? 2 : $i % 2;
		  
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  if ($i == 0 && $j != 0 && (strcasecmp($table[$i][$j], "Controls") != 0))
			  {
				  $thisPage = $UrlHandler->SkipArgFromURL("OrderBy");
				  $link = $thisPage . "OrderBy=" . str_replace(" ", "_", $table[$i][$j]);
				  $link = urlencode($link);
				  $table[$i][$j] .= "&nbsp;" . $FlashCom->UpDownIcon($link);
			  }
			  $output .= $this->V001O->Format_Cell($table[$i][$j], $bc, 'left', false, true);
		  }
		  
		  $output .= "</tr>";
	  }

	  unlink($FlashCom);
	  unlink($UrlHandler);

	  return $this->V002O->ModifyAndDump('T001D', array('Content'=>$output));
  }
}
?>