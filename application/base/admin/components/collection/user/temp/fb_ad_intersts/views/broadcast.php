<section class="ylive-page" data-csrf="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
        <div class="col-xl-2 theme-box">
            <?php get_the_file(MIDRUB_BASE_USER_APPS_YLIVE . 'views/menu.php'); ?>    
        </div>
        <div class="col-xl-10 broadcast-history">
            <div class="row">
                <div class="col-12">
                    <div class="live-video-history">
                        <div class="accordion" id="accordion">
                            <div class="card">
                                <div class="card-header" id="new-messages-area">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#new-messages" aria-expanded="true" aria-controls="new-messages">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-right-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                                                <path fill-rule="evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                            </svg>
                                            <?php echo $this->lang->line('ylive_new_messages'); ?>
                                        </button>
                                    </h5>
                                </div>
                                <div id="new-messages" class="collapse show" aria-labelledby="new-messages-area" data-parent="#accordion">
                                    <div class="card-body new-messages">
                                        <?php if ( !empty($new_messages) ) { ?>
                                        <div class="row">
                                            <div class="col-11">                                                
                                                <ul class="ylive-new-messages">
                                                    <li class="ylive-load-old-messages">
                                                        <a href="#" class="ylive-load-old-messages-btn">
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                                            </svg>
                                                            <?php echo $this->lang->line('ylive_load_old_messages'); ?>
                                                        </a>
                                                    </li>
                                                    <?php

                                                    // List new messages
                                                    foreach ( $new_messages as $new_message ) {

                                                        // Display message
                                                        echo '<li class="ylive-message-single showed" data-id="' . $new_message['message_id'] . '">'
                                                                . '<div class="card">'
                                                                    . '<div class="card-header d-flex justify-content-between align-items-center">'
                                                                        . '<h6 class="m-0">'
                                                                            . '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                                                                . '<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z" />'
                                                                                . '<path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />'
                                                                            . '</svg>'
                                                                            . calculate_time($new_message['created'], time())
                                                                        . '</h6>'
                                                                    . '</div>'
                                                                    . '<div class="card-body">'
                                                                        . '<div class="media">'
                                                                            . '<img class="mr-3" src="' . $new_message['image'] . '" alt="Author Image" />'
                                                                            . '<div class="media-body">'
                                                                                . '<h5 class="mt-0">'
                                                                                    . $new_message['user_name']
                                                                                . '</h5>'
                                                                                . '<p>'
                                                                                    . $new_message['message']
                                                                                . '</p>'
                                                                            . '</div>'
                                                                        . '</div>'
                                                                    . '</div>'
                                                                . '</div>'
                                                            . '</li>';

                                                    }

                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <div class="no-active-live-messages">
                                            <?php echo $this->lang->line('ylive_no_messages_found'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="replied-messages-area">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#replied-messages" aria-expanded="false" aria-controls="replied-messages">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-right-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                                                <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                            </svg>
                                            <?php echo $this->lang->line('ylive_replied_messages'); ?>
                                        </button>
                                    </h5>
                                </div>

                                <div id="replied-messages" class="collapse" aria-labelledby="replied-messages-area" data-parent="#accordion">
                                    <div class="card-body replied-messages">
                                        <?php if ( !empty($replied_messages) ) { ?>
                                        <div class="row">
                                            <div class="col-11">                                                
                                                <ul class="ylive-replied-messages">
                                                    <li class="ylive-load-old-messages">
                                                        <a href="#" class="ylive-load-old-messages-btn">
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                                            </svg>
                                                            <?php echo $this->lang->line('ylive_load_old_messages'); ?>
                                                        </a>
                                                    </li>
                                                    <?php

                                                    // List replied messages
                                                    foreach ( $replied_messages as $replied_message ) {

                                                        // Display message
                                                        echo '<li class="ylive-message-single showed" data-id="' . $replied_message['message_id'] . '">'
                                                                . '<div class="card">'
                                                                    . '<div class="card-header d-flex justify-content-between align-items-center">'
                                                                        . '<h6 class="m-0">'
                                                                            . '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                                                                . '<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z" />'
                                                                                . '<path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />'
                                                                            . '</svg>'
                                                                            . calculate_time($replied_message['created'], time())
                                                                        . '</h6>'
                                                                    . '</div>'
                                                                    . '<div class="card-body">'
                                                                        . '<div class="media">'
                                                                            . '<img class="mr-3" src="' . $replied_message['image'] . '" alt="Author Image" />'
                                                                            . '<div class="media-body">'
                                                                                . '<h5 class="mt-0">'
                                                                                    . $replied_message['user_name']
                                                                                . '</h5>'
                                                                                . '<p>'
                                                                                    . $replied_message['message']
                                                                                . '</p>'
                                                                            . '</div>'
                                                                        . '</div>'
                                                                    . '</div>'
                                                                    . '<div class="card-footer">'
                                                                        . '<div class="row">'
                                                                            . '<div class="col-12">'
                                                                                . '<div class="media">'
                                                                                    . '<div class="media-body your-reply">'
                                                                                        . '<h5 class="mt-0">' . $this->lang->line('ylive_your_reply') . ': </h5>'
                                                                                        . '<p>'
                                                                                            . $replied_message['reply']
                                                                                        . '</p>'
                                                                                    . '</div>'
                                                                                . '</div>'
                                                                            . '</div>'
                                                                        . '</div>'
                                                                    . '</div>'
                                                                . '</div>'
                                                            . '</li>';

                                                    }

                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                            <div class="no-replied-live-messages">
                                                <?php echo $this->lang->line('ylive_no_messages_found'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="deleted-messages-area">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#deleted-messages" aria-expanded="false" aria-controls="deleted-messages">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-right-quote" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                                                <path fill-rule="evenodd" d="M7.066 4.76A1.665 1.665 0 0 0 4 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/>
                                            </svg>
                                            <?php echo $this->lang->line('ylive_deleted_messages'); ?>
                                        </button>
                                    </h5>
                                </div>

                                <div id="deleted-messages" class="collapse" aria-labelledby="deleted-messages-area" data-parent="#accordion">
                                    <div class="card-body deleted-messages">
                                    <?php if ( !empty($deleted_messages) ) { ?>
                                        <div class="row">
                                            <div class="col-11">                                                
                                                <ul class="ylive-deleted-messages">
                                                    <li class="ylive-load-old-messages">
                                                        <a href="#" class="ylive-load-old-messages-btn">
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                                            </svg>
                                                            <?php echo $this->lang->line('ylive_load_old_messages'); ?>
                                                        </a>
                                                    </li>
                                                    <?php

                                                    // List deleted messages
                                                    foreach ( $deleted_messages as $deleted_message ) {

                                                        // Display message
                                                        echo '<li class="ylive-message-single showed" data-id="' . $deleted_message['message_id'] . '">'
                                                                . '<div class="card">'
                                                                    . '<div class="card-header d-flex justify-content-between align-items-center">'
                                                                        . '<h6 class="m-0">'
                                                                            . '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                                                                . '<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z" />'
                                                                                . '<path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />'
                                                                            . '</svg>'
                                                                            . calculate_time($deleted_message['created'], time())
                                                                        . '</h6>'
                                                                    . '</div>'
                                                                    . '<div class="card-body">'
                                                                        . '<div class="media">'
                                                                            . '<img class="mr-3" src="' . $deleted_message['image'] . '" alt="Author Image" />'
                                                                            . '<div class="media-body">'
                                                                                . '<h5 class="mt-0">'
                                                                                    . $deleted_message['user_name']
                                                                                . '</h5>'
                                                                                . '<p>'
                                                                                    . $deleted_message['message']
                                                                                . '</p>'
                                                                            . '</div>'
                                                                        . '</div>'
                                                                    . '</div>'
                                                                    . '<div class="card-footer">'
                                                                        . '<div class="row">'
                                                                            . '<div class="col-12">'
                                                                                . '<div class="media">'
                                                                                    . '<div class="media-body deleted-reason">'
                                                                                        . '<h5 class="mt-0">'
                                                                                            . $this->lang->line('ylive_message_was_deleted_because')
                                                                                        . '</h5>'
                                                                                        . '<p>'
                                                                                            . $deleted_message['reply']
                                                                                        . '</p>'
                                                                                    . '</div>'
                                                                                . '</div>'
                                                                            . '</div>'
                                                                        . '</div>'
                                                                    . '</div>'
                                                                . '</div>'
                                                            . '</li>';

                                                    }

                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                            <div class="no-deleted-live-messages">
                                                <?php echo $this->lang->line('ylive_no_messages_found'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Words List !-->
<script language="javascript">
    var words = {
        no_messages_found: '<?php echo $this->lang->line('ylive_no_messages_found'); ?>',
        message_was_deleted_because: '<?php echo $this->lang->line('ylive_message_was_deleted_because'); ?>',
        you_have_deleted_it_maually: '<?php echo $this->lang->line('ylive_you_have_deleted_it_maually'); ?>',
    };
</script>
