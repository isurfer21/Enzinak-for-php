<?php

# CLASS ------------------------------------
#  Title: Mdb Manager
#  Decription: To manage MS-Access database.
#  Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once(APPROOT."CTemplate.php");

class CMdbManager
{
	private $ConnectionString;
	
	public function setPlugIn($ConnStr)
	{
		$this->ConnectionString = $ConnStr;
	}
	
	public function getConnStr($iDatabasePath)
	{
		$Configuration = array();
		$Configuration['Driver'] = "{Microsoft Access Driver (*.mdb)}";
		$Configuration['File'] = getcwd().$iDatabasePath; 
		$Configuration['Connection'] = "ADODB.Connection";
		
		$TemplateSetter = new CTemplate();
		$connectionTemplate = 'Driver=[Driver];DBQ=[File];ConnectionName=[Connection]';		
		$ConnectionString = $TemplateSetter->FitIn($connectionTemplate, $Configuration);
		
		return $ConnectionString;
	}

	public function extractTable($Query)
	{
		$Connection = odbc_connect($this->ConnectionString, '', '');
		if($Connection)
		{
			$Result = odbc_exec($Connection, $Query);
			if($Result)
			{
				while ($Data[] = odbc_fetch_array($Result));
				odbc_free_result($Result);
				odbc_close($Connection);
				return $Data;
			}
			else
			{
				return 'Error: '.odbc_errormsg();	 
			}
		}
		else
		{
			return 'Error: Unable to connect!';
		}
	}
	
	public function executeQuery($Query)
	{
		$Connection = odbc_connect($this->ConnectionString, '', '');
		if($Connection)
		{
			$Result = odbc_exec($Connection, $Query);
			if($Result)
			{
				odbc_close($Connection);
			}
			else
			{
				return 'Error: '.odbc_errormsg();	 
			}
		}
		else
		{
			return 'Error: Unable to connect!';
		}
	}
}

?>