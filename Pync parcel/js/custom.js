

//Calculator
$('.cost-Calculator-area .Calculator_btn').click(function(){ 

  $Weight =  parseFloat($('#Estimate-Weight').val());
  $cost =  $('.cost-Calculator-area  .cost');
  
  switch($Weight){
	  
	  case 0.5 :  
	  $('.spinner1').css('display', 'inline-block');
	  
	    setTimeout(function(){ 
	     $cost.text('5.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break; 
	  
	 case 1 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('8.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;  
	  
	 case 2 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('12.50');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break; 
	  
	 case 3 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('17.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	 case 4 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('20');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break; 
	  
	 case 5 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('23.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break; 
	  
	 case 6 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('26.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break; 
	  
	 case 7 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('29.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break; 
	  
	 case 8 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('32.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;  
	  
	   case 9 : 
	   $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('35.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;  
	  
	 case 10 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('38.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	   case 11 : 
	   $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('41.50');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	    case 12 : 
		$('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('45.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	 case 13 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('48.50');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	case 14 : 
	$('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('52.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	 case 15 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('55.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	 case 16 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('58.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	case 17 : 
	$('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('61.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	 
	  case 18 : 
	  $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('64.50');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	  case 19 : 
	  $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('68.00');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	 case 20 : 
	 $('.spinner1').css('display', 'inline-block');
	 setTimeout(function(){ 
	     $cost.text('71.50');
	     $('.spinner1').css('display', 'none'); 
		 
	  }, 1000);
	  break;
	  
	  default : 
	  $cost.text('0.00');
	  
  }

}); 

$('.reset_btn').click(function(){ 

   $cost.text('0.00');
  $('#Estimate-Weight').val(0);

});