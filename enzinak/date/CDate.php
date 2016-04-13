<?php

# CLASS ------------------------------------
#	Title: Date Manager
#	Decription: To manager date.
#	Developer: Abhishek Kumar (c) 2008.
# ------------------------------------------

class CDate
{
	public function ChangeDateFormat($iDate)
	{
		list($dd,$mm,$yyyy) = explode("/",$iDate);
		return ($yyyy."-".$mm."-".$dd);
	}
	
	public function TimeRightNow($tFormat)
	{
		require_once("Date.php");
	
		$iNow = date("Y-m-d H:i:s");
		$d = new Date($iNow);
		$d->setTZByID("GMT");
		$d->convertTZByID("IST");
		$oNow = $d->format($tFormat);
		
		return $oNow;
	}
	
	public function TimeRightNowL($tFormat)
	{
		require_once("Date.php");
	
		$IST = time()+19800;
		$iNow = date("Y-m-d H:i:s", $IST);
		$d = new Date($iNow);
		$d->setTZByID("GMT");
		//$d->convertTZByID("IST");
		$oNow = $d->format($tFormat);
		
		return $oNow;
	}
	public function DateDifference($a, $b)
	{
		$output = "DateDiff('yyyy',$a,$b)&'Y '&DateDiff('m',$a,$b) MOD 12&'M '&DateDiff('d',$a,$b) MOD 30&'D '&DateDiff('h',$a,$b) MOD 24&'H '&DateDiff('n',$a,$b) MOD 60&'M '&DateDiff('s',$a,$b) MOD 60&'S'";
		
		return $output;
	}
	
	public function DateToSeconds($year, $month, $date, $hour, $minute, $second)
	{
		return ($year*12*30*24*60*60 + $month*30*24*60*60 + $date*24*60*60 + $hour*60*60 + $minute*60 + $second);	
	}
	
	public function SecondsToDate($second)
	{
		$date = array();
		$date[0] = (int)($second/(12*30*24*60*60));	
		$date[1] = (int)(($second%(12*30*24*60*60))/(30*24*60*60));	
		$date[2] = (int)(($second%(30*24*60*60))/(24*60*60));	
		$date[3] = (int)(($second%(24*60*60))/(60*60));
		$date[4] = (int)(($second%(60*60))/60);		
		$date[5] = (int)($second%60);
		return $date;
	}
	
	public function DateMassToArray($x)
	{
		$y = explode(" ",$x);
		
		for($i=0; $i<count($y); $i++)
		{
			$y[$i] = substr($y[$i], 0, strlen($y[$i])-1);
		}
		return $y;
	}
	
	public function DateValueToArray($x)
	{
		list($d,$t) = explode(" ",$x);
		
		$dd = explode("-",$d);
		$tt = explode(":",$t);
		
		$y = array_merge($dd, $tt);
		
		return $y;
	}
	
	public function DateMassToSeconds($date)
	{
		$second = $this->DateToSeconds($date[0], $date[1], $date[2], $date[3], $date[4], $date[5]);
		return $second;
	}
	
	public function SecondsToDateMass($second)
	{	
		$date = $this->SecondsToDate($second);
		return ($date[0]."Y ".$date[1]."M ".$date[2]."D ".$date[3]."H ".$date[4]."M ".$date[5]."S");
	}
	
	public function DateMassDifference($x, $y)
	{
		//if($x < $y) Swap($x, $y);
		$z = $this->DateMassToSeconds($this->DateMassToArray($x)) - $this->DateMassToSeconds($this->DateMassToArray($y));
		return ($this->SecondsToDateMass($z));
	}
	
	public function DateValueDifference($x, $y)
	{
		//if($x < $y) Swap($x, $y);
		$z = $this->DateMassToSeconds($this->DateValueToArray($x)) - $this->DateMassToSeconds($this->DateValueToArray($y));
		return ($this->SecondsToDateMass($z));
	}
	
	public function DateMassSum($x, $y)
	{
		$z = $this->DateMassToSeconds($this->DateMassToArray($x)) + $this->DateMassToSeconds($this->DateMassToArray($y));
		return ($this->SecondsToDateMass($z));
	}
	
	public function DateValueSum($x, $y)
	{
		$z = $this->DateMassToSeconds($this->DateValueToArray($x)) + $this->DateMassToSeconds($this->DateValueToArray($y));
		return ($this->SecondsToDateMass($z));
	}

	public function Swap(&$x, &$y)
	{
		$temp = $x;
		$x = $y;
		$y = $temp;
	}	
}

?>