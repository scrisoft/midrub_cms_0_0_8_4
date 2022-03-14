<?php
/**
 * Admin Inc
 *
 * PHP Version 7.3
 *
 * This files contains the hooks for
 * the Ad Interests Suggests for Facebook app from the admin Panel
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
 * The public method set_admin_app_options registers options for Admin's panel
 * 
 * @since 0.0.8.3
 */
set_admin_app_options(
    'fb_ad_intersts',
    array (
         
        array (
            'type' => 'checkbox_input',
            'slug' => 'app_fb_ad_intersts_enable',
            'label' => $this->lang->line('fb_ad_intersts_enable_app'),
            'label_description' => $this->lang->line('fb_ad_intersts_if_is_enabled_fb_ad_intersts')
        )
        
    )

);

/* End of file admin.php */