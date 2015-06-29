<?
/**
*
* Page Navigation Helper
*
* Page Navigation helper helps you to create pagination and paging navigation.
* 
* @package		PageNav
* @subpackage	Helpers
* @author		Achmad Ardiansyah
* @category	Helpers
* 
**/
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// Load Config File
$CI =& get_instance();
$CI->config->load('pagenav');

define('PAGENAV_PAGE', $CI->config->item('pagenav_page'));
define('PAGENAV_LIMIT', $CI->config->item('pagenav_offset'));

/**
 * CreatePageNav
 *
 * Create new page navigation class.
 *
 * @access	public
 * @param	array
 * @return	PageNav Class
 */	
if (!function_exists('CreatePageNav')) {
	function CreatePageNav($params) {
		if (array_key_exists('curpage', $params) && array_key_exists('limit', $params) && array_key_exists('total', $params)) {
			$data = new PageNav($params);
			return $data;
		}
		
		return false;
	}
}

if (!function_exists('ValidatePageNavSession')) {
	function ValidatePageNavSession($code = false) {
		global $CI;
		
		if ($code && $code != $CI->session->userdata('pagenav_code')) {
			$CI->session->unset_userdata('pagenav_code');
			$CI->session->unset_userdata('pagenav_page');
			$CI->session->unset_userdata('pagenav_limit');
		}
	}
}

/**
 * GetPageNLimitVar
 *
 * Helps you get current page and limit.
 *
 * @access	public
 * @param	array uri segment, leave blank to get default CI default uri segment
 * @return	array
 */	
if (!function_exists('GetPageNLimitVar')) {
	function GetPageNLimitVar($code = true, $limit = 10, $segments = NULL) {
		global $CI;
		
		if ($segments == NULL)
			$segments = $CI->uri->segments;
		
		$return = array();
		 
		if (($key1 = array_search(PAGENAV_PAGE,$segments)))
			$return['curpage'] = $segments[$key1+1];
		else if ($code && ($CI->session->userdata('pagenav_code') == $code || $code === true) && $CI->session->userdata('pagenav_page'))
			$return['curpage'] = $CI->session->userdata('pagenav_page');
		else
			$return['curpage'] = 1;
		
		if (($key2 = array_search(PAGENAV_LIMIT,$segments)))
			$return['limit'] = $segments[$key2+1];
		else if ($code && ($CI->session->userdata('pagenav_code') == $code || $code === true)){
			if($CI->session->userdata('pagenav_limit'))
				$return['limit'] = $CI->session->userdata('pagenav_limit');
			else
				$return['limit'] = $limit;
		}else
			$return['limit'] = $limit;
		
		return $return;
	}
}

/**
 * GetLimitStart
 *
 * Helps you get start position of data from current page.
 *
 * @access	public
 * @param	integer current page
 * @param	integer data limit
 * @return	array
 */	
if (!function_exists('GetLimitStart')) {
	function GetLimitStart($page, $limit) { 
		$page = (int) $page;
		$limit = (int) $limit;
		
		return ($page-1)*$limit;
	}
}

function FormatLink($page){
	return PAGENAV_PAGE.'/'.$page;
}

class PageNav {
	
	// Configuration Variables
	var $curpage				= 1;						// Current Page
	var $limit					= 10;						// Data Limit
	var $total					= 0;						// Total Data
	var $total_page				= 0;
	var $show_limit				= true;						// Show Limit on URL?
	var $first_text				= "First";					// 'First' Text
	var $prev_text				= "Prev";					// 'Previous' Text
	var $next_text				= "Next";					// 'Next' Text
	var $last_text				= "Last";					// 'Last' Text
	var $num_links				= 4;						// Number of links before and after the current page
	var $full_class				= 'full-pagenav';			// Class for Navigation div tag
	var $fnl_class				= 'fnl-pagenav';			// Class for First and Last link
	var $fnl_dis_class			= 'fnl-dis-pagenav';		// Class for Disabled First and Last link
	var $pnn_class				= 'pnn-pagenav';			// Class for Prev and Next Link
	var $pnn_dis_class			= 'pnn-dis-pagenav';		// Class for Disabled Prev and Next Link
	var $num_class				= 'num-pagenav';			// Class for Page Number Links
	var $cur_class				= 'cur-pagenav';			// Class for Current Page Number
	var $limit_class			= 'limit-pagenav';			// Class for Limit Box
	var $counter_class			= 'counter-pagenav';		// Class for Counter div tag
	var $counter_cur_class		= 'counter-cur-pagenav';	// Class for Current data on Counter
	var $counter_total_class	= 'counter-total-pagenav';	// Class for Total data on Counter
	
	// for page number links
	var $start					= NULL;
	var $end					= NULL;
	var $CI						= NULL;
	
	function PageNav($config = array()) {
		// Setting parameters
		if (count($config) > 0) {
			foreach($config as $key => $val) {
				if (isset($this->$key) && $key != 'start' && $key != 'end')
					$this->$key = $val;
			}
		}
		
		$this->CI =& get_instance();
		
		// If show ALL data, limit will set to 200
		if ($this->limit == 'ALL')
			$this->limit = 200;
		
		// Set global start and end variabel for Number Links looping
		if (($this->curpage - $this->num_links) < 1)
			$this->start = 1;
		else 
			$this->start = $this->curpage - $this->num_links;
		
		$this->total_page = ceil(($this->total/$this->limit));
		
		$this->end = $this->curpage + $this->num_links;
	}
	
	/**
	 * AttachStyle
	 *
	 * Default style.
	 *
	 * @access	public
	 * @return	string
	 */	
	function AttachStyle() {
		return "
		<style>
		.fnl-pagenav, .pnn-pagenav { 
			color: #999999;
		}
		.fnl-dis-pagenav, .pnn-dis-pagenav { 
			color: #CCCCCC;
		}
		.cur-pagenav, .counter-cur-pagenav, .counter-total-pagenav {
			font-weight: bold;
		}
		</style>
		";
	}
	
	/**
	 * Navigation
	 *
	 * Create page navigation (eg. First Prev 1 2 3 4 5 Next Last).
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */	
	function Navigation($link) {
		$cur_class = 'active';
		// if data is empty return nothing
		if ($this->total == 0 || $this->limit == 0)
			return '';
		
		$numpage = ceil($this->total / $this->limit);
		
		// only 1 page?? no need to continue.
		if ($numpage == 1)
			return '';
		
		// Set start and end variabel for Number Links looping
		$start = ($this->start < 1) ? 1 : $this->start;
		// $end = ($this->end > $numpage) ? $numpage : $this->end;
		$end = $numpage;
		
		// make sure the last character of link is /
		$link = base_url().rtrim($link, '/').'/';
		
		$output = '';
		
		// Creating First and Prev link
		// if ($this->curpage > 1) {
			$output .= '<a href="javascript:void(0)" id="1" class="page gradient first '.$this->fnl_class.'">'.$this->first_text.'</a> ';
			$output .= '<a href="javascript:void(0)" id="'.($this->curpage-1).'" class="page gradient prev '.$this->pnn_class.'">'.$this->prev_text.'</a> ';
		// } else {
			// $output .= '<span class="'.$this->fnl_dis_class.'">'.$this->first_text.'</span> ';
			// $output .= '<span class="'.$this->pnn_dis_class.'">'.$this->prev_text.'</span> ';
		// }
		
		// Looping for Number Links
		for ($i = $start; $i <= $end; $i++) {
			if ($i == $this->curpage)
				$output .= '<a href="javascript:void(0)" id="'.$i.'" class="page '.$cur_class.' '.$i.'">'.$i.'</a> ';
			else 
				// $output .= '<a onclick="'.$link.PAGENAV_PAGE.'/'.$i.($this->show_limit?'/'.PAGENAV_LIMIT.'/'.$this->limit:'').'" class="'.$this->num_class.'">'.$i.'</a> ';
				$output .= '<a href="javascript:void(0)" id="'.$i.'" class="page gradient '.$i.'">'.$i.'</a> ';
				
				// $plus = 'onchange="window.location=\''.$link.PAGENAV_PAGE.'/\' + this.value;"';
		}
		
		// Creating Next and Last link
		// if ($this->curpage < $numpage) {
			$output .= '<a href="javascript:void(0)" id="'.($this->curpage+1).'" class="page gradient next '.$this->pnn_class.'">'.$this->next_text.'</a> ';
			$output .= '<a href="javascript:void(0)" id="'.($numpage).'" class="page gradient last '.$this->fnl_class.'">'.$this->last_text.'</a> ';
			// $output .= '<a href="'.$link.PAGENAV_PAGE.'/'.$numpage.($this->show_limit?'/'.PAGENAV_LIMIT.'/'.$this->limit:'').'" class="'.$this->fnl_class.'">'.$this->last_text.'</a>';
		// } else {
			// $output .= '<span class="'.$this->pnn_dis_class.'">'.$this->next_text.'</span> ';
			// $output .= '<span class="'.$this->fnl_dis_class.'">'.$this->last_text.'</span>';
		// }
		
		// remove double slashes
		$output = preg_replace("#([^:])//+#", "\\1/", $output);
		
		$output = '<div class="'.$this->full_class.'">'.$output.'</div>';
		
		return $output;
	}
	
	/**
	 * LimitBox
	 *
	 * Create a limit box to change data limit.
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */	
	function LimitBox($name='LimitBox',$option='',$link=false) {
		// if data is empty return nothing
		if ($this->total == 0 || $this->limit == 0)
			return '';
		
		// Only if limit shown on URL
		if ($this->show_limit) {
			// page options
			for($o=0;$o<$this->total_page;$o++){
				$options[($o+1)] = ($o+1);
			}
			
			// if total data less than or equal 200 or data limit is 200 that's mean show all
			//if ($this->total <= 200 || $this->limit == 200)
				//$options[200] = 'ALL';
			
			// set new option if the given limit is not on the list
			//if (!in_array($this->limit, $options) && $this->limit != 200)
				//$options[$this->limit] = $this->limit;
			
			$plus='';
			if($link){
				// make sure the last character of link is /
				$link = base_url().rtrim($link, '/').'/';
				$plus = 'onchange="window.location=\''.$link.PAGENAV_PAGE.'/\' + this.value;"';
			}
			$plus .=' page="'.PAGENAV_PAGE.'"';
			
			$output = form_dropdown($name,$options,$this->curpage,$plus.' '.$option);
			
			return $output;
		}
		
		return '';
	}
	
	/**
	 * LimitBox
	 *
	 * Create data counter (eg. Showing 1 - 10 from 127).
	 *
	 * @access	public
	 * @return	string
	 */	
	function Counter() {
		$first = GetLimitStart($this->curpage, $this->limit)+1;
		$last = $this->curpage*$this->limit;
		$total = $this->total;
		
		if ($total==0)
			return '<i>No Records</i>';
		
		if ($total <= $this->limit)
			$last=$total;
		
		return sprintf($this->CI->config->item('pagenav_counter_text'),$this->counter_class, $this->counter_cur_class, $first, $this->counter_cur_class, $last, $this->counter_total_class, $total);
	}
	
	/**
	 * LimitBox
	 *
	 * Create page counter (eg. Showing Page 1 of 12).
	 *
	 * @access	public
	 * @return	string
	 */	
	function PageCounter() {
		$numpage = ceil($this->total / $this->limit);
		
		if ($this->total==0)
			return '<i>No Records</i>';
		
		/*if ($numpage == 1)
			return '';*/
		
		return sprintf($this->CI->config->item('pagenav_pagecounter_text'), $this->counter_class, $this->counter_cur_class, $this->curpage, $this->counter_total_class, $numpage);
	}
	
	function RememberMe($code = false) {
		if ($code)
			$this->CI->session->set_userdata('pagenav_code',$code);
		$this->CI->session->set_userdata('pagenav_page',$this->curpage);
		$this->CI->session->set_userdata('pagenav_limit',$this->limit);
	}
	
	function ForgetMe() {
		$this->CI->session->unset_userdata('pagenav_code');
		$this->CI->session->unset_userdata('pagenav_page');
		$this->CI->session->unset_userdata('pagenav_limit');
	}
}
?>