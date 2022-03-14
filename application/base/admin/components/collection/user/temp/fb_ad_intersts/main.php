<?php
/**
 * Ad Interests Suggests for Facebook App
 *
 * This file loads the Ad Interests Suggests for Facebook App app
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the page namespace
namespace MidrubBase\User\Apps\Collection\fb_ad_intersts;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS') OR define('MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS', MIDRUB_BASE_USER . 'apps/collection/fb_ad_intersts/');
defined('MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS_VERSION') OR define('MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS_VERSION', '0.0.1');

// Define the namespaces to use
use MidrubBase\User\Interfaces as MidrubBaseUserInterfaces;
use MidrubBase\User\Apps\Collection\fb_ad_intersts\Controllers as MidrubBaseUserAppsCollectionfb_ad_interstsControllers;

/*
 * Main class loads the Ad Interests Suggests for Facebook App app loader
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Main implements MidrubBaseUserInterfaces\Apps {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }

    /**
     * The public method check_availability checks if the app is available
     *
     * @return boolean true or false
     */
    public function check_availability() {

        // Verify if user can use this app
        if ( !get_option('app_fb_ad_intersts_enable') || !plan_feature('app_fb_ad_intersts') || !team_role_permission('fb_ad_intersts') ) {
            return false;
        } else {
            return true;
        }
        
    }
    
    /**
     * The public method user loads the app's main page in the user panel
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function user() {
        
        // Verify if the app is enabled
        if ( !get_option('app_fb_ad_intersts_enable') || !plan_feature('app_fb_ad_intersts') ) {
            show_404();
        }
        
        // Instantiate the class
        (new MidrubBaseUserAppsCollectionfb_ad_interstsControllers\User)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function ajax() {

        // Verify if the app is enabled
        if ( !get_option('app_fb_ad_intersts_enable') || !plan_feature('app_fb_ad_intersts') ) {
            exit();
        }
        
        // Get action's get input
        $action = $this->CI->input->get('action', TRUE);

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {
            
            // Call method if exists
            (new MidrubBaseUserAppsCollectionfb_ad_interstsControllers\Ajax)->$action();
            
        } catch (Exception $ex) {
            
            $data = array(
                'success' => FALSE,
                'message' => $ex->getMessage()
            );
            
            echo json_encode($data);
            
        }
        
    }

    /**
     * The public method rest processes the rest's requests
     * 
     * @param string $endpoint contains the requested endpoint
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function rest($endpoint) {

    }
    
    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function cron_jobs() {
        
    }
    
    /**
     * The public method delete_account is called when user's account is deleted
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function delete_account($user_id) {

        // Require the User Inc
        require_once MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS . 'inc/user.php';

        // Delete all user's records in this app
        delete_user_from_fb_ad_intersts($user_id);
        
    }

    /**
     * The public method hooks contains the app's hooks
     * 
     * @param string $category contains the hooks category
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_hooks( $category ) {

        // Load and run hooks based on category
        switch ( $category ) {

            case 'admin_init':

                // Load the admin language file
                $this->CI->lang->load('fb_ad_intersts_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS);

                // Verify which component is
                if ( ( md_the_component_variable('component') === 'user' ) && ( $this->CI->input->get('app', TRUE) === 'fb_ad_intersts' ) ) {

                    // Require the Admin Inc
                    get_the_file(MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS . 'inc/admin.php');

                } else if ( ( md_the_component_variable('component') === 'user' ) && ( md_the_component_variable('component_display') === 'plans' ) ) {

                    // Require the Plans Inc
                    get_the_file(MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS . 'inc/plans.php');

                }

                break;

            case 'user_init':

                // Load the members language file
                $this->CI->lang->load('fb_ad_intersts_members', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS);                 

                // Verify which component is
                if ( md_the_component_variable('component') === 'team' ) {

                    if ( get_option('app_fb_ad_intersts_enable') && plan_feature('app_fb_ad_intersts') ) {

                        // Require the Permissions Inc
                        get_the_file(MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS . 'inc/members.php');

                    }

                }

                break;

        }

        // Require the General Inc
        get_the_file(MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS . 'inc/general.php');

    }

    /**
     * The public method guest contains the app's access for guests
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function guest() {

        // Show the 404 error
        show_404();

    }
    
    /**
     * The public method app_info contains the app's info
     * 
     * @since 0.0.8.3
     * 
     * @return array with app's information
     */
    public function app_info() {
        
        // Load the app's language files
        $this->CI->lang->load( 'fb_ad_intersts_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS);
        
        // Return app information
        return array(
            'app_name' => $this->CI->lang->line('fb_ad_intersts'),
            'app_slug' => 'fb_ad_intersts',
            'app_icon' => '<i class="fab fa-facebook-square"></i>',
            'version' => MIDRUB_BASE_USER_APPS_FB_AD_INTERESTS_VERSION,
            'update_url' => 'https://update.midrub.com/fb_ad_intersts/',
            'update_code' => TRUE,
            'update_code_url' => 'https://access-codes.midrub.com/',
            'min_version' => '0.0.8.3',
            'max_version' => '0.0.8.3'
        );
        
    }

}

/* End of file main.php */