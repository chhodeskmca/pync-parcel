$('.account_info_btn').click(function () {
	$(this).css('display', 'none');
	$('#gender').addClass("gender");
	$('.account_info_update_btn').css('display', 'block');
	//if(  $('.change-value input').is("[disabled]") ){};  
	$('.change-value input').removeAttr("disabled");
	$('.addressParish').removeAttr("disabled");
	$('.AddressType').removeAttr("disabled");
	$('.Delivery-Preference select').removeAttr("disabled");
});
/* If Address Type input is clicked and value is 1, 2, 3, 
   Parish address input will be enabled */
$('.addressParish').change(function () {
	$RegionAddressVal = $(this).val();
	if ($RegionAddressVal == 'Kingston') {
		$('.RegionAddress').prop('selectedIndex', 0);
		$('.RegionAddress option').removeAttr("selected");
		$(".RegionAddress option[value='Portmore']").removeClass("show");
		$(".RegionAddress option[value='Spanish Town']").removeClass("show");
		$(".RegionAddress option[value='Old Harbour']").removeClass("show");
		$(".RegionAddress option[value='Bog Walk']").removeClass("show");
		$(".RegionAddress option[value='Linstead']").removeClass("show");
		$(".RegionAddress option[value='Half-Way Tree']").removeClass("show");
		$(".RegionAddress option[value='Constant Spring']").removeClass("show");
		$(".RegionAddress option[value='Cross Roads']").removeClass("show");
		$(".RegionAddress option[value='Kingston']").addClass("show");
	} else if ($RegionAddressVal == 'St. Andrew') {
		$('.RegionAddress').prop('selectedIndex', 0);
		$('.RegionAddress option').removeAttr("selected");
		$(".RegionAddress option[value='Kingston']").removeClass("show");
		$(".RegionAddress option[value='Portmore']").removeClass("show");
		$(".RegionAddress option[value='Spanish Town']").removeClass("show");
		$(".RegionAddress option[value='Old Harbour']").removeClass("show");
		$(".RegionAddress option[value='Bog Walk']").removeClass("show");
		$(".RegionAddress option[value='Linstead']").removeClass("show");
		$(".RegionAddress option[value='Half-Way Tree']").addClass("show");
		$(".RegionAddress option[value='Constant Spring']").addClass("show");
		$(".RegionAddress option[value='Cross Roads']").addClass("show");
	} else if ($RegionAddressVal == 'St. Catherine') {
		$('.RegionAddress').prop('selectedIndex', 0);
		$('.RegionAddress option').removeAttr("selected");
		$(".RegionAddress option[value='Kingston']").removeClass("show");
		$(".RegionAddress option[value='Half-Way Tree']").removeClass("show");
		$(".RegionAddress option[value='Constant Spring']").removeClass("show");
		$(".RegionAddress option[value='Cross Roads']").removeClass("show");
		$(".RegionAddress option[value='Portmore']").addClass("show");
		$(".RegionAddress option[value='Spanish Town']").addClass("show");
		$(".RegionAddress option[value='Old Harbour']").addClass("show");
		$(".RegionAddress option[value='Bog Walk']").addClass("show");
		$(".RegionAddress option[value='Linstead']").addClass("show");
	} else {
		$(".RegionAddress option").removeClass("show");
		$('.RegionAddress').prop('selectedIndex', 0);
	}
});
// reset Password
$('.pwd-enble-btn').click(function () {
	$(this).css('display', 'none');
	$('.pwd-update-btn').css('display', 'block');
	$('.hide-show-pwd').removeAttr("disabled");
});
// $('.pwd-update-btn').click( function(){ 
// $(this).css('display', 'none'); 
// $('.hide-show-pwd').attr("disabled", "") ;
// $('.pwd-enble-btn').css('display', 'block');
// }); 
// Aurized Usrer information updating
$('.AurizedUsr-enble-btn').click(function () {
	$(this).css('display', 'none');
	$('.AurizedUsr-update-btn').css('display', 'block');
	$('.AuthorizedUser').removeAttr("disabled");
});
// $('.AurizedUsr-update-btn').click( function(){ 
// $(this).css('display', 'none'); 
// $('.AuthorizedUser').attr("disabled", "") ;
// $('.AurizedUsr-enble-btn').css('display', 'block');
// });  
//Calculator
$('.cost-Calculator-area .Calculator_btn').click(function () {
	$Weight = parseFloat($('#Estimate-Weight').val());
	$cost = $('.cost-Calculator-area  .cost');
	switch ($Weight) {
		case 0.5:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('5.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 1:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('8.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 2:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('12.50');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 3:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('17.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 4:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('20');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 5:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('23.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 6:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('26.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 7:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('29.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 8:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('32.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 9:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('35.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 10:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('38.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 11:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('41.50');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 12:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('45.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 13:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('48.50');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 14:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('52.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 15:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('55.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 16:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('58.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 17:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('61.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 18:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('64.50');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 19:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('68.00');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		case 20:
			$('.spinner1').css('display', 'inline-block');
			setTimeout(function () {
				$cost.text('71.50');
				$('.spinner1').css('display', 'none');
			}, 1000);
			break;
		default:
			$cost.text('0.00');
	}
});
$('.reset_btn').click(function () {
	$cost.text('0.00');
	$('#Estimate-Weight').val(0);
});
// address type 
$('.main-header').click(function () {

});
$('.AddressType').on('change', function () {
	$addressType = $(this).val();
	// $(".addressParish ").val("St. Catherine").trigger("change");
	if ($addressType != '') {
		$('.address_spinner').css('display', 'block');
		setTimeout(function () {
			$.post('../codes.php',
				{
					addresType: $addressType
				},
				function (response) {
					if (response != 0) {
						const dataObject = JSON.parse(response);
						$parish = dataObject['parish'];
						$region = dataObject['region'];
						$address_line1 = dataObject['address_line1'];
						$address_line2 = dataObject['address_line2'];
						$(".addressParish").val($parish).trigger("change");
						$(".RegionAddress").val($region).trigger("change");
						$('.AddressLine1').val($address_line1);
						$('.AddressLine2').val($address_line2);
						$('.address_spinner').css('display', 'none');
					} else {
						$('.address_spinner').css('display', 'none');
					}
				});
		}, 1000);
	}
});
