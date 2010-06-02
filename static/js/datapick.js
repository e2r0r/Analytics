$(function(){
	$.datepicker.setDefaults($.extend({showMonthAfterYear: false}, $.datepicker.regional['zh-CN']));
	
	$("#nav1_day").datepicker($.datepicker.regional['zh-CN']);
	$("#nav2_day").datepicker($.datepicker.regional['zh-CN']);
	$("#nav3_from").datepicker($.datepicker.regional['zh-CN']);
	$("#nav3_to").datepicker($.datepicker.regional['zh-CN']);
	$("#nav4_from").datepicker($.datepicker.regional['zh-CN']);
	$("#nav4_to").datepicker($.datepicker.regional['zh-CN']);
	$("#nav5_from").datepicker($.datepicker.regional['zh-CN']);
	$("#nav5_to").datepicker($.datepicker.regional['zh-CN']);
	$("#nav6_from").datepicker($.datepicker.regional['zh-CN']);
	$("#nav6_to").datepicker($.datepicker.regional['zh-CN']);
	$("#nav7_from").datepicker($.datepicker.regional['zh-CN']);
	$("#nav7_to").datepicker($.datepicker.regional['zh-CN']);
	
	$("#nav1_day").datepicker('option', {dateFormat: 'yy-mm-dd'});
	$('#nav2').show();
	$("#nav2_day").datepicker('option', {dateFormat: 'yy-mm-dd'});
	//$('#nav2').hide();
	$("#nav3_from").datepicker('option', {dateFormat: 'yy-mm-dd'});
	$("#nav3_to").datepicker('option', {dateFormat: 'yy-mm-dd'});
	//$('#nav3').hide();
	$("#nav4_from").datepicker('option', {dateFormat: 'yy-mm-dd'});
	$("#nav4_to").datepicker('option', {dateFormat: 'yy-mm-dd'});
	//$('#nav4').hide();
	$("#nav5_from").datepicker('option', {dateFormat: 'yy-mm-dd'});
	$("#nav5_to").datepicker('option', {dateFormat: 'yy-mm-dd'});
	//$('#nav5').hide();
	$("#nav6_from").datepicker('option', {dateFormat: 'yy-mm-dd'});
	$("#nav6_to").datepicker('option', {dateFormat: 'yy-mm-dd'});
	//$('#nav6').hide();
	$("#nav7_from").datepicker('option', {dateFormat: 'yy-mm-dd'});
	$("#nav7_to").datepicker('option', {dateFormat: 'yy-mm-dd'});
	//$('#nav7').hide();
	
	//$("#nav1_day").datepicker({minDate:new Date(2010,1-1,25),maxDate:new Date(2010,1-1,26)});
	
});


$(document).ready(function(){
	
	function to_ch(date,type)
	{
		var date_arr = date.split('-');
		if(type=='1')
		{
			return  date_arr[0]+'年'+date_arr[1]+'月'+date_arr[2]+'日';
		}else{
			return  date_arr[0]+date_arr[1]+date_arr[2];
		}
	}
	
	$('#nav1_btn').click(function(){
		var from_date = $('#nav1_day').val();
		
		var from_date1 = to_ch(from_date,1);
		
		$('#tu_title').html('截止到 '+from_date1+' 的统计结果');
		$('#biao_title').html('截止到 '+from_date1+' 的统计结果');
		
		var from_date2 = to_ch(from_date,2);
		
		$('#tu').attr('src','/chart/info/date?end='+from_date2);
		$('#biao').attr('src','/table/info?date='+from_date2);
		$('#print').attr('src','/table/info?date='+from_date2);
		return false;
	});
	
	$('#nav2_btn').click(function(){
		var from_date = $('#nav2_day').val();
		
		var from_date1 = to_ch(from_date,1);
		
		$('#tu_title').html('截止到 '+from_date1+' 的统计结果');
		$('#biao_title').html('截止到 '+from_date1+' 的统计结果');
		
		var from_date2 = to_ch(from_date,2);
		
		$('#tu').attr('src','/chart/trend?end='+from_date2);
		$('#biao').attr('src','/table/trend?end='+from_date2);
		$('#print').attr('src','/table/trend?end='+from_date2);
		return false;
	});
	
	$('#nav3_btn').click(function(){
		var to_date = $('#nav3_to').val();
		
		var to_date1 = to_ch(to_date,1);
		
		$('#tu_title').html(' '+to_date1+' 向前7天内的数据');
		$('#biao_title').html(' '+to_date1+' 向前7天内的数据');
		
		to_date2 = to_ch(to_date,2);
		
		$('#tu').attr('src','/chart/info/login?end='+to_date2);
		$('#biao').attr('src','/table/info/login?end='+to_date2);
		$('#print').attr('src','/table/info/login?end='+to_date2);
		return false;
	});
	
	$('#nav4_btn').click(function(){
		var from_date = $('#nav4_from').val();
		var to_date = $('#nav4_to').val();
		
		var from_date1 = to_ch(from_date,1);
		var to_date1 = to_ch(to_date,1);
		
		$('#tu_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		$('#biao_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		
		from_date2 = to_ch(from_date,2);
		to_date2 = to_ch(to_date,2);
		
		$('#tu').attr('src','/chart/trend?start='+from_date2+'&end='+to_date2);
		$('#biao').attr('src','/table/trend/average?start='+from_date2+'&end='+to_date2);
		$('#print').attr('src','/table/trend/average?start='+from_date2+'&end='+to_date2);
		return false;
	});
	
	$('#nav5_btn').click(function(){
		var from_date = $('#nav5_from').val();
		var to_date = $('#nav5_to').val();
		
		var from_date1 = to_ch(from_date,1);
		var to_date1 = to_ch(to_date,1);
		
		$('#tu_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		$('#biao_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		
		from_date2 = to_ch(from_date,2);
		to_date2 = to_ch(to_date,2);
		
		$('#tu').attr('src','/chart/trend?start='+from_date2+'&end='+to_date2);
		$('#biao').attr('src','/table/trend/max?start='+from_date2+'&end='+to_date2);
		$('#print').attr('src','/table/trend/max?start='+from_date2+'&end='+to_date2);
		return false;
	});
	
	$('#nav6_btn').click(function(){
		var from_date = $('#nav6_from').val();
		var to_date = $('#nav6_to').val();
		
		var from_date1 = to_ch(from_date,1);
		var to_date1 = to_ch(to_date,1);
		
		$('#tu_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		$('#biao_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		
		from_date2 = to_ch(from_date,2);
		to_date2 = to_ch(to_date,2);
		
		$('#tu').attr('src','/chart/info?start='+from_date2+'&end='+to_date2);
		$('#biao').attr('src','/table/infos?start='+from_date2+'&end='+to_date2);
		$('#print').attr('src','/table/infos?start='+from_date2+'&end='+to_date2);
		return false;
	});
	
	$('#nav7_btn').click(function(){
		var from_date = $('#nav7_from').val();
		var to_date = $('#nav7_to').val();
		
		var from_date1 = to_ch(from_date,1);
		var to_date1 = to_ch(to_date,1);
		
		$('#tu_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		$('#biao_title').html('从 '+from_date1+' 到 '+to_date1+' 这段时间的数据');
		
		from_date2 = to_ch(from_date,2);
		to_date2 = to_ch(to_date,2);
		
		$('#tu').attr('src','/chart/trend?start='+from_date2+'&end='+to_date2);
		$('#biao').attr('src','/table/trend?start='+from_date2+'&end='+to_date2);
		$('#print').attr('src','/table/trend?start='+from_date2+'&end='+to_date2);
		return false;
	});
	
	
	
	$('.nav_class').click(function(){
		$('.nav1_class').hide();
		var nav = $(this).attr('href').replace('#','');
		//var nav = window.location.hash.replace("#",'');
		//alert(nav);
		$('#'+nav).show();
		$('#tu').attr('src','');
		$('#biao').attr('src','');
		$('#nav_title').html($(this).text());
		return false;
	});
	
	$('#pie_select').change(function(){
		var selected = $(this).val();
		switch(selected){
			case '1':
				tu_url = '/chart/rate?t=sex';
				biao_url = '/table/rate?t=sex';
				break;
            case '2':
				tu_url = '/chart/rate?t=age';
				biao_url = '/table/rate?t=age';
				break;
            case '3':
				tu_url = '/chart/rate?t=info';
				biao_url = '/table/rate?t=info';
				break;
        case '4':
				tu_url = '/chart/rate?t=friend';
				biao_url = '/table/rate?t=friend';
				break;
        case '5':
				tu_url = '/chart/rate?t=focus';
				biao_url = '/table/rate?t=focus';
				break;
        case '6':
				tu_url = '/chart/rate?t=inbox';
				biao_url = '/table/rate?t=inbox';
				break;
        case '7':
				tu_url = '/chart/rate?t=outbox';
				biao_url = '/table/rate?t=outbox';
				break;
        case '8':
				tu_url = '/chart/rate?t=invite';
				biao_url = '/table/rate?t=invite';
				break;
        case '9':
				tu_url = '/chart/rate?t=contact';
				biao_url = '/table/rate?t=contact';
				break;
        case 10:
				tu_url = '';
				biao_url = '';
				break;
			default:
				tu_url = '';
				biao_url = '';
				break;
		}
		$('#tu').attr('src',tu_url);
		$('#biao').attr('src',biao_url);
	});      
});