<?php

# CLASS ------------------------------------
#	Title: Authorizer
#	Decription: To authorize users.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once(APPROOT."Internet\CUrl.php");

class CAuthorizer
{
	var $ProceedingFunction;
	var $AuthorizedUser;

	function ListAuthorizedUser($iList)
	{
		$this->AuthorizedUser = $iList;
	}

	function CallOnSuccess($iFunc)
	{
		$this->ProceedingFunction = $iFunc;
	}

	function ValidateAuthorization()
	{
		global $Accesso; 
		
		if(in_array($Accesso['Authority'], $this->AuthorizedUser))
		{
			$this->AuthorizedAccess();
		}
		else
		{
			$this->UnauthorizedAccess();	
		}
	}	
	
	function ValidateRole()
	{
		global $Accesso; 
		
		if(in_array($Accesso['Role'], $this->AuthorizedUser))
		{
			$this->AuthorizedAccess();
		}
		else
		{
			$this->UnauthorizedAccess();	
		}
	}	

	function AuthorizedAccess()
	{
		if(isset($this->ProceedingFunction)) 
		{
			call_user_func($this->ProceedingFunction);
		}
	}
	
	function UnauthorizedAccess()
	{
		$HandleUrl = new CUrl();
		header("location:Unauthorised.php?caller=".$HandleUrl->ExtractFileNameFromURL($_SERVER['REQUEST_URI']));
		//die();
	}	
}

?>