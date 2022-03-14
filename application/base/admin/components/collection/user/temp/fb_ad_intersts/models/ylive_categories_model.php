<?php
/**
 * yLive Categories Model
 *
 * PHP Version 7.3
 *
 * yLive_categories_model file contains the yLive Categories Model
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
 * Ylive_categories_model class - operates the ylive_categories table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */
class Ylive_categories_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'ylive_categories';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get the table
        $ylive_categories = $this->db->table_exists('ylive_categories');

        // Verify if the table exists
        if ( !$ylive_categories ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `ylive_categories` (
                              `category_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `created` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_category creates a category
     *
     * @param integer $user_id contains the user's id
     * @param string $name contains the list's name
     * 
     * @return integer with last inserted id or false
     */
    public function save_category( $user_id, $name ) {
        
        // Get current time
        $created = time();
        
        // Set data
        $data = array(
            'user_id' => $user_id,
            'name' => $name,
            'created' => $created
        );
        
        // Insert data
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted ID
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file ylive_categories_model.php */