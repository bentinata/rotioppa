<?
for($t=1;$t<=31;$t++){$tgl[$t]=$t;}
for($b=1;$b<=12;$b++){$bln[$b]=$b;}
for($y=2010;$y<=date('Y');$y++){$year[$y]=$y;}
?>	<br><div class="judul">
		REGISTRASI AFFILIATE<BR/>
	</div>
	<div style="color:red">*Lengkapi data di bawah ini dengan data diri anda
	<div class="garis"></div><br>
<div id="kemitraan">
	<ul>
		<li class="box_content">
			<div class="space_blog">
				<div class="form_pendaftaran_mitra">
						<div class="head">
							Formulir Pendaftaran
						</div>
						<div class="form-input">
                        <form method="post">
								<div class="tbl">
									<ul>
										<li><label>Email </label>: <input type="text" name="email_k" value="<?=$this->input->post('email_k')?>" /><span class="notered">*</span></li>
									</ul>
									<ul>
									<li><label>Password </label>: <input type="password" name="pass" value="<?=$this->input->post('pass')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Ulangi Password </label>: <input type="password" name="pass_re" value="<?=$this->input->post('pass')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Nama </label>: <input type="text" name="nama" value="<?=$this->input->post('nama')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Nama Panggilan</label>: <input type="text" name="nama_p" value="<?=$this->input->post('nama_p')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Tlp. </label>: <input type="text" name="tlp" value="<?=$this->input->post('tlp')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>HP </label>: <input type="text" name="hp" value="<?=$this->input->post('hp')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Alamat </label>: <textarea type="text" name="alamat" value="<?=$this->input->post('alamat')?>"></textarea><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Kota </label>: <input type="text" name="kota" value="<?=$this->input->post('kota')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Provinsi </label>: <input type="text" name="prov" value="<?=$this->input->post('prov')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li><label>Negara </label>: <input type="text" name="negara" value="<?=$this->input->post('negara')?>" /><span class="notered">*</span></li>
									</ul>
									<ul><li>Jenis Kelamin : 
											<select>
											  <option value="volvo">Pria</option>
											  <option value="saab">Wanita</option>
											</select> 
										</li>
									</ul>
									<ul>	<li><label>Tanggal Pembayaran </label>: 
											<?=form_dropdown('tgl',$tgl,$this->input->post('tgl'))?> 
											<?=form_dropdown('bln',$bln,$this->input->post('bln'))?> 
											<?=form_dropdown('thn',$year,$this->input->post('thn'))?>
											<span class="notered">*</span></li>
									</ul>
									<ul><li>Metode Pembayaran : 
											<form>
											<input type="radio" name="metode" value="male" checked>Transfer Antar Bank
											<input type="radio" name="metode" value="female">Paypal
											</form> 
										</li>
									</ul>
									<ul><li>Batas Pencairan Komisi : 
											<select>
											  <option value="volvo">Volvo</option>
											  <option value="saab">Saab</option>
											  <option value="mercedes">Mercedes</option>
											  <option value="audi">Audi</option>
											</select> 
										</li>
									</ul>
									<ul><li>Url web/blog : 
											<input class="tinput" type="text" name="inama">
										</li></ul>
									<ul class="form" id="in_konfirm">
									<li><label style="top:20px">Kode Verifikasi </label>: <img src="<?=base_url().'captcha'?>" width="80px" height="30px" style="position:relative;top:8px;margin-right:10px;" />
									<input type="text" class="captcha" name="captcha" />
									<span class="notered">*</span></li>
									</ul>
									<ul>
										<li style="margin-left:160px">
											<input class="isubmit" type="submit" name="_ISUBMIT" value="Daftar" />
										</li>
									</ul>
								</div>
								</form>
						</div>
					
				</div>		
			</div>
		</li>
	</ul>
</div>

