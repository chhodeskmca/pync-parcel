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

        // Build options HTML
        let newOptions = firstOption;
        Array.from(allRegions).sort().forEach(region => {
            newOptions += `<option value="${region}">${region}</option>`;
        });

        // Set options and update visibility
        $region.html(newOptions);
        updateRegionVisibility();
    }

    // Enable the Region select
    function enableRegionSelect() {
        const $region = $('#RegionAddress');
        $region.prop('disabled', false).removeAttr('readonly');
    }

    // Initialize on page load
    try { console.debug('[region-filter] initializing...'); } catch(e) {}
    initializeRegionOptions();
    enableRegionSelect();

    // Handle parish changes
    $(document).on('change', '.addressParish, #State', function() {
        try { console.debug('[region-filter] parish changed to:', $(this).val()); } catch(e) {}
        updateRegionVisibility();
        enableRegionSelect();
    });
});
