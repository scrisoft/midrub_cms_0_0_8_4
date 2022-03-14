<?php
/**
 * History Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class History
 * with methods to process the broadcasts hitory data
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
 * History class provides the methods to process the broadcasts hitory data
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
*/
class History {
    
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
        
    }

    //-----------------------------------------------------
    // Main class's methods
    //-----------------------------------------------------

    /**
     * The public method load_broadcasts_history loads the broadcasts history
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_broadcasts_history() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $key = $this->CI->input->post('key', TRUE);
            $page = $this->CI->input->post('page', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_no_broadcasts_found')
                );

                // Display the false response
                echo json_encode($data);
                
            } else {

                // If $page is false, set 1
                if (!$page) {
                    $page = 1;
                }

                // Set the limit
                $limit = 10;
                $page--;

                // Use the base model for a simply sql query
                $get_broadcasts = $this->CI->base_model->get_data_where(
                    'ylive_broadcasts',
                    '*',
                    array(
                        'user_id' => $this->CI->user_id
                    ),
                    array(),
                    array('broadcast_title' => $this->CI->db->escape_like_str($key)),
                    array(),
                    array(
                        'order' => array('broadcast_id', 'desc'),
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );

                // Verify if broadcasts exists
                if ( $get_broadcasts ) {

                    // Get total number of broadcasts with base model
                    $total = $this->CI->base_model->get_data_where(
                        'ylive_broadcasts',
                        'COUNT(broadcast_id) AS total',
                        array(
                            'user_id' => $this->CI->user_id
                        ),
                        array(),
                        array('broadcast_title' => $this->CI->db->escape_like_str($key)),
                        array(),
                        array()
                    );

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'broadcasts' => $get_broadcasts,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'details' => $this->CI->lang->line('ylive_details')
                        )
                    );

                    // Display the response
                    echo json_encode($data);

                } else {

                    // Prepare the false response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_no_broadcasts_found')
                    );

                    // Display the false response
                    echo json_encode($data);

                }
                
            }
            
        }
        
    }

}

/* End of file history.php */