<?php
function format_date($date,$short=false){	
	if ($date != '')
	{
		$_date = check_time_include($date);
		if($_date['date'] == '0000-00-00') return false;

		$date = $_date['date'];
		$time = isset($_date['time'])?$_date['time']:'';
		$d	= explode('-', $date);
	
		$m	= Array(
		'January'
		,'February'
		,'March'
		,'April'
		,'May'
		,'June'
		,'July'
		,'August'
		,'September'
		,'October'
		,'November'
		,'December'
		);
	
		if($short) return $d[2].'-'.$d[1].'-'.$d[0].' '.$time; 
		else{
			if(empty($time))
			return $d[2].' '.$m[$d[1]-1].' '.$d[0];
			else	
			return $d[2].' '.$m[$d[1]-1].' '.$d[0].' , '.$time; 
		}
	}
	else
	{
		return false;
	}
}

function check_time_include($date)
{
	$d = explode(' ', $date);
	if(count($d)==2) return array('date'=>$d[0],'time'=>$d[1]);
	return array('date'=>$date);
}

function reverse_format($date)
{
	if(empty($date)) 
	{
		return;
	}
	
	$d = explode('-', $date);
	
	return "{$d[1]}-{$d[2]}-{$d[0]}";
}

function format_ymd($date)
{
	if(empty($date) || $date == '00-00-0000')
	{
		return '';
	}
	else
	{
		$d = explode('-', $date);
		return $d[2].'-'.$d[1].'-'.$d[0];
	}
}

function format_dmy($date)
{
	if(empty($date) || $date == '0000-00-00')
	{
		return '';
	}
	else
	{
		return date('d-m-Y', strtotime($date));
	}
	
}


/* End of file welcome.php */
/* Location: ./system/application/helpers/MY_date_helper.php */
