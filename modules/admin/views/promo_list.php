<div id="bg-content"><div class="header">
	<img src="http://localhost/rotioppa/themes/admin/img/icon/mainmenu.png">	<span>Daftar Promo</span>
</div>
<br class="clr">

<div class="cari left">
	
	<span class="load1"></span>
</div>
<a href="http://localhost/rotioppa/admin/promo/input" title="input promo"><img src="http://localhost/rotioppa/themes/admin/img/icon/add.png" style="position:relative;top:5px"></a>
<br class="clr"><br>

<span class="load2"></span>
<div id="viewajax1">
<table class="adminlist" cellspacing="1">
<thead>
<tr>
    <th class="no">No</th>
    <th>Promo</th>
    <th>Aksi</th>
   
</tr>	
</thead>

<tbody id="viewajax2">
<? if($list_promo){$i=$startnumber;foreach($list_promo as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->judul_promo?></td>
	<td>
	<?=anchor($this->module.'/'.$this->router->class.'/edit/'.$lk->promoID,loadImgThem('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor($this->module.'/'.$this->router->class.'/delete/'.$lk->promoID,loadImgThem('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdelproduk'))?>
	</td>
</tr>
<? }}?>

<script language="javascript">
$(function(){
	$('.butdelpromo').click(function(){ 
		if(confirm("Yakin akan menghapus promo?")){
			return true;
		}
		return false;
	});
});
</script></tbody>
<tfoot>
<tr><td colspan="12">
    <div class="pagination">
   
    </div>
</td></tr>
</tfoot>
</table>

  </div>


<!-- autocomplete -->
<script type="text/javascript" src="http://localhost/rotioppa/assets/js/autocomplete/jquery.autocomplete.js"></script><link href="http://localhost/rotioppa/assets//js/autocomplete/styles.css" rel="stylesheet" type="text/css">

</div>