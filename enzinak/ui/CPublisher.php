<?php

require_once("..\Configuration\CConfig.php");

require_once(APPROOT."CTemplate.php");

class CPublisher
{
	var $SidebarVisibility;
	
	function __construct()
	{
		$this->SidebarVisibility = true;
	}
	
	function setSidebarVisibility($iVisibility)
	{
		$this->SidebarVisibility = $iVisibility;
	}
	
	function Publish($iContent)
	{
		$VoCTemplate = new CTemplate();

		$VoCTemplate->setTemplatePath('..\Asset\Template\\');
		
		$TemplateArguments = array();
		
		$TemplateArguments['StyleSheet'] = $VoCTemplate->Dump('T005S_StyleSheet');
		$TemplateArguments['JavaScript'] = $VoCTemplate->Dump('T004S_Javascript');
		
		$TemplateArguments['Header'] = $VoCTemplate->Dump('T002S_BrandBar');
		$TemplateArguments['Header'] .= $VoCTemplate->Dump('T003S_HorizontalLine');
		
		// + Content
		$_Content = array();
		$_Content['Content'] = $iContent;
		// - Content
		
		$TemplateBodyContent = array();
		$TemplateBodyContent['Content'] = $VoCTemplate->ModifyAndDump('T012D_Container', $_Content);
			
		if($this->SidebarVisibility == true)
		{			
			$TemplateBodyContent['Sidebar'] = $VoCTemplate->Dump('T007D_SideBar');
			$TemplateArguments['Body'] = $VoCTemplate->ModifyAndDump('T009D_WebPageBody', $TemplateBodyContent);
		} 
		else
		{
			$TemplateArguments['Body'] = $VoCTemplate->ModifyAndDump('T013D_WebPageBodyWithoutSidebar', $TemplateBodyContent);
		}
		
		$TemplateArguments['Footer'] = $VoCTemplate->Dump('T003S_HorizontalLine');
		$TemplateArguments['Footer'] .= $VoCTemplate->Dump('T006S_LicenseCredit');
		
		echo $VoCTemplate->ModifyAndDump('T001D_WebPage', $TemplateArguments);
	}	
}

?>