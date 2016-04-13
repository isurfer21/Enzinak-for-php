<?php

# CLASS ------------------------------------
#	Title: Sql Processor
#	Decription: To process sql.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class SqlProcessor
{
	public function ProcessQuery($database, $query)
	{ 
		$connect = odbc_connect($database, "root", ""); 		
	
		if($connect)
		{
			$result = @odbc_exec($connect, $query);
			
			if (!$result)
			{
				$ouput = "Error#002: ".odbc_errormsg();	 
			}
			else
			{
				odbc_close($connect);	
			}
		}
		else
		{
			$ouput = "Error#001: Could not connect to database!";
		}
	
		return $output;
	}
}

?>