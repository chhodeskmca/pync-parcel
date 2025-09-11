  
    // window width
	if( $(document).width() == 767 ||  $(document).width() > 767 ){  
	
	    $('.account_content').addClass("active");
	    $('.account_content').addClass("show"); 
	};
	
	$('.account_Tab_btn').click(function(){ 
	 
		 if( $('.account_content').hasClass('active') ){ 
		 
		           // removing all active class of user account tab content
				   
			 	  $('.right-arrow').removeClass("arrow-active");
			 	  $('.right-arrow1').removeClass("arrow-active");
			 	  $('.right-arrow2').removeClass("arrow-active");
			 	  $('.right-arrow3').removeClass("arrow-active");
				  
			 	  $('.account_content').removeClass("active");
			 	  $('.account_content').removeClass("show"); 
				  
				  $('.pwd_reset_content').removeClass("active");
			 	  $('.pwd_reset_content').removeClass("show"); 
				  
				  $('.AuthorizedUser_content').removeClass("active");
		          $('.AuthorizedUser_content').removeClass("show"); 
			 
		 }else{ 
		 
					$('.right-arrow1').removeClass("arrow-active");
					$('.right-arrow2').removeClass("arrow-active");
					$('.right-arrow3').removeClass("arrow-active");
						  
					$('.account_content').addClass("active");
					$('.account_content').addClass("show"); 
					$('.right-arrow').addClass("arrow-active");					
					
					$('.pwd_reset_content').removeClass("active");
					$('.pwd_reset_content').removeClass("show"); 
					
					$('.AuthorizedUser_content').removeClass("active");
					$('.AuthorizedUser_content').removeClass("show"); 
		 }
	});  

    $('.reset_Tab_btn').click(function(){ 

		 if( $('.pwd_reset_content').hasClass('active') ){ 
		 
		          $('.right-arrow').removeClass("arrow-active");
			 	  $('.right-arrow1').removeClass("arrow-active");
			 	  $('.right-arrow2').removeClass("arrow-active");
			 	  $('.right-arrow3').removeClass("arrow-active");
				 
			 	  $('.pwd_reset_content').removeClass("active");
			 	  $('.pwd_reset_content').removeClass("show"); 
				 
				  $('.account_content').removeClass("active");
			 	  $('.account_content').removeClass("show");  
				 
				  $('.AuthorizedUser_content').removeClass("active");
			 	  $('.AuthorizedUser_content').removeClass("show"); 
			 
		 }else{ 
		 
		          $('.right-arrow').removeClass("arrow-active");
			      $('.right-arrow2').removeClass("arrow-active");
			      $('.right-arrow3').removeClass("arrow-active");
			
		          $('.pwd_reset_content').addClass("active");
		          $('.pwd_reset_content').addClass("show"); 
		          $('.right-arrow1').addClass("arrow-active");
		   
		          $('.account_content').removeClass("active");
		          $('.account_content').removeClass("show");  
		   
		          $('.AuthorizedUser_content').removeClass("active");
		          $('.AuthorizedUser_content').removeClass("show");  
		   
		          $('.MiamiAddress_content').removeClass("active");
		          $('.MiamiAddress_content').removeClass("show"); 
		 }
	});  
	
	$('.AuthorizedUser_tab_btn').click(function(){ 

		 if( $('.AuthorizedUser_content').hasClass('active') ){ 
		          
				  // removing all active class of user account tab content
		          $('.right-arrow').removeClass("arrow-active");
			 	  $('.right-arrow1').removeClass("arrow-active");
			 	  $('.right-arrow2').removeClass("arrow-active");
			 	  $('.right-arrow3').removeClass("arrow-active");
				 
			 	  $('.AuthorizedUser_content').removeClass("active");
			 	  $('.AuthorizedUser_content').removeClass("show"); 
				 
				  $('.account_content').removeClass("active");
			 	  $('.account_content').removeClass("show");  
				 
				  $('.pwd_reset_content').removeClass("active");
			 	  $('.pwd_reset_content').removeClass("show"); 
				 
				  $('.MiamiAddress_content').removeClass("active");
			 	  $('.MiamiAddress_content').removeClass("show"); 
			 
		 }else{ 
		          
		          $('.right-arrow').removeClass("arrow-active");
			      $('.right-arrow1').removeClass("arrow-active");
			      $('.right-arrow3').removeClass("arrow-active");
			
		          $('.AuthorizedUser_content').addClass("active");
		          $('.AuthorizedUser_content').addClass("show"); 
		          $('.right-arrow2').addClass("arrow-active");
		   
		          $('.account_content').removeClass("active");
		          $('.account_content').removeClass("show");  
		   
		          $('.pwd_reset_content').removeClass("active");
		          $('.pwd_reset_content').removeClass("show"); 
		   
		          $('.MiamiAddress_content').removeClass("active");
		          $('.MiamiAddress_content').removeClass("show"); 
		 }
	}); 
	
	$('.MiamiAddress_tab_btn').click(function(){ 

		 if( $('.MiamiAddress_content').hasClass('active') ){ 
		 
		         // removing all active class of user account tab content
				 $('.right-arrow').removeClass("arrow-active");
			 	 $('.right-arrow1').removeClass("arrow-active");
			 	 $('.right-arrow2').removeClass("arrow-active");
			 	 $('.right-arrow3').removeClass("arrow-active");
				 
				 $('.MiamiAddress_content').removeClass("active");
			 	 $('.MiamiAddress_content').removeClass("show"); 
		 
			 	 $('.AuthorizedUser_content').removeClass("active");
			 	 $('.AuthorizedUser_content').removeClass("show"); 
				 
				 $('.account_content').removeClass("active");
			 	 $('.account_content').removeClass("show");  
				 
				 $('.pwd_reset_content').removeClass("active");
			 	 $('.pwd_reset_content').removeClass("show");
			 
		 }else{ 
		 
		          $('.right-arrow').removeClass("arrow-active");
			      $('.right-arrow1').removeClass("arrow-active");
			      $('.right-arrow2').removeClass("arrow-active");
			
		          $('.MiamiAddress_content').addClass("active"); 
		          $('.MiamiAddress_content').addClass("show"); 
		          $('.right-arrow3').addClass("arrow-active");
		   
		          $('.AuthorizedUser_content').removeClass("active");
		          $('.AuthorizedUser_content').removeClass("show"); 
		   
		          $('.account_content').removeClass("active");
		          $('.account_content').removeClass("show");  
		   
		          $('.pwd_reset_content').removeClass("active");
		          $('.pwd_reset_content').removeClass("show"); 
		 }
	});  
	
