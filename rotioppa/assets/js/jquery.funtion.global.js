//
						   
	// function load page with ajax
	function get_page_content(urlpage,obj,datapost,loadView,resultMode){
		var oldcontainer='';
		var theload = $('#loadpage').html();
		$.ajax({
			type: "POST",
			url: urlpage,
			//data: "name=John&location=Boston",
			data: datapost,
			beforeSend: function(){
				if(loadView){
					$(obj).hide();
					$(loadView).html(theload).show();
				}else
					$(obj).html(theload);
			},
			success: function(msg){
				if(msg=='logout'){ 
					alert(loginExpired);
					document.location.href=urlLogin;
				}
				if(loadView){
					$(loadView).html('').hide();
					if(resultMode=='val')
					$(obj).val(msg).show();
					else
					$(obj).html( msg ).show();
				}else
					$(obj).html( msg );
			}
		});
	}


	// format digit for currency
	function format_to_curency(digit){
		var fullint = digit.replace(/\./g,''); //alert(fullint);
		var len = fullint.length; //alert(len);
		var lenDigit = 3;
		if(len>=lenDigit){
			var firstPartLen = len%lenDigit; //alert(firstPartLen); 
			var nextLen = len-firstPartLen;
			if(firstPartLen!=0){
				var firstPart = fullint.slice(0,firstPartLen)+'.';
				var nextPart = fullint.slice(firstPartLen);
			}else{
				var firstPart = '';
				var nextPart = fullint;
			}
			//alert(nextPart);
			var c=new Array();
			var p=0;
			for(i=0;p<nextLen;i++){ 
				c[i] = nextPart.slice(p,(lenDigit+p)); //alert(c[i]);
				p+=lenDigit;
			}
			var res = firstPart + c.join('.'); //alert(res);
			return res;
		}else
			return digit;
	}
	function clear_format_curency(digit,kecuali){
		var fullint = digit.replace(/\./g,''); //alert(fullint);
		var str = digit.split(""); //alert(str.length);
		var ret='';
		for(i=0;i<str.length;i++){ 
			if(str[i].charCodeAt()>=48 && str[i].charCodeAt()<=57){
				ret+=str[i];
			}
			if(kecuali==str[i]) ret+=str[i];
		}
		return ret;
	}

	// function format id for code
	function format_id_code(id,len){
		lenid=id.length;
		sisa=len-lenid;
		zero='';
		if(sisa>0){
			for(i=0;i<sisa;i++){
				zero+='0';
			}ret=zero+id;
		}else ret=id;
		return ret;
	}

	// pakai metode range keyCode
	// return value
	// 1: true
	// 2: false
	// 3: no-action
	// 4: for coma(,)
	// 5: for backspace/dell
	// input: integer code --> e.which
	function justNumber(e){
		// range 0...9 ang2a di atas dan angka di numlock
		if((e>=48 && e<=57) || (e>=96 && e<=105)) return 1;
		// range a...z or A...Z
		else if(e>=65 && e<=90) return 2;
		// if coma
		else if(e==188) return 4;
		else if(e==8 || e==46) return 5;
		// not in range (artinya simbol2 dll)
		return 3;
	}
	function split_coma(itg,splitter,output_simbol){ 
		str=itg.toString();
		if(!output_simbol)output_simbol=',';
		if(!splitter)splitter=',';
		var spl_theVal = str.split(splitter); //alert(spl_theVal[0]+'--'+spl_theVal[1]);
		var ret = Array;
		if(spl_theVal[1]) 
			spl_koma=output_simbol+spl_theVal[1]; 
		else spl_koma='';
		ret[0]=spl_theVal[0];
		ret[1]=spl_koma;
		return ret;
	}
	function validate_filetype(fext, ftype)
	{
		for(var num in ftype)
		{
			if(fext == ftype[num])
			return true;
		}
		return false;
	}


$(function(){
	$(".digit")
	.keypress(function(e){ 
		// ambil text sebelum di input char yg baru
		theVal_old=$(this).val(); //alert(theVal_old);
	})
	.keyup(function(e){ 
		var theVal=clear_format_curency($(this).val());
		var theChar=e.which; //alert(theChar);
		var defineChar=justNumber(theChar); //alert(defineChar);
		if(defineChar==1 || defineChar==5){
			// pisahkan koma terlebih dahulu
			//var spl_theVal = theVal.split(','); //alert(spl_theVal[0]+'--'+spl_theVal[1]);
			//if(spl_theVal[1]) spl_koma=','+spl_theVal[1]; else spl_koma='';
			// convert to curency
			var thisval=format_to_curency(theVal);
			// gabungkan kembali koma dan write to input file
			$(this).val(thisval);
			//write to hidden data
			$(this).next(".fixdigit").val(theVal);
		}else if(defineChar==2){
			alert('Hanya boleh angka 0-9!');
			$(this).val(theVal_old);
		}else if(defineChar==4){
			// allow coma so this part is empty
		}else $(this).val(theVal_old);
	});
	/*.keyup(function(e){ 
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
			//display error message
			alert('Input number 0...9');
			$(this).val(clear_format_curency($(this).val(),'.'));
			return false;
		}else{
			var digit = $(this).val();
			var res = format_to_curency(digit);
			$(this).val(res);

			var res_val = clear_format_curency($(this).val());
			$(this).next(".fixdigit").val(res_val);
		}
	});*/

	$(".numberchar")
	.keypress(function(e){ 
		// ambil text sebelum di input char yg baru
		theVal_old_number=$(this).val();//alert(theVal);
	})
	.keyup(function(e){ 
		var theVal=$(this).val();
		var theChar=e.which; //alert(theChar);
		var defineChar=justNumber(theChar);
		if(defineChar==1 || defineChar==5 || defineChar==3){
			$(this).val(theVal);
		}else if(defineChar==2){
			alert('Hanya boleh angka 0-9!');
			$(this).val(theVal_old_number);
		}else if(defineChar==4){
			// allow coma so this part is empty
		}else $(this).val(theVal_old_number);
	});

});
