/*
 * Main JavaJscript file
*/

jQuery(document).ready(function ($) {
    'use strict';

    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');

    /*******************************
    METHODS
    ********************************/

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect input change
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('change', '.plugins-page .amazon-s3-uploader-text-input', function () {

        // Prepare data to send
        var data = {
            action: 'amazon_s3_uploader_save_configuration'
        };

        // Set data's option
        data['option'] = {
            [$(this).attr('data-option')]: $(this).val()
        };

        // Set the CSRF field
        data[$('.plugins-page').attr('data-csrf')] = $('.plugins-page').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'plugin-ajax/amazon_s3_uploader', 'POST', data, 'amazon_s3_uploader_save_configuration_response');        

    });

    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display the plugin save configuration
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.amazon_s3_uploader_save_configuration_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };

    /*******************************
    FORMS
    ********************************/

});