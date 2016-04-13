<?php

# CLASS ------------------------------------
#	Title: FormatMachine
#	Description: It's a format machine.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once("Core\AkPhpLib\TemplateHandler.php");
require_once("Core\AkPhpLib\FileHandler.php");
require_once("Core\AkPhpLib\XmlToArray.php");

class FormatMachine
{
	private $V001O;
	private $V002O;
	
	public function __construct()
	{
		$this->V001O = new TemplateHandler();
		$this->V002O = new FileHandler();
	}

	public function __distruct()
	{
		unlink($this->V001O);
		unlink($this->V002O);
	}

	public function BreakDateTime($iDateTime)
	{
		list($sDate, $sTime) = split(" ", $iDateTime);
		list($yyyy, $mm, $dd) = split("-", $sDate);
		list($hr, $min, $sec) = split(":", $sTime);			
		return array($yyyy, $mm, $dd, $hr, $min, $sec);
	}
	
	public function FormatInformationAccordingToDataType($ft, $fv, $format)
	{
		$output = "";
		$Formatte = unserialize($format);
		
		switch($ft)
		{
			case 'DATETIME': 
				list($yyyy, $mm, $dd, $hr, $min, $sec) = $this->BreakDateTime($fv);	
				$output = $this->Format_Date($yyyy, $mm, $dd, $hr, $min, $sec, $Formatte[$ft]);
				break;
			case 'BIT': 
				$output = $this->Format_Bit($fv, $Formatte[$ft]);
				break;
			case 'NULL':
				$output = $this->Format_NullData($fv, $Formatte[$ft]);
				break;
			default: 
				$output = $fv;
		}
		
		return $output;
	}
	
	public function Format_NullData($fv, $format)
	{
	 	if($format != NULL)
			$output = ($format == true) ? "&nbsp;" : NULL;
		else
			$output = $fv;
		
		return $output;
	}
	
	public function Format_Date($year, $month, $date, $hour, $minute, $second, $format)
	{
		$ShortMonth = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		$LongMonth = array('January','February','March','April','May','June','July','August','September','October','November','December');
		
		$V001A = array('Year'=>$year, 'Month'=>$month, 'Date'=>$date, 'Hour'=>$hour, 'Minute'=>$minute, 'Second'=>$second);
	
		$V001A['ShortMonth'] = $ShortMonth[intval($month)-1];
		$V001A['LongMonth'] = $LongMonth[intval($month)-1];
		
		$xml = $this->V002O->ReadFromFile('Assets\setting\DateTemplate.xml');

		$format = ($format != NULL)? $format : 'X000'; 
		
		$parseXml = new XmlToArray($xml);
		$V002T = $parseXml->dom['Template'][$format];
		unlink($parseXml);
		
		$output = $this->V001O->FitIn($V002T, $V001A);
		
		return $output;
	}
	
	public function Format_Bit($val, $format)
	{
		$Boolean = array('False','True');
		
		$xml = $this->V002O->ReadFromFile('Assets\setting\BitTemplate.xml');

		$format = ($format != NULL)? $format : 'X000'; 
		
		$parseXml = new XmlToArray($xml);
		$output = $parseXml->dom['Template'][$format][$Boolean[intval($val)]];
		unlink($parseXml);
		
		return $output;
	}
	
	public function Format_Cell($Label, $StyleNum, $Align, $Filter, $Pad)
	{
		$Style = array('S014C', 'S015C', 'S016C', 'S017C');
		
		if(($Filter == true)||($Filter == 1))
			$Label = str_replace("_", " ", $Label);
		
		if(($Pad == true)||($Pad == 1))
			$Label = "&nbsp;".$Label."&nbsp;";
		
		$iArg = array();
		
		$iArg['align'] = $Align;
		$iArg['style'] = $Style[$StyleNum];
		$iArg['label'] = $Label;
		
		$output = $this->V001O->FitIn('<td align="[align]" class="[style]">[label]</td>', $iArg);
		
		return $output;
	}
	
	public function Filter($input)
	{
		$searchlist = array("\"","\'");
		$replacelist = array("’’","’");
		
		for($i=0; $i<count($searchlist); $i++)
			$output = str_replace($searchlist[$i], $replacelist[$i], $input); 
	
		$output = $this->MicroFilter($output);
	
		return $output;
	}
	
	public function MicroFilter($input)
	{
		$searchlist = array("\n","\t","\r","\0","\x0B");
	
		for($j=0; $j<count($searchlist); $j++)
		{
			$input = explode($searchlist[$j], $input);
			
			for($i=0; $i<count($input); $i++)
				$input[$i] = trim($input[$i]);
			
			if($searchlist[$j]=="\n" || $searchlist[$j]=="\r") 
				$input = join("<br>",$input);	
			else
				$input = join(" ",$input);	
		}
	
		return trim($input);
	}
}

?>