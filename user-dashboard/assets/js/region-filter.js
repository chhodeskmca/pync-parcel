// Parish-based region filtering (user)
$(document).ready(function() {
    const parishMap = {
        'Kingston': ['Kingston'],
        'St. Andrew': ['Half-Way Tree', 'Constant Spring', 'Cross Roads'],
        'St. Catherine': ['Portmore', 'Spanish Town', 'Old Harbour', 'Bog Walk', 'Linstead']
    };

    function getParishValue() {
        return $('.addressParish').length ? $('.addressParish').val() : $('#State').val() || '';
    }

    function updateRegionVisibility() {
        const parish = getParishValue();
        const $region = $('#RegionAddress');
        if (!$region.length) return;

        // Get current selection
        const currentValue = $region.val();
        
        // Get all options except the first (Keep "Choose...")
        const $options = $region.find('option:not(:first)');
        
        // Get allowed regions for selected parish
        const allowed = parishMap[parish] || [];

        // Show/hide options based on selected parish
        $options.each(function() {
            const $option = $(this);
            if (allowed.includes($option.val())) {
                $option.show();
            } else {
                $option.hide();
                // If a hidden option was selected, reset to Choose...
                if ($option.is(':selected')) {
                    $region.val('');
                }
            }
        });

        // If current selection is valid for new parish, keep it
        if (currentValue && allowed.includes(currentValue)) {
            $region.val(currentValue);
        }
    }

    // Initialize all possible region options once
    function initializeRegionOptions() {
        const $region = $('#RegionAddress');
        if (!$region.length) return;

        // Keep the first "Choose..." option
        const firstOption = $region.find('option:first').prop('outerHTML');
        
        // Get all unique regions
        const allRegions = new Set();
        Object.values(parishMap).forEach(regions => {
            regions.forEach(r => allRegions.add(r));
        });
        // Also include any current region value provided by server (so saved selections aren't lost)
        const currentRegion = $region.data('current');
        if (currentRegion) allRegions.add(currentRegion);

        // Build options HTML
        let newOptions = firstOption;
        Array.from(allRegions).sort().forEach(region => {
            // escape HTML when injecting via template literal
            const esc = String(region).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            newOptions += `<option value="${esc}">${esc}</option>`;
        });

        // Set options and update visibility
        $region.html(newOptions);
        // Set the current region value if it exists
        if (currentRegion) {
            $region.val(currentRegion);
        }
        updateRegionVisibility();
    }

    // Enable the Region select
    function enableRegionSelect() {
        const $region = $('#RegionAddress');
        $region.prop('disabled', false).removeAttr('readonly');
    }

    // Initialize on page load (do NOT enable the Region select here - it should stay disabled until user clicks Enable Edit)
    try { console.debug('[region-filter] initializing...'); } catch(e) {}
    initializeRegionOptions();

    // Handle parish changes
    $(document).on('change', '.addressParish, #State', function() {
        try { console.debug('[region-filter] parish changed to:', $(this).val()); } catch(e) {}
        updateRegionVisibility();
        // do NOT auto-enable the Region select here; enabling is controlled by the 'Enable Edit' button
    });
});
