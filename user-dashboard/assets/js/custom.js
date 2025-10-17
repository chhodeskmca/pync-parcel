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
/* If Parish is selected, show only relevant regions */
$('.addressParish').change(function () {
	$RegionAddressVal = $(this).val();
	$('.RegionAddress').prop('selectedIndex', 0);
	$('.RegionAddress option').removeAttr("selected");
	$('.RegionAddress option').hide(); // Hide all options first
	$('.RegionAddress option:first').show(); // Always show "Choose..." option

	if ($RegionAddressVal == 'Kingston') {
		$(".RegionAddress option[value='Kingston']").show();
	} else if ($RegionAddressVal == 'St. Andrew') {
		$(".RegionAddress option[value='Half-Way Tree']").show();
		$(".RegionAddress option[value='Constant Spring']").show();
		$(".RegionAddress option[value='Cross Roads']").show();
	} else if ($RegionAddressVal == 'St. Catherine') {
		$(".RegionAddress option[value='Portmore']").show();
		$(".RegionAddress option[value='Spanish Town']").show();
		$(".RegionAddress option[value='Old Harbour']").show();
		$(".RegionAddress option[value='Bog Walk']").show();
		$(".RegionAddress option[value='Linstead']").show();
	} else {
		// If no parish selected, hide all region options except "Choose..."
		$('.RegionAddress option').hide();
		$('.RegionAddress option:first').show();
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
// Calculator (dashboard) - dynamic implementation
(function(){
	var ratesData = null;

	function tryFetchPaths(paths) {
		return new Promise(function(resolve, reject) {
			var i = 0;
			function tryNext() {
				if (i >= paths.length) return reject(new Error('All paths failed'));
				var p = paths[i++];
				fetch(p, {cache: 'no-cache'})
					.then(function(res){ if(!res.ok) throw new Error('not ok'); return res.json(); })
					.then(function(json){ resolve(json); })
					.catch(function(){ tryNext(); });
			}
			tryNext();
		});
	}

	function buildCandidatePaths() {
		var paths = ['/rates.json','../rates.json','rates.json','./rates.json','../../rates.json'];
		try {
			var script = document.currentScript;
			if (!script) script = document.querySelector('script[src*="/user-dashboard/assets/js/custom.js"], script[src*="custom.js"]');
			if (script && script.src) {
				var scriptDir = script.src.replace(/\/[^\/]*$/, '');
				paths.unshift(scriptDir + '/rates.json');
			}
			var loc = window.location.pathname;
			var parts = loc.split('/').filter(Boolean);
			var accum = '';
			for (var i = 0; i < parts.length; i++) {
				accum += '/' + parts[i];
				paths.push(accum + '/rates.json');
			}
		} catch (e) {}
		var seen = {};
		return paths.filter(function(p){ if(seen[p]) return false; seen[p]=true; return true; });
	}

	function loadRates(){
		if(ratesData) return Promise.resolve(ratesData);
		var candidatePaths = buildCandidatePaths();
		candidatePaths.unshift('/Pync-parcel/rates.json');
		return tryFetchPaths(candidatePaths).then(function(json){ ratesData = json; return ratesData; });
	}

	function formatPrice(n){ return Number(n).toFixed(2); }

	function computePrice(weight, data){
		var rates = {};
		var maxWeight = 0;
		(data.rates || []).forEach(function(r){ rates[String(r.weight)] = parseFloat(r.price); if(r.weight > maxWeight) maxWeight = r.weight; });
		var additional = parseFloat(data.additional_rate_above_20 || 0);
		var minWeight = parseFloat(data.minimum_weight || 0.5);
		if(isNaN(weight) || weight <= 0) return 0;
		if(weight <= minWeight) return rates[String(minWeight)] || 0;
		if(weight <= maxWeight){
			var key;
			if(weight > 0 && weight <= minWeight) key = minWeight;
			else if(weight > minWeight && weight <= 1) key = 1;
			else key = Math.ceil(weight);
			return rates[String(key)] || 0;
		}
		var base = rates[String(maxWeight)] || 0;
		var extraUnits = Math.ceil(weight - maxWeight);
		return base + extraUnits * additional;
	}

	$('.cost-Calculator-area .Calculator_btn').on('click', function(e){
		e.preventDefault();
		var $weightInput = $('#Estimate-Weight');
		var $spinner = $('.spinner1');
		var $cost = $('.cost-Calculator-area .cost');
		var weight = parseFloat($weightInput.val());
		$spinner.css('display','inline-block');
		loadRates().then(function(data){
			var price = computePrice(weight, data);
			setTimeout(function(){
				$cost.text(formatPrice(price));
				$spinner.css('display','none');
			}, 500);
		}).catch(function(err){
			console.error('Rate load error', err);
			$spinner.css('display','none');
			$cost.text('0.00');
		});
	});

	$('.reset_btn').on('click', function(e){
		e.preventDefault();
		$('.cost-Calculator-area .cost').text('0.00');
		$('#Estimate-Weight').val('');
	});
})();
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
