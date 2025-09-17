
   // package redirects to tracking information page
    $('#mypackages tbody tr').click(function() {
		console.log("clicked");
		
		
         window.location = 'tracking.php';
    });  
	$('.notifi-area a').click(function() {
		
         window.location = 'tracking.php';
    });  
	
    $('.prealert-edit-btn').click(function() {
		
         window.location = 'updateprealert.html';
    }); 
   
    //  input making disabled and enabled attributes in  account setting 
     
    $('.account_info_btn').click( function(){  
	
             $(this).css('display', 'none');
			 $('#gender').addClass("gender");
		     $('.account_info_update_btn').css('display', 'block');
             //if(  $('.change-value input').is("[disabled]") ){};  
		        $('.change-value input').removeAttr("disabled") ;
		        $('.addressParish').removeAttr("disabled") ;
		        $('.AddressType').removeAttr("disabled") ;
		 
    }); 
	$('.account_info_update_btn').click( function(){ 
		
		   $(this).css('display', 'none'); 
		   $('#gender').removeClass("gender");
		   $('.change-value input').attr("disabled", "") ;
		   $('.AddressType').attr("disabled", "") ;
		   $('.RegionAddress').attr("disabled", "") ;
		   $('.addressParish').attr("disabled", "") ;
		   $('.account_info_btn').css('display', 'block');
		   $('.RegionAddress2').attr("disabled", "");
	       $('.RegionAddress3').attr("disabled", "") ;
		  
    });  
	
	/* If Address Type input is clicked and value is 1, 2, 3, 
       Parish address input will be enabled */
	$('.addressParish').change( function(){ 
	
	     $RegionAddressVal = $(this).val(); 
		if( $RegionAddressVal == 1 ){  
		
		     $('.RegionAddress').css('display', 'block');
             $('.RegionAddress2').css('display', 'none');
			 $('.RegionAddress3').css('display', 'none');
		     $('.RegionAddress').removeAttr("disabled") ; 
			 $('.RegionAddress2').attr("disabled", "");
			 $('.RegionAddress3').attr("disabled", "") 
			

		}else if($RegionAddressVal == 2){  
		
		    $('.RegionAddress3').css('display', 'none');
            $('.RegionAddress').css('display', 'none');
            $('.RegionAddress2').css('display', 'block');
		    $('.RegionAddress').attr("disabled", "");
			$('.RegionAddress3').attr("disabled", "") ;
		    $('.RegionAddress2').removeAttr("disabled") ;
			
		}else if($RegionAddressVal == 3){ 
		     
		    $('.RegionAddress2').css('display', 'none');
			$('.RegionAddress').css('display', 'none');
			$('.RegionAddress2').attr("disabled", "");
		    $('.RegionAddress').attr("disabled", "");
			$('.RegionAddress3').removeAttr("disabled") ;
			$('.RegionAddress3').css('display', 'block');
	
		}else{  
		
            $('.RegionAddress option').prop('selected', function() {
               return this.defaultSelected;
            });     
		    $('.RegionAddress').attr("disabled", "") ;
			$('.RegionAddress3').css('display', 'none');
            $('.RegionAddress').css('display', 'block');
            $('.RegionAddress2').css('display', 'none');
		}
	 }); 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	
	// reset Password
    $('.pwd-enble-btn').click( function(){  
	
            $(this).css('display', 'none');
		    $('.pwd-update-btn').css('display', 'block');  
		    $('.hide-show-pwd').removeAttr("disabled") ;
		  
    }); 
	$('.pwd-update-btn').click( function(){ 
		
		   $(this).css('display', 'none'); 
		   $('.hide-show-pwd').attr("disabled", "") ;
		   $('.pwd-enble-btn').css('display', 'block');
		  
    }); 
	// Aurized Usrer information updating
	$('.AurizedUsr-enble-btn').click( function(){  
	
            $(this).css('display', 'none');
		    $('.AurizedUsr-update-btn').css('display', 'block');  
		    $('.AuthorizedUser').removeAttr("disabled") ;
		  
    }); 
	$('.AurizedUsr-update-btn').click( function(){ 
		
		   $(this).css('display', 'none'); 
		   $('.AuthorizedUser').attr("disabled", "") ;
		   $('.AurizedUsr-enble-btn').css('display', 'block');
		  
    });  
  