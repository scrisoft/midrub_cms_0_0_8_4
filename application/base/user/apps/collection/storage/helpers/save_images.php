<?php
/**
 * Save Images Helpers
 *
 * This file contains the class Save_images
 * with methods to download images from url
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace MidrubBase\User\Apps\Collection\Storage\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Media as MidrubBaseClassesMedia;

/*
 * Save_images class provides the methods to download images from url
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
*/
class Save_images {
    
    /**
     * Class variables
     *
     * @since 0.0.7.6
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.6
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method download_images_from_urls downloads images from url
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */ 
    public function download_images_from_urls() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() && get_option('app_storage_enable_url_download') ) {
            
            // Load Media Model
            $this->CI->load->model('media');
            
            // Add form validation
            $this->CI->form_validation->set_rules('imported_urls', 'Imported Urls', 'trim|required');
            
            // Get data
            $imported_urls = $this->CI->input->post('imported_urls');
            
            if ( $this->CI->form_validation->run() === false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            } else {
                
                // Get all image's urls
                $all_urls = explode("\n", $imported_urls);
                
                // Verify if there is at least one url
                if ( count($all_urls) > 0 ) {
                    
                    $count = 0;
                    
                    $user_storage = get_user_option('user_storage', $this->CI->user_id);
                    
                    if ( !$user_storage ) {
                        $user_storage = 0;
                    }
                    
                    $total_storage = 0;
                    
                    // Fedine the medias array
                    $medias = array();
                    
                    // List all urls
                    foreach ( $all_urls as $url ) {
                        
                        // Clear the url
                        $clean_url = strip_tags(trim($url));
                        
                        // Get image's info
                        $img_info = $this->check_if_is_image($clean_url);
                        
                        // Get plan's storage
                        $plan_storage = $this->CI->plans->get_plan_features( $this->CI->user_id, 'storage' );
                        
                        // Verify if url is an image
                        if ( $img_info ) {
                            
                            // Verify if the image has supported format
                            if ( ($img_info[2] > 0) && ($img_info[2] < 4 ) ) {
                                
                                // Get image size
                                $image_size = $this->get_image_size($clean_url);

                                if ( !$image_size ) {
                                    
                                    continue;
                                    
                                }
                
                                // Get temp storage
                                $temp_storage = $image_size + $user_storage;
                                
                                // Verify if user has enough storage
                                if ( $temp_storage >= $plan_storage ) {
                                    
                                    continue;

                                }

                                // Get upload limit
                                $upload_limit = get_option('upload_limit');

                                if ( !$upload_limit ) {

                                    $upload_limit = 6291456;

                                } else {

                                    $upload_limit = $upload_limit * 1048576;

                                }

                                if ( $image_size > $upload_limit ) {
                                    
                                    continue;

                                }
                                
                                // Generate thumbnail
                                $thumb = $this->generate_thumbnail($clean_url, FCPATH . 'assets/share/' . time() . '.jpeg', 250, 250);

                                // Verify if thumbnail exists
                                if ( $thumb ) {

                                    // Upload media
                                    $upload_response = (new MidrubBaseClassesMedia\Upload)->upload_from_url(array(
                                        'cover_url' => $thumb,
                                        'file_url' => $clean_url,
                                        'allowed_extensions' => array('image/png', 'image/jpg', 'image/jpeg', 'image/gif')
                                    ), true);

                                    // Verify if the files were uploaded
                                    if ( !empty($upload_response['success']) ) {

                                        // Count file
                                        $count++;

                                        // Verify if total storage was returned
                                        if ( !empty($upload_response['user_storage']) ) {
                                            $total_storage = $upload_response['user_storage'];
                                        }

                                    }

                                }
                                
                            }
                            
                        }
                        
                    }
                    
                    if ( $count ) {
                        
                        $data = array(
                            'success' => TRUE,
                            'message' => $count . ' ' . $this->CI->lang->line('images_were_saved_successfully'),
                            'user_storage' => $total_storage
                        );

                        echo json_encode($data);
                        exit();                        
                        
                    } else {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $count . ' ' . $this->CI->lang->line('images_were_saved_successfully')
                        );

                        echo json_encode($data);
                        exit();
                        
                    }
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('error_occurred')
        );

        echo json_encode($data);  
        
    }
    
    /**
     * The public method generate_thumbnail generates an image thumbnail
     * 
     * @param string $image contains the image's path
     * @param string $file_name contains the file's name
     * @param integer $w contains the thumbnail width
     * @param integer $h contains the image's height
     * 
     * @return array with image's information or false
     */ 
    public function generate_thumbnail($image, $file_name, $w, $h) {
        
        try {
         
            // Get the image's string
            $the_image_string = ImageCreateFromString(file_get_contents($image));

            // Calculate resized ratio
            $h = $h === true ? (ImageSY($the_image_string) * $w / ImageSX($the_image_string)) : $h;

            // Create image 
            $thumbnail = ImageCreateTrueColor($w, $h);
            ImageCopyResampled($thumbnail, $the_image_string, 0, 0, 0, 0, $w, $h, ImageSX($the_image_string), ImageSY($the_image_string));

            // Save image
            ImageJPEG($thumbnail, $file_name, 95); 

            // Get string
            $string = file_get_contents($file_name);

            // Delete the image
            unlink($file_name);

            // Return resized image
            return $string;
            
        } catch (Exception $ex) {
            
            return false;

        }
        
    }
    
    /**
     * The public method check_if_is_image verifies if url is an image
     * 
     * @param string $url contains the image's url
     * 
     * @since 0.0.7.6
     * 
     * @return array with image's information or false
     */ 
    public function check_if_is_image($url) {
        
        $img_info = getimagesize($url);
        
        if ( @is_array($img_info ) ) {

            return $img_info;

        } else {

            return false;

        }
        
    }
    
    /**
     * The public method get_image_size gets the image's size
     * 
     * @param string $url contains the image's url
     * 
     * @since 0.0.7.6
     * 
     * @return integer with image size or false
     */ 
    public function get_image_size($url) {
        
        // Get real image's size
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_NOBODY, TRUE);
        $data = curl_exec($curl);
        $size = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($curl);

        // Verify if the size is real
        if ( !is_numeric($size) ) {

            return false;

        } else {
            
            return $size;
            
        }
        
    }    

}

