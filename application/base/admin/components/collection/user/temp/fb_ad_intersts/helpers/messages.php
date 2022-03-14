<?php
/**
 * Messages Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class Messages
 * with methods to process the messages
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
 */

// Define the page namespace
namespace MidrubBase\User\Apps\Collection\Ylive\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Messages class provides the methods to process the messages
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://novashock.net/license-term/
 * @link     https://www.midrub.com/
 * @since 0.0.8.3
*/
class Messages {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI, $connect, $client, $clientId, $clientSecret, $apiKey, $appName, $scriptUri;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the yLive Messages Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_APPS_YLIVE . 'models/', 'Ylive_messages_model', 'ylive_messages_model' );

        // Get the Google's client_id
        $this->clientId = get_option('youtube_client_id');
        
        // Get the Google's client_secret
        $this->clientSecret = get_option('youtube_client_secret');
        
        // Get the Google's api key
        $this->apiKey = get_option('youtube_api_key');
        
        // Get the Google's application name
        $this->appName = get_option('youtube_google_application_name');

        // Load the networks language's file
        $this->CI->lang->load( 'default_networks', $this->CI->config->item('language') );
                
        // Require the  vendor's libraries
        require_once FCPATH . 'vendor/autoload.php';
        
        // Youtube CallBack
        $this->scriptUri = site_url('user/callback/youtube');
        
    }

    //-----------------------------------------------------
    // Main class's methods
    //-----------------------------------------------------
    
    /**
     * The public method load_messages loads messages by page
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function load_messages() {

        // Response container
        $response = array();

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Get a random youtube's account
            $get_account = $this->CI->base_model->get_data_where(
            'ylive_channels_meta',
                'networks.*',
                array(
                    'ylive_channels_meta.user_id' => $this->CI->user_id,
                    'networks.network_name' => 'youtube'
                ),
                array(),
                array(),
                array(array(
                    'table' => 'networks',
                    'condition' => 'ylive_channels_meta.channel_id=networks.network_id',
                    'join_from' => 'LEFT'
                )),
                array(
                    'order' => array('RAND()', ''),
                    'start' => 0,
                    'limit' => 1
                )
            );

            // Verify if account exists
            if ( $get_account ) {

                // Call the class Google_Client
                $this->client = new \Google_Client();

                // Name of the google application
                $this->client->setApplicationName($this->appName);

                // Set the client_id
                $this->client->setClientId($this->clientId);

                // Set the client_secret
                $this->client->setClientSecret($this->clientSecret);

                // Redirects to same url
                $this->client->setRedirectUri($this->scriptUri);

                // Set the api key
                $this->client->setDeveloperKey($this->apiKey);

                // Load required scopes
                $this->client->setScopes(array('https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/userinfo.profile'));

                // Get refresh token
                $this->client->refreshToken($get_account[0]['secret']);

                // Get access token
                $newtoken = $this->client->getAccessToken();

                // Verify if new token exists
                if ( $newtoken ) {

                    // Set header
                    $headerQuery = array();
                    $headerQuery[] = 'Authorization: Bearer '. $newtoken['access_token'];
                    $headerQuery[] = 'Content-type: application/atom+xml';

                    // Set url params
                    $url_params = array(
                        'part' => 'id,snippet,contentDetails,status',
                        'broadcastStatus' => 'active',
                        'key' => $this->apiKey
                    );

                    // Prepare curl
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/liveBroadcasts' . '?' . urldecode(http_build_query($url_params)));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerQuery);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
                    $broadcasts = json_decode(curl_exec($ch), true);
                    curl_close($ch);

                    // Verify if lives exists
                    if ( !empty($broadcasts['items']) ) {

                        // List all lives
                        foreach ( $broadcasts['items'] as $live ) {

                            // Verify for snippet
                            if ( !empty($live['snippet']['title']) && !empty($live['snippet']['liveChatId']) ) {

                                // Verify if $response has broadcasts key
                                if ( !isset($response['broadcasts']) ) {
                                    $response['broadcasts'] = array();
                                }

                                // Set broadcasts
                                $response['broadcasts'][] = array(
                                    'chat_id' => $live['snippet']['liveChatId'],
                                    'chat_title' => $this->CI->security->xss_clean($live['snippet']['title']),
                                    'network_id' => $get_account[0]['network_id'],
                                    'cover' => $live['snippet']['thumbnails']['default']['url']
                                );

                                // Get broadcast from the database
                                $get_broadcast = $this->CI->base_model->get_data_where(
                                    'ylive_broadcasts',
                                    '*',
                                    array(
                                        'net_id' => $live['snippet']['liveChatId']
                                    )
                                );

                                // Verify if the broadcast was already saved
                                if ( !$get_broadcast ) {

                                    // Broadcast args
                                    $broadcast_args = array(
                                        'user_id' => $this->CI->user_id,
                                        'network_name' => 'youtube',
                                        'network_id' => $get_account[0]['network_id'],
                                        'net_id' => $live['snippet']['liveChatId'],
                                        'broadcast_title' => $this->CI->security->xss_clean($live['snippet']['title']),
                                        'broadcast_cover' => $this->CI->security->xss_clean($live['snippet']['thumbnails']['default']['url']),
                                        'created' => time()                                        
                                    );

                                    // Save broadcast by using the Base's Model
                                    $this->CI->base_model->insert('ylive_broadcasts', $broadcast_args);

                                }

                                // Chat params
                                $chat_params = array(
                                    'liveChatId' => $live['snippet']['liveChatId'],
                                    'part' => 'id,snippet,authorDetails',
                                    'key' => $this->apiKey
                                );

                                // Prepare curl
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/liveChat/messages' . '?' . urldecode(http_build_query($chat_params)));
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headerQuery);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                                curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);

                                // Get response
                                $chat_response = json_decode(curl_exec($ch), true);

                                curl_close($ch);  
                                
                                // Verify for comments
                                if ( !empty($chat_response['items']) ) {

                                    // List all messages
                                    foreach ( $chat_response['items'] as $message ) {

                                        // Only text events
                                        if ( $message['snippet']['type'] === 'textMessageEvent' ) {

                                            // Verify if is not the owner of this live
                                            if ( $live['snippet']['channelId'] !== $message['authorDetails']['channelId'] ) {

                                                // Prepare the message_args
                                                $message_args = array(
                                                    'user_id' => $this->CI->user_id,
                                                    'network_name' => 'youtube',
                                                    'network_id' => $get_account[0]['network_id'],
                                                    'net_id' => $message['authorDetails']['channelId'],
                                                    'user_name' => $this->CI->security->xss_clean($message['authorDetails']['displayName']),
                                                    'message_net_id' => $message['id'],
                                                    'message' => $this->CI->security->xss_clean($message['snippet']['displayMessage']),
                                                    'image' => $message['authorDetails']['profileImageUrl'],
                                                    'source' => 'youtube_messages',
                                                    'extra' => $live['snippet']['liveChatId'],
                                                    'created' => time()
                                                );

                                                // Use the base model for a simply sql query
                                                $get_message = $this->CI->base_model->get_data_where(
                                                    'ylive_messages',
                                                    '*',
                                                    array(
                                                        'message_net_id' => $message['id'],
                                                        'source' => 'youtube_messages'
                                                    )
                                                );

                                                // Verify if the message already exists
                                                if ( !$get_message ) {

                                                    // Use the base model to get all Facebook Page's categories
                                                    $categories = $this->CI->base_model->get_data_where(
                                                        'ylive_channels_categories',
                                                        '*',
                                                        array(
                                                            'channel_id' => $get_account[0]['network_id']
                                                        )
                                                    );

                                                    // If categories exists add them to array
                                                    if ($categories) {

                                                        // Categories array
                                                        $categories_array = array();

                                                        // List found categories
                                                        foreach ($categories as $category) {

                                                            // Add categories to array
                                                            $categories_array[] = $category['category_id'];

                                                        }
                                                    
                                                    }

                                                    // Use the base model for a simply sql query
                                                    $get_keywords = $this->CI->base_model->get_data_where(
                                                        'ylive_moderation_keywords_categories',
                                                        'ylive_moderation_keywords.*',
                                                        array(
                                                            'ylive_moderation_keywords.active >' => 0
                                                        ),
                                                        array(
                                                            'ylive_moderation_keywords_categories.category_id', $categories_array
                                                        ),
                                                        array(),
                                                        array(
                                                            array(
                                                                'table' => 'ylive_moderation_keywords',
                                                                'condition' => 'ylive_moderation_keywords_categories.keywords_id=ylive_moderation_keywords.keywords_id',
                                                                'join_from' => 'LEFT'
                                                            )
                                                        )
                                                    );

                                                    // Verify for keywords
                                                    if ( $get_keywords ) {

                                                        // Best match keywords
                                                        $best_match = array();

                                                        // List all keywords
                                                        foreach ($get_keywords as $get_keyword) {

                                                            // Get keywords
                                                            $keywords = explode(' ', $get_keyword['body']);

                                                            // Verify if keywords exists
                                                            if ($keywords) {

                                                                // Prepare the text
                                                                $text = $this->clear($this->CI->security->xss_clean($message['snippet']['displayMessage']));

                                                                // Verify if text exists
                                                                if ($text) {

                                                                    // Count matches
                                                                    $count = 0;

                                                                    // List keywords
                                                                    foreach ($keywords as $keyword) {

                                                                        // Verify if the keyword is a string
                                                                        if (!$this->clear($keyword)) {
                                                                            continue;
                                                                        }

                                                                        // Verify if keyword exists
                                                                        if (strpos($text, $this->clear($keyword)) !== false) {
                                                                            $count++;
                                                                        }
                                                                    }

                                                                    // Calculate percentage
                                                                    $percentChange = (1 - $count / count($keywords)) * 100;

                                                                    // Set percentage
                                                                    $total = round((100 - $percentChange), 0);

                                                                    // Verify if the accuracy is good
                                                                    if ($total >= $get_keyword['accuracy']) {

                                                                        // Verify if best match exists
                                                                        if ($best_match) {

                                                                            // Very if old accuraccy is less
                                                                            if ($best_match['accuracy'] < $total) {

                                                                                // Set accuracy
                                                                                $best_match['accuracy'] = $total;

                                                                                // Set keywords
                                                                                $best_match['keywords'] = $get_keyword;
                                                                            }

                                                                        } else {

                                                                            // Set accuracy
                                                                            $best_match['accuracy'] = $total;

                                                                            // Set keywords
                                                                            $best_match['keywords'] = $get_keyword;

                                                                        }

                                                                    }

                                                                }

                                                            }

                                                        }

                                                    }

                                                    // Verify for best match
                                                    if ( $best_match ) {

                                                        // Verify for mode
                                                        if ( $best_match['keywords']['mode'] < 1 ) {
                                                            
                                                            // Set header
                                                            $headerQuery = array();
                                                            $headerQuery[] = 'Authorization: Bearer ' . $newtoken['access_token'];
                                                            $headerQuery[] = 'Content-type: application/atom+xml';

                                                            // Set delete params
                                                            $delete_params = array(
                                                                'id' => $message['id'],
                                                                'key' => $this->apiKey
                                                            );

                                                            // Set Url
                                                            $url = 'https://www.googleapis.com/youtube/v3/liveChat/messages' . '?' . urldecode(http_build_query($delete_params));

                                                            // Prepare curl
                                                            $ch = curl_init();
                                                            curl_setopt($ch, CURLOPT_URL, $url);
                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerQuery);
                                                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                                                            curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
                                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                                                            $deletion_response = json_decode(curl_exec($ch), true);
                                                            curl_close($ch);

                                                            // Verify if response exists
                                                            if ( empty($deletion_response['error']) ) {

                                                                // Set reply
                                                                $message_args['reply'] = $this->CI->lang->line('ylive_message_was_deleted_automatically');

                                                                // Set the keywords ID
                                                                $message_args['keywords_id'] = $best_match['keywords']['keywords_id'];

                                                                // Set status
                                                                $message_args['status'] = 2;

                                                            } else {

                                                                // Set reply
                                                                $message_args['reply'] = $deletion_response['error']['message'];

                                                                // Set the keywords ID
                                                                $message_args['keywords_id'] = $best_match['keywords']['keywords_id'];

                                                                // Set status
                                                                $message_args['status'] = 2;

                                                            }

                                                        } else {

                                                            // Set url params
                                                            $url_params = array(
                                                                'part' => 'snippet',
                                                                'key' => $this->apiKey
                                                            );

                                                            // Set url
                                                            $url = 'https://www.googleapis.com/youtube/v3/liveChat/messages' . '?' . urldecode(http_build_query($url_params));

                                                            // Set reply message
                                                            $reply_message = array(
                                                                'snippet' => array(
                                                                    'liveChatId' => $live['snippet']['liveChatId'],
                                                                    'type' => 'textMessageEvent',
                                                                    'textMessageDetails' => array(
                                                                        'messageText' => '@' . $this->CI->security->xss_clean($message['authorDetails']['displayName']) . ' ' . $best_match['keywords']['reply']
                                                                    )
                                                                )
                                                            );

                                                            // Set header
                                                            $headerQuery = array();
                                                            $headerQuery[] = 'Authorization: Bearer '. $newtoken['access_token'];
                                                            $headerQuery[] = 'Accept: application/json';
                                                            $headerQuery[] = 'Content-Type: application/json';

                                                            // Prepare curl
                                                            $ch = curl_init();
                                                            curl_setopt($ch, CURLOPT_URL, $url);
                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerQuery);
                                                            curl_setopt($ch, CURLOPT_POST, TRUE);
                                                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reply_message));
                                                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                                                            curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
                                                            $reply_response = json_decode(curl_exec($ch), TRUE);
                                                            curl_close($ch);

                                                            // Verify if the message was sent
                                                            if ( !empty($reply_response['id']) ) {

                                                                // Set reply
                                                                $message_args['reply'] = $reply_message['snippet']['textMessageDetails']['messageText'];

                                                                // Set the keywords ID
                                                                $message_args['keywords_id'] = $best_match['keywords']['keywords_id'];

                                                                // Set status
                                                                $message_args['status'] = 1;

                                                            } else {

                                                                // Set reply
                                                                $message_args['reply'] = $reply_response['error']['message'];

                                                                // Set the keywords ID
                                                                $message_args['keywords_id'] = $best_match['keywords']['keywords_id'];

                                                                // Set status
                                                                $message_args['status'] = 2;

                                                            }

                                                        }

                                                    }

                                                    // Save message by using the Base's Model
                                                    $this->CI->base_model->insert('ylive_messages', $message_args);

                                                }

                                            }

                                        }

                                    }

                                }
                                
                            }

                        }

                    }

                }

            }
            
        }

        // Verify if $response is not empty
        if ( $response ) {

            // Prepare the success response
            $data = array(
                'success' => TRUE,
                'broadcasts' => $response['broadcasts']
            );

            // Display the success response
            echo json_encode($data); 

        } else {

            // Prepare the false response
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('ylive_no_active_live_videos_found')
            );

            // Display the false response
            echo json_encode($data);  

        }
        
    }

    /**
     * The public method get_live_messages gets messages for live videos
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_live_messages() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('chat_id', 'Chat ID', 'trim|required');     

            // Get data
            $chat_id = $this->CI->input->post('chat_id', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Use the base model to get messages
                $get_live_messages = $this->CI->base_model->get_data_where(
                    'ylive_messages',
                    '*',
                    array(
                        'user_id' => $this->CI->user_id,
                        'extra' => $chat_id
                    )
                );

                // Verify for live messages
                if ( $get_live_messages ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'messages' => $get_live_messages,
                        'created' => time(),
                        'words' => array(
                            'enter_a_reply_here' => $this->CI->lang->line('ylive_enter_a_reply_here'),
                            'load_old_messages' => $this->CI->lang->line('ylive_load_old_messages')
                        )
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();                 

                }

            }

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_no_messages_found')
        );

        // Display the false response
        echo json_encode($data);  
        
    }

    /**
     * Gets the commenter's messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function get_all_commenter_messages() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('commenter_id', 'Commenter ID', 'trim|required');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $commenter_id = $this->CI->input->post('commenter_id', TRUE);
            $page = $this->CI->input->post('page', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() === false ) {

                // Prepare the false response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('ylive_no_messages_found')
                );

                // Display the false response
                echo json_encode($data);
                
            } else {

                // If $page is false, set 1
                if (!$page) {
                    $page = 1;
                }

                // Set the limit
                $limit = 10;
                $page--;

                // Use the base model for a simply sql query
                $get_messages = $this->CI->base_model->get_data_where(
                    'ylive_messages',
                    'ylive_messages.*, ylive_broadcasts.broadcast_title',
                    array(
                        'ylive_messages.net_id' => $commenter_id,
                        'ylive_messages.user_id' => $this->CI->user_id
                    ),
                    array(),
                    array(),
                    array(
                        array(
                            'table' => 'ylive_broadcasts',
                            'condition' => 'ylive_messages.extra=ylive_broadcasts.net_id',
                            'join_from' => 'LEFT'
                        )
                    ),
                    array(
                        'order' => array('ylive_messages.message_id', 'desc'),
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );

                // Verify if messages exists
                if ( $get_messages ) {

                    // Get total number of messages with base model
                    $total = $this->CI->base_model->get_data_where(
                        'ylive_messages',
                        'COUNT(message_id) AS total',
                        array(
                            'net_id' => $commenter_id,
                            'user_id' => $this->CI->user_id
                        )
                    );

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'messages' => $get_messages,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'date' => time(),
                        'words' => array(
                            'your_reply' => $this->CI->lang->line('ylive_your_reply'),
                            'message_was_deleted_because' => $this->CI->lang->line('ylive_message_was_deleted_because')
                        )
                    );

                    // Display the response
                    echo json_encode($data);

                } else {

                    // Prepare the false response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ylive_no_messages_found')
                    );

                    // Display the false response
                    echo json_encode($data);

                }
                
            }
            
        }
        
    }

    /**
     * The public method delete_live_messages deletes live videos messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function delete_live_messages() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('message_id', 'Message ID', 'trim|numeric|required');     

            // Get data
            $message_id = $this->CI->input->post('message_id', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Use the base model for a simply sql query
                $get_network = $this->CI->base_model->get_data_where(
                    'ylive_messages',
                    'networks.*, ylive_messages.message_net_id, ylive_messages.extra',
                    array(
                        'ylive_messages.message_id' => $message_id,
                        'ylive_messages.user_id' => $this->CI->user_id
                    ),
                    array(),
                    array(),
                    array(array(
                        'table' => 'networks',
                        'condition' => 'ylive_messages.network_id=networks.network_id',
                        'join_from' => 'LEFT'
                    ))
                );

                // Verify if network exists
                if ( $get_network ) {

                    // Call the class Google_Client
                    $this->client = new \Google_Client();

                    // Offline because we need to get refresh token
                    $this->client->setAccessType('offline');

                    // Name of the google application
                    $this->client->setApplicationName($this->appName);

                    // Set the client_id
                    $this->client->setClientId($this->clientId);

                    // Set the client_secret
                    $this->client->setClientSecret($this->clientSecret);

                    // Redirects to same url
                    $this->client->setRedirectUri($this->scriptUri);

                    // Set the api key
                    $this->client->setDeveloperKey($this->apiKey);

                    // Load required scopes
                    $this->client->setScopes(array('https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/userinfo.profile'));

                    // Get refresh token
                    $this->client->refreshToken($get_network[0]['secret']);

                    // Get access token
                    $newtoken = $this->client->getAccessToken();

                    // Verify if new token exists
                    if ( $newtoken ) {

                        // Set header
                        $headerQuery = array();
                        $headerQuery[] = 'Authorization: Bearer ' . $newtoken['access_token'];
                        $headerQuery[] = 'Content-type: application/atom+xml';

                        // Set message params
                        $message_params = array(
                            'id' => $get_network[0]['message_net_id'],
                            'key' => $this->apiKey
                        );

                        // Set Url
                        $url = 'https://www.googleapis.com/youtube/v3/liveChat/messages' . '?' . urldecode(http_build_query($message_params));

                        // Prepare curl
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerQuery);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                        $response = json_decode(curl_exec($ch), true);
                        curl_close($ch);

                        // Verify if response exists
                        if ( empty($response['error']) ) {

                            // Prepare the success response
                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('ylive_message_was_deleted')
                            );

                            // Display the success response
                            echo json_encode($data);

                            // Mark message as deleted
                            $this->CI->base_model->update(
                                'ylive_messages',
                                array(
                                    'message_id' => $message_id
                                ), array(
                                    'reply' => $this->CI->lang->line('ylive_you_have_deleted_it_maually'),
                                    'status' => 2
                                )
                            );

                        } else {

                            // Prepare the false response
                            $data = array(
                                'success' => FALSE,
                                'message' => $response['error']['message']
                            );

                            // Display the false response
                            echo json_encode($data);  

                        }

                        exit();

                    }

                }

            }

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_no_message_found')
        );

        // Display the false response
        echo json_encode($data);  
        
    }

    /**
     * The public method reply_live_messages replies to live videos messages
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function reply_live_messages() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('message_id', 'Message ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('message_reply', 'Message Reply', 'trim|required');   

            // Get data
            $message_id = $this->CI->input->post('message_id', TRUE);
            $message_reply = $this->CI->input->post('message_reply', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Use the base model for a simply sql query
                $get_network = $this->CI->base_model->get_data_where(
                    'ylive_messages',
                    'networks.*, ylive_messages.message_net_id, ylive_messages.extra',
                    array(
                        'ylive_messages.message_id' => $message_id,
                        'ylive_messages.user_id' => $this->CI->user_id
                    ),
                    array(),
                    array(),
                    array(array(
                        'table' => 'networks',
                        'condition' => 'ylive_messages.network_id=networks.network_id',
                        'join_from' => 'LEFT'
                    ))
                );

                // Verify if network exists
                if ( $get_network ) {

                    // Call the class Google_Client
                    $this->client = new \Google_Client();

                    // Offline because we need to get refresh token
                    $this->client->setAccessType('offline');

                    // Name of the google application
                    $this->client->setApplicationName($this->appName);

                    // Set the client_id
                    $this->client->setClientId($this->clientId);

                    // Set the client_secret
                    $this->client->setClientSecret($this->clientSecret);

                    // Redirects to same url
                    $this->client->setRedirectUri($this->scriptUri);

                    // Set the api key
                    $this->client->setDeveloperKey($this->apiKey);

                    // Load required scopes
                    $this->client->setScopes(array('https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/userinfo.profile'));

                    // Get refresh token
                    $this->client->refreshToken($get_network[0]['secret']);

                    // Get access token
                    $newtoken = $this->client->getAccessToken();

                    // Verify if new token exists
                    if ( $newtoken ) {

                        // Set url params
                        $url_params = array(
                            'part' => 'snippet',
                            'key' => $this->apiKey
                        );

                        // Set url
                        $url = 'https://www.googleapis.com/youtube/v3/liveChat/messages' . '?' . urldecode(http_build_query($url_params));

                        // Set message
                        $message = array(
                            'snippet' => array(
                                'liveChatId' => $get_network[0]['extra'],
                                'type' => 'textMessageEvent',
                                'textMessageDetails' => array(
                                    'messageText' => '@' . $get_network[0]['user_name'] . ' ' . $message_reply
                                )
                            )
                        );

                        // Set header
                        $headerQuery = array();
                        $headerQuery[] = 'Authorization: Bearer '. $newtoken['access_token'];
                        $headerQuery[] = 'Accept: application/json';
                        $headerQuery[] = 'Content-Type: application/json';

                        // Prepare curl
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerQuery);
                        curl_setopt($ch, CURLOPT_POST, TRUE);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
                        $response = json_decode(curl_exec($ch), TRUE);
                        curl_close($ch);

                        // Verify if the message was sent
                        if ( !empty($response['id']) ) {

                            // Prepare the success response
                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('ylive_message_sent_successfully'),
                                'message_id' => $message_id
                            );

                            // Display the success response
                            echo json_encode($data);  

                            // Mark message as deleted
                            $this->CI->base_model->update(
                                'ylive_messages',
                                array(
                                    'message_id' => $message_id
                                ), array(
                                    'reply' => $message_reply,
                                    'status' => 1
                                )
                            );

                        } else {
                            
                            // Prepare the false response
                            $data = array(
                                'success' => FALSE,
                                'message' => $response['error']['message']
                            );

                            // Display the false response
                            echo json_encode($data);  

                        }

                        exit();

                    }

                }

            }

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_no_message_found')
        );

        // Display the false response
        echo json_encode($data);  
        
    }

    /**
     * The public method messages_for_graph loads messages for graph
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function messages_for_graph() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('channel_id', 'Channel ID', 'trim');

            // Get data
            $channel_id = $this->CI->input->post('channel_id', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Loads messages by popularity
                $messages = $this->CI->ylive_messages_model->messages_for_graph($this->CI->user_id, $channel_id);

                // Verify if messages exists
                if ( $messages ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'messages' => $messages,
                        'words' => array(
                            'number_bot_messages' => $this->CI->lang->line('ylive_number_received_messages')
                        )
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'words' => array(
                'number_bot_messages' => $this->CI->lang->line('ylive_number_received_messages')
            )
        );

        // Display the false response
        echo json_encode($data);
        
    }

    /**
     * The public method messages_by_popularity loads messages by popularity
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function messages_by_popularity() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('channel_id', 'Channel ID', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $channel_id = $this->CI->input->post('channel_id', TRUE);
            $page = $this->CI->input->post('page', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // If $page is false, set 1
                if (!$page) {
                    $page = 1;
                }

                // Decrease the page
                $page--;

                // Loads messages by popularity
                $messages = $this->CI->ylive_messages_model->keywords_by_popularity($this->CI->user_id, $channel_id, $page);

                // Verify if messages exists
                if ( $messages ) {

                    // Calculate total number of messages
                    $total_messages = $this->CI->ylive_messages_model->keywords_by_popularity($this->CI->user_id, $channel_id);

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'messages' => $messages,
                        'total' => count($total_messages),
                        'page' => ($page + 1),
                        'words' => array(
                            'delete' => $this->CI->lang->line('ylive_delete'),
                            'reply' => $this->CI->lang->line('ylive_reply')
                        )
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ylive_no_keywords_found')
        );

        // Display the false response
        echo json_encode($data);
        
    }

    //-----------------------------------------------------
    // Helpers methods
    //-----------------------------------------------------

    /**
     * The pretected method clear removes special characters
     * 
     * @param string $string contains the string to clear
     * 
     * @since 0.0.8.0
     * 
     * @return string with clean string
     */
    protected function clear($string) {
        
        return strtolower($string);

    }

}

/* End of file messages.php */