<?php
/**
 * Settings Helpers
 *
 * This file contains the class Settings
 * with methods to manage the admin's settings
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Admin\Components\Collection\Settings\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Settings class provides the methods to manage the admin's settings
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Settings {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method save_admin_settings saves the admin's settings
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function save_admin_settings() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_options', 'All Options', 'trim');
            $this->CI->form_validation->set_rules('all_inputs', 'All Inputs', 'trim');

            // Get data
            $all_options = $this->CI->input->post('all_options');
            $all_inputs = $this->CI->input->post('all_inputs');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                $count = 0;
                
                if ( $all_options ) {
                
                    foreach( $all_options as $option ) {

                        if ( $option[1] ) {

                            if ( update_option($option[0], $option[1]) ) {

                                $count++;

                            }

                        } else {

                            if ( delete_option($option[0]) ) {

                                $count++;

                            }

                        }

                    }
                
                }
                
                if ( $all_inputs ) {
                
                    foreach( $all_inputs as $input ) {

                        if ( $input[1] ) {

                            if ( update_option($input[0], $input[1]) ) {

                                $count++;

                            }

                        } else {

                            if ( delete_option($input[0]) ) {

                                $count++;

                            }

                        }

                    }
                    
                }
                
                if ( $count ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('changes_were_saved')
                    );

                    echo json_encode($data); 
                    exit();
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('changes_were_not_saved')
        );

        echo json_encode($data);  
        
    }

    /**
     * The public method upload_media_in_storage uploads media in storage
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function upload_media_in_storage() {

        // Supported formats
        $check_format = array('image/png', 'image/jpeg', 'image/gif');
        
        if ( !in_array($_FILES['file']['type'], $check_format) ) {
            
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred') . ': ' . $this->CI->lang->line('no_supported_format')
            );

            echo json_encode($message);
            exit();
            
        }
        
        $format = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        
        $config['upload_path'] = 'assets/img';
        
        $config['file_name'] = time();
        
        $this->CI->load->library('upload', $config);
        
        $this->CI->upload->initialize($config);
        
        $this->CI->upload->set_allowed_types('*');
        
        $data['upload_data'] = '';
        
        if ( $this->CI->upload->do_upload('file') ) {
            
            // Delete old media file
            $old_url = get_option($_POST['file_name']);
            
            if ( $old_url ) {
                
                $url = str_replace($this->CI->config->base_url(), '', $old_url);
                // Check if old file exist and delete it
                if ( file_exists($url) ) {
                    
                    unlink($url);
                    
                }
                
            }
            
            // Get information about uploaded file
            $data['upload_data'] = $this->CI->upload->data();
            
            $this->CI->options->set_media_option($_POST['file_name'], $this->CI->config->base_url() . 'assets/img/' . $data['upload_data']['file_name']);
                
            echo '<img src="' . $this->CI->config->base_url() . 'assets/img/' . $data ['upload_data'] ['file_name'] . '" class="thumbnail" />';
            
        }
        
    }

}

/* End of file settings.php */