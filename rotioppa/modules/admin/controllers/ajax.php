<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// clear template
		$this->template->clear_layout();
	}
	function add_related()
	{
		// load def lang
		$this->lang->load('defproduk',$this->globals->lang);
		$t='';
		for($i=0;$i<3;$i++){
		$text = '<fieldset>
		<legend><input class="ck_name" name="ck['.($i+1).']" value="3" type="checkbox"></legend>		
		<table>
		<tr>
			<th>'.lang('ukuran').'</th>
			<td><input type="text" name="ukuran" value="" /></td>
		</tr>
		<tr>
			<th>'.lang('oldstock').'</th>
			<td><input type="text" name="oldstock" value="" /></td>
		</tr>
		<tr>
			<th>'.lang('stock').'</th>
			<td><input type="text" class="st_name" name="st'.$i.'" value="6" /></td>
		</tr>
		</table></fieldset>';
		$t.=$text;
		}
		echo $t;
	}
}
