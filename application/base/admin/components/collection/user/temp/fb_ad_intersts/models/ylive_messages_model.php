<?php
/**
 * yLive Messages Model
 *
 * PHP Version 7.3
 *
 * yLive_messages_model file contains the yLive Messages Model
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
 * yLive_messages_model class - operates the ylive_messages and ylive_messages table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */
class Ylive_messages_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'ylive_messages';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get the table
        $ylive_broadcasts = $this->db->table_exists('ylive_broadcasts');

        // Verify if the table exists
        if ( !$ylive_broadcasts ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `ylive_broadcasts` (
                              `broadcast_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `network_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `network_id` bigint(20) NOT NULL,
                              `net_id` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,                            
                              `broadcast_title` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `broadcast_cover` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
        }        

        // Get the table
        $ylive_messages = $this->db->table_exists('ylive_messages');

        // Verify if the table exists
        if ( !$ylive_messages ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `ylive_messages` (
                              `message_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `network_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `network_id` bigint(20) NOT NULL,
                              `net_id` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `user_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `message_net_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `message` varbinary(4000),
                              `reply` varbinary(4000),
                              `image` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `keywords_id` bigint(20) NOT NULL,
                              `status` TINYINT(1) NOT NULL,
                              `source` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `extra` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }

    /**
     * The public method the_youtube_commenters gets the commenters by page
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays commenters
     * @param integer $limit displays the limit of displayed commenters
     * @param string $key contains the search key
     * 
     * @return object with commenters or false
     */
    public function the_youtube_commenters( $user_id, $start, $limit = NULL, $key ) {
        
        // Select messages
        $this->db->select('*');
        $this->db->from('ylive_messages');
        $this->db->where(array(
            'user_id' => $user_id
            )
        );

        // If $key exists means will displayed messages even by key
        if ( $key ) {
            
            // This method allows to escape special characters for LIKE conditions
            $key = $this->db->escape_like_str($key);
            
            // Gets messages which contains the $key
            $this->db->like('user_name', $key);
            
        }
        
        // Group messages
        $this->db->group_by(array('net_id'));

        // Order messages
        $this->db->order_by('message_id', 'desc');
        
        // Verify if $limit is not null
        if ( $limit ) {

            // Set limit
            $this->db->limit($limit, $start);

        }
        
        $query = $this->db->get();
        
        // Verify if messages exists
        if ( $query->num_rows() > 0 ) {
            
            // Verify if $limit is not null
            if ( $limit ) {
            
                // Get results
                return $query->result_array();
            
            } else {

                return $query->num_rows();

            }
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method the_keywords_commenters gets the commenters by keywords and page
     *
     * @param integer $keywords_id contains the keywords ID
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays commenters
     * @param integer $limit displays the limit of displayed commenters
     * 
     * @return object with commenters or false
     */
    public function the_keywords_commenters( $keywords_id, $user_id, $start, $limit = NULL ) {
        
        // Select messages
        $this->db->select('*');
        $this->db->from('ylive_messages');
        $this->db->where(array(
                'user_id' => $user_id,
                'keywords_id' => $keywords_id
            )
        );
        
        // Group messages
        $this->db->group_by(array('net_id'));

        // Order messages
        $this->db->order_by('message_id', 'desc');
        
        // Verify if $limit is not null
        if ( $limit ) {

            // Set limit
            $this->db->limit($limit, $start);

        }
        
        $query = $this->db->get();
        
        // Verify if messages exists
        if ( $query->num_rows() > 0 ) {
            
            // Verify if $limit is not null
            if ( $limit ) {
            
                // Get results
                return $query->result_array();
            
            } else {

                return $query->num_rows();

            }
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method messages_for_graph returns messages for graph
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $channel_id contains the channel's ID
     * 
     * @return array with messages or boolean false
     */
    public function messages_for_graph($user_id, $channel_id=NULL) {

        $this->db->select('LEFT(FROM_UNIXTIME(created),10) as datetime', false);
        $this->db->select('COUNT(message_id) as number', false);
        $this->db->from('ylive_messages');

        // Verify if channel's ID exists
        if ( $channel_id ) {

            $this->db->where(
                array(
                    'user_id' => $user_id,
                    'network_id'=> $channel_id,
                    'source' => 'youtube_messages',
                    'created >' => strtotime('-31day', time())
                )
            );

        } else {

            $this->db->where(
                array(
                    'user_id' => $user_id,
                    'source' => 'youtube_messages',
                    'created >' => strtotime('-31day', time())
                )
            );

        }
        
        $this->db->group_by('datetime');
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {
            
            // Return data
            return $query->result_array();
            
        } else {
            
            return false;
            
        }

    }

    /**
     * The public method keywords_by_popularity gets keywords by popularity
     * 
     * @param integer $channel_id contains the channel's ID
     * @param integer $page contains the page's number
     * 
     * @return array with keywords or boolean false
     */
    public function keywords_by_popularity($user_id, $channel_id, $page=0) {

        // Select keywords
        $this->db->select('ylive_moderation_keywords.body, ylive_moderation_keywords.mode, COUNT(ylive_messages.message_id) as number', false);
        
        // From
        $this->db->from('ylive_moderation_keywords');

        // Join
        $this->db->join('ylive_messages', 'ylive_moderation_keywords.keywords_id=ylive_messages.keywords_id', 'left');

        // Verify if channel's ID exists
        if ( $channel_id ) {

            $this->db->where(
                array(
                    'ylive_moderation_keywords.user_id' => $user_id,
                    'ylive_messages.network_id'=> $channel_id
                )
            );

        } else {

            $this->db->where(
                array(
                    'ylive_moderation_keywords.user_id' => $user_id
                )
            );
            
        }

        $this->db->group_by('ylive_moderation_keywords.body');
        $this->db->order_by('number', 'DESC');

        // Verify if $page is positive otherwise return all results
        if ( $page ) {

            // Set number of items and page
            $this->db->limit(10, ($page * 10) );

        }
        
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {
            
            // Return data
            return $query->result_array();
            
        } else {
            
            return false;
            
        }

    }

    /**
     * The public method keywords_activity_graph returns the keywords activity
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $keywords_id contains the keywords ID
     * 
     * @return array with keywords or boolean false
     */
    public function keywords_activity_graph($user_id, $keywords_id) {

        $this->db->select('LEFT(FROM_UNIXTIME(created),10) as datetime', false);
        $this->db->select('COUNT(keywords_id) as number', false);
        $this->db->from('ylive_messages');
        $this->db->where(
            array(
                'user_id' => $user_id,
                'keywords_id'=> $keywords_id,
                'created >' => strtotime('-31day', time())
            )
        );
        $this->db->group_by('datetime');
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {
            
            // Return data
            return $query->result_array();
            
        } else {
            
            return false;
            
        }

    }
    
}

/* End of file ylive_messages_model.php */