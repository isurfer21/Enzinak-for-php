<?

# CLASS ------------------------------------
#	Title: Utility
#	Decription: To manager date.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class CUtility
{
	public function Swap(&$x, &$y)
	{
		$temp = $x;
		$x = $y;
		$y = $temp;
	}	
}

?>