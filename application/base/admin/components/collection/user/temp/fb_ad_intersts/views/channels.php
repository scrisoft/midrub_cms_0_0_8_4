<section class="ylive-page">
    <div class="row">
        <div class="col-xl-2 theme-box">
            <?php get_the_file(MIDRUB_BASE_USER_APPS_YLIVE . 'views/menu.php'); ?>    
        </div>
        <div class="col-xl-4">
            <div class="channels-list theme-box">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-12">
                                <i class="icon-social-youtube"></i>
                                <?php echo $this->lang->line('ylive_youtube_channels'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-12">
                                <?php echo form_open('user/app/ylive', array('class' => 'search-channels', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <i class="icon-magnifier"></i>
                                    </div>
                                    <input type="text" class="form-control search-for-channels" placeholder="<?php echo $this->lang->line('ylive_search_channels'); ?>">
                                    <div class="input-group-append">
                                        <button type="button" class="btn input-group-text cancel-channels-search">
                                            <i class="icon-close"></i>
                                        </button>
                                        <button type="button" class="channels-manager" data-toggle="modal" data-target="#accounts-manager-popup">
                                            <i class="icon-user-follow"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="list-channels">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <nav>
                            <ul class="pagination" data-type="channels">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">     
            <div class="connect-channel theme-box">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-12">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bezier2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h1A1.5 1.5 0 0 1 5 2.5h4.134a1 1 0 1 1 0 1h-2.01c.18.18.34.381.484.605.638.992.892 2.354.892 3.895 0 1.993.257 3.092.713 3.7.356.476.895.721 1.787.784A1.5 1.5 0 0 1 12.5 11h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5H6.866a1 1 0 1 1 0-1h1.711a2.839 2.839 0 0 1-.165-.2C7.743 11.407 7.5 10.007 7.5 8c0-1.46-.246-2.597-.733-3.355-.39-.605-.952-1-1.767-1.112A1.5 1.5 0 0 1 3.5 5h-1A1.5 1.5 0 0 1 1 3.5v-1zM2.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10 10a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                                </svg>
                                <?php echo $this->lang->line('ylive_connect_channel'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z" />
                                <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                            </svg>
                            <?php echo $this->lang->line('ylive_connect_channel_instructions'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="connect-to-bot theme-box">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-12">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                <?php echo $this->lang->line('ylive_connect_to_bot'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z" />
                                <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                            </svg>
                            <?php echo $this->lang->line('ylive_connect_to_bot_instructions'); ?>
                        </p>
                        <button class="btn btn-link connect-to-bot-btn theme-background-green text-white" type="button">
                            <?php echo $this->lang->line('ylive_connect_to_bot_btn'); ?>
                        </button>
                        <button class="btn btn-link disconnect-from-bot-btn theme-background-red text-white" type="button">
                            <?php echo $this->lang->line('ylive_disconnect_from_bot_btn'); ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="categories-list theme-box">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-12">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bookmark-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z"/>
                                </svg>
                                <?php echo $this->lang->line('ylive_categories'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z" />
                                        <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                                    </svg>
                                    <?php echo $this->lang->line('ylive_youtube_categories'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 all-categories-list">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Save Button -->
<div class="save-channel-configuration">
    <div class="row">
        <div class="col-8">
            <p>
                <i class="icon-bell"></i>
                <?php echo $this->lang->line('ylive_you_have_unsaved_changes'); ?>
            </p>
        </div>
        <div class="col-4 text-right">
            <button type="button" class="btn btn-default">
                <i class="far fa-save"></i>
                <?php echo $this->lang->line('ylive_save_changes'); ?>
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="accounts-manager-popup" tabindex="-1" role="dialog" aria-labelledby="accounts-manager-popup" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <i class="icon-social-youtube"></i>
                    <?php echo $this->lang->line('ylive_connect_channels'); ?>
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-boost="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_channels'); ?>
                            </legend>
                            <div class="row">
                                <div class="col-12">
                                    <?php echo form_open('user/app/ylive', array('class' => 'search-all-channels', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <i class="icon-magnifier"></i>
                                        </div>
                                        <input type="text" class="form-control search-for-channels" placeholder="<?php echo $this->lang->line('ylive_search_channels'); ?>">
                                        <div class="input-group-append">
                                            <button type="button" class="btn input-group-text cancel-channels-search">
                                                <i class="icon-close"></i>
                                            </button>
                                            <button type="button" class="channels-manager connect-new-channel">
                                                <i class="icon-social-youtube"></i>
                                                <?php echo $this->lang->line('ylive_connect'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="accounts-manager-accounts-list">
                                    </ul>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_instructions'); ?>
                            </legend>
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $this->lang->line('ylive_connect_instructions'); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Word list for JS !-->
<script language="javascript">
    var words = {
        please_enter_text_reply: '<?php echo $this->lang->line('ylive_please_enter_text_reply'); ?>',
        please_select_suggestion_group: '<?php echo $this->lang->line('ylive_please_select_suggestion_group'); ?>',
        please_select_at_least_reply: '<?php echo $this->lang->line('ylive_please_select_at_least_reply'); ?>',
    };
</script>