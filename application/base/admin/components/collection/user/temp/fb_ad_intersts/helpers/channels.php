<?php
/**
 * Channels Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class Channels
 * with methods to process the channels data
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
 * Channels class provides the methods to process the channels data
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
*/
class Channels {
    
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
        
        // Load the yLive Channels Meta Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_APPS_YLIVE . 'models/', 'Ylive_channels_meta_model', 'ylive_channels_meta_model' );
        
    }

    //-----------------------------------------------------
    // Main class's methods
    //-----------------------------------------------------

    /**
     * The public method load_all_connected_channels search for connected channels
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_all_connected_channels() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');

            // Get data
            $key = $this->CI->input->post('key', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_no_channels_found')
                );

                // Display the false response
                echo json_encode($data);
                exit();
                
            } else {

                // Use the base model for a simply sql query
                $get_channels = $this->CI->base_model->get_data_where(
                    'networks',
                    'network_id, user_name',
                    array(
                        'network_name' => 'youtube',
                        'user_id' => $this->CI->user_id
                    ),
                    array(),
                    array('user_name' => $this->CI->db->escape_like_str($key))
                );

                // Verify if channels exists
                if ( $get_channels ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'channels' => $get_channels
                    );                    

                    // Display the response
                    echo json_encode($data);

                } else {

                    // Prepare the false response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_no_channels_found')
                    );

                    // Display the false response
                    echo json_encode($data);

                }
                
            }
            
        }
        
    }

    /**
     * The public method load_connected_channels loads channels by page and search key
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_connected_channels() {

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
                    'message' => $this->CI->lang->line('ylive_no_channels_found')
                );

                // Display the false response
                echo json_encode($data);
                exit();
                
            } else {

                // If $page is false, set 1
                if (!$page) {
                    $page = 1;
                }

                // Set the limit
                $limit = 10;
                $page--;

                // Use the base model for a simply sql query
                $get_channels = $this->CI->base_model->get_data_where(
                    'networks',
                    'network_id, net_id, user_name, user_avatar, secret',
                    array(
                        'network_name' => 'youtube',
                        'user_id' => $this->CI->user_id
                    ),
                    array(),
                    array('user_name' => $this->CI->db->escape_like_str($key)),
                    array(),
                    array(
                        'order' => array('network_id', 'desc'),
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );

                // Verify if channels exists
                if ( $get_channels ) {

                    // Use the base model for a simply sql query
                    $total = $this->CI->base_model->get_data_where(
                        'networks',
                        'COUNT(network_id) AS total',
                        array(
                            'network_name' => 'youtube',
                            'user_id' => $this->CI->user_id
                        ),
                        array(),
                        array('user_name' => $this->CI->db->escape_like_str($key))
                    );

                    // Channels variable
                    $channels = array();

                    // List all channels
                    foreach ( $get_channels as $channel ) {

                        $channels[] = array(
                            'network_id' => $channel['network_id'],
                            'user_name' => $channel['user_name'],
                            'user_picture' => $channel['user_avatar'],
                            'access_token' => $channel['secret']
                        );

                    } 

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'channels' => $channels,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'connect' => $this->CI->lang->line('ylive_connect')
                        )
                    );                    

                    // Display the response
                    echo json_encode($data);

                } else {

                    // Prepare the false response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_no_channels_found')
                    );

                    // Display the false response
                    echo json_encode($data);

                }
                
            }
            
        }
        
    }

    /**
     * The public method account_manager_delete_accounts deletes a Youtube Channel
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function account_manager_delete_accounts() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('channel_id', 'Channel ID', 'trim|numeric|required');     

            // Get data
            $channel_id = $this->CI->input->post('channel_id', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_no_channel_found')
                );

                // Display the false response
                echo json_encode($data);
                
            } else {

                // Use the base model to verify if user is the owner of the channel
                $get_channel = $this->CI->base_model->get_data_where(
                    'networks',
                    '*',
                    array(
                        'network_id' => $channel_id,
                        'network_name' => 'youtube',
                        'user_id' => $this->CI->user_id
                    )
                );

                // Verify if the channel exists
                if ( $get_channel ) { 

                    // Try to delete the channel
                    if ( $this->CI->base_model->delete('networks', array('network_id' => $channel_id) ) ) {

                        // Delete all channel's records
                        run_hook(
                            'delete_network_account',
                            array(
                                'account_id' => $channel_id
                            )

                        );

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('ylive_channel_was_deleted')
                        );

                        // Display the success response
                        echo json_encode($data);

                    } else {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ylive_channel_was_not_deleted')
                        );

                        // Display the error response
                        echo json_encode($data);

                    }

                    exit();

                }

            }

        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_error_occurred')
        );

        // Display the error response
        echo json_encode($data);

    }

    /**
     * The public method connect_youtube_channel gets the Channel's configuration
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function connect_youtube_channel() {

        // Get channel's ID
        $channel_id = $this->CI->input->get('channel_id', TRUE);

        // If channel's ID is numeric
        if ( is_numeric($channel_id) ) {

            // Use the base model to verify if user is the owner of the channel
            $get_channel = $this->CI->base_model->get_data_where(
                'networks',
                '*',
                array(
                    'network_id' => $channel_id,
                    'network_name' => 'youtube',
                    'user_id' => $this->CI->user_id
                )
            );

            // Verify if the channel exists
            if ( $get_channel ) {

                // Use the base model to get the channel's subscription
                $get_channel_subscription = $this->CI->base_model->get_data_where(
                    'ylive_channels_meta',
                    '*',
                    array(
                        'channel_id' => $channel_id,
                        'meta_name' => 'subscribed',
                    )
                );

                // Prepare the success response
                $data = array(
                    'success' => TRUE,
                    'network_id' => $channel_id,
                    'subscribed' => false
                );

                // Verify if the channel is subscribed to the bot
                if ( $get_channel_subscription ) {

                    // Set true for subscribed
                    $data['subscribed'] = true;

                }

                // Use the base model to get all Youtube Channels categories
                $categories = $this->CI->base_model->get_data_where(
                    'ylive_channels_categories',
                    '*',
                    array(
                        'channel_id' => $channel_id
                    )
                );

                // If categories exists add them to array
                if ( $categories ) {

                    // Set categories
                    $data['categories'] = $categories;

                }

                // Display the success response
                echo json_encode($data); 
                exit();
            
            } else {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_no_channel_found')
                );

                // Display the false response
                echo json_encode($data);

            }

        } else {

            // Prepare the false response
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('ylive_no_channel_found')
            );

            // Display the false response
            echo json_encode($data);

        }
        
    }

    /**
     * The public method connect_to_bot connects/disconects Youtube Channel to bot
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function connect_to_bot() {

        // Get channel's ID
        $channel_id = $this->CI->input->get('channel_id', TRUE);

        // If channel's ID is numeric
        if ( is_numeric($channel_id) ) {

            // Use the base model to get the channel
            $get_channel = $this->CI->base_model->get_data_where(
                'networks',
                '*',
                array(
                    'network_id' => $channel_id,
                    'network_name' => 'youtube',
                    'user_id' => $this->CI->user_id
                )
            );

            // Verify if the channel exists
            if ( $get_channel ) {

                // Use the base model to get the channel's subscription
                $get_channel_subscription = $this->CI->base_model->get_data_where(
                    'ylive_channels_meta',
                    '*',
                    array(
                        'channel_id' => $channel_id,
                        'meta_name' => 'subscribed',
                    )
                );

                // Verify if the channel has subscription
                if ( $get_channel_subscription ) {

                    // Try to delete the channel's subscription
                    if ( $this->CI->base_model->delete('ylive_channels_meta', array('channel_id' => $channel_id, 'meta_name' => 'subscribed') ) ) {

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('ylive_channel_was_subscribed')
                        );

                        // Display the success response
                        echo json_encode($data);

                    } else {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ylive_channel_was_not_subscribed')
                        );

                        // Display the error response
                        echo json_encode($data);

                    }

                } else {

                    // Channel data
                    $channel_data = array(
                        'user_id' => $this->CI->user_id,
                        'channel_id' => $channel_id,
                        'meta_name' => 'subscribed',
                        'meta_value' => 1
                    );

                    // Save the subscription by using the basic model
                    if ( $this->CI->base_model->insert('ylive_channels_meta', $channel_data) ) {

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('ylive_channel_was_subscribed')
                        );

                        // Display the success response
                        echo json_encode($data); 

                    } else {

                        // Prepare the false response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ylive_channel_was_not_subscribed')
                        );

                        // Display the false response
                        echo json_encode($data);                    

                    }

                }

                exit();

            } else {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_channel_was_not_found')
                );

                // Display the false response
                echo json_encode($data);

            }

        } else {

            // Prepare the false response
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('ylive_channel_was_not_found')
            );

            // Display the false response
            echo json_encode($data);

        }
        
    }

    /**
     * The public method select_youtube_channel_category select a Youtube Channel category
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function select_youtube_channel_category() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('channel_id', 'Channel ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('category_id', 'Category ID', 'trim|numeric|required');

            // Get data
            $channel_id = $this->CI->input->post('channel_id', TRUE);
            $category_id = $this->CI->input->post('category_id', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_channel_or_category_wrong')
                );

                // Display the false response
                echo json_encode($data);
                
            } else {

                // Use the base model to verify if user is the owner of the page
                $get_page = $this->CI->base_model->get_data_where(
                    'networks',
                    '*',
                    array(
                        'network_id' => $channel_id,
                        'network_name' => 'youtube',
                        'user_id' => $this->CI->user_id
                    )
                );

                // Verify if user is owner of the Facebook Page
                if ( $get_page ) {

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

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'category_id' => $category_id
                        );

                        // Display the success response
                        echo json_encode($data);

                    } else {

                        // Prepare the false response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ylive_you_are_not_owner_category')
                        );

                        // Display the false response
                        echo json_encode($data);
                        
                    }

                } else {

                    // Prepare the false response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_you_are_not_owner')
                    );

                    // Display the false response
                    echo json_encode($data);

                } 

            }

        }
        
    }

    /**
     * The public method save_channel_configuration saves a Youtube Channel configuration
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function save_channel_configuration() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('channel_id', 'Channel ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('categories', 'Categories', 'trim');        

            // Get data
            $channel_id = $this->CI->input->post('channel_id', TRUE);
            $categories = $this->CI->input->post('categories', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_no_channel_found')
                );

                // Display the false response
                echo json_encode($data);
                
            } else {

                // Use the base model to verify if user is the owner of the channel
                $get_channel = $this->CI->base_model->get_data_where(
                    'networks',
                    '*',
                    array(
                        'network_id' => $channel_id,
                        'network_name' => 'youtube',
                        'user_id' => $this->CI->user_id
                    )
                );

                // Verify if the channel exists
                if ( $get_channel ) {

                    // Delete Youtube Channels categories
                    $this->CI->base_model->delete('ylive_channels_categories', array('channel_id' => $channel_id));

                    // Set count
                    $count = 0;

                    // Set uncount
                    $uncount = 0;

                    // Verify if categories exists
                    if ( $categories ) {

                        // List all categories
                        foreach ( $categories as $category_id ) {

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
                            if ($get_category) {


                                // Prepare the Category
                                $category = array(
                                    'channel_id' => $channel_id,
                                    'category_id' => $category_id
                                );

                                // Save the Category
                                if ( $this->CI->base_model->insert('ylive_channels_categories', $category) ) {
                                    $count++;
                                } else {
                                    $uncount++;
                                }

                            }

                        }

                    }

                    if ( ( $count > 0 ) && ( $uncount > 0 ) ) {

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('ylive_changes_saved_successfully_but_error_occurred')
                        );

                        // Display the success response
                        echo json_encode($data);

                    } else if ( ( $count > 0 ) && ( $uncount === 0 ) ) {

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('ylive_changes_saved_successfully')
                        );

                        // Display the success response
                        echo json_encode($data);

                    } else if ( ( $count < 1 ) && ( $uncount > 1 ) ) {

                        // Prepare the false response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ylive_changes_not_saved_successfully')
                        );

                        // Display the false response
                        echo json_encode($data);

                    } else {

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('ylive_changes_saved_successfully')
                        );

                        // Display the success response
                        echo json_encode($data);
                        
                    }

                } else {

                    // Prepare the false response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_you_are_not_owner')
                    );

                    // Display the false response
                    echo json_encode($data);

                } 

            }

        }
        
    }

}

/* End of file channels.php */