<?php
/**
 * yLive Channels Meta Model
 *
 * PHP Version 7.3
 *
 * Ylive_channels_meta_model file contains the yLive Channels Meta Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ylive_channels_meta_model class - operates the ylive_channels_meta table.
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */
class Ylive_channels_meta_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'ylive_channels_meta';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get the table
        $ylive_channels_meta = $this->db->table_exists('ylive_channels_meta');

        // Verify if the table exists
        if ( !$ylive_channels_meta ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `ylive_channels_meta` (
                              `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `channel_id` bigint(20) NOT NULL,
                              `meta_name` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `meta_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
        }

        // Get the table
        $ylive_channels_categories = $this->db->table_exists('ylive_channels_categories');

        // Verify if the table exists
        if ( !$ylive_channels_categories ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `ylive_channels_categories` (
                              `id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `channel_id` bigint(20) NOT NULL,
                              `category_id` bigint(20) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
}

/* End of file ylive_channels_meta_model.php */