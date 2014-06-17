<?php
/**
 * @filename class.dbagent.php
 * @author Abhishek Kumar
**/

class dbagent 
{
	public static function query($iQuery, $iReturn)
	{
		$output = array();
		
		if($connection = mysql_connect(DB_HOST, DB_USER, DB_PASS))
			if($database = mysql_select_db(DB_SCHEMA))
				if($result = mysql_query($iQuery))
				{
					if($iReturn)
					{
						$output['num_rows'] = mysql_num_rows($result);
						while ($data[] = mysql_fetch_array($result, MYSQL_ASSOC));
						mysql_free_result($result);
						$output['success'] = $data;
					}
					else
					{
						$output['affected_rows'] = mysql_affected_rows();
						$output['insert_id'] = mysql_insert_id();
						$output['success'] = $result;
					}
					mysql_close($connection);    
				}
				else
					$output['failure'] = mysql_error();  
			else
				$output['failure'] = mysql_error();
		else
			$output['failure'] = mysql_error();
		
		return $output;
	}
}

?>