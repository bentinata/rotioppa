<br/><style>
#in_konfirm li label{width:200px;top:4px;position:relative}
</style>
<?
for($t=1;$t<=31;$t++){$tgl[$t]=$t;}
for($b=1;$b<=12;$b++){$bln[$b]=$b;}
for($y=2010;$y<=date('Y');$y++){$year[$y]=$y;}

$bank_tujuan_transfer = array('BCA'=>'BCA','Mandiri'=>'Mandiri');
?>
<div class="judula">KONFIRMASI PEMBAYARAN</div>
<div class="garis">
</div><br /><br />

<div style="color:red">*Pastikan data yang di bawah ini sesuai dengan transaksi yang anda lakukan</div><br/>
<div class="bordere">
<div class="judules">Konfirmasi Detail</div>
<div class="konten">
Konfirmasi pembayaran bisa dilakukan dengan menggunakan beberapa cara dibawah ini :<br/>
SMS ke no : 0857 2303 6868<br/>
atau dengan melengkapi form dibawah ini<br/><br/>
</div>
</div><br/>

<form method="post" action="" id="form_konfirm" class="bordere">
<div class="judules">Form Konfirmasi</div><br/>
<div class="konten">
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>
<span class="note"><?=lang('complete_your_data')?></span><br /><br />
<ul class="form" id="in_konfirm">
	<li><label>Nama </label>: <input type="text" style="width:300px" name="nama" value="<?=$this->input->post('nama')?>" /><span class="notered">*</span></li>
	<li><label>Email </label>: <input type="text" style="width:300px" name="email_k" value="<?=$this->input->post('email_k')?>" /><span class="notered">*</span></li>
	<li><label>No.Invoice </label>: <input type="text" style="width:300px" name="invoice" value="<?=$this->input->post('invoice')?>" maxlength="60" /><span class="notered">*</span></li>
	<li><label>Tanggal Pembayaran </label>: 
		Tgl <?=form_dropdown('tgl',$tgl,$this->input->post('tgl'))?> 
		Bln <?=form_dropdown('bln',$bln,$this->input->post('bln'))?> 
		Thn <?=form_dropdown('thn',$year,$this->input->post('thn'))?>
		<span class="notered">*</span></li>
	<li><label>Total Pembayaran </label>: <input type="text" style="width:300px" class="digit" name="total" value="<?=$this->input->post('total')?>" /><input type="hidden" name="hid_total" class="fixdigit" /><span class="notered">*</span></li>
	<li><label>Pembayaran Dari Bank </label>: <input type="text" style="width:300px" name="from_bank" value="<?=$this->input->post('from_bank')?>" /><span class="notered">*</span></li>
	<li><label>Nama Pemilik Rekening/Nasabah </label>: <input type="text" style="width:300px" name="rek" value="<?=$this->input->post('rek')?>" /><span class="notered">*</span></li>
	<li><label>Bank Tujuan Transfer </label>: <?=form_dropdown('to_bank',$bank_tujuan_transfer,$this->input->post('to_bank'))?><span class="notered">*</span></li>
	<li><label>Pesan </label>: <textarea name="pesan" style="width:300px"><?=$this->input->post('pesan')?></textarea><span class="notered">*</span></li>
	<li><label style="top:20px">Kode Verifikasi </label>: <img src="<?=base_url().'captcha'?>" width="80px" height="30px" style="position:relative;top:8px;margin-right:10px;" />
	<input type="text" style="width:220px" class="captcha" name="captcha" />
	<span class="notered">*</span></li><br/>
	<li><label>&nbsp;</label>&nbsp;&nbsp;<input id="konok" type="button" name="_KONFIRM" value="Konfirmasi" /></li>
</ul><br/><br/>
<input type="hidden" name="do" value="1" />
</form>	
</div>
<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$("input[name='_KONFIRM']").click(function(){
		nm=$("input[name='nama']").val();
		em=$("input[name='email_k']").val();
		inf=$("input[name='invoice']").val();
		tt=$("input[name='total']").val();
		fb=$("input[name='from_bank']").val();
		rk=$("input[name='rek']").val();
		tb=$("input[name='to_bank']").val();
		ps=$("textarea[name='pesan']").val();
		cp=$("input[name='captcha']").val();
		if(em!='' && nm!='' && inf!='' && tt!='' && fb!='' && rk!='' && tb!='' && ps!='' && cp!='')
			$('#form_konfirm').submit();
		else{
			alert('<?=lang('data_not_complete')?>');
			return false;
		}
	});
	$(".digit").keyup(function(e){ 
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
			//display error message
			alert('<?=lang('justnumber')?>');
			$(this).val(clear_format_curency($(this).val(),'.'));
			return false;
		}else{
			var digit = $(this).val();
			var res = format_to_curency(digit);
			$(this).val(res);

			var res_val = clear_format_curency($(this).val());
			$(this).next(".fixdigit").val(res_val);
		}
	});
});
</script>
