<?php
/**
 * yLive Keywords Moderation Model
 *
 * PHP Version 7.3
 *
 * Ylive_keywords_moderation_model file contains the yLive Keywords Moderation Model
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
 * Ylive_keywords_moderation_model class - operates the ylive_keywords_moderation table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */
class Ylive_keywords_moderation_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'ylive_moderation_keywords';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get the table
        $ylive_moderation_keywords = $this->db->table_exists('ylive_moderation_keywords');

        // Verify if the table exists
        if ( !$ylive_moderation_keywords ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `ylive_moderation_keywords` (
                              `keywords_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `body` VARBINARY(4000) NOT NULL,
                              `accuracy` int(3) NOT NULL,
                              `mode` tinyint(1) NOT NULL,
                              `reply` VARBINARY(4000) NOT NULL,
                              `active` tinyint(1) NOT NULL,
                              `created` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
        }

        // Get the table
        $ylive_moderation_keywords_categories = $this->db->table_exists('ylive_moderation_keywords_categories');

        // Verify if the table exists
        if ( !$ylive_moderation_keywords_categories ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `ylive_moderation_keywords_categories` (
                              `id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `keywords_id` bigint(20) NOT NULL,
                              `category_id` bigint(20) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
        }

        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }

}

/* End of file ylive_keywords_moderation_model.php */