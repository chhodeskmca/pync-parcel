// Parish-based region filtering
$(document).ready(function() {
    // Only run if user is admin
    if (!$('body').hasClass('admin-dashboard')) {
        return;
    }
    
    function filterRegionsByParish() {
        const parish = $('.addressParish').val();
        const regions = $('#RegionAddress option:not(:first)');
        
        // Hide all region options except the first one (Choose...)
        regions.hide();
        
        // Show relevant regions based on parish selection
        if (parish === 'Kingston') {
            $('#RegionAddress option[value="Kingston"]').show();
        } else if (parish === 'St. Andrew') {
            $('#RegionAddress option[value="Half-Way Tree"]').show();
            $('#RegionAddress option[value="Constant Spring"]').show();
            $('#RegionAddress option[value="Cross Roads"]').show();
        } else if (parish === 'St. Catherine') {
            $('#RegionAddress option[value="Portmore"]').show();
            $('#RegionAddress option[value="Spanish Town"]').show();
            $('#RegionAddress option[value="Old Harbour"]').show();
            $('#RegionAddress option[value="Bog Walk"]').show();
            $('#RegionAddress option[value="Linstead"]').show();
        }
        
        // Reset selection if current value is not valid for the selected parish
        const currentRegion = $('#RegionAddress').val();
        const visibleOptions = $('#RegionAddress option:visible');
        if (visibleOptions.filter(`[value="${currentRegion}"]`).length === 0) {
            $('#RegionAddress').val('');
        }
    }
    
    // Initial filtering on page load
    filterRegionsByParish();
    
    // Filter when parish selection changes
    $('.addressParish').change(function() {
        filterRegionsByParish();
    });
});
