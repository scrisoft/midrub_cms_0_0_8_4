<?php
/**
 * Team helper
 *
 * This file contains the methods
 * for team's page
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Media as MidrubBaseClassesMedia;

if (!function_exists('media_delete_files_by_extension')) {
    
    /**
     * The function media_delete_files_by_extension deletes all files by extension
     * 
     * @param string $path contains the dir path
     * @param string $ext the files extension
     * 
     * @return void
     */
    function media_delete_files_by_extension($path, $ext) {
        
        if ( glob($path . '/*' . $ext) ) {
        
            foreach (glob($path . '/*' . $ext) as $filename) {
                unlink($filename);
            }
        
        }
        
    }   
    
}

if (!function_exists('upload_media_in_storage')) {
    
    /**
     * The function upload_media_in_storage uploads media in the user storage
     * 
     * @return void
     */
    function upload_media_in_storage() {
        
        // Get codeigniter object instance
        $CI = get_instance();

        // Require the base class
        $CI->load->file(APPPATH . 'base/main.php');

        // Call the MidrubBase class
        new MidrubBase\MidrubBase('user_init');
        
        // Load Media Model
        $CI->load->model('media');
        
        // Verify if post data was sent
        if ( $CI->input->post() ) {

            $CI->form_validation->set_rules('cover', 'Cover', 'trim');
            $CI->form_validation->set_rules('type', 'Type', 'trim|required');
            $CI->form_validation->set_rules('category', 'Category', 'trim');

            // Get data
            $cover = $CI->input->post('cover');
            $type = $CI->input->post('type');
            $category = $CI->input->post('category');

            // Verify if the sent data is corect
            if ( ( $CI->form_validation->run() !== false ) ) {

                // Set upload data
                $upload_data = array(
                    'cover' => $cover,
                    'allowed_extensions' => array('image/png', 'image/jpeg', 'image/gif', 'video/mp4', 'video/webm', 'video/avi')
                );

                // Verify if category exists
                if ( $category ) {
                    
                    // Set category
                    $upload_data['category'] = $category;

                }

                // Upload media
                (new MidrubBaseClassesMedia\Upload)->upload($upload_data);
                exit();
                
            }
            
        }

        // Prepare the error message
        $message = array(
            'success' => FALSE,
            'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('wrong_data')
        );

        // Display the error message
        echo json_encode($message);
        
    }
    
}

if (!function_exists('generate_thumbnail')) {
    
    /**
     * The function generate_thumbnail generates an image thumbnail
     * 
     * @param string $image contains the image's path
     * @param string $file_name contains the file's name
     * @param integer $w contains the thumbnail width
     * @param integer $h contains the image's height
     * 
     * @return array with image's information or false
     */
    function generate_thumbnail($image, $file_name, $w, $h) {
        
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
    
}

if (!function_exists('save_media_in_storage')) {
    
    /**
     * The function save_media_in_storage saves media from urls
     * 
     * @return void
     */
    function save_media_in_storage() {
        
        // Get codeigniter object instance
        $CI = get_instance();

        // Require the base class
        $CI->load->file(APPPATH . 'base/main.php');

        // Call the MidrubBase class
        new MidrubBase\MidrubBase('user_init');
        
        // Load Media Model
        $CI->load->model('media');

        // Verify if post data was sent
        if ( $CI->input->post() ) {

            $CI->form_validation->set_rules('cover', 'Cover', 'trim|required');
            $CI->form_validation->set_rules('type', 'Type', 'trim|required');
            $CI->form_validation->set_rules('name', 'Name', 'trim|required');
            $CI->form_validation->set_rules('link', 'Link', 'trim|required');

            // Get data
            $cover = str_replace('url: ', '', $CI->input->post('cover') );
            $type = $CI->input->post('type');
            $name = $CI->input->post('name');
            $link = str_replace('url: ', '', $CI->input->post('link') );

            if ( $CI->form_validation->run() === false ) {

                $message = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('wrong_data')
                );

                echo json_encode($message);

            } else {
                
                // Get user storage
                $user_storage = get_user_option('user_storage', $CI->user_id);
                
                // Get real image's size
                $curl = curl_init($link);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($curl, CURLOPT_HEADER, TRUE);
                curl_setopt($curl, CURLOPT_NOBODY, TRUE);
                $data = curl_exec($curl);
                $size = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                curl_close($curl);
                
                // Verify if the size is real
                if ( !is_numeric($size) ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('wrong_data')
                    );

                    echo json_encode($message);
                    exit();
                    
                }
                
                // Verify if the file is a valid image
                switch (@exif_imagetype($link)) {
                    
                    case '1':
                        
                        $type = 'image/gif';
                        
                        break;
                    
                    case '2':
                        
                        $type = 'image/jpeg';
                        
                        break;
                    
                    case '3':
                        
                        $type = 'image/png';
                        
                        break;
                    
                }
                
                // Get total storage
                $total_storage = $size + ($user_storage?$user_storage:0);
                
                // Verify if user has enough storage
                if ( $total_storage >= $CI->plans->get_plan_features( $CI->user_id, 'storage' ) ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('no_free_space')
                    );

                    echo json_encode($message);
                    exit();
                    
                }

                // Supported formats
                $check_format = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'video/mp4');
                
                if ( !$type ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('file_too_large')
                    );

                    echo json_encode($message);
                    exit();
                    
                }

                if ( in_array( $type, $check_format ) ) {

                    // Generate thumbnail
                    $thumb = in_array( $type, array('video/mp4') )?base_url('assets/img/no-image.png'):generate_thumbnail($link, FCPATH . 'assets/share/' . time() . '.jpeg', 250, 250);

                    // Verify if thumbnail exists
                    if ( $thumb ) {

                        // Upload media
                        $upload_response = (new MidrubBaseClassesMedia\Upload)->upload_from_url(array(
                            'cover_url' => $thumb,
                            'file_url' => $link,
                            'allowed_extensions' => array('image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'video/mp4')
                        ));
                        exit();

                    }

                } else {

                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('unsupported_format')
                    );

                    echo json_encode($message);

                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('get_media')) {
    
    /**
     * The function get_media gets the user's media
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function get_media() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Media Model
        $CI->load->model('media');
        
        // Get page's input
        $page = $CI->input->get('page');
        
        // Get category_id's input
        $category_id = $CI->input->get('category_id');
        
        if ( !$category_id ) {
            $category_id = 0;
        }
        
        // Get limir's input
        $limit = $CI->input->get('limit');
        
        // Verify if limit exists
        if ( !$limit ) {
            $limit = 16;
        }
        
        // If page not exists will be 1
        if ( !$page || !is_numeric($page) ) {
            $page = 1;
        }
        
        $page--;
        
        $total = $CI->media->get_user_medias($CI->user_id, 0, 0, $category_id);
        
        $getmedias = $CI->media->get_user_medias($CI->user_id, ($page * $limit), $limit, $category_id);
        
        if ( $getmedias ) {
            
            $data = array(
                'success' => TRUE,
                'total' => $total,
                'medias' => $getmedias,
                'page' => ($page + 1)
            );
            
            echo json_encode($data);
            
        } else {
            
            $data = array(
                'success' => FALSE
            );
            
            echo json_encode($data);
            
        }
        
    }
    
}

if (!function_exists('delete_media')) {
    
    /**
     * The function delete_media deletes user's media
     * 
     * @param integer $media_id contains the media's ID
     * @param boolean $returns contains the option to return or no the response
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function delete_media( $media_id = NULL, $returns = NULL ) {
        
        // Get codeigniter object instance
        $CI = get_instance();

        // Require the base class
        $CI->load->file(APPPATH . 'base/main.php');

        // Call the MidrubBase class
        new MidrubBase\MidrubBase('user_init');
        
        // Load Media Model
        $CI->load->model('media');
        
        // Verify if media_id is null
        if ( !$media_id ) {
        
            // Get media's input
            $media_id = $CI->input->get('media_id');
            
            // If any media missing returns error message
            if ( !$media_id ) {
                
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('file_not_found')
                ));
                
                exit();
                
            }
            
        }
        
        // Get return
        $returns = $CI->input->get('returns');

        // Get media
        $get_media = $CI->media->single_media($CI->user_id, $media_id);
        
        // Verify if the user is owner of the media
        if ( $get_media ) {

            // Delete media
            (new MidrubBaseClassesMedia\Delete)->delete_file(array(
                'media_id' => $media_id
            ));
            exit();
            
        }

        // Display the error message
        echo json_encode(array(
            'success' => FALSE,
            'message' => $CI->lang->line('file_deleted_unsuccessfully')
        ));
        
    }
    
}