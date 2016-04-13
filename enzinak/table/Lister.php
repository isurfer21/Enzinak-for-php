<?php

# CLASS ------------------------------------
#	Title: Lister
#	Decription: To create list.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

require_once("Core\AkPhpLib\TemplateHandler.php");

class Lister
{
	private $V001O;
	
	public function __construct()
	{
		$this->V001O = new TemplateHandler();
	}
	
	public function __destruct()
	{
		unlink($this->V001O);
	}

	public function TableToCategorizedList($iTable, $iCategory, $iItem)
	{
		$Output = array();
		$iUnique = $this->GetUniqueItemList($iTable, $iCategory);
		
		for($i=0; $i<count($iUnique); $i++)
		{
			array_push($Output, "+{".$iUnique[$i]);
			
			for($j=0; $j<count($iTable); $j++)
			{
				if( $iTable[$j][$iCategory] == $iUnique[$i] )
				{
					array_push($Output, $iTable[$j][$iItem]);
				}
			}
			
			array_push($Output, "}-");
		}
		
		return $Output;
	}
	
	public function GetUniqueItemList($iTable, $iColumn)
	{
		$Output = array();
		
		for($i=0; $i<count($iTable); $i++)
		{
			if(!in_array($iTable[$i][$iColumn], $Output))
			{
				array_push($Output, $iTable[$i][$iColumn]);
			}
		}
		
		return $Output;
	}
	
	public function ReturnIndex($iItem, $iList)
	{
		for($i=0; $i<count($iList); $i++)
		{
			if( $iItem == $iList[$i] )
			{
				$Output = $i; 
			}
		}
		
		return $Output;
	}
	
	public function CreateList($iList)
	{
		for($i=0; $i<count($iList); $i++)
		{
			$iArg = array('Link'=>$iList[$i]['Link'], 'Caption'=>$iList[$i]['Label']);
			$list .= $this->V001O->FitIn('<li><a href="[Link]" target="_self">[Caption]</a></li>', $iArg);
		}
		return $this->V001O->FitIn('<ul>[Caption]</ul>', array('Caption'=>$list));
	}
	
	public function CreateListWithoutLink($iList)
	{
		for($i=0; $i<count($iList); $i++)
		{
			$list .= $this->V001O->FitIn('<li>[Caption]</li>', array('Caption'=>$iList[$i]));
		}
		return $this->V001O->FitIn('<ul>[Caption]</ul>', array('Caption'=>$list));
	}
}

?>