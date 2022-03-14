<?php
/**
 * User Controller
 *
 * This file loads the yLive app in the user panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */

// Define the page namespace
namespace MidrubBase\User\Apps\Collection\yLive\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class loads the yLive app loader
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI, $networks = array();

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
        
        // Load language
        $this->CI->lang->load( 'ylive_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_APPS_YLIVE);
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function view() {

        // Set the page's title
        set_the_title($this->CI->lang->line('ylive'));

        // Set yLive styles
        set_css_urls(array('stylesheet', base_url('assets/base/user/apps/collection/ylive/styles/css/styles.css?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION), 'text/css', 'all'));

        // Verify if is not the main app's page
        if ( $this->CI->input->get('p', TRUE) ) {

            // Display page
            switch ( $this->CI->input->get('p', TRUE) ) {

                case 'channels':

                    // Set yLive Channels Js
                    set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/channels.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

                    // Set views params
                    set_user_view(

                        $this->CI->load->ext_view(
                            MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                            'channels',
                            array(),
                            true
                        )

                    );

                    break;

                case 'moderation':

                    // Verify if moderation keywords's ID exists
                    if ( is_numeric($this->CI->input->get('keywords', TRUE) ) ) {

                        // Set Chart JS
                        set_js_urls(array('//www.chartjs.org/dist/2.7.2/Chart.js'));

                        // Set Utils JS
                        set_js_urls(array('//www.chartjs.org/samples/latest/utils.js'));

                        // Set yLive Moderation Keywords JavaScript file
                        set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/keywords.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

                        // Use the base model for a simply sql query
                        $get_keywords = $this->CI->base_model->get_data_where(
                            'ylive_moderation_keywords',
                            'body AS keywords, accuracy, mode, reply, active',
                            array(
                                'keywords_id' => $this->CI->input->get('keywords', TRUE),
                                'user_id' => $this->CI->user_id
                            )
                        );

                        // If keywords missing, show 404
                        if (!$get_keywords) {

                            // Display 404 page
                            show_404();
                        }

                        // Params to pass to view
                        $params = array();

                        // Set keywords's ID
                        $params['keywords_id'] = $this->CI->input->get('keywords', TRUE);

                        // Set keywords
                        $params['keywords'] = $get_keywords[0]['keywords'];

                        // Set accuracy
                        $params['accuracy'] = $get_keywords[0]['accuracy'];

                        // Set mode
                        $params['mode'] = $get_keywords[0]['mode'];

                        // Set reply
                        $params['reply'] = $get_keywords[0]['reply'];

                        // Set status
                        $params['active'] = $get_keywords[0]['active'];

                        // Use the base model for a simply sql query
                        $get_categories = $this->CI->base_model->get_data_where(
                            'ylive_moderation_keywords_categories',
                            'ylive_categories.category_id, ylive_categories.name',
                            array(
                                'ylive_moderation_keywords_categories.keywords_id' => $this->CI->input->get('keywords', TRUE)
                            ),
                            array(),
                            array(),
                            array(array(
                                'table' => 'ylive_categories',
                                'condition' => 'ylive_moderation_keywords_categories.category_id=ylive_categories.category_id',
                                'join_from' => 'LEFT'
                            ))
                        );

                        // Verify if categories exists
                        if ( $get_categories ) {
                            $params['categories'] = $get_categories;
                        }

                        // Set views params
                        set_user_view(

                            $this->CI->load->ext_view(
                                MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                                'keywords',
                                $params,
                                true
                            )

                        );
                        
                    } else {

                        // Set yLive's Keywords Js
                        set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/moderation.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

                        // Set views params
                        set_user_view(

                            $this->CI->load->ext_view(
                                MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                                'moderation',
                                array(),
                                true
                            )

                        );

                    }

                    break; 
            
                case 'commenters':

                    // Verify if commenter's ID exists
                    if ( $this->CI->input->get('commenter', TRUE) ) {

                        // Set yLive's Commenter Js
                        set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/commenter.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

                        // Get commenter from the database
                        $get_commenter = $this->CI->base_model->get_data_where(
                            'ylive_messages',
                            '*',
                            array(
                                  'net_id' => $this->CI->input->get('commenter', TRUE),
                                  'user_id' => $this->CI->user_id
                            )
                        );
                        
                        // Verify if the commenter exists
                        if ( !$get_commenter ) {
                         
                            // Display 404 page
                            show_404();
                            
                        }

                        // Params to pass to view
                        $params = array(
                            'commenter_id' => $this->CI->input->get('commenter', TRUE),
                            'name' => $get_commenter[0]['user_name'],
                            'image' => $get_commenter[0]['image']
                        );

                        // Set views params
                        set_user_view(

                            $this->CI->load->ext_view(
                                MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                                'commenter',
                                $params,
                                true
                            )

                        );
                        

                    } else {

                        // Set yLive's Commenters Js
                        set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/commenters.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

                        // Set views params
                        set_user_view(

                            $this->CI->load->ext_view(
                                MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                                'commenters',
                                array(),
                                true
                            )

                        );

                    }

                    break; 

                case 'history':
                    
                    // Verify if moderation broadcast's ID exists
                    if ( is_numeric($this->CI->input->get('broadcast', TRUE) ) ) {

                        // Set yLive's Broadcast Js
                        set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/broadcast.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));
                        
                        // Get broadcast from the database
                        $get_broadcast = $this->CI->base_model->get_data_where(
                            'ylive_broadcasts',
                            '*',
                            array(
                                  'broadcast_id' => $this->CI->input->get('broadcast', TRUE),
                                  'user_id' => $this->CI->user_id
                            )
                       );
                        
                        // Verify if the broadcast exists
                        if ( !$get_broadcast ) {
                         
                            // Display 404 page
                            show_404();
                            
                        }
                        
                        // Params to pass to view
                        $params = array();
                        
                        // Get messages
                        $get_messages = $this->CI->base_model->get_data_where(
                            'ylive_messages',
                            '*',
                            array(
                                 'user_id' => $this->CI->user_id,
                                 'extra' => $get_broadcast[0]['net_id']
                             )
                        );
                        
                        // Verify if messages exists
                        if ( $get_messages ) {
                            
                            // List all messages
                            foreach ( $get_messages as $get_message ) {
                                
                                // Verify if is a deleted message
                                if ( (int)$get_message['status'] === 2 ) {
                                    
                                    // Verify if $params has deleted messages
                                    if ( !isset($params['deleted_messages']) ) {
                                        
                                        // Set deleted messages
                                        $params['deleted_messages'] = array();
                                        
                                    }
                                    
                                    // Set the message as deleted
                                    $params['deleted_messages'][] = $get_message;
                                    
                                } else if ( (int)$get_message['status'] === 1 ) {
                                    
                                    // Verify if $params has replied messages
                                    if ( !isset($params['replied_messages']) ) {
                                        
                                        // Set replied messages
                                        $params['replied_messages'] = array();
                                        
                                    }
                                    
                                    // Set the message as replied
                                    $params['replied_messages'][] = $get_message;
                                    
                                } else {
                                    
                                    // Verify if $params has new messages
                                    if ( !isset($params['new_messages']) ) {
                                        
                                        // Set new messages
                                        $params['new_messages'] = array();
                                        
                                    }
                                    
                                    // Set the message as new
                                    $params['new_messages'][] = $get_message;
                                    
                                }
                                
                            }
                            
                        }
                        
                        // Set views params
                        set_user_view(
                            
                            $this->CI->load->ext_view(
                                MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                                'broadcast',
                                $params,
                                true
                            )

                        );
                        
                    } else {

                        // Set yLive's History Js
                        set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/history.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

                        // Set views params
                        set_user_view(

                            $this->CI->load->ext_view(
                                MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                                'history',
                                array(),
                                true
                            )

                        );
                        
                    }

                    break; 

                case 'statistics':

                    // Set Chart JS
                    set_js_urls(array('//www.chartjs.org/dist/2.7.2/Chart.js'));

                    // Set Utils JS
                    set_js_urls(array('//www.chartjs.org/samples/latest/utils.js'));
                    
                    // Set yLive's Statistics JavaScript Js
                    set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/statistics.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

                    // Params to pass to view
                    $params = array(); 
                    
                    // Use the base model to get the Youtube count
                    $youtube = $this->CI->base_model->get_data_where(
                        'networks',
                        'COUNT(network_id) AS total',
                        array(
                            'network_name' => 'youtube',
                            'user_id' => $this->CI->user_id
                        )
                    );

                    // Verify if Youtube Channels exists
                    if ( $youtube ) {

                        // Set number of channels
                        $params['total_channels'] = $youtube[0]['total'];

                    } else {

                        // Set number of channels
                        $params['total_channels'] = 0;                        

                    }

                    // Set number of commenters
                    $params['total_commenters'] = $this->CI->ylive_messages_model->the_youtube_commenters($this->CI->user_id, 0, '', '');

                    // Get total number of messages with base model
                    $messages = $this->CI->base_model->get_data_where(
                        'ylive_messages',
                        'COUNT(message_id) AS total',
                        array(
                            'user_id' => $this->CI->user_id
                        )
                    );

                    // Verify if messages exists
                    if ( $messages ) {

                        // Set number of messages
                        $params['total_messages'] = $messages[0]['total'];

                    } else {

                        // Set default number of messages
                        $params['total_messages'] = 0;                        

                    } 

                    // Set views params
                    set_user_view(

                        $this->CI->load->ext_view(
                            MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                            'statistics',
                            $params,
                            true
                        )

                    );

                    break;                    

                default:

                    // Display 404 page
                    show_404();
                
                    break;

            }

        } else {

            // Set Main JS file
            set_js_urls(array(base_url('assets/base/user/apps/collection/ylive/js/main.js?ver=' . MIDRUB_BASE_USER_APPS_YLIVE_VERSION)));

            // Set views params
            set_user_view(

                $this->CI->load->ext_view(
                    MIDRUB_BASE_USER_APPS_YLIVE . 'views',
                    'main',
                    array(),
                    true
                )

            );

        }
        
    }

}

/* End of file user.php */