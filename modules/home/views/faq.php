<div style="min-height:400px" class="content-text">
<div class="box-title">
	<h2>FAQ</h2>
</div>
<div class="box-content">

<? $i=1;if($faq){foreach($faq as $f){?>
<p style="font-size:16px" id="sam<?=$i?>">
<strong>- <?=$f->question?></strong><br />
<?=$f->answer?><br /><br />
</p>
<? }}?>
</div>
</div>
