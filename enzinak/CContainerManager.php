<?
# Abhishek Kumar (c) 2008.

require_once("..\Configuration\CConfig.php");

class CContainerManager
{
	function __construct()
	{
		session_start();
		//$this->Get();		
	}
	
	function Get()
	{
		global $Container;
		$Container = array();	
			
		if (isset($_SESSION[SESSION_NAME])) 
		{
			$Container = unserialize($_SESSION[SESSION_NAME]);	
		}
	}
	
	function Set()
	{
		$_SESSION[SESSION_NAME] = serialize($GLOBALS['Container']);	
	}
	
	function Clean()
	{
		if (isset($_SESSION[SESSION_NAME])) 
		{
			unset($_SESSION[SESSION_NAME]);
			unset($GLOBALS['Container']);
			session_destroy();
		}
	}
	
	function Add($Associate, $Value)
	{
		global $Container;
		if (!isset($Container[$Associate])) 
		{
			$Container[$Associate] = $Value;
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function Modify($Associate, $Value)
	{
		global $Container;
		if (isset($Container[$Associate])) 
		{
			$Container[$Associate] = $Value;
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function Delete($Associate)
	{
		global $Container;
		if (isset($Container[$Associate])) 
		{
			unset($Container[$Associate]);
			return true;
		}
		else
		{
			return false;
		}		
	}
}

/*
$V002O = new CContainerManager();

$V002O->Add('kid','hello');
$V002O->Add('kid1','hello1');
$V002O->Add('kid2','hello2');

//$V002O->Clean();
print_r($Container);
//$V002O->Sync();
*/

?>