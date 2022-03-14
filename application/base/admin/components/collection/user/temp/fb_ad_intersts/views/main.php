<section class="ylive-page" data-csrf="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
        <div class="col-xl-2 theme-box">
            <?php get_the_file(MIDRUB_BASE_USER_APPS_YLIVE . 'views/menu.php'); ?>    
        </div>
        <div class="col-xl-10 broadcasts-list">
            <div class="row">
                <div class="col-12">                     
                    <div class="no-active-live-videos">
                        <?php echo $this->lang->line('ylive_no_active_live_videos_found'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="active-live-videos">                    
                        <ul class="nav nav-pills mb-3 justify-content-center" id="active-live-videos" role="tablist">             
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="scrisoft-tuts" role="tabpanel" aria-labelledby="scrisoft-tuts-tab">
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
                                                <div class="no-active-live-messages">
                                                    <?php echo $this->lang->line('ylive_no_messages_found'); ?>
                                                </div>
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
                                                <div class="no-replied-live-messages">
                                                    <?php echo $this->lang->line('ylive_no_messages_found'); ?>
                                                </div>
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
                                                <div class="no-deleted-live-messages">
                                                    <?php echo $this->lang->line('ylive_no_messages_found'); ?>
                                                </div>
                                            </div>
                                        </div>
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
