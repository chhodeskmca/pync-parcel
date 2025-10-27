// Parish-based region filtering (user) - Safari compatible version
$(document).ready(function() {
    const parishMap = {
        'Kingston': ['Kingston'],
        'St. Andrew': ['Half-Way Tree', 'Constant Spring', 'Cross Roads'],
        'St. Catherine': ['Portmore', 'Spanish Town', 'Old Harbour', 'Bog Walk', 'Linstead']
    };

    function getParishValue() {
        return $('.addressParish').length ? $('.addressParish').val() : $('#State').val() || '';
    }

    function updateRegionOptions() {
        const parish = getParishValue();
        const $region = $('#RegionAddress');
        if (!$region.length) return;

        // Get current selection
        const currentValue = $region.val();

        // Get allowed regions for selected parish
        const allowed = parishMap[parish] || [];

        // Keep the first "Choose..." option
        const firstOption = $region.find('option:first').prop('outerHTML');

        // Build new options HTML for allowed regions
        let newOptions = firstOption;
        allowed.forEach(region => {
            // escape HTML when injecting via template literal
            const esc = String(region).replace(/&/g, '&amp;').replace(/</g, '<').replace(/>/g, '>').replace(/"/g, '"');
            const selected = (currentValue === region) ? ' selected' : '';
            newOptions += `<option value="${esc}"${selected}>${esc}</option>`;
        });

        // Replace all options
        $region.html(newOptions);

        // If current selection is not in allowed regions, reset to Choose...
        if (currentValue && !allowed.includes(currentValue)) {
            $region.val('');
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
            const esc = String(region).replace(/&/g, '&amp;').replace(/</g, '<').replace(/>/g, '>').replace(/"/g, '"');
            const selected = (currentRegion === region) ? ' selected' : '';
            newOptions += `<option value="${esc}"${selected}>${esc}</option>`;
        });

        // Set options and update visibility
        $region.html(newOptions);
        updateRegionOptions();
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
        updateRegionOptions();
        // do NOT auto-enable the Region select here; enabling is controlled by the 'Enable Edit' button
    });
});
