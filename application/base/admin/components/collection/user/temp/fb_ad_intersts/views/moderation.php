<section class="ylive-page">
    <div class="row">
        <div class="col-xl-2 theme-box">
            <?php get_the_file(MIDRUB_BASE_USER_APPS_YLIVE . 'views/menu.php'); ?>    
        </div>
        <div class="col-xl-10">
            <div class="moderation-list theme-box">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-8">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-menu-button-wide" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M0 1.5A1.5 1.5 0 0 1 1.5 0h13A1.5 1.5 0 0 1 16 1.5v2A1.5 1.5 0 0 1 14.5 5h-13A1.5 1.5 0 0 1 0 3.5v-2zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-13zM14 7H2a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1zM2 6a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H2z" />
                                    <path fill-rule="evenodd" d="M15 11H1v-1h14v1zM2 12.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-10a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z" />
                                    <path d="M12.823 2.823l-.396-.396A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0z" />
                                </svg>
                                <?php echo $this->lang->line('ylive_keywords'); ?>
                            </div>
                            <div class="col-4 text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create-new-keywords">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                                            <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z" />
                                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                        </svg>
                                        <?php echo $this->lang->line('ylive_new_keywords'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-12">
                                <?php echo form_open('user/app/ylive', array('class' => 'search-keywords', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <i class="icon-magnifier"></i>
                                    </div>
                                    <input type="text" class="form-control search-key" placeholder="<?php echo $this->lang->line('ylive_search_keywords'); ?>">
                                    <div class="input-group-append">
                                        <button type="button" class="btn input-group-text cancel-keywords-search">
                                            <i class="icon-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="messages-management">
                                    <div class="checkbox-option-select">
                                        <input id="all-keywords-select" name="all-keywords-select" type="checkbox">
                                        <label for="all-keywords-select"></label>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary theme-background-white delete-keywords">
                                        <i class="icon-trash"></i>
                                        <?php echo $this->lang->line('ylive_delete'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="keywords-list">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <nav>
                            <ul class="pagination" data-type="keywords">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Create New Keywords -->
<div class="modal fade" id="create-new-keywords" tabindex="-1" role="dialog" aria-boostledby="create-new-keyword-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <?php echo $this->lang->line('ylive_create_new_keywords'); ?>
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-boost="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('user/app/ylive', array('class' => 'ylive-create-keywords', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend><?php echo $this->lang->line('ylive_keywords'); ?></legend>
                            <div class="form-group">
                                <textarea class="form-control ylive-keywords" rows="3" placeholder="<?php echo $this->lang->line('ylive_enter_the_keywords'); ?>" required></textarea>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_actions'); ?>
                            </legend>
                            <p>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z" />
                                    <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                                </svg>
                                <?php echo $this->lang->line('ylive_keywords_actions_description'); ?>
                            </p>
                            <nav>
                                <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-keywords-reply-tab" data-toggle="tab" href="#nav-keywords-reply" role="tab" aria-controls="nav-keywords-reply" aria-selected="true">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-reply" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9.502 5.013a.144.144 0 0 0-.202.134V6.3a.5.5 0 0 1-.5.5c-.667 0-2.013.005-3.3.822-.984.624-1.99 1.76-2.595 3.876C3.925 10.515 5.09 9.982 6.11 9.7a8.741 8.741 0 0 1 1.921-.306 7.403 7.403 0 0 1 .798.008h.013l.005.001h.001L8.8 9.9l.05-.498a.5.5 0 0 1 .45.498v1.153c0 .108.11.176.202.134l3.984-2.933a.494.494 0 0 1 .042-.028.147.147 0 0 0 0-.252.494.494 0 0 1-.042-.028L9.502 5.013zM8.3 10.386a7.745 7.745 0 0 0-1.923.277c-1.326.368-2.896 1.201-3.94 3.08a.5.5 0 0 1-.933-.305c.464-3.71 1.886-5.662 3.46-6.66 1.245-.79 2.527-.942 3.336-.971v-.66a1.144 1.144 0 0 1 1.767-.96l3.994 2.94a1.147 1.147 0 0 1 0 1.946l-3.994 2.94a1.144 1.144 0 0 1-1.767-.96v-.667z"/>
                                        </svg>
                                        <?php echo $this->lang->line('ylive_reply'); ?>
                                    </a>
                                    <a class="nav-item nav-link" id="nav-keywords-delete-tab" data-toggle="tab" href="#nav-keywords-delete" role="tab" aria-controls="nav-keywords-delete" aria-selected="false">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-octagon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                                            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                        <?php echo $this->lang->line('ylive_delete'); ?>
                                    </a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-keywords-reply" role="tabpanel" aria-labelledby="nav-keywords-reply-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="dropdown ylive-dropdown-accuracy">
                                                <button class="btn btn-secondary dropdown-toggle ylives-accuracy-select btn-select" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo $this->lang->line('ylive_keywords_accuracy'); ?>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <ul class="list-group ylives-accuracy-list">
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="10">
                                                                        10%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="20">
                                                                        20%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="30">
                                                                        30%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="40">
                                                                        40%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="50">
                                                                        50%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="60">
                                                                        60%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="70">
                                                                        70%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="80">
                                                                        80%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="90">
                                                                        90%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="100">
                                                                        100%
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <fieldset>
                                                <legend>
                                                    <?php echo $this->lang->line('ylive_text_reply'); ?>
                                                </legend>
                                                <div class="form-group">
                                                    <textarea class="form-control ylive-keywords-reply-message" rows="3" placeholder="<?php echo $this->lang->line('ylive_enter_the_reply'); ?>"></textarea>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-keywords-delete" role="tabpanel" aria-labelledby="nav-keywords-delete-tab">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="dropdown ylive-dropdown-accuracy">
                                                <button class="btn btn-secondary dropdown-toggle ylives-accuracy-select btn-select" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo $this->lang->line('ylive_keywords_accuracy'); ?>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <ul class="list-group ylives-accuracy-list">
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="10">
                                                                        10%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="20">
                                                                        20%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="30">
                                                                        30%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="40">
                                                                        40%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="50">
                                                                        50%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="60">
                                                                        60%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="70">
                                                                        70%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="80">
                                                                        80%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="90">
                                                                        90%
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" data-id="100">
                                                                        100%
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <fieldset>
                            <button type="submit" class="btn btn-primary">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-in-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1h-2z" />
                                    <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z" />
                                </svg>
                                <?php echo $this->lang->line('save'); ?>
                            </button>
                        </fieldset>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Word list for JS !-->
<script language="javascript">
    var words = {
        keywords_reply_short: '<?php echo $this->lang->line('ylive_keywords_reply_short'); ?>',
        please_enter_keyword: '<?php echo $this->lang->line('ylive_please_enter_keyword'); ?>',
        keywords_accuracy: '<?php echo $this->lang->line('ylive_keywords_accuracy'); ?>'
    };
</script>