<?php
/**
 * Commenters Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class Commenters
 * with methods to process the commenters data
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */

// Define the page namespace
namespace MidrubBase\User\Apps\Collection\Ylive\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Commenters class provides the methods to process the commenters data
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
*/
class Commenters {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the yLive Messages Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_APPS_YLIVE . 'models/', 'Ylive_messages_model', 'ylive_messages_model' );
        
    }

    //-----------------------------------------------------
    // Main class's methods
    //-----------------------------------------------------

    /**
     * The public method load_youtube_commenters loads Youtube's commenters
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_youtube_commenters() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $key = $this->CI->input->post('key', TRUE);
            $page = $this->CI->input->post('page', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // If $page is false, set 1
                if (!$page) {
                    $page = 1;
                }

                // Set the limit
                $limit = 10;
                $page--;

                // Gets the commenters based on the saved messages
                $get_commenters = $this->CI->ylive_messages_model->the_youtube_commenters($this->CI->user_id, $page, $limit, $key);

                // Verify if commenters exists
                if ( $get_commenters ) {

                    // Get total commenters
                    $get_total = $this->CI->ylive_messages_model->the_youtube_commenters($this->CI->user_id, $page, '', $key);

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'commenters' => $get_commenters,
                        'total' => $get_total,
                        'page' => ($page + 1),
                        'words' => array(
                            'details' => $this->CI->lang->line('ylive_details')
                        )
                    );

                    // Display the response
                    echo json_encode($data);
                    exit();

                }
                
            }
            
        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_no_commenters_found')
        );

        // Display the false response
        echo json_encode($data);
        
    }

}

/* End of file commenters.php */