<?

# CLASS -------------------------------------
#	Title: Array To String
#	Decription: To convert array into string.
#	Developer: Abhishek Kumar (c) 2008.
# -------------------------------------------

class CArrayToString
{
	public function AssociativeArrayToString($iArray)
	{
		$List = $this->AssociateItem($iArray);
		$Cord = $this->JoinList($List);
		$oString = $this->EncloseInBracket($Cord);
		
		return $oString;
	}

	public function SimpleArrayToString($iArray)
	{
		$Cord = $this->JoinList($iArray);
		$oString = $this->EncloseInBracket($Cord);
		
		return $oString;
	}
	
	private function AssociateItem($iArray)
	{
		$oArray = array();
		$i=0;
		foreach($iArray as $sVar=>$sVal)
		{
			$oArray[$i++] = $this->JoinListItem($sVar, $sVal);
		}		
		return $oArray;
	}

	private function JoinListItem($iVar, $iVal)
	{
		$oString = $iVar.':'.$iVal;
		return $oString;
	}
	
	private function JoinList($iArray)
	{
		$oString = join(',', $iArray);
		return $oString;
	}
	
	private function EncloseInBracket($iString)
	{
		$oString = '['.$iString.']';
		return $oString;
	}
}

/* EXAMPLE:

	$arr2str = new CArrayToString();
	$V002A = array ( 'id1' => 'one', 'id2' => 'two', 'id3' => 'three' );
	$V001S = $arr2str->AssociativeArrayToString($V002A); 
	print_r($V001S);
	$V003A = array ('one','two','three');
	$V001S = $arr2str->SimpleArrayToString($V003A); 
	print_r($V001S);

*/

?>