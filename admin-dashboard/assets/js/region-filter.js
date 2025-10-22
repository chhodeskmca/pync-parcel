// Parish-based region filtering (admin)
$(document).ready(function() {
    // map parish -> allowed regions
    const parishMap = {
        'Kingston': ['Kingston'],
        'St. Andrew': ['Half-Way Tree', 'Constant Spring', 'Cross Roads'],
        'St. Catherine': ['Portmore', 'Spanish Town', 'Old Harbour', 'Bog Walk', 'Linstead']
    };

    function getParishValue() {
        // support both .addressParish (admin) and #State (some forms)
        let p = $('.addressParish').length ? $('.addressParish').val() : $('#State').val();
        return p || '';
    }

    function filterRegionsByParish() {
        const parish = getParishValue();
        const $region = $('#RegionAddress');
        if (!$region.length) return;

        const allowed = parishMap[parish] || [];

        // preserve previous selection if present
        const previous = $region.val();

        // rebuild options: keep the first placeholder, then add allowed options
        const placeholder = $region.find('option').first().prop('outerHTML');
        let newOptions = placeholder;
        allowed.forEach(function(r) {
            newOptions += `<option value="${r}">${r}</option>`;
        });

        $region.html(newOptions);

        // If previous exists and is allowed, restore it
        if (previous && allowed.indexOf(previous) !== -1) {
            $region.val(previous);
        } else {
            $region.val('');
        }
    }

    // initial run
    try { console.debug('[region-filter] initial run (admin)'); } catch(e) {}
    filterRegionsByParish();

    // also run again shortly after to override legacy scripts that hide/show options
    setTimeout(filterRegionsByParish, 150);

    // wire changes for both selectors
    $(document).on('change', '.addressParish, #State', function() {
        try { console.debug('[region-filter] parish changed to', getParishValue()); } catch(e) {}
        filterRegionsByParish();
    });
});
