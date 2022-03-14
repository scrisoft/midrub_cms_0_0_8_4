<?php
/**
 * Plans Inc
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
 * The public set_plans_options registers the plans options for
 * the Ad Interests Suggests for Facebook app
 * 
 * @since 0.0.8.3
 */
set_plans_options(

    array(
        'name' => $this->lang->line('fb_ad_intersts'),
        'icon' => '<i class="fab fa-facebook-square"></i>',
        'slug' => 'fb_ad_intersts',
        'fields' => array(

            array (
                'type' => 'checkbox_input',
                'slug' => 'app_fb_ad_intersts',
                'label' => $this->lang->line('fb_ad_intersts_enable_app'),
                'label_description' => $this->lang->line('fb_ad_intersts_if_is_enabled_plan')
            )

        )

    )

);

/* End of file plans.php */