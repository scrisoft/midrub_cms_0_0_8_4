<?php
/**
 * General Inc
 *
 * PHP Version 7.3
 *
 * This files contains the hooks for
 * the yLive's app
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

/**
 * The public method add_hook registers a hook
 * 
 * @since 0.0.8.3
 */
add_hook(
    'delete_network_account',
    function ($args) {

        // Verify if account's id exists
        if ( isset($args['account_id']) ) {

            // Get codeigniter object instance
            $CI = get_instance();

            // Delete the network's records
            $CI->base_model->delete('ylive_channels_meta', array('channel_id' => $args['account_id']));
            $CI->base_model->delete('ylive_channels_categories', array('channel_id' => $args['account_id']));
            $CI->base_model->delete('ylive_broadcasts', array('network_id' => $args['account_id']));
            $CI->base_model->delete('ylive_messages', array('network_id' => $args['account_id']));

        }

    }

);

/* End of file general.php */