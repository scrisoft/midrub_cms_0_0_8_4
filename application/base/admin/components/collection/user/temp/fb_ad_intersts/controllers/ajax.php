<?php
/**
 * Ajax Controller
 *
 * This file processes the app's ajax calls
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */

// Define the page namespace
namespace MidrubBase\User\Apps\Collection\Ylive\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\User\Apps\Collection\Ylive\Helpers as MidrubBaseUserAppsCollectionYliveHelpers;

/*
 * Ajax class processes the app's ajax calls
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */
class Ajax {
    
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

        // Load language
        $this->CI->lang->load( 'ylive_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_APPS_YLIVE);
        
    }

    /**
     * The public method load_all_connected_channels search for connected channels
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_all_connected_channels() {

        // Search for Channels
        (new MidrubBaseUserAppsCollectionYliveHelpers\Channels)->load_all_connected_channels();

    }

    /**
     * The public method load_connected_channels loads channels by page and search key
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_connected_channels() {

        // Load Channels
        (new MidrubBaseUserAppsCollectionYliveHelpers\Channels)->load_connected_channels();

    }

    /**
     * The public method account_manager_delete_accounts deletes a Youtube Channel
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function account_manager_delete_accounts() {

        // Deletes Youtube Channels
        (new MidrubBaseUserAppsCollectionYliveHelpers\Channels)->account_manager_delete_accounts();

    }

    /**
     * The public method connect_youtube_channel gets the Channel's configuration
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function connect_youtube_channel() {

        // Connect a Youtube Channel
        (new MidrubBaseUserAppsCollectionYliveHelpers\Channels)->connect_youtube_channel();

    }

    /**
     * The public method connect_to_bot connects Youtube Channel to bot
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function connect_to_bot() {

        // Connects Youtube Channel to bot
        (new MidrubBaseUserAppsCollectionYliveHelpers\Channels)->connect_to_bot();

    }

    /**
     * The public method select_youtube_channel_category select a Youtube Channel category
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function select_youtube_channel_category() {

        // Selects Youtube Channel category
        (new MidrubBaseUserAppsCollectionYliveHelpers\Channels)->select_youtube_channel_category();

    }

    /**
     * The public method save_channel_configuration saves a Youtube Channel configuration
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function save_channel_configuration() {

        // Save Youtube Channel configuration
        (new MidrubBaseUserAppsCollectionYliveHelpers\Channels)->save_channel_configuration();

    }

    /**
     * The public method save_moderation_keywords saves moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function save_moderation_keywords() {

        // Save moderation keywords
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->save_moderation_keywords();

    }

    /**
     * The public method update_moderation_keywords udates a moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function update_moderation_keywords() {

        // Update moderation keywords
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->update_moderation_keywords();

    }

    /**
     * The public method delete_moderation_keywords deletes moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function delete_moderation_keywords() {

        // Delete moderation keywords
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->delete_moderation_keywords();

    }

    /**
     * The public method load_keywords loads keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_keywords() {

        // Loads keywords
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->load_keywords();

    }

    /**
     * The public method check_for_moderation_keywords verifies if user has moderation keywords
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function check_for_moderation_keywords() {

        // Verifies if user has moderation keywords
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->check_for_moderation_keywords();

    }

    /**
     * The public method get_replied_messages loads the replied messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_replied_messages() {

        // Loads replied messages
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->get_replied_messages();

    }

    /**
     * The public method get_deleted_messages loads the deleted messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_deleted_messages() {

        // Loads deleted messages
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->get_deleted_messages();

    }

    /**
     * The public method get_keywords_commenters loads the commenters
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_keywords_commenters() {

        // Loads commenters
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->get_keywords_commenters();

    }

    /**
     * The public method get_keywords_activity_graph loads the keywords activity
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_keywords_activity_graph() {

        // Loads activity
        (new MidrubBaseUserAppsCollectionYliveHelpers\Keywords)->get_keywords_activity_graph();

    }

    /**
     * The public method load_youtube_commenters loads Youtube's commenters
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_youtube_commenters() {

        // Loads commenters
        (new MidrubBaseUserAppsCollectionYliveHelpers\Commenters)->load_youtube_commenters();

    }
    

    /**
     * The public method create_category creates a category
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function create_category() {

        // Creates a category
        (new MidrubBaseUserAppsCollectionYliveHelpers\Categories)->create_category();

    }

    /**
     * The public method get_categories_by_page gets categories by page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_categories_by_page() {

        // Gets categories
        (new MidrubBaseUserAppsCollectionYliveHelpers\Categories)->get_categories_by_page();

    }

    /**
     * The public method get_all_categories gets all categories
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_all_categories() {

        // Gets all categories
        (new MidrubBaseUserAppsCollectionYliveHelpers\Categories)->get_all_categories();

    }    

    /**
     * The public method delete_category deletes a category
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function delete_category() {

        // Deletes a category
        (new MidrubBaseUserAppsCollectionYliveHelpers\Categories)->delete_category();

    }

    /**
     * The public method load_messages loads messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_messages() {
        
        // Loads messages
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->load_messages();
        
    }

    /**
     * The public method get_live_messages gets messages for live videos
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_live_messages() {
        
        // Get messages
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->get_live_messages();
        
    }

    /**
     * The public method dreply_live_messages replies to live videos messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function reply_live_messages() {
        
        // Reply message
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->reply_live_messages();
        
    }

    /**
     * The public method delete_live_messages deletes live videos messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function delete_live_messages() {
        
        // Delete message
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->delete_live_messages();
        
    }

    /**
     * The public method get_all_commenter_messages gets commenter's messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_all_commenter_messages() {
        
        // Load messages
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->get_all_commenter_messages();
        
    }

    /**
     * The public method messages_for_graph returns messages for graph
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function messages_for_graph() {

        // Load messages for graph
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->messages_for_graph();

    }

    /**
     * The public method dashboard_messages_for_graph returns messages for graph
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function dashboard_messages_for_graph() {

        // Load messages for graph
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->dashboard_messages_for_graph();

    }

    /**
     * The public method messages_by_popularity loads messages by popularity
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function messages_by_popularity() {

        // Load messages by popularity
        (new MidrubBaseUserAppsCollectionYliveHelpers\Messages)->messages_by_popularity();

    }

    /**
     * The public method load_broadcasts_history loads the broadcasts history
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function load_broadcasts_history() {
        
        // Loads broadcasts
        (new MidrubBaseUserAppsCollectionYliveHelpers\History)->load_broadcasts_history();
        
    }    

}

/* End of file ajax.php */