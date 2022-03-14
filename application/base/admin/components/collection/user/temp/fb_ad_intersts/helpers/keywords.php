<?php
/**
 * Keywords Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class Keywords
 * with methods to process the keywords data
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
 * Keywords class provides the methods to process the moderation keywords data
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
*/
class Keywords {
    
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
        
        // Load the yLive Keywords Moderation Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_APPS_YLIVE . 'models/', 'Ylive_keywords_moderation_model', 'ylive_keywords_moderation_model' );

        // Load the yLive Messages Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_APPS_YLIVE . 'models/', 'Ylive_messages_model', 'ylive_messages_model' );
        
    }

    //-----------------------------------------------------
    // Main class's methods
    //-----------------------------------------------------
    
    /**
     * The public method save_moderation_keywords saves moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function save_moderation_keywords() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('keywords', 'Keywords', 'trim|required');
            $this->CI->form_validation->set_rules('accuracy', 'Accuracy', 'trim');
            $this->CI->form_validation->set_rules('mode', 'Mode', 'trim');
            $this->CI->form_validation->set_rules('reply', 'Reply', 'trim');

            // Get data
            $keywords = $this->CI->input->post('keywords', TRUE);
            $accuracy = $this->CI->input->post('accuracy', TRUE);
            $mode = $this->CI->input->post('mode', TRUE);
            $reply = $this->CI->input->post('reply', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare no category found message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_please_enter_keyword')
                );

                // Display response
                echo json_encode($data);
                exit();
                
            } else {

                // Verify if accuracy exists
                if ( !is_numeric($accuracy) ) {
                    $accuracy = 100;
                }

                // Verify if the keywords has the reply mode
                if ( $mode === 'reply' ) {

                    // Verify if the reply exists
                    if ( empty($reply) ) {

                        // Prepare no category found message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ylive_keywords_reply_short')
                        );

                        // Display response
                        echo json_encode($data);
                        exit();                        

                    }

                }

                // Try to create the moderation keywords parameters
                $args = array(
                    'user_id' => $this->CI->user_id,
                    'body' => strtolower(trim($keywords)),
                    'accuracy' => $accuracy,
                    'mode' => ($mode === 'reply')?1:0,
                    'reply' => $reply?trim($reply):'',
                    'created' => time()
                );

                // Save moderation keywords parameters by using the Base's Model
                $last_id = $this->CI->base_model->insert('ylive_moderation_keywords', $args);

                // Verify if the message was saved
                if ( $last_id ) {

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('ylive_keywords_were_saved')
                    );

                    // Display success message
                    echo json_encode($data);
                    
                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_keywords_were_not_saved')
                    );

                    // Display error message
                    echo json_encode($data);

                }

                exit();
                
            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_error_occurred')
        );

        // Display error message
        echo json_encode($data);
        
    }

    /**
     * The public method update_moderation_keywords updates moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function update_moderation_keywords() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('keywords_id', 'Keywords ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('keywords', 'Keywords', 'trim|required');
            $this->CI->form_validation->set_rules('accuracy', 'Accuracy', 'trim');
            $this->CI->form_validation->set_rules('mode', 'Mode', 'trim');
            $this->CI->form_validation->set_rules('reply', 'Reply', 'trim');
            $this->CI->form_validation->set_rules('status', 'Status', 'trim');
            $this->CI->form_validation->set_rules('categories', 'Categories', 'trim');

            // Get data
            $keywords_id = $this->CI->input->post('keywords_id', TRUE);
            $keywords = $this->CI->input->post('keywords', TRUE);
            $accuracy = $this->CI->input->post('accuracy', TRUE);
            $mode = $this->CI->input->post('mode', TRUE);
            $reply = $this->CI->input->post('reply', TRUE);
            $status = $this->CI->input->post('status', TRUE);
            $categories = $this->CI->input->post('categories', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare no category found message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_keywords_too_short')
                );

                // Display response
                echo json_encode($data);
                exit();
                
            } else {

                // Verify if the Keywords ID is numeric
                if ( is_numeric($keywords_id) ) {

                    // Use the base model for a simply sql query
                    $get_keywords = $this->CI->base_model->get_data_where(
                        'ylive_moderation_keywords',
                        'keywords_id',
                        array(
                            'keywords_id' => $keywords_id,
                            'user_id' => $this->CI->user_id
                        )
                    );

                    // Verify if the keywords is of the current user
                    if ( $get_keywords ) {

                        // Prepare the keywords's keywords
                        $keywords_body = array(
                            'body' => $keywords
                        );

                        // Verify if accuracy exists
                        if ( is_numeric($accuracy) && ( $accuracy > 9 && $accuracy < 101 ) ) {

                            // Set accuracy
                            $keywords_body['accuracy'] = $accuracy;

                        } else {

                            // Set accuracy
                            $keywords_body['accuracy'] = 100;
                            
                        }

                        // Verify if reply exists
                        if ( $reply ) {

                            // Set reply
                            $keywords_body['reply'] = $reply;                            

                        }

                        // Verify if $mode is 1
                        if ( $mode === 'reply' ) {

                            // Set mode
                            $keywords_body['mode'] = 1; 

                        } else {

                            // Set mode
                            $keywords_body['mode'] = 0; 
                            
                        }

                        // Verify if $status is 1
                        if ( $status === '1' ) {

                            // Set active
                            $keywords_body['active'] = 1; 

                        } else {

                            // Set active
                            $keywords_body['active'] = 0; 
                            
                        }                        

                        // Try to update the moderation keywords
                        $this->CI->base_model->update('ylive_moderation_keywords', array('keywords_id' => $keywords_id), $keywords_body);

                        // Use the base model for a simply sql query
                        $get_updated_keywords = $this->CI->base_model->get_data_where(
                            'ylive_moderation_keywords',
                            '*',
                            array(
                                'keywords_id' => $keywords_id,
                                'user_id' => $this->CI->user_id
                            )
                        );

                        // Very if keywords were updated
                        if ( ($get_updated_keywords[0]['body'] === $keywords_body['body']) && ($get_updated_keywords[0]['accuracy'] === $keywords_body['accuracy']) ) {

                            // Delete the keywords categories
                            $this->CI->base_model->delete('ylive_moderation_keywords_categories', array('keywords_id' => $keywords_id));

                            // Verify if categories exists
                            if ( $categories ) {

                                // Count categories
                                $count = 0;

                                // List all categories
                                foreach ($categories as $category_id) {

                                    // Use the base model to verify if user is the owner of the category
                                    $get_category = $this->CI->base_model->get_data_where(
                                        'ylive_categories',
                                        '*',
                                        array(
                                            'category_id' => $category_id,
                                            'user_id' => $this->CI->user_id
                                        )
                                    );

                                    // Verify if the category and user exists
                                    if ( $get_category ) {

                                        // Prepare the Category
                                        $category = array(
                                            'keywords_id' => $keywords_id,
                                            'category_id' => $category_id
                                        );

                                        // Save the Category
                                        if ($this->CI->base_model->insert('ylive_moderation_keywords_categories', $category)) {
                                            $count++;
                                        }

                                    }

                                }

                                // Verify if all categories were saved
                                if (count($categories) > $count) {

                                    // Prepare the error message
                                    $data = array(
                                        'success' => FALSE,
                                        'message' => $this->CI->lang->line('ylive_keywords_was_updated_successfully_without_categories')
                                    );

                                    // Display error message
                                    echo json_encode($data);
                                    exit();
                                    
                                }

                            }

                            // Prepare the success message
                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('ylive_keywords_were_updated_successfully')
                            );

                            // Display success message
                            echo json_encode($data);

                        } else {

                            // Prepare the error message
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('ylive_keywords_were_not_updated_successfully')
                            );

                            // Display error message
                            echo json_encode($data);

                        }

                    } else {

                        // Prepare the error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ylive_keywords_id_missing')
                        );

                        // Display error message
                        echo json_encode($data);

                    }
                    
                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_keywords_id_missing')
                    );

                    // Display error message
                    echo json_encode($data);

                }

                exit();
                
            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_error_occurred')
        );

        // Display error message
        echo json_encode($data);
        
    }

    /**
     * The public method load_keywords loads keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function load_keywords() {

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
                    'message' => $this->CI->lang->line('ylive_no_keywords_found')
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
                $get_keywords = $this->CI->base_model->get_data_where(
                    'ylive_moderation_keywords',
                    'keywords_id, body',
                    array(
                        'user_id' => $this->CI->user_id
                    ),
                    array(),
                    array('body' => $this->CI->db->escape_like_str($key)),
                    array(),
                    array(
                        'order' => array('keywords_id', 'desc'),
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );

                // Verify if keywords exists
                if ( $get_keywords ) {

                    // Get total number of keywords with base model
                    $total = $this->CI->base_model->get_data_where(
                        'ylive_moderation_keywords',
                        'COUNT(keywords_id) AS total',
                        array(
                            'user_id' => $this->CI->user_id
                        ),
                        array(),
                        array('body' => $this->CI->db->escape_like_str($key)),
                        array(),
                        array()
                    );

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'keywords' => $get_keywords,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1)
                    );

                    // Display the response
                    echo json_encode($data);

                } else {

                    // Prepare the false response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_no_keywords_found')
                    );

                    // Display the false response
                    echo json_encode($data);

                }
                
            }
            
        }
        
    }

    /**
     * The public method check_for_moderation_keywords verifies if user has moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function check_for_moderation_keywords() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Use the base model for a simply sql query
            $get_moderation_keywords = $this->CI->base_model->get_data_where(
                'ylive_moderation_keywords',
                'keywords_id, body',
                array(
                    'user_id' => $this->CI->user_id
                )
            );

            // Verify if moderation keywords exists
            if ($get_moderation_keywords) {

                // Prepare the response
                $data = array(
                    'success' => TRUE
                );

                // Display the response
                echo json_encode($data);

            } else {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_no_keywords_found')
                );

                // Display the false response
                echo json_encode($data);

            }
            
        }
        
    }

    /**
     * The public method delete_moderation_keywords deletes moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function delete_moderation_keywords() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('keywords', 'Keywords', 'trim');
            
            // Get data
            $keywords = $this->CI->input->post('keywords');

            // Verify if request is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Default count
                $count = 0;

                // List all keywords
                foreach ( $keywords as $keyword ) {

                    // Verify if the keywords id is numeric
                    if (is_numeric($keyword[1])) {

                        // Try to delete keyword
                        if ( $this->CI->base_model->delete('ylive_moderation_keywords', array('keywords_id' => $keyword[1], 'user_id' => $this->CI->user_id)) ) {

                            // Delete all moderation keyword's records
                            run_hook(
                                'delete_moderation_keywords',
                                array(
                                    'keywords_id' => $keyword[1]
                                )

                            );

                            // Increase count
                            $count++;

                        }

                    }

                }

                // Verify if at least one keyword were deleted
                if ( $count ) {
                    
                    // Prepare success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $count . $this->CI->lang->line('ylive_moderation_keywords_were_deleted')
                    );

                    // Display success response
                    echo json_encode($data);

                } else {

                    // Prepare error response
                    $data = array(
                        'success' => FALSE,
                        'message' => '0' . $this->CI->lang->line('ylive_moderation_keywords_were_not_deleted')
                    );

                    // Display error response
                    echo json_encode($data);

                }
                
                exit();
                
            }
            
        }

        // Prepare error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_error_occurred')
        );

        // Display error response
        echo json_encode($data);
        
    }

    /**
     * The public method get_replied_messages loads the replied messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_replied_messages() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('keywords_id', 'Keywords ID', 'trim|integer|numeric');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $keywords_id = $this->CI->input->post('keywords_id', TRUE);
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

                // Use the base model for a simply sql query
                $get_messages = $this->CI->base_model->get_data_where(
                    'ylive_messages',
                    '*',
                    array(
                        'user_id' => $this->CI->user_id,
                        'keywords_id' => $keywords_id,
                        'status' => 1
                    ),
                    array(),
                    array(),
                    array(),
                    array(
                        'order' => array('message_id', 'desc'),
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );

                // Verify if messages exists
                if ( $get_messages ) {

                    // Get total number of messages with base model
                    $total = $this->CI->base_model->get_data_where(
                        'ylive_messages',
                        'COUNT(message_id) AS total',
                        array(
                            'user_id' => $this->CI->user_id,
                            'keywords_id' => $keywords_id,
                            'status' => 1
                        )
                    );

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'messages' => $get_messages,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'created' => time()
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
            'message' => $this->CI->lang->line('ylive_no_messages_found')
        );

        // Display the false response
        echo json_encode($data);
        
    }

    /**
     * The public method get_deleted_messages loads the deleted messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_deleted_messages() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('keywords_id', 'Keywords ID', 'trim|integer|numeric');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $keywords_id = $this->CI->input->post('keywords_id', TRUE);
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

                // Use the base model for a simply sql query
                $get_messages = $this->CI->base_model->get_data_where(
                    'ylive_messages',
                    '*',
                    array(
                        'user_id' => $this->CI->user_id,
                        'keywords_id' => $keywords_id,
                        'status' => 2
                    ),
                    array(),
                    array(),
                    array(),
                    array(
                        'order' => array('message_id', 'desc'),
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );

                // Verify if messages exists
                if ( $get_messages ) {

                    // Get total number of messages with base model
                    $total = $this->CI->base_model->get_data_where(
                        'ylive_messages',
                        'COUNT(message_id) AS total',
                        array(
                            'user_id' => $this->CI->user_id,
                            'keywords_id' => $keywords_id,
                            'status' => 2
                        )
                    );

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'messages' => $get_messages,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'created' => time()
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
            'message' => $this->CI->lang->line('ylive_no_messages_found')
        );

        // Display the false response
        echo json_encode($data);
        
    }

    /**
     * The public method get_keywords_commenters loads the commenters
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_keywords_commenters() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('keywords_id', 'Keywords ID', 'trim|integer|numeric');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $keywords_id = $this->CI->input->post('keywords_id', TRUE);
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
                $get_commenters = $this->CI->ylive_messages_model->the_keywords_commenters($keywords_id, $this->CI->user_id, $page, $limit);

                // Verify if commenters exists
                if ( $get_commenters ) {

                    // Get total commenters
                    $get_total = $this->CI->ylive_messages_model->the_keywords_commenters($keywords_id, $this->CI->user_id, $page);

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

    /**
     * The public method get_keywords_activity_graph loads the keywords activity
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_keywords_activity_graph() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('keywords_id', 'Keywords ID', 'trim|integer|numeric');

            // Get data
            $keywords_id = $this->CI->input->post('keywords_id', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Loads reply's activity for graph
                $activities = $this->CI->ylive_messages_model->keywords_activity_graph($this->CI->user_id, $keywords_id);

                // Verify if activity exists
                if ( $activities ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'activities' => $activities,
                        'words' => array(
                            'received_messages' => $this->CI->lang->line('ylive_number_received_messages')
                        )
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'words' => array(
                'received_messages' => $this->CI->lang->line('ylive_number_received_messages')
            )
        );

        // Display the false response
        echo json_encode($data);
        
    }

}

/* End of file keywords.php */