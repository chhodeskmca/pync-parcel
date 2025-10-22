// Calculator - improved dynamic implementation
// Loads rates.json and computes price for arbitrary weights
(function(){
	var ratesData = null;

		function tryFetchPaths(paths) {
			return new Promise(function(resolve, reject) {
				var i = 0;
				function tryNext() {
					if (i >= paths.length) return reject(new Error('All paths failed'));
					var p = paths[i++];
					try { console.debug('[rates] trying', p); } catch (e) {}
					fetch(p, {cache: 'no-cache'})
						.then(function(res){ if(!res.ok) throw new Error('not ok'); return res.json(); })
						.then(function(json){ try { console.debug('[rates] loaded', p); } catch (e) {} ; resolve(json); })
						.catch(function(err){ try { console.debug('[rates] failed', p, err && err.message); } catch (e) {} ; tryNext(); });
				}
				tryNext();
			});
		}

			function buildCandidatePaths() {
				var paths = ['rates.json','./rates.json','../rates.json','../../rates.json','/rates.json'];
				try {
					// Try to derive a path based on the script's src (works even when served from subfolders)
					var script = document.currentScript;
					if (!script) script = document.querySelector('script[src*="/js/custom.js"], script[src*="js/custom.js"]');
					if (script && script.src) {
						var scriptDir = script.src.replace(/\/[^\/]*$/, '');
						paths.unshift(scriptDir + '/rates.json');
					}
					// Also try based on current location path (several directory levels)
					var loc = window.location.pathname;
					var parts = loc.split('/').filter(Boolean);
					var accum = '';
					for (var i = 0; i < parts.length; i++) {
						accum += '/' + parts[i];
						paths.push(accum + '/rates.json');
					}
				} catch (e) {
					// ignore
				}
								// dedupe while preserving order
								var seen = {};
								var final = paths.filter(function(p){ if(seen[p]) return false; seen[p]=true; return true; });
								try { console.debug('[rates] candidate paths', final); } catch (e) {}
								return final;
			}

			function loadRates() {
				if (ratesData) return Promise.resolve(ratesData);
					var candidatePaths = buildCandidatePaths();
					// project root path (useful when site is served from /Pync-parcel)
					candidatePaths.unshift('/Pync-parcel/rates.json');
				return tryFetchPaths(candidatePaths).then(function(json){ ratesData = json; return ratesData; });
			}

	function formatPrice(n){
		return Number(n).toFixed(2);
	}

	function computePrice(weight, data){
		var rates = {};
		var maxWeight = 0;
		(data.rates || []).forEach(function(r){ rates[String(r.weight)] = parseFloat(r.price); if (r.weight > maxWeight) maxWeight = r.weight; });
		var additional = parseFloat(data.additional_rate_above_20 || 0);
		var minWeight = parseFloat(data.minimum_weight || 0.5);

		if (isNaN(weight) || weight <= 0) return 0;

		// if very small, charge minimum bracket
		if (weight <= minWeight) return rates[String(minWeight)] || 0;

		// weights up to maxWeight: round up to next integer (except handle 0.5 special)
		if (weight <= maxWeight) {
			var key;
			if (weight > 0 && weight <= minWeight) {
				key = minWeight;
			} else if (weight > minWeight && weight <= 1) {
				key = 1;
			} else {
				key = Math.ceil(weight);
			}
			key = String(key);
			return rates[key] !== undefined ? rates[key] : 0;
		}

		// weight > maxWeight
		var base = rates[String(maxWeight)] || 0;
		var extraUnits = Math.ceil(weight - maxWeight);
		return base + extraUnits * additional;
	}

	$('.cost-Calculator-area .Calculator_btn').on('click', function(e){
		e.preventDefault();
		var $weightInput = $('#Estimate-Weight');
		var $spinner = $('.spinner1');
		var $cost = $('.cost-Calculator-area .cost');
		var raw = $weightInput.val();
		var weight = parseFloat(raw);

		$spinner.css('display','inline-block');

		loadRates().then(function(data){
			var price = computePrice(weight, data);
			// small simulated delay to match UX
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
