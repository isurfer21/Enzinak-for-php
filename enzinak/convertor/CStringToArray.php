<?

# CLASS -------------------------------------
#	Title: String To Array
#	Decription: To convert string into array.
#	Developer: Abhishek Kumar (c) 2008.
# -------------------------------------------

class CStringToArray
{
	public function StringToAssociativeArray($iString)
	{
		$Cord = $this->ExtractCord($iString); 
		$List = $this->TrimBracket($Cord);
		$iArray = $this->ParseList($List);
		$oArray = $this->AssociateItem($iArray);
		
		return $oArray;
	}

	public function StringToSimpleArray($iString)
	{
		$Cord = $this->ExtractCord($iString); 
		$List = $this->TrimBracket($Cord);
		$oArray = $this->ParseList($List);
		
		return $oArray;
	}
	
	private function ExtractCord($iString)
	{
		$beginPos = strpos($iString,'[');
		$endPos = strrpos($iString,']')+1;
		$iString = substr($iString, $beginPos, $endPos-$beginPos);
		return $iString;
	}
	
	private function ExtractList($iString)
	{   // Not used
		$beginPos = strpos($iString,'[')+1;
		$endPos = strrpos($iString,']');
		$iString = substr($iString, $beginPos, $endPos-$beginPos);
		return $iString;
	}

	private function TrimBracket($iString)
	{
		$beginPos = 1;
		$endPos = strlen($iString)-2;
		$iString = substr($iString, $beginPos, $endPos);
		return $iString;
	}
	
	private function ParseList($iString)
	{
		$oArray = explode(',', $iString);
		return $oArray;
	}
	
	private function ParseListItem($iString)
	{
		$oArray = explode(':', $iString);
		return $oArray;
	}
	
	private function AssociateItem($iArray)
	{
		$oArray = array();
		for($i=0; $i<count($iArray); $i++)
		{
			list($sVar, $sVal) = $this->ParseListItem($iArray[$i]);
			$oArray[$sVar] = $sVal;
		}		
		return $oArray;
	}
}

/* EXAMPLE:

	$str2arr = new CStringToArray();
	$V001A = array();
	$V002S = "[id1:one,id2:two,id3:three]";
	$V001A = $str2arr->StringToAssociativeArray($V002S); 
	print_r($V001A);
	$V003S = "[one,two,three]";
	$V001A = $str2arr->StringToSimpleArray($V003S); 
	print_r($V001A);

*/

?>