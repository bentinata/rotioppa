	<br><div class="judula">
		Berita & Info
	</div>
	<div class="garis"></div><br>
<div id="kemitraan">
<style>
	.list_artikel img{max-width:100%; height:auto}
</style>
	<ul class="form-kiri2">
    	<? if($list){ ?>
        <div id="viewajax2">
    		<? $this->template->load_view('berita_list',false)?>
    	</div>
       
		<div class="box-title-footer">
			<br /><br />
			<center>
				<div class="pagination">
					<?=$paging->Navigation('page','class="paging"',$thislink)?>
				</div>
			</center>
               <? }else{ ?>
			 <br />
<br />
<b>Barang Kosong</b>
<? }?>
		</div>
      
	</ul>
    
	<ul class="form-kanan2">	
		<li id="sisi">
			<div>
				<ul>
					<li id="block-sidebar_kanan" class="width-sidebar">
						<?=$template['partials']['pg_berita_lain'];?>
					</li>
				</ul>
			
			</div>
		</li>
	</ul>
    <div class="clear"></div>

</div>
<br>
<br>