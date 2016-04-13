<?php

# CLASS ------------------------------------
#  Title: Table Extractor
#  Decription: To manage contents in table.
#  Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------
  
class TableExtractor
{
  public function ExtractTable($database, $query)
  {
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

?>