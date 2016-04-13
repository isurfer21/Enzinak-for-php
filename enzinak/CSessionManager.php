<?php

# CLASS ------------------------------------
#	Title: Session Manager
#	Decription: To manage session.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once("..\Configuration\CConfig.php");

require_once(APPROOT."Internet\CUrl.php");
require_once(APPROOT."CContainerManager.php");

class CSessionManager
{
	function ValidateSignIn()
	{
		if( $this->ValidateSession() )
		{
			$this->ProceedFurther();
		}
		else
		{
			$this->RedirectTowardsLoginPage();
		}
	}
	
	function ValidateSession()
	{
		global $Container;
		
		$VoCContainerManager = new CContainerManager();
		$VoCContainerManager->Get();

		$timestamp = $_SERVER['REQUEST_TIME'];
		
		if($Container['Expiry_Time'] > $timestamp)
		{	
			return true;
		}
	}
	
	function RedirectTowardsLoginPage()
	{
		$HandleUrl = new CUrl();
		header("location:Login.php?caller=".$HandleUrl->ExtractFileNameFromURL($_SERVER['REQUEST_URI']));
		//die();
	}
			
	function ProceedFurther()
	{
		//global $Container;
		//$GLOBALS['Accesso'] = $Container;
	}	
}

?>