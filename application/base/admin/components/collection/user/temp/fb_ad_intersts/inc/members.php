<?php
/**
 * Members Inc
 *
 * PHP Version 7.3
 *
 * This files contains the hooks for
 * the Team's component from the user Panel
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
 * The public set_member_permissions registers the team's permissions
 * 
 * @since 0.0.8.3
 */
set_member_permissions(

    array(
        'name' => $this->lang->line('ylive'),
        'icon' => '<i class="icon-action-redo"></i>',
        'slug' => 'ylive',
        'fields' => array(
    
            array (
                'type' => 'checkbox_input',
                'slug' => 'ylive',
                'label' => $this->lang->line('ylive_allow'),
                'label_description' => $this->lang->line('ylive_allow_if_enabled')
            )
    
        )
    
    )

);

/* End of file members.php */