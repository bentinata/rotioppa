<h3>Aktivasi Customer</h3>
<br />
<br />
<? if(isset($ok)){?>
<div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div>
<? if($ok){?>
<div class="boxq boxqbg2" style="padding:50px;text-align:center;font-size:14px">Silahkan Anda login melalui link di bawah ini, untuk menggunakan fasilitas member yang telah disediakan<br /><br />
[ <?=anchor(site_url('login'),'Login Member',array('style'=>'font-size:11px'))?> ]
</div>
<? }}?>