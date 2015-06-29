<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mail_lib{
    var $from,$spr,$spr_html;
    function Mail_lib(){
        $this->CI =& get_instance();
        $this->CI->load->library('email');
        $this->from = array('mail'=>'yohgenius@gmail.com','name'=>'kueibuhasan.Com');
        $this->spr = "\r\n";
        $this->spr_html = "<br />";
    }
    function foot_html(){
		$ttd = "Salam ,".$this->spr_html.$this->spr_html
				."kueibuhasan.com Management Team".$this->spr_html.$this->spr_html
				."<h5>"
				."website 	: www.kueibuhasan.com".$this->spr_html 
				."office 	: Bojong Sereh 003/001 Lebak Wangi Kec.Arjasari Kab.Bandung".$this->spr_html
				."phone 	: 0857 2439 8188".$this->spr_html
				."</h5>";
		return $ttd;
	}

    function reg_member($to,$link,$nama,$from=false){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);

		if($from) $this->from = $from;
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);

        $this->CI->email->subject('Link Aktivasi Pendaftaran Customer');
		$msg = "Halo $nama,".$this->spr_html.$this->spr_html
				."Terima kasih telah mendaftar menjadi Customer kueibuhasan.com".$this->spr_html.$this->spr_html
				."Silahkan klik link dibawah ini untuk mengaktifkan akun $nama".$this->spr_html.$this->spr_html
				.$link;
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html(); #echo $msg;break;

        $this->CI->email->message($msg);
        return	$this->CI->email->send();
		#echo $this->CI->email->print_debugger();
    }
    function act_member($to,$nama,$pass,$link_login){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);

		$this->CI->email->subject('Aktivasi Data Customer');
		$msg = "Selamat Datang $nama di kueibuhasan.com,".$this->spr_html.$this->spr_html
				."Akun $nama di kueibuhasan.com telah aktif, silahkan ".$this->spr_html
				."Anda login dengan mengklik link dan menggunakan ".$this->spr_html
				."data dibawah ini :".$this->spr_html.$this->spr_html
				."<b><a href=\"$link_login\">$link_login</a></b>".$this->spr_html.$this->spr_html
				."Data Login $nama".$this->spr_html.$this->spr_html
				."Email : $to".$this->spr_html
				."Password : $pass";
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html(); #echo $msg;break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
	}
    function reg_aff($to,$link,$nama,$from=false){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);

		if($from) $this->from = $from;
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);

        $this->CI->email->subject('Kode Aktivasi Pendaftaran Affiliate');
		$msg = "Halo $nama,".$this->spr.$this->spr_html
				."Terima kasih telah mendaftar menjadi Affiliate kueibuhasan.com".$this->spr_html.$this->spr_html
				."Silahkan klik link dibawah ini untuk mengaktifkan akun $nama".$this->spr_html.$this->spr_html
				.$link;
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html(); #echo $msg;break;

        $this->CI->email->message($msg);
        return	$this->CI->email->send();
		#echo $this->CI->email->print_debugger();
    }
    function act_aff($to,$nama,$pass,$link_login){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);

		$this->CI->email->subject('Aktivasi Data Affiliate');
				// ."Akun $nama di kueibuhasan.com telah aktif, silahkan $nama login dengan".$this->spr_html
		$msg = "Selamat Datang $nama di kueibuhasan.com,".$this->spr_html.$this->spr_html
				."mengklik link dan menggunakan data dibawah ini :".$this->spr_html.$this->spr_html
				."<b>$link_login</b>".$this->spr_html.$this->spr_html
				."Data Login $nama".$this->spr_html.$this->spr_html
				."Email : $to".$this->spr_html
				."Password : $pass";
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html();  #echo $msg;break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
	}

    function cekout($to,$list,$nama,$detail){
        $noinv=$detail->kode_transaksi;
        $tgl=$detail->tgl;
        $status=$detail->status_kirim;
        $biaya_kirim=$detail->biaya_kirim;
        $kode_unik=$detail->kode_unik;

        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);
        
        // list barang
        $tot_biaya=0;
        $tot_barang=0;
        $br='';
		if($list){
			foreach($list as $ck){
				$theprice = $ck->harga;
				$jmlprice = $theprice*$ck->qty;
                $jmlberat = $ck->berat*$ck->qty;
                $cv=convert_unit($ck->berat);
                $cv3=convert_unit($jmlberat);
				$ukr=!empty($ck->ukuran)?lang('cart_ukuran').' : '.$ck->ukuran.$this->spr_html:'';

				$br .="Nama Barang : $ck->nama_produk".$this->spr_html.$ukr
					."QTY : $ck->qty".$this->spr_html
					."Harga Satuan : Rp. ".currency($theprice).$this->spr_html
                    ."Berat Barang : ".$cv['hasil']." ".$cv['satuan'].$this->spr_html
                    ."Total Berat Barang : ".$cv3['hasil']." ".$cv3['satuan'].$this->spr_html
					."Total Harga : Rp. ".currency($jmlprice).$this->spr_html.$this->spr_html;
				$tot_biaya+=$jmlprice;
				$tot_barang+=$ck->qty;
			}
		}
        $cv2=convert_unit($detail->total_berat);
		$this->CI->email->subject('Konfirmasi Invoice no '.$noinv);
        $msg = "Terima kasih telah melakukan pembelian produk di kueibuhasan.com, ".$this->spr_html
				."dilampirkan Invoice dari proses pembelian produk yang telah $nama lakukan :".$this->spr_html.$this->spr_html
				."No Invoice : $noinv".$this->spr_html
				."Tgl Check Out : $tgl ".$this->spr_html
				."Status : ".lang('status_kirim_'.$status).$this->spr_html.$this->spr_html
				.$br
				."Total Barang : $tot_barang".$this->spr_html
				."Total Biaya : Rp. ".currency($tot_biaya).$this->spr_html
                ."Total Berat Barang : ".$cv2['hasil']." ".$cv2['satuan'].$this->spr_html
				."Biaya Pengiriman : Rp. ".currency($biaya_kirim).$this->spr_html
				."Kode Unik Transfer : Rp. $kode_unik ".$this->spr_html
				."Total Biaya Transfer: Rp. ".currency(($tot_biaya+$kode_unik+$biaya_kirim)).$this->spr_html.$this->spr_html

				."Silahkan $nama transfer biaya pemesanan produk dengan menggunakan ".$this->spr_html
				."salah satu metode pembayaran dibawah ini : ".$this->spr_html.$this->spr_html
				."<b>Transfer antar Bank</b> ".$this->spr_html.$this->spr_html

                ."Nama Bank : Bank Central Asia (BCA)".$this->spr_html
				."Cabang : KCU Garut".$this->spr_html
				."No.Rek : 148 073 4498 ".$this->spr_html
				."a/n : Ahmad Syarif. H".$this->spr_html.$this->spr_html

                ."Nama Bank : Bank Mandiri".$this->spr_html
				."Cabang : KCU Garut".$this->spr_html
				."No.Rek : 131 00 1169749 9 ".$this->spr_html
				."a/n : Ahmad Syarif. H".$this->spr_html.$this->spr_html

				."Setelah proses pengiriman dana telah $nama lakukan, jangan lupa untuk ".$this->spr_html
				."mengirimkan konfirmasi pembelian kepada kami dengan menggunakan salah ".$this->spr_html
				."satu layanan dibawah ini :".$this->spr_html.$this->spr_html

				."Menginformasikan kepada kami melalui telepon ke no 022 - 93643654 ".$this->spr_html
                ."atau ".$this->spr_html
                ."SMS melalui no 0857 2303 6868 ".$this->spr_html
                ."atau ".$this->spr_html
				."Kirimkan email melalui ".'<a href="'.site_url('home/konfirmasi').'">Halaman Konfirmasi Pembayaran</a>'.$this->spr_html.$this->spr_html

				."Setelah konfirmasi pembelian kami terima, kami akan segera memproses ".$this->spr_html
				."pembelian yang telah $nama lakukan.";
        $msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html(); #echo $msg; #break;
        
		$this->CI->email->message($msg);
        return $this->CI->email->send();
    }

    function sendpass($to,$pass,$nick,$from=false){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        if($from) $this->from = $from;
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);
        $this->CI->email->subject('Password Akun Member');
        $msg = "$nick telah meminta mengirimkan password ke alamat email".$this->spr_html
            ."Berikut data login $nick".$this->spr_html
            ."Email : $to".$this->spr_html
            ."Password : $pass";
        $msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html();#echo $msg;break;
        $this->CI->email->message($msg);
        return $this->CI->email->send();
    }
    function sendpassaff($to,$pass,$nick,$from=false){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        if($from) $this->from = $from;
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);
        $this->CI->email->subject('Password Akun Affiliate');
        $msg = "$nick telah meminta mengirimkan password ke alamat email".$this->spr_html
            ."Berikut data login $nick".$this->spr_html
            ."Email : $to".$this->spr_html
            ."Password : $pass";
        $msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html();#echo $msg;break;
        $this->CI->email->message($msg);
        return $this->CI->email->send();
    }

    function proses_cekout($to,$list,$nama,$detail){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $harga = $detail->harga;
        $kode_unik = $detail->kode_unik;
        $biaya_kirim = $detail->biaya_kirim;
        $status = $detail->status_kirim;
        $tgl = $detail->tanggal;
        $noinv = $detail->kode_transaksi;

        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);

        // list barang
        $tot_biaya=0;
        $tot_barang=0;
        $br='';
		if($list){
			foreach($list as $ck){
				$theprice = $ck->harga;
				$jmlprice = $theprice*$ck->qty;
                $jmlberat = $ck->berat*$ck->qty;
                $cv=convert_unit($ck->berat);
                $cv3=convert_unit($jmlberat);

				$br .="Nama Barang : $ck->nama_produk".$this->spr_html
					."QTY : $ck->qty".$this->spr_html
                    ."Berat Barang : ".$cv['hasil']." ".$cv['satuan'].$this->spr_html
                    ."Total Berat Barang : ".$cv3['hasil']." ".$cv3['satuan'].$this->spr_html
					."Harga Satuan : Rp. ".currency($theprice).$this->spr_html
					."Total Harga : Rp. ".currency($jmlprice).$this->spr_html.$this->spr_html;
				$tot_biaya+=$jmlprice;
				$tot_barang+=$ck->qty;
			}
		}

        $cv2=convert_unit($detail->total_berat);
        $this->CI->email->subject('Konfirmasi Pembelian no '.$noinv);
		$msg = "Kami Informasikan bahwa konfirmasi pembelian produk yang telah $nama lakukan ".$this->spr_html
				."di kueibuhasan.com dengan data dibawah ini telah kami terima : ".$this->spr_html.$this->spr_html
				."No Invoice : $noinv".$this->spr_html
				."Tgl Check Out : $tgl ".$this->spr_html
				."Status : ".lang('status_kirim_'.$status).$this->spr_html.$this->spr_html
				.$br
				."Total Barang : $tot_barang".$this->spr_html
				."Total Biaya : Rp. ".currency($tot_biaya).$this->spr_html
                ."Total Berat Barang : ".$cv2['hasil']." ".$cv2['satuan'].$this->spr_html
				."Biaya Pengiriman : Rp. ".currency($biaya_kirim).$this->spr_html
				."Kode Unik Transfer : Rp. $kode_unik ".$this->spr_html
				."Total Biaya Transfer : Rp. ".currency(($tot_biaya+$kode_unik+$biaya_kirim)).$this->spr_html.$this->spr_html
				."Dan saat ini status pembelian produk yang telah $nama lakukan adalah ".$this->spr_html
				."\"<b>Dalam Proses Pengiriman</b>\"".$this->spr_html.$this->spr_html
				."Silahkan $nama tunggu beberapa hari hingga produk yang di pesan sampai ".$this->spr_html
				."ke alamat pengiriman $nama dengan data dibawah ini :".$this->spr_html.$this->spr_html
				."Nama penerima : $detail->nama".$this->spr_html
				."Alamat tujuan : $detail->alamat".$this->spr_html
				."Kode pos : $detail->kota $detail->zip".$this->spr_html
				."No.Tlp : $detail->tlp".$this->spr_html.$this->spr_html
				."Terima kasih telah menjadi Konsumen kueibuhasan.com :-)";
        $msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html(); #echo $msg;break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
        #echo $this->CI->email->print_debugger();
	}

    function send_resi($to,$no_invoice,$no_resi,$layanan){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $pp=$this->CI->email->to($to);
		#$this->CI->email->to("yusupmail@gmail.com");
		$this->CI->email->subject('Konfirmasi Status Pengiriman '.$no_invoice);
		$msg = "Kami informasikan bahwa status produk yang Anda pesan ".$this->spr_html
				."dengan no invoice pemesanan $no_invoice sudah dalam ".$this->spr_html
				."proses pengiriman.".$this->spr_html.$this->spr_html
				."Dibawah ini adalah data dari status pengiriman tersebut :".$this->spr_html.$this->spr_html
				."<table border=\"0\">"
				."<tr><td>No Invoiice</td><td>: $no_invoice</td></tr>"
				."<tr><td>Layanan Pengiriman &nbsp;&nbsp;&nbsp;</td><td>: $layanan</td></tr>"
				."<tr><td>No Resi</td><td>: $no_resi</td></tr>"
				."</table>";
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html(); #echo $msg;break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
    }

    function konfirmasi($email,$nama,$inv,$total,$frombank,$rek,$tgl,$tobank,$pesan){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($email, 'System Konfirmasi');
        $this->CI->email->to("konfirmasi@kueibuhasan.com");
        #$this->CI->email->to("yusupmail@gmail.com");

		$this->CI->email->subject('Konfirmasi Pembayaran no Invoice '.$inv);
		$msg = "Pelanggan yang telah melakukan konfirmasi,".$this->spr_html.$this->spr_html
				."Email : $email".$this->spr_html
				."Nama : $nama".$this->spr_html
                ."No.Invoice : $inv".$this->spr_html
				."Total Pembayaran : $total".$this->spr_html
				."Dari Bank : $frombank".$this->spr_html
				."No.Rek : $rek".$this->spr_html
				."Tujuan Bank : $tobank".$this->spr_html
                ."Pesan : $pesan".$this->spr_html
				."Tanggal : $tgl";
		#$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html(); echo $msg;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
	}
    function tell_friend($to,$tonama,$link,$produk,$from_mail,$from_nama){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);
        #$this->CI->email->to("yusupmail@gmail.com");

		$this->CI->email->subject('Rekomendasi Produk dari '.$from_nama);
		$msg = "Halo $tonama,".$this->spr_html.$this->spr_html
                ."Teman $tonama yang bernama $from_nama merekomendasikan sebuah produk".$this->spr_html
                ."dengan nama $produk".$this->spr_html
				."Silahkan kunjungi "
				."<a href=\"$link\" title=\"Klik untuk melihat detailnya\">$link</a>".$this->spr_html
                ."untuk melihat detil dari produk yang di rekomendasikan tersebut.".$this->spr_html.$this->spr_html
                ."Salam,".$this->spr_html
                ."www.kueibuhasan.com Management Team";
		#echo $msg;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
    }

    function confirm_buletin($to,$tonama,$link){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);
        #$this->CI->email->to("yusupmail@gmail.com");

		$this->CI->email->subject('Konfirmasi Berlangganan Buletin');
		$msg = "Terima kasih telah menjadi pelanggan kueibuhasan.com,".$this->spr_html.$this->spr_html
				."Dengan menjadi pelanggan kueibuhasan.com maka Anda akan mendapatkan  ".$this->spr_html
                ."bulletin exclusive dari kami setiap bulannya yang berisi informasi ".$this->spr_html
                ."Produk, Diskon dan Informasi promo menarik lainnya, selain itu ".$this->spr_html
                ."Anda pun akan mendapatkan Newsletter yang berisi update informasi ".$this->spr_html
                ."bermanfaat baik itu seputar kueibuhasan.com, Tips Berbelanja atau ".$this->spr_html
                ."Informasi lainnya di luar Bulletin Kami.".$this->spr_html.$this->spr_html
                ."Silahkan Anda klik link dibawah ini untuk mengaktifkan status berlangganan Anda.".$this->spr_html
				."<a href=\"$link\" title=\"Klik untuk konfirmasi\">$link</a>".$this->spr_html.$this->spr_html
                ."Salam,".$this->spr_html
                ."www.kueibuhasan.com Management Team";
		#echo $msg; break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
    }

    function act_prospek($to,$nama){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);

		$this->CI->email->subject('Konfirmasi Berlangganan Buletin Berhasil');
		$msg = "Halo $nama ,".$this->spr_html.$this->spr_html
                ."Terimakasih telah menjadi Pelanggan Buletin kueibuhasan.com";
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html();  #echo $msg;break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
	}

    function send_msg_support($nama,$mail,$subj,$pesan,$atch=false){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($mail,$nama);
        $this->CI->email->to('support@kueibuhasan.com');
        #$this->CI->email->to('yusupmail@gmail.com');

		if($atch){
			if(isset($atch['name']))
			$this->CI->email->attach($atch['file'],$atch['name']);
			else
			$this->CI->email->attach($atch['file']);
		}
		$this->CI->email->subject($subj);
		$msg = $pesan;  #echo $msg;break;

		$this->CI->email->message($msg);
        $return = $this->CI->email->send();
        #echo $this->CI->email->print_debugger();
        return $return;
	}

    function rem_cekout($detail,$list,$hari_ke,$no,$max_day){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        
        $to = $detail->email;
        $nama = $detail->nama_panggilan;
        $harga = $detail->harga;
        $kode_unik = $detail->kode_unik;
        $biaya_kirim = $detail->biaya_kirim;
        $status = $detail->status_kirim;
        $tgl = $detail->tgl_transaksi;
        $noinv = $detail->kode_transaksi;
        $cv2=convert_unit($detail->total_berat);

        // list barang
        $tot_biaya=0;
        $tot_barang=0;
        $br='';
		if($list){
			foreach($list as $ck){
				$theprice = $ck->harga;
				$jmlprice = $theprice*$ck->qty;
                $jmlberat = $ck->berat*$ck->qty;
                $cv=convert_unit($ck->berat);
                $cv3=convert_unit($jmlberat);

				$br .="Nama Barang : $ck->nama_produk".$this->spr_html
					."QTY : $ck->qty".$this->spr_html
                    ."Berat Barang : ".$cv['hasil']." ".$cv['satuan'].$this->spr_html
                    ."Total Berat Barang : ".$cv3['hasil']." ".$cv3['satuan'].$this->spr_html
					."Harga Satuan : Rp. ".currency($theprice).$this->spr_html
					."Total Harga : Rp. ".currency($jmlprice).$this->spr_html.$this->spr_html;
				$tot_biaya+=$jmlprice;
				$tot_barang+=$ck->qty;
			}
		}
		$harga_total=($tot_biaya+$kode_unik+$biaya_kirim);
		if($max_day==$no){
		$note = 'Note: email ini adalah email tagihan terakhir, jika pada'.$this->spr_html
				.'hari ini proses pembayaran masih belum dilengkapi, maka'.$this->spr_html
				.'data pemesanan dari invoice no. '.$noinv.' akan kami'.$this->spr_html
				.'hapus secara otomatis.';
		}else{
		$note = 'Note: email ini adalah email tagihan '.$hari_ke[$no].', jika dalam jangka'.$this->spr_html
				.'waktu '.($max_day-$no).' hari kedepan proses pembayaran masih belum dilengkapi,'.$this->spr_html
				.'maka data pemesanan dari invoice '.$noinv.' akan kami hapus'.$this->spr_html
				.'secara otomatis.';
		}

        $this->CI->email->to($to);
		$this->CI->email->subject('Pemberitahuan Tagihan akan invoice no. '.$no);
		$msg = 'Kami informasikan bahwa '.$nama.' memiliki tagihan '.$this->spr_html
				.'invoice no. '.$noinv.' sebesar Rp. '.currency($harga_total).$this->spr_html
				.'dengan rincian sebagai berikut :'.$this->spr_html.$this->spr_html

				.'No Invoice : '.$noinv.$this->spr_html
				.'Tgl Check Out : '.$tgl.$this->spr_html
				.'Status : '.lang('status_kirim_'.$status).$this->spr_html.$this->spr_html
				.$br
				.'Total Barang : '.$tot_barang.$this->spr_html
				.'Total Biaya : Rp. '.currency($tot_biaya).$this->spr_html
                .'Total Berat Barang : '.$cv2['hasil'].' '.$cv2['satuan'].$this->spr_html
				.'Biaya Pengiriman : Rp. '.currency($biaya_kirim).$this->spr_html
				.'Kode Unik Transfer : Rp. '.$kode_unik.$this->spr_html
				.'Total Biaya Transfer : Rp. '.currency($harga_total).$this->spr_html.$this->spr_html

                .'Silahkan lengkapi proses pemesanan akan invoice'.$this->spr_html
                .'no '.$noinv.' diatas dengan mengirimkan biaya tagihan'.$this->spr_html
                .'ke salah satu no rekening dibawah ini :'.$this->spr_html.$this->spr_html
                
                .'Nama Bank : Bank Central Asia (BCA)'.$this->spr_html
				.'Cabang : KCU Garut'.$this->spr_html
				.'No.Rek : 148 073 4498'.$this->spr_html
				.'a/n : Ahmad Syarif. H'.$this->spr_html.$this->spr_html

                .'Nama Bank : Bank Mandiri'.$this->spr_html
				.'Cabang : KCU Garut'.$this->spr_html
				.'No.Rek : 131 00 1169749 9'.$this->spr_html
				.'a/n : Ahmad Syarif. H'.$this->spr_html.$this->spr_html

				.'Setelah proses pembayaran dilakukan jangan lupa untuk'.$this->spr_html
				.'melakukan konfirmasi dengan menggunakan salah satu'.$this->spr_html
				.'metode dibawah ini :'.$this->spr_html.$this->spr_html

				.'Mengirimkan SMS ke no : 0857 2303 6868'.$this->spr_html
				.'atau'.$this->spr_html
				.'Mengirimkan Email ke konfirmasi@kueibuhasan.com'.$this->spr_html
				.'atau'.$this->spr_html
				.'Menggunakan form konfirmasi dengan mengakses link dibawah ini :'.$this->spr_html
				.'<a href="'.site_url('home/konfirmasi').'">Halaman Konfirmasi Pembayaran</a>'.$this->spr_html.$this->spr_html

				.'Setelah kami menerima konfirmasi, maka pemesanan dari'.$this->spr_html
				.'invoice '.$noinv.' akan segera kami proses.'.$this->spr_html
				.'<i><h5>'.$note.'</h5></i>';
                
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html();  #echo $msg.'<br />------------<br /><br />';//break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
	}

    function del_cekout($to,$invoice){
        $config['mailtype'] = 'html';
		$this->CI->email->initialize($config);
        $this->CI->email->from($this->from['mail'], $this->from['name']);
        $this->CI->email->to($to);

		$this->CI->email->subject('Penghapusan Data Invoice no. '.$invoice);
		$msg='Kami informasikan bahwa pemesanan produk dengan data'.$this->spr_html
			.'invoice no. '.$invoice.' telah kami hapus secara otomatis.'.$this->spr_html.$this->spr_html
            .'Silahkan lakukan check out ulang untuk melakukan proses'.$this->spr_html
            .'pemesanan produk di kueibuhasan.com.';
		$msg = $msg.$this->spr_html.$this->spr_html.$this->foot_html();  #echo $msg.'<br />------------<br /><br />';//break;

		$this->CI->email->message($msg);
        return $this->CI->email->send();
	}

}
