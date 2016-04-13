<?

# CLASS -------------------------------------
#	Title: RegEx Verifier
#	Decription: To verify regular expression.
#	Developer: Abhishek Kumar (c) 2008.
# -------------------------------------------

class RegExVerifier
{
	public function isDateTime($input)
	{
		$regexp = "^[0-9 -:]+$";
		$output = (ereg($regexp, $input)) ? true : false;
		return $output;
	}
	
	public function isAlnum($input)
	{
		$regexp = "^[a-zA-Z0-9]+$";
		$output = (ereg($regexp, $input)) ? true : false;
		return $output;
	}
	
	public function isAlnumdot($input)
	{
		$regexp = "^[a-zA-Z0-9.]+$";
		$output = (ereg($regexp, $input)) ? true : false;
		return $output;
	}
	
	public function isPathToFile($input)
	{
		$regexp = "^[a-zA-Z0-9./_]+$";
		$output = (ereg($regexp, $input)) ? true : false;
		return $output;
	}
	
	public function isHyperlink($input)
	{
		$regexp = "^[a-zA-Z0-9./:\?&='%]+$";
		$output = (ereg($regexp, $input)) ? true : false;
		return $output;
	}
}

?>