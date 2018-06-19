jQuery(document).ready(function() {

    jQuery('#fi-new-invoice').on('click', function (v) {

        v.preventDefault();
        
        var inputs = $('#fi-invoice-form :input').serialize();
    
        var data = {
            'action': 'fi_add_invoice',
            'fi-invoice': inputs
        };
        
        jQuery.post(ajaxurl, data, function(response) {
            console.log(response);
        });

    });
    
});
