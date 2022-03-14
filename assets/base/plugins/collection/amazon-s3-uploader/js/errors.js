/*
 * Errors JavaJscript file
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

    /*
     * Load errors by page
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.4
     */    
    Main.amazon_s3_uploader_get_errors =  function (page) {

        // Prepare data to send
        var data = {
            action: 'amazon_s3_uploader_get_errors',
            page: page
            
        };
        
        // Set the CSRF field
        data[$('.plugins-page').attr('data-csrf')] = $('.plugins-page').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'plugin-ajax/amazon_s3_uploader', 'POST', data, 'amazon_s3_uploader_display_errors');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Load default content
     * 
     * @since   0.0.8.4 
     */
    $(function () {
        
        // Display errors by page
        Main.amazon_s3_uploader_get_errors(1);
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */    
    $( document ).on( 'click', '.plugins-page .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'errors':

                // Display errors by page
                Main.amazon_s3_uploader_get_errors(page);
                
                // Display loading animation
                $('.page-loading').fadeIn('slow');              

                break;

        }
        
    });

    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display errors response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.amazon_s3_uploader_display_errors = function ( status, data ) {

        // Hide Pagination
        $('.plugins-page .panel-failed-requests .panel-footer').hide();  

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Set the page
            Main.pagination.page = data.page;

            // Generate pagination
            Main.show_pagination('.theme-settings-page', data.total);

            // All errors
            var all_errors = '';
            
            // List all errors
            for ( var e = 0; e < data.errors.length; e++ ) {

                // Set error
                all_errors += '<li class="list-group-item theme-background-grey-light">'
                    + '<div class="row">'
                        + '<div class="col-md-8">'
                            + '<p>'
                                + data.errors[e].body
                            + '</p>'
                        + '</div>'
                        + '<div class="col-md-4 text-right">'
                            + '<span class="badge badge-primary badge-pill theme-color-black">'
                                + '<i class="material-icons-outlined">'
                                    + 'history'
                                + '</i>'
                                + Main.calculate_time(data.errors[e].created, data.current_time).replace(/<[^>]*>?/gm, '')
                            + '</span>'
                        + '</div>'              
                    + '</div>'
                + '</li>';

            }

            // Display errors
            $('.plugins-page .panel-failed-requests .panel-body .list-group').html(all_errors);

            // Show Pagination
            $('.plugins-page .panel-failed-requests .panel-footer').show();  
            
        } else {
            
            // Set no data found message
            var no_data = '<li class="list-group-item">'
                                + data.message
                            + '</li>';

            // Display the no data found message
            $('.plugins-page .panel-failed-requests .panel-body .list-group').html(no_data);   
            
        }

    };

    /*******************************
    FORMS
    ********************************/

});