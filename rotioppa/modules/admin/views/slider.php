<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span>Slide Banner</span>
</div>
<br class="clr" />
<fieldset>
<legend>Tambah Banner :</legend>
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>
<form method="post" enctype="multipart/form-data" >
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th>Gambar</th>
	<td><input type="file" name="galery" /></td>
</tr>
<tr>
	<th>URL</th>
	<td>
    <input type="url" name="url" /><br /></td>
</tr>
<tr>
	<th></th>
    <td>
	<button type="submit" name="tambah_img">Upload</button>
	<input type="hidden" name="tambah_img" value="1" /></td>
</tr>
</tbody>
    </table>
    </form>
    <p class="error">Note: Ukuran image <?=$ukuran?><br />Banner yang akan ditampilkan adalah 4 banner dengan urutan terbawah</p>
    </fieldset>
            <div class="list-galery galery-complete">
         
        	<table class="adminlist" align="center">
            	<thead>
                	<th>#</th>
                	<th>Gambar Banner</th>
                    <th>URL</th>
                    <th></th>
                </thead>
                <tbody id="sortable">
               	<? $i=0;$a ="";if($galery){foreach($galery as $g){ $i++?>
                	<tr id="item-<?=$g->id?>">
                    	<td><?=$i?></td>
                    	<td><a class="fbox" href="<?=site_url('uploads/slider/'.$g->nama_gambar)?>"><img src="<?=site_url('uploads/slider/'.$g->nama_gambar)?>" width="200" height="78" /></a></td>
                        <td><span class="url"><?=$g->url?></span></td>
                    	<td><a class="btn btn-danger delete todelete" href="<?=site_url('admin/slider/delete/'.$g->id)?>" style="margin-top:5px;">Delete</a></td>
                    </tr>
		<? if($i==4){ $a = '</div><div class="list-galery galery-complete">';}}}?>
                </tbody>
            </table>
		<?=$a?>
			
		</div>
    
</div>

<script>
$(function(){
	$('.todelete').click(function(){
		if(confirm('Delete?')) return true;
		return false;
	});
	
	//Merubah Urutan
    $('#sortable').sortable({
        axis: 'y',
        stop: function (event, ui) {
	        var data = $(this).sortable('serialize');

            $.ajax({
                data: data,
                type: 'POST',
                url: '<?=site_url('admin/slider/updateOrder')?>'
            });
	}
    });
});
</script>
