/*
 * Subscription Expired JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';

    // Get website url
    var url =  $('meta[name=url]').attr('content');

    /*******************************
    METHODS
    ********************************/

    /*
     * Display alert
     */
    Main.popup_fon = function( cl, msg, ft, lt ) {

        // Add message
        $('<div class="md-message ' + cl + '"><i class="icon-bell"></i> ' + msg + '</div>').insertAfter('section');

        // Display alert
        setTimeout(function () {

            $( document ).find( '.md-message' ).animate({opacity: '0'}, 500);

        }, ft);

        // Hide alert
        setTimeout(function () {

            $( document ).find( '.md-message' ).remove();

        }, lt);

    };
  
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display if the coupon code is correct
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.subscription_expired_verify_coupon_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Set the plan price
            var plan_price = $( '.gateways-page .container-fluid' ).attr( 'data-price' );

            // Set discount
            var discount = plan_price/100*data.value;
            
            // Calculate discount
            var result = plan_price - discount;
            
            // Set new price
            $( '.subscription-expired-price' ).text( result.toFixed(2) );
            
            // Set the discount
            $( '.subscription-expired-discount-price' ).text( '(' + data.words.discount + ' ' + data.value + '%)' );
            
            // Empty current coupon code field
            $( '.subscription-expired-discount-code' ).val( '' );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*******************************
    FORMS
    ********************************/

    /*
     * Detect when the coupon code is submitted
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('submit', '.subscription-expired-verify-coupon-code-form', function (e) {
        e.preventDefault();
        
        // Get coupon's code
        var code = $(this).find('.subscription-expired-discount-code').val();
        
        // Prepare data to send
        var data = {
            action: 'verify_coupon',
            code: code
        };
        
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/upgrade', 'POST', data, 'subscription_expired_verify_coupon_response');
        
    });

});