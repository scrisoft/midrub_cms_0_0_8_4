<?php
/**
 * User Inc
 *
 * PHP Version 7.3
 *
 * This file contains the function
 * to delete the user's data from the yLive app
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('delete_user_from_ylive') ) {

    /**
     * The function delete_user_from_ylive deletes the user's records from yLive
     * 
     * @param integer $user_id has the user's ID
     * 
     * @return void
     */
    function delete_user_from_ylive($user_id) {

        // Get codeigniter object instance
        $CI = get_instance();

        // Load Base Model
        $CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_model', 'base_model' );

        // Delete the user's broadcasts
        $CI->base_model->delete('ylive_broadcasts', array('user_id' => $user_id)); 
        
        // Delete the user's messages
        $CI->base_model->delete('ylive_messages', array('user_id' => $user_id)); 
        
        // Delete the user's moderation keywords
        $CI->base_model->delete('ylive_moderation_keywords', array('user_id' => $user_id)); 
        
        // Delete the user's networks meta
        $CI->base_model->delete('ylive_channels_meta', array('user_id' => $user_id));         
        
        // Use the base model for a simply sql query
        $get_categories = $CI->base_model->get_data_where(
            'ylive_categories',
            'category_id',
            array(
                'user_id' => $user_id
            )
        );

        // Verify if categories exists
        if ( $get_categories ) {

            // List all categories
            foreach ( $get_categories as $get_category ) {

                // Delete the user's categories
                $CI->base_model->delete('ylive_categories', array('category_id' => $get_category['category_id']));     
                
                // Delete the keywords categories
                $CI->base_model->delete('ylive_moderation_keywords_categories', array('category_id' => $get_category['category_id'])); 
                
                // Delete the channels categories
                $CI->base_model->delete('ylive_channels_categories', array('category_id' => $get_category['category_id']));                

            }

        }
        
    }

}

/* End of file user.php */