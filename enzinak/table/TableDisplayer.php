<?php

# CLASS ------------------------------------
#  Title: Table Formator
#  Decription: To manage contents in table.
#  Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------
  
require_once(APPROOT."Table\TableFormator.php");

class TableDisplayer extends TableFormator
{
  private $V001O;
  private $V002O;
  
  public function __construct()
  {
  	$this->V001O = new FormatMachine();
	$this->V002O = new TemplateHandler();
	$this->V002O->setTemplatePath('Assets\template\Tables\\');
  }
  
  public function __destruct()
  {
  	unlink($this->V001O);
	unlink($this->V002O);
  }

  public function ShowTable($table)
  {
	  $output .= "<TABLE>";
	  for ($i = 0; $i < count($table); $i++)
	  {
		  $output .= "<TR>";
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  $output .= "<TD>" . $table[$i][$j] . "</TD>";
		  }
		  $output .= "</TR>";
	  }
	  $output .= "</TABLE>";
	  
	  return $output;
  }
  
  public function ShowTableV($table)
  {
	  $output = '';
	  for ($i = 1; $i < count($table); $i++)
	  {
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  $output .= "<tr>";
			  $bc = 2;
			  $output .= $this->V001O->Format_Cell($table[0][$j], $bc, 'left', false, true);
			  $bc = ($j == 0) ? 2 : $j % 2;
			  $output .= $this->V001O->Format_Cell($table[$i][$j], $bc, 'left', false, true);
			  $output .= "</tr>";
		  }
	  }
	   
	  return $this->V002O->ModifyAndDump('T001D', array('Content'=>$output));
  }
  
  public function ShowTableH($table)
  {
  	  $output = '';
	  for ($i = 0; $i < count($table); $i++)
	  {
		  $output .= "<tr>";
		  
		  $bc = ($i == 0) ? 2 : $i % 2;
		  
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  $output .= $this->V001O->Format_Cell($table[$i][$j], $bc, 'left', false, true);
		  }
		  
		  $output .= "</tr>";
	  }
	  
	  return $this->V002O->ModifyAndDump('T001D', array('Content'=>$output));
  }
  
  public function ShowTableH_SortingEnabled($table)
  {
	  $FlashCom = new FlashComponent();
	  $UrlHandler = new UrlJuggler();
	  
	  $output = '';
	  
	  for ($i = 0; $i < count($table); $i++)
	  {
		  $output .= "<tr>";
		  
		  $bc = ($i == 0) ? 2 : $i % 2;
		  
		  for ($j = 0; $j < count($table[$i]); $j++)
		  {
			  if ($i == 0 && $j != 0 && (strcasecmp($table[$i][$j], "Controls") != 0))
			  {
				  $thisPage = $UrlHandler->SkipArgFromURL("OrderBy");
				  $link = $thisPage . "OrderBy=" . str_replace(" ", "_", $table[$i][$j]);
				  $link = urlencode($link);
				  $table[$i][$j] .= "&nbsp;" . $FlashCom->UpDownIcon($link);
			  }
			  $output .= $this->V001O->Format_Cell($table[$i][$j], $bc, 'left', false, true);
		  }
		  
		  $output .= "</tr>";
	  }

	  unlink($FlashCom);
	  unlink($UrlHandler);

	  return $this->V002O->ModifyAndDump('T001D', array('Content'=>$output));
  }
}

?>