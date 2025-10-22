$(document).ready(function() {
    $('#packageTypeFilter').change(function() {
        const filter = $(this).val();
        const table = $('.table-area');
        
        if (filter === 'all') {
            table.find('tbody tr').show();
        } else {
            table.find('tbody tr').hide();
            table.find('tbody tr[data-type="' + filter + '"]').show();
        }
    });
});
