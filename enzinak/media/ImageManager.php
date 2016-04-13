<?php

# CLASS ------------------------------------
#	Title: Image Manager
#	Decription: To manager image.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

include("..\Configuration\CConfig.php");

include($RelativePath."CTemplate.php");
include($RelativePath."RegExVerifier.php");

class ImageManager
{
	private $V001O;
	private $V002O;
	
	public function __construct()
	{
		$this->V001O = new TemplateHandler();
		$this->V001O->setTemplatePath('assets\templates\\');
		$this->V002O = new RegExVerifier();
	}
	
	public function __destruct()
	{
		unlink($this->V001O);
		unlink($this->V002O);
	}
	
	public function ImageResizer($image)
	{
		//$image = "Database/Foto/IMG_001.jpg"; // Name of the source image
		list($PictureWidth, $PictureHeight) = getimagesize($image); // Get original size of source image
		
		$PictureAspectRatio = $PictureWidth/$PictureHeight;
	
		$Width = 160;
		$Height = 120;
		$AspectRatio = $Width/$Height;
		
		if ($PictureAspectRatio > $AspectRatio)
		{
			$NewWidth = $Width;
			$NewHeight = $Width/$PictureWidth * $PictureHeight;
		}
		else if ($PictureAspectRatio < $AspectRatio)
		{
			$NewWidth = $Height/$PictureHeight * $PictureWidth;
			$NewHeight = $Height;
		}
		else if ($PictureAspectRatio == $AspectRatio)
		{
			$NewWidth = $Width;
			$NewHeight = $Height;
		}
		
		# Generate the resources
		$thumb = imagecreatetruecolor($NewWidth, $NewHeight); // Create resource for thumbnail
		$source = imagecreatefromjpeg($image); // Set the resource for the source image
		
		# Generate the actual thumbnail
		imagecopyresized($thumb, $source, 0,0,0,0, $NewWidth, $NewHeight, $PictureWidth, $PictureHeight); // Generate thumbnail data
		
		# Stream the data to a filename
		imagejpeg($thumb,$image,50); // Stream image to file 'original_thumbnail.jpg'
		
		# Release the memory
		imagedestroy($thumb); // Always remember to clear your resources!
		imagedestroy($source); // Otherwise, you get a "memory leak"	
	}
	
	public function Photo_Tabular($iCache)
	{
		foreach($iCache as $i => $iValue)
		{	
			if($this->V002O->isPathToFile($iCache[$i]['Photo']) == false)
			{
				$iCache[$i]['Photo'] = (strcasecmp($iCache[$i]['Sex'],"Female") == 0) ? "assets/images/Default_F.gif" : "assets/images/Default_M.gif";
			}
			
			$iArg = array(	'Photo'=>$iCache[$i]['Photo'], 
							'First_Name'=>$iCache[$i]['First_Name'],
							'Middle_Name'=>$iCache[$i]['Middle_Name'], 
							'Last_Name'=>$iCache[$i]['Last_Name'],
							'Employee_ID'=>$iCache[$i]['Employee_ID'],
							'Title_Position'=>$iCache[$i]['Title_Position'],
							'Department'=>$iCache[$i]['Department']		);
			
			$oCache .= $this->V001O->ModifyAndDump('T007D', $iArg);
		}
		
		return $this->V001O->ModifyAndDump('T006D', array('Content'=>$oCache));
	}
	
	public function jpgButton($link, $caption)
	{
		$img = "assets/images/CosmicGelLg4.gif";
		$iArg = array('Link'=>$link, 'Image'=>$img, 'Caption'=>$caption);
		$Ouput = $this->V001O->ModifyAndDump('T005D', $iArg);
		return $Ouput;
	}
	
	public function CreateIcon($link, $image, $tooltip)
	{
		$iTemplate = '&nbsp;'.'<a href="[href]" target="_self"><img src="[src]" alt="[alt]"></a>'.'&nbsp;';
		$iArg = array('href'=>$link, 'src'=>$image, 'alt'=>$tooltip);
		$Ouput = $this->V001O->FitIn($iTemplate, $iArg);
		return $Ouput;
	}
}

?>