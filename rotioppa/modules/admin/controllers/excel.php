<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Excel extends Admin_Controller{
	function __construct(){
		parent::__construct(); 
		// load lang
		$this->lang->load('defexcel');

		// load library
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');

	}
	function index()
	{
		$this->template->set_view ('excel',false,config_item('modulename'));		
	}
	function dl_member($tgl1,$tgl2)
	{
		// load model
		$this->load->model('member_model', 'mm');
		// load lang
		$this->lang->load('defmember');

		// get data, untuk sementara hanya pakai tgl input saja
		$filter='3';
		$key['tgl1']=$tgl1;
		$key['tgl2']=$tgl2;
		$search=array('val'=>$key,'key'=>$filter);
		$ord=array('order'=>'1','asdesc'=>'a');
		$list_member=$this->mm->list_member($search,$ord);
		// jika tdk ada data, show msg
		if(!$list_member){ 
			java_alert(lang('no_data'));
			redirect_java(config_item('modulename').'/'.$this->router->class);
			return false;
		}
		
		// load excel
		$objPHPExcel = new PHPExcel();		
		$objPHPExcel->getProperties()
			->setTitle("Member List")
			->setDescription("Daftar Member")
			->setCreator("Djilbab Management");
        $sheet=$objPHPExcel->getActiveSheet();
		// set title
		$sheet->SetCellValue('A1', 'List Member - Djilbab')
			->SetCellValue('A2', 'Tanggal')
			->SetCellValue('C2', format_date_ina($tgl1,'-'))
			->SetCellValue('A3', 'Sampai Tgl.')
			->SetCellValue('C3', format_date_ina($tgl2,'-'));
		$sheet->mergeCells('A1:J1')
			->mergeCells('A2:B2')
			->mergeCells('A3:B3')
			->mergeCells('C2:D2')
			->mergeCells('C3:D3');
		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension('1')->setRowHeight(24);
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);
		
		// set header table
		$row_num=5;
		$sheet->SetCellValue('A'.$row_num,'#')
			->SetCellValue('B'.$row_num,strip_tags(lang('email')))
			->SetCellValue('C'.$row_num,strip_tags(lang('nama')))
			->SetCellValue('D'.$row_num,strip_tags(lang('tgl_sign')))
			->SetCellValue('E'.$row_num,strip_tags(lang('no_tlp')));
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getStyle('A'.$row_num.':E'.$row_num)->getFill()->setFillType(Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
        // loop table            
		$i=0;
		foreach($list_member as $lk)
		{	$i++;$row_num++;
			$sheet->setCellValue('A'.$row_num, $i);
			$sheet->setCellValue('B'.$row_num,$lk->email);
			$sheet->setCellValue('C'.$row_num,$lk->nama_lengkap);
			$sheet->setCellValue('E'.$row_num,$lk->no_tlp);
			// khusus untuk date
			Cell::setValueBinder( new Cell_AdvancedValueBinder() );
			$sheet->setCellValue('D'.$row_num,$lk->tgl_daftar);
			$sheet->getStyle('D'.$row_num)->getNumberFormat()->setFormatCode(Style_NumberFormat::FORMAT_DATE_DATETIME);
		}

        // header   
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="list_member.xls"');
		header('Cache-Control: max-age=0');
		
		// nama file
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
	}
	function dl_prospek($tgl1,$tgl2)
	{
		// load model
		$this->load->model('prospek_model', 'pm');
		// load lang
		$this->lang->load('defprospek');

		// get data, untuk sementara hanya pakai tgl input saja
		$filter='3';
		$key['tgl1']=$tgl1;
		$key['tgl2']=$tgl2;
		$search=array('val'=>$key,'key'=>$filter);
		$ord=array('order'=>'1','asdesc'=>'a');
		$list_member=$this->pm->list_member($search,$ord);
		// jika tdk ada data, show msg
		if(!$list_member){ 
			java_alert(lang('no_data'));
			redirect_java(config_item('modulename').'/'.$this->router->class);
			return false;
		}
		
		// load excel
		$objPHPExcel = new PHPExcel();		
		$objPHPExcel->getProperties()
			->setTitle("List Prospek")
			->setDescription("Daftar Prospek")
			->setCreator("Djilbab Management");
        $sheet=$objPHPExcel->getActiveSheet();
		// set title
		$sheet->SetCellValue('A1', 'List Prospek - Djilbab')
			->SetCellValue('A2', 'Tanggal')
			->SetCellValue('C2', format_date_ina($tgl1,'-'))
			->SetCellValue('A3', 'Sampai Tgl.')
			->SetCellValue('C3', format_date_ina($tgl2,'-'));
		$sheet->mergeCells('A1:J1')
			->mergeCells('A2:B2')
			->mergeCells('A3:B3')
			->mergeCells('C2:D2')
			->mergeCells('C3:D3');
		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension('1')->setRowHeight(24);
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);
		
		// set header table
		$row_num=5;
		$sheet->SetCellValue('A'.$row_num,'#')
			->SetCellValue('B'.$row_num,strip_tags(lang('email')))
			->SetCellValue('C'.$row_num,strip_tags(lang('nama')))
			->SetCellValue('D'.$row_num,strip_tags(lang('tgl_sign')))
			->SetCellValue('E'.$row_num,strip_tags(lang('tgl_valid')));
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getStyle('A'.$row_num.':E'.$row_num)->getFill()->setFillType(Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
        // loop table            
		$i=0;
		foreach($list_member as $lk)
		{	$i++;$row_num++;
			$sheet->setCellValue('A'.$row_num, $i);
			$sheet->setCellValue('B'.$row_num,$lk->email);
			$sheet->setCellValue('C'.$row_num,$lk->nama);
			// khusus untuk date
			Cell::setValueBinder( new Cell_AdvancedValueBinder() );
			$sheet->setCellValue('D'.$row_num,$lk->tgl);
			$sheet->getStyle('D'.$row_num)->getNumberFormat()->setFormatCode(Style_NumberFormat::FORMAT_DATE_DATETIME);
			$sheet->setCellValue('E'.$row_num,$lk->tgl_validate);
			$sheet->getStyle('E'.$row_num)->getNumberFormat()->setFormatCode(Style_NumberFormat::FORMAT_DATE_YYYYMMDD);
		}

        // header   
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="list_prospek.xls"');
		header('Cache-Control: max-age=0');
		
		// nama file
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
	}
	function dl_aff($tgl1,$tgl2)
	{
		// load model
		$this->load->model('aff_model', 'am');
		// load lang
		$this->lang->load('defaff');

		// get data, untuk sementara hanya pakai tgl input saja
		$filter='3';
		$key['tgl1']=$tgl1;
		$key['tgl2']=$tgl2;
		$search=array('val'=>$key,'key'=>$filter);
		$ord=array('order'=>'1','asdesc'=>'a');
		$list_aff=$this->am->list_aff($search,$ord);
		// jika tdk ada data, show msg
		if(!$list_aff){ 
			java_alert(lang('no_data'));
			redirect_java(config_item('modulename').'/'.$this->router->class);
			return false;
		}
		
		// load excel
		$objPHPExcel = new PHPExcel();		
		$objPHPExcel->getProperties()
			->setTitle("List Affiliate")
			->setDescription("Daftar Affiliate")
			->setCreator("Djilbab Management");
        $sheet=$objPHPExcel->getActiveSheet();
		// set title
		$sheet->SetCellValue('A1', 'List Affiliate - Djilbab')
			->SetCellValue('A2', 'Tanggal')
			->SetCellValue('C2', format_date_ina($tgl1,'-'))
			->SetCellValue('A3', 'Sampai Tgl.')
			->SetCellValue('C3', format_date_ina($tgl2,'-'));
		$sheet->mergeCells('A1:J1')
			->mergeCells('A2:B2')
			->mergeCells('A3:B3')
			->mergeCells('C2:D2')
			->mergeCells('C3:D3');
		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension('1')->setRowHeight(24);
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);
		
		// set header table
		$row_num=5;
		$sheet->SetCellValue('A'.$row_num,'#')
			->SetCellValue('B'.$row_num,strip_tags(lang('email')))
			->SetCellValue('C'.$row_num,strip_tags(lang('nama')))
			->SetCellValue('D'.$row_num,strip_tags(lang('tgl_sign')))
			->SetCellValue('E'.$row_num,strip_tags(lang('no_tlp')));
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getStyle('A'.$row_num.':E'.$row_num)->getFill()->setFillType(Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
        // loop table            
		$i=0;
		foreach($list_aff as $lk)
		{	$i++;$row_num++;
			$sheet->setCellValue('A'.$row_num, $i);
			$sheet->setCellValue('B'.$row_num,$lk->email);
			$sheet->setCellValue('C'.$row_num,$lk->nama_lengkap);
			$sheet->setCellValue('E'.$row_num,$lk->no_tlp);
			// khusus untuk date
			Cell::setValueBinder( new Cell_AdvancedValueBinder() );
			$sheet->setCellValue('D'.$row_num,$lk->tgl_daftar);
			$sheet->getStyle('D'.$row_num)->getNumberFormat()->setFormatCode(Style_NumberFormat::FORMAT_DATE_DATETIME);
		}

        // header   
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="list_affiliate.xls"');
		header('Cache-Control: max-age=0');
		
		// nama file
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
	}
	function dl_transaksi($tgl1,$tgl2)
	{
		// load model
		$this->load->model('transaksi_model', 'tm');
		// load lang
		$this->lang->load('deftransaksi');

		// get data, untuk sementara hanya pakai tgl input saja
		$filter='5';
		$key['tgl1']=$tgl1;
		$key['tgl2']=$tgl2;
		$list_trans=$this->tm->get_cekout(false,false,false,$key,$filter);
		// jika tdk ada data, show msg
		if(!$list_trans){ 
			java_alert(lang('no_data'));
			redirect_java(config_item('modulename').'/'.$this->router->class);
			return false;
		}
		
		// load excel
		$objPHPExcel = new PHPExcel();		
		$objPHPExcel->getProperties()
			->setTitle("Transaksi List")
			->setDescription("Daftar transaksi")
			->setCreator("Djilbab Management");
        $sheet=$objPHPExcel->getActiveSheet();
		// set title
		$sheet->SetCellValue('A1', 'List Transaksi - Djilbab')
			->SetCellValue('A2', 'Tanggal')
			->SetCellValue('C2', format_date_ina($tgl1,'-'))
			->SetCellValue('A3', 'Sampai Tgl.')
			->SetCellValue('C3', format_date_ina($tgl2,'-'));
		$sheet->mergeCells('A1:J1')
			->mergeCells('A2:B2')
			->mergeCells('A3:B3')
			->mergeCells('C2:D2')
			->mergeCells('C3:D3');
		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension('1')->setRowHeight(24);
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);
		
		// set header table
		$row_num=5;
		$sheet->SetCellValue('A'.$row_num,'#')
			->SetCellValue('B'.$row_num,strip_tags(lang('trans_code')))
			->SetCellValue('C'.$row_num,strip_tags(lang('email')))
			->SetCellValue('D'.$row_num,strip_tags(lang('harga')))
			->SetCellValue('E'.$row_num,strip_tags(lang('tgl_cekout')))
			->SetCellValue('F'.$row_num,strip_tags(lang('cara_bayar')))
			->SetCellValue('G'.$row_num,strip_tags(lang('is_bayar')))
			->SetCellValue('H'.$row_num,strip_tags(lang('is_kirim')));
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getStyle('A'.$row_num.':H'.$row_num)->getFill()->setFillType(Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
        // loop table            
		$i=0;
		foreach($list_trans as $lk)
		{	$i++;$row_num++;
			$sheet->setCellValue('A'.$row_num, $i);
			$sheet->setCellValue('B'.$row_num,$lk->kode_transaksi);
			$sheet->setCellValue('C'.$row_num,$lk->email);
			$sheet->setCellValue('D'.$row_num,currency($lk->total));
			$sheet->setCellValue('F'.$row_num,lang('cara_bayar_'.$lk->cara_bayar));
			$sheet->setCellValue('G'.$row_num,lang('status_bayar_'.$lk->status_bayar));
			$sheet->setCellValue('H'.$row_num,lang('status_kirim_'.$lk->status_kirim));
			// khusus untuk date
			Cell::setValueBinder( new Cell_AdvancedValueBinder() );
			$sheet->setCellValue('E'.$row_num,$lk->full_tgl_cekout);
			$sheet->getStyle('E'.$row_num)->getNumberFormat()->setFormatCode(Style_NumberFormat::FORMAT_DATE_DATETIME);
		}

        // header   
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="list_transaksi.xls"');
		header('Cache-Control: max-age=0');
		
		// nama file
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
	}
	function dl_kom($tgl1,$tgl2)
	{
		// load model
		$this->load->module_model(config_item('modulename'), 'komisi_model', 'km');
		// load lang
		$this->lang->load('defaff');
		
		$tg1=explode('-',$tgl1);
		$tg2=explode('-',$tgl2);
        $search['range']['first'] = $tg1[0].'-'.$tg1[1];
        $search['range']['last'] = $tg2[0].'-'.$tg2[1];
		$list_kom=$this->km->list_komisi($search,false,false,false);
		// jika tdk ada data, show msg
		if(!$list_kom){ 
			java_alert(lang('no_data'));
			redirect_java(config_item('modulename').'/'.$this->router->class);
			return false;
		}
		
		// load excel
		$objPHPExcel = new PHPExcel();		
		$objPHPExcel->getProperties()
			->setTitle("Komisi List")
			->setDescription("Daftar komisi")
			->setCreator("Djilbab Management");
        $sheet=$objPHPExcel->getActiveSheet();
		// set title
		$sheet->SetCellValue('A1', 'List Komisi - Djilbab')
			->SetCellValue('A2', 'Tanggal')
			->SetCellValue('C2', format_date_ina($tgl1,'-'))
			->SetCellValue('A3', 'Sampai Tgl.')
			->SetCellValue('C3', format_date_ina($tgl2,'-'));
		$sheet->mergeCells('A1:J1')
			->mergeCells('A2:B2')
			->mergeCells('A3:B3')
			->mergeCells('C2:D2')
			->mergeCells('C3:D3');
		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension('1')->setRowHeight(24);
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);
		
		// set header table
		$row_num=5;
		$sheet->SetCellValue('A'.$row_num,'#')
			->SetCellValue('B'.$row_num,strip_tags(lang('aff')))
			->SetCellValue('C'.$row_num,strip_tags(lang('bulan')))
			->SetCellValue('D'.$row_num,strip_tags(lang('harga')))
			->SetCellValue('E'.$row_num,strip_tags(lang('tot_item')))
			->SetCellValue('F'.$row_num,strip_tags(lang('tot_harga')))
			->SetCellValue('G'.$row_num,strip_tags(lang('tot_komisi')))
			->SetCellValue('H'.$row_num,strip_tags(lang('status_kirim')));
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getStyle('A'.$row_num.':H'.$row_num)->getFill()->setFillType(Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
        // loop table            
		$i=0;
		foreach($list_kom as $lk)
		{	$i++;$row_num++;
			$dt=explode('-',$lk->tgl);
			$mname=month_name($dt[1]);

			$sheet->setCellValue('A'.$row_num, $i);
			$sheet->setCellValue('B'.$row_num,$lk->nama_panggilan);
			$sheet->setCellValue('C'.$row_num,$lk->email);
			$sheet->setCellValue('D'.$row_num,$mname.' '.$dt[0]);
			$sheet->setCellValue('E'.$row_num,$lk->total_item);
			$sheet->setCellValue('F'.$row_num,currency($lk->total_harga));
			$sheet->setCellValue('G'.$row_num,currency($lk->total_komisi));
			$sheet->setCellValue('H'.$row_num,lang('status_komisi_'.$lk->status_kirim));
		}

        // header   
		#header('Content-Type: application/vnd.ms-excel');
		#header('Content-Disposition: attachment;filename="list_komisi.xls"');
		#header('Cache-Control: max-age=0');
		
		// nama file
		#$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		#$objWriter->save('php://output'); 
	}
	function dl_list_produk($tgl1,$tgl2)
	{
		// load model
		$this->load->model('produk_model', 'pm');
		// load lang
		$this->lang->load('defproduk');

		// get data, untuk sementara hanya pakai tgl input saja
		$filter='5';
		$key['tgl1']=$tgl1;
		$key['tgl2']=$tgl2;
        $key['order']='DESC';
		$list_produk=$this->pm->list_produk(false,false,false,$key,$filter);
		// jika tdk ada data, show msg
		if(!$list_produk){ 
			java_alert(lang('no_data'));
			#redirect_java(config_item('modulename').'/'.$this->router->class);
			return false;
		}
		
		// load excel
		$objPHPExcel = new PHPExcel();		
		$objPHPExcel->getProperties()
			->setTitle("Produk List")
			->setDescription("Daftar produk")
			->setCreator("Djilbab Management");
        $sheet=$objPHPExcel->getActiveSheet();
		// set title
		$sheet->SetCellValue('A1', 'List Produk - Djilbab')
			->SetCellValue('A2', 'Tanggal')
			->SetCellValue('C2', format_date_ina($tgl1,'-'))
			->SetCellValue('A3', 'Sampai Tgl.')
			->SetCellValue('C3', format_date_ina($tgl2,'-'));
		$sheet->mergeCells('A1:H1')
			->mergeCells('A2:B2')
			->mergeCells('A3:B3')
			->mergeCells('C2:D2');
			// ->mergeCells('C3:D3');
		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension('1')->setRowHeight(24);
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);
		
		// set header table
		$row_num=5;
		$sheet->SetCellValue('A'.$row_num,'#')
			->SetCellValue('B'.$row_num,strip_tags(lang('l_vcode')))
			->SetCellValue('C'.$row_num,strip_tags(lang('l_pcode')))
			->SetCellValue('D'.$row_num,strip_tags(lang('l_nama_produk')))
			->SetCellValue('E'.$row_num,strip_tags(lang('kat')))
			->SetCellValue('F'.$row_num,strip_tags(lang('subkat')))
			->SetCellValue('G'.$row_num,strip_tags(lang('l_subkat2')))
			->SetCellValue('H'.$row_num,strip_tags(lang('tgl_in')));
			#->SetCellValue('I'.$row_num,strip_tags(lang('l_stock_awal')))
			#->SetCellValue('J'.$row_num,strip_tags(lang('l_stock_akhir')))
			#->SetCellValue('K'.$row_num,strip_tags(lang('l_stock_jual')));
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		#$sheet->getColumnDimension('G')->setAutoSize(true);
		#$sheet->getColumnDimension('H')->setAutoSize(true);
		#$sheet->getColumnDimension('I')->setAutoSize(true);
		#$sheet->getColumnDimension('J')->setAutoSize(true);
		#$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getStyle('A'.$row_num.':H'.$row_num)->getFill()->setFillType(Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
        // loop table            
		$i=0;
		foreach($list_produk as $lk)
		{	$i++;$row_num++;
			$sheet->setCellValue('A'.$row_num, $i);
			$sheet->setCellValue('B'.$row_num,$lk->vcode);
			$sheet->setCellValue('C'.$row_num,format_kode($lk->idkat).format_kode($lk->idsub,3).$lk->id);
			$sheet->setCellValue('D'.$row_num,$lk->nama_produk);
			$sheet->setCellValue('E'.$row_num,$lk->kategori);
			$sheet->setCellValue('F'.$row_num,$lk->subkategori);
			$sheet->setCellValue('G'.$row_num,$lk->subkategori2);
			#$sheet->setCellValue('I'.$row_num,$lk->oldstock);
			#$sheet->setCellValue('J'.$row_num,$lk->stock);
			#$sheet->setCellValue('K'.$row_num,$lk->stockjual);
			// khusus untuk date
			Cell::setValueBinder( new Cell_AdvancedValueBinder() );
			$sheet->setCellValue('H'.$row_num,$lk->tgl);
			$sheet->getStyle('H'.$row_num)->getNumberFormat()->setFormatCode(Style_NumberFormat::FORMAT_DATE_DATETIME);
		}

        // header   
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="list_produk.xls"');
		header('Cache-Control: max-age=0');
		
		// nama file
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
	}
	function dl_list_untung($tgl1,$tgl2)
	{
		// load model
		$this->load->model('untung_model', 'pu');
		// load lang
		$this->lang->load('defproduk');

		// get data, untuk sementara hanya pakai tgl input saja
		$filter='5';
		$key['tgl1']=$tgl1;
		$key['tgl2']=$tgl2;
        $key['order']='DESC';
		$list_untung=$this->pu->list_untung(false,false,false,$key,$filter);
		// jika tdk ada data, show msg
		if(!$list_untung){ 
			java_alert(lang('no_data'));
			redirect_java(config_item('modulename').'/'.$this->router->class);
			return false;
		}
		
		// load excel
		$objPHPExcel = new PHPExcel();		
		$objPHPExcel->getProperties()
			->setTitle("Produk List")
			->setDescription("Daftar produk")
			->setCreator("Djilbab Management");
        $sheet=$objPHPExcel->getActiveSheet();
		// set title
		$sheet->SetCellValue('A1', 'List Produk - Djilbab')
			->SetCellValue('A2', 'Tanggal')
			->SetCellValue('C2', format_date_ina($tgl1,'-'))
			->SetCellValue('A3', 'Sampai Tgl.')
			// ->SetCellValue('A8', 'Jumlah Keuntungan')
			->SetCellValue('C3', format_date_ina($tgl2,'-'));
		$sheet->mergeCells('A1:H1')
			->mergeCells('A2:B2')
			->mergeCells('A3:B3')
			->mergeCells('C2:D2')
			->mergeCells('C3:D3')
			->mergeCells('A8:F8');
		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		// $sheet->getStyle('A8')->getAlignment()->setVertical(Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension('1')->setRowHeight(24);
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A3')->getFont()->setBold(true);
		// $sheet->getStyle('A8')->getFont()->setBold(true);
		
		// set header table
		$row_num=5;
		$sheet->SetCellValue('A'.$row_num,'No')
			->SetCellValue('B'.$row_num,strip_tags(lang('l_nama_produk')))
			->SetCellValue('C'.$row_num,strip_tags(lang('harga_baru')))
			->SetCellValue('D'.$row_num,strip_tags(lang('harga_vendor')))
			->SetCellValue('E'.$row_num,strip_tags(lang('stock_akhir')))
			->SetCellValue('F'.$row_num,'Keuntungan');
			/*->SetCellValue('E'.$row_num,strip_tags(lang('kat')))
			->SetCellValue('F'.$row_num,strip_tags(lang('subkat')))
			->SetCellValue('G'.$row_num,strip_tags(lang('l_subkat2')))
			->SetCellValue('H'.$row_num,strip_tags(lang('tgl_in')));*/
			#->SetCellValue('I'.$row_num,strip_tags(lang('l_stock_awal')))
			#->SetCellValue('J'.$row_num,strip_tags(lang('l_stock_akhir')))
			#->SetCellValue('K'.$row_num,strip_tags(lang('l_stock_jual')));
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		#$sheet->getColumnDimension('G')->setAutoSize(true);
		#$sheet->getColumnDimension('H')->setAutoSize(true);
		#$sheet->getColumnDimension('I')->setAutoSize(true);
		#$sheet->getColumnDimension('J')->setAutoSize(true);
		#$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getStyle('A'.$row_num.':H'.$row_num)->getFill()->setFillType(Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
        // loop table            
		$i=0;
		foreach($list_untung as $lk)
		{	$i++;$row_num++;
			$untung=0;
			$jml_untung=0;
			$harga_br=$lk->harga_baru;
			$harga_vd=$lk->harga_vendor;
			$untung=$harga_br-$harga_vd;
			// #$jml_untung=$untung+$untung[$i+1];
			// $c1 = $objPHPExcel->getSheet(0)->getCell('F6')->getValue();
			// $c2 = $objPHPExcel->getSheet(0)->getCell('F7')->getValue();
			// $jml_untung=$c1+$c2;
			
			$sheet->setCellValue('A'.$row_num, $i);
			$sheet->setCellValue('B'.$row_num,$lk->nama_produk);
			$sheet->setCellValue('C'.$row_num,$lk->harga_baru);
			$sheet->setCellValue('D'.$row_num,$lk->harga_vendor);
			$sheet->setCellValue('E'.$row_num,$lk->stock);
			$sheet->setCellValue('F'.$row_num,$untung);
			// $sheet->setCellValue('G'.$row_num,$jml_untung);
			#$sheet->setCellValue('H'.$row_num,$c2);
			
			#$sheet->setCellValue('B'.$row_num,$lk->vcode);	#$sheet->setCellValue('C'.$row_num,format_kode($lk->idkat).format_kode($lk->idsub,3).$lk->id);
			#$sheet->setCellValue('E'.$row_num,$lk->kategori);
			#$sheet->setCellValue('F'.$row_num,$lk->subkategori);
			#$sheet->setCellValue('G'.$row_num,$lk->subkategori2);
			// khusus untuk date
			Cell::setValueBinder( new Cell_AdvancedValueBinder() );
			#$sheet->setCellValue('H'.$row_num,$lk->tgl);
			$sheet->getStyle('H'.$row_num)->getNumberFormat()->setFormatCode(Style_NumberFormat::FORMAT_DATE_DATETIME);
		}

        // header   
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="list_untung.xls"');
		header('Cache-Control: max-age=0');
		
		// nama file
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
	}
}
