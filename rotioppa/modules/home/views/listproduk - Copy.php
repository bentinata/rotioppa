	<br>
	<div class="judula">
		<?=lang('search_produk')?>
	</div>
	<div class="garis"></div>
	<br>
    <? if($list){?>
    <div id="viewajax2">
    	<? $this->template->load_view('listproduk_list',false)?>
    </div>


<div class="box-title-footer">
	<br /><br />
<center>
<div id="container">
	<div class="pagination">
	<?=$paging->Navigation('page','class="paging"',$thislink)?>
	</div>
	</div>
</center>
<? }else{ ?>
<br />
<br />
<b>Barang Kosong</b>
<? }?>
</div>

<br>

