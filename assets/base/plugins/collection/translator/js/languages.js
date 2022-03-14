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
     * Detect words edit click button
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.plugins-page .panel-language-file .translator-plugin-word-edit-btn', function (e) {
        e.preventDefault();
        
        // Enable the text edit
        $(this).closest('.translator-plugin-word-area').addClass('translator-plugin-word-area-active').find('.translator-plugin-word').attr('contenteditable', 'true');

    });

    /*
     * Detect words save click button
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.plugins-page .panel-language-file .translator-plugin-word-save-btn', function (e) {
        e.preventDefault();

        // Save this event
        Main.this_event = $(this);
        
        // Get the file
        let file = Main.this_event.closest('.translator-plugin-word-area').attr('data-file');

        // Gets the words slug
        let key = Main.this_event.closest('.translator-plugin-word-area').attr('data-key');

        // Get the words
        let value = Main.this_event.closest('.translator-plugin-word-area').find('.translator-plugin-word').html();

        // Prepare data to send
        var data = {
            action: 'translator_save_words',
            file: file,
            key: key,
            value: value
        };

        // Set the CSRF field
        data[$('.plugins-page').attr('data-csrf')] = $('.plugins-page').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'plugin-ajax/translator', 'POST', data, 'translator_save_words_response');   

    });
    
    /*
     * Detect new language click button
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.plugins-page .panel-all-languages .translator-plugin-language-save-btn', function (e) {
        e.preventDefault();
        
        // Prepare data to send
        var data = {
            action: 'translator_new_language',
            name: $('.plugins-page .panel-all-languages .translator-plugin-language-name').val()
        };

        // Set the CSRF field
        data[$('.plugins-page').attr('data-csrf')] = $('.plugins-page').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'plugin-ajax/translator', 'POST', data, 'translator_new_language_response');   

    });

    /*
     * Detect delete language click button
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.plugins-page .panel-all-languages .translator-plugin-language-delete-btn', function (e) {
        e.preventDefault();

        // Set language
        $('#translator-plugin-delete-language-modal').attr('data-language', $(this).closest('.translator-plugin-language').attr('data-language'));

        // Show modal
        $('#translator-plugin-delete-language-modal').modal('show'); 

    });

    /*
     * Detect language deletion confirmation
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '#translator-plugin-delete-language-modal .translator-plugin-confirm-language-deletion', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'translator_delete_language',
            language: $('#translator-plugin-delete-language-modal').attr('data-language')
        };

        // Set the CSRF field
        data[$('.plugins-page').attr('data-csrf')] = $('.plugins-page').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'plugin-ajax/translator', 'POST', data, 'translator_delete_language_response');  

    });

    /*
     * Detect language component reload
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.plugins-page .panel-language-files .translator-plugin-reload-language', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'translator_reload_language',
            language: $('.plugins-page .panel-language-files').attr('data-language'),
            component: $(this).attr('href')
        };

        // Set the CSRF field
        data[$('.plugins-page').attr('data-csrf')] = $('.plugins-page').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'plugin-ajax/translator', 'POST', data, 'translator_reload_language_response');  

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
    Main.methods.translator_save_configuration_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };

    /*
     * Display the words save configuration
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.translator_save_words_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Disable the text edit
            Main.this_event.closest('.translator-plugin-word-area').removeClass('translator-plugin-word-area-active').find('.translator-plugin-word').attr('contenteditable', 'false');
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };

    /*
     * Display the new language creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.translator_new_language_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Set pause
            setTimeout(function () {

                // Refresh page
                document.location.href = document.location.href;

            }, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

            // Verify if directories exists
            if ( typeof data.directories !== 'undefined' ) {

                // Directories container
                var directories = '';

                // List all directories
                for ( var d = 0; d < data.directories.length; d++ ) {

                    // Add the directory to the container
                    directories += '<tr>'
                        + '<td>'
                            + '<div class="translator-plugin-word-area">'
                                + '<div class="translator-plugin-word">'
                                    + data.directories[d]
                                + '</div>'
                            + '</div>'
                        + '</td>'
                    + '</tr>';

                }

                // Show the directories
                $('#translator-plugin-new-language-modal table tbody').html(directories);              

                // Show modal
                $('#translator-plugin-new-language-modal').modal('show');

            }
            
        }
        
    };

    /*
     * Display the language deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.translator_delete_language_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Set pause
            setTimeout(function () {

                // Refresh page
                document.location.href = document.location.href;

            }, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

            // Verify if directories exists
            if ( typeof data.directories !== 'undefined' ) {

                // Directories container
                var directories = '';

                // List all directories
                for ( var d = 0; d < data.directories.length; d++ ) {

                    // Add the directory to the container
                    directories += '<tr>'
                        + '<td>'
                            + '<div class="translator-plugin-word-area">'
                                + '<div class="translator-plugin-word">'
                                    + data.directories[d]
                                + '</div>'
                            + '</div>'
                        + '</td>'
                    + '</tr>';

                }

                // Show the directories
                $('#translator-plugin-new-language-modal table tbody').html(directories);              

                // Show modal
                $('#translator-plugin-new-language-modal').modal('show');

            }
            
        }
        
    };

    /*
     * Display the language reload response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.translator_reload_language_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Set pause
            setTimeout(function () {

                // Refresh page
                document.location.href = document.location.href;

            }, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };

    /*******************************
    FORMS
    ********************************/

});