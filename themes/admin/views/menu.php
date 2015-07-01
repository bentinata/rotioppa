<div id="myslidemenu" class="jqueryslidemenu">
<ul>
<li><?=anchor(config_item('modulename'),loadImgThem('icon/home.png','',false,config_item('modulename'),true).'Home')?></li>
	<? /*<ul>
	<li><?=anchor(config_item('modulename').'/aff',loadImgThem('icon/bullet_green.png','',false,config_item('modulename'),true).'List Affiliate')?></li>
	<li><?=anchor(config_item('modulename').'/komisi',loadImgThem('icon/bullet_green.png','',false,config_item('modulename'),true).'Komisi')?></li>
	</ul>*/?>
</li>
<li><?=anchor(config_item('modulename').'/profile',loadImgThem('icon/bullet_green.png','',false,config_item('modulename'),true).'Profile')?></li>
</li>
<li><?=anchor(config_item('modulename').'/promo',loadImgThem('icon/bullet_green.png','',false,config_item('modulename'),true).'Promo')?></li>
</li>
<li><?=anchor(config_item('modulename').'/update_pass',loadImgThem('icon/bullet_green.png','',false,config_item('modulename'),true).'Ubah password')?></li>
</li>
<li><?=anchor('login/'.config_item('modulename').'/logout',loadImgThem('icon/disconnect.png','',false,config_item('modulename'),true).'Logout')?></li>
</ul>
<br style="clear: left" />
</div>
