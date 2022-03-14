<section class="ylive-page">
    <div class="row">
        <div class="col-xl-2 theme-box">
            <?php get_the_file(MIDRUB_BASE_USER_APPS_YLIVE . 'views/menu.php'); ?>    
        </div>
        <div class="col-xl-10">
            <div class="ylive-keywords-top theme-box">
                <?php echo form_open('user/app/ylive', array('class' => 'save-moderation-keywords-form', 'data-id' => $keywords_id, 'data-csrf' => $this->security->get_csrf_token_name())); ?>
                <div class="row">
                    <div class="col-4 col-lg-8">
                        <textarea class="form-control moderation-keywords" rows="3" placeholder="<?php echo $this->lang->line('ylive_enter_the_keywords'); ?>" required><?php echo htmlspecialchars($keywords); ?></textarea>
                    </div>
                    <div class="col-8 col-lg-4 text-right">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-secondary theme-background-blue ylive-save-message">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z" />
                                    <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 7.707V11.5a.5.5 0 0 0 .5.5z" />
                                </svg>
                                <?php echo $this->lang->line('save'); ?>
                            </button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="ylive-keywords-status pt-2 pl-3 pb-2 pr-3 theme-box">
                <div class="row">
                    <div class="col-8">
                        <h4>
                            <?php echo $this->lang->line('ylive_active'); ?>
                        </h4>
                    </div>
                    <div class="col-4">
                        <div class="checkbox-option pull-right">
                            <input id="ylive-keywords-status" name="ylive-keywords-status" class="app-option-checkbox" type="checkbox" <?php echo !empty($active)?'checked':''; ?>/>
                            <label for="ylive-keywords-status"></label>
                        </div>
                    </div>
                </div>          
            </div>   
            <div class="ylive-categories mb-3 theme-box">
                <div class="row">
                    <div class="col-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button class="btn btn-primary" type="button">
                                    <i class="far fa-bookmark"></i>
                                    <?php echo $this->lang->line('ylive_uncategorized'); ?>
                                </button>
                                <?php
                                if ( isset($categories) ) {

                                    foreach ($categories as $category) {

                                        echo '<button class="btn btn-primary select-category" type="button" data-id="' . htmlspecialchars($category['category_id']) . '">'
                                                . '<i class="far fa-bookmark"></i>'
                                                . htmlspecialchars($category['name'])
                                            . '</button>';
                                    }

                                }
                                ?>
                                <button class="btn btn-success select-categories" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="categories">
                                    <span>&#43;</span>
                                </button>
                            </div>
                            <div class="panel-body collapse multi-collapse" id="categories">
                                <div class="row row-eq-height">
                                    <div class="col-12 col-lg-4 col-xl-2">
                                        <button type="button" class="btn btn-secondary theme-color-black" data-toggle="modal" data-target="#categories-manager">
                                            <i class="icon-settings"></i>
                                            <?php echo $this->lang->line('ylive_manage_categories'); ?>
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-8 col-xl-10">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php echo form_open('user/app/ylive', array('class' => 'search-categories', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <i class="icon-magnifier"></i>
                                                    </div>
                                                    <input type="text" class="form-control search-category" placeholder="<?php echo $this->lang->line('ylive_search_categories'); ?>">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn input-group-text cancel-categories-search">
                                                            <i class="icon-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <?php echo form_close(); ?>
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
                </div>
            </div>         
            <div class="ylive-keywords-body pl-3 pr-3 theme-box">
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_actions'); ?>
                            </legend>
                            <p>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bookmark" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                </svg>
                                <?php echo $this->lang->line('ylive_keywords_actions_description'); ?>
                            </p>
                            <nav>
                                <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link<?php echo empty($mode)?'':' active'; ?>" id="nav-keywords-reply-tab" data-toggle="tab" href="#nav-keywords-reply" role="tab" aria-controls="nav-keywords-reply" aria-selected="<?php echo empty($mode)?'true':'false'; ?>">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-reply" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9.502 5.013a.144.144 0 0 0-.202.134V6.3a.5.5 0 0 1-.5.5c-.667 0-2.013.005-3.3.822-.984.624-1.99 1.76-2.595 3.876C3.925 10.515 5.09 9.982 6.11 9.7a8.741 8.741 0 0 1 1.921-.306 7.403 7.403 0 0 1 .798.008h.013l.005.001h.001L8.8 9.9l.05-.498a.5.5 0 0 1 .45.498v1.153c0 .108.11.176.202.134l3.984-2.933a.494.494 0 0 1 .042-.028.147.147 0 0 0 0-.252.494.494 0 0 1-.042-.028L9.502 5.013zM8.3 10.386a7.745 7.745 0 0 0-1.923.277c-1.326.368-2.896 1.201-3.94 3.08a.5.5 0 0 1-.933-.305c.464-3.71 1.886-5.662 3.46-6.66 1.245-.79 2.527-.942 3.336-.971v-.66a1.144 1.144 0 0 1 1.767-.96l3.994 2.94a1.147 1.147 0 0 1 0 1.946l-3.994 2.94a1.144 1.144 0 0 1-1.767-.96v-.667z"/>
                                        </svg>
                                        <?php echo $this->lang->line('ylive_reply'); ?>
                                    </a>
                                    <a class="nav-item nav-link<?php echo empty($mode)?' active':''; ?>" id="nav-keywords-delete-tab" data-toggle="tab" href="#nav-keywords-delete" role="tab" aria-controls="nav-keywords-delete" aria-selected="<?php echo empty($mode)?'false':'true'; ?>">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-octagon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                                            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                        <?php echo $this->lang->line('ylive_delete'); ?>
                                    </a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade<?php echo empty($mode)?'':' show active'; ?>" id="nav-keywords-reply" role="tabpanel" aria-labelledby="nav-keywords-reply-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="dropdown ylive-dropdown-accuracy">
                                                <button class="btn btn-secondary dropdown-toggle ylives-accuracy-select btn-select" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"<?php echo ($accuracy)?'data-id="' . $accuracy . '"':''; ?>>
                                                    <?php echo ($accuracy)?$accuracy . '%':$this->lang->line('ylive_keywords_accuracy'); ?>
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
                                                    <textarea class="form-control ylive-keywords-reply-message" rows="3" placeholder="<?php echo $this->lang->line('ylive_enter_the_reply'); ?>"><?php echo $reply; ?></textarea>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade<?php echo empty($mode)?' show active':''; ?>" id="nav-keywords-delete" role="tabpanel" aria-labelledby="nav-keywords-delete-tab">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="dropdown ylive-dropdown-accuracy">
                                                <button class="btn btn-secondary dropdown-toggle ylives-accuracy-select btn-select" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"<?php echo ($accuracy)?'data-id="' . $accuracy . '"':''; ?>>
                                                    <?php echo ($accuracy)?$accuracy . '%':$this->lang->line('ylive_keywords_accuracy'); ?>
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
            </div>
            <div class="ylive-keywords-replied pl-3 pr-3 theme-box">
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_replied_messages'); ?>
                            </legend>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="ylive-replied-messages-list">
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <nav>
                                        <ul class="pagination" data-type="replied-messages">
                                        </ul>
                                    </nav>
                                </div>
                            </div>                            
                        </fieldset>
                    </div>
                </div>
            </div>  
            <div class="ylive-keywords-deleted pl-3 pr-3 theme-box">
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_deleted_messages'); ?>
                            </legend>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="ylive-deleted-messages-list">
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <nav>
                                        <ul class="pagination" data-type="deleted-messages">
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div> 
            <div class="ylive-keywords-commenters pl-3 pr-3 theme-box">
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_commenters'); ?>
                            </legend>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="ylive-keywords-commenters-list">
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <nav>
                                        <ul class="pagination" data-type="commenters">
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>  
            <div class="ylive-keywords-graph pl-3 pr-3 theme-box">
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <div class="row">
                                <div class="col-12">
                                    <canvas id="ylive-keywords-stats-chart" height="400"></canvas>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Manager -->
<div class="modal fade" id="categories-manager" tabindex="-1" role="dialog" aria-boostledby="categories-manager" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <?php echo $this->lang->line('ylive_manage_categories'); ?>
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-boost="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend><?php echo $this->lang->line('ylive_new_category'); ?></legend>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?php echo form_open('user/app/ylive', array('class' => 'ylive-create-category', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
                                    <div class="input-group">
                                        <input type="text" class="form-control category-name" name="category-name" placeholder="<?php echo $this->lang->line('ylive_enter_category_name'); ?>">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z" />
                                                    <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 7.707V11.5a.5.5 0 0 0 .5.5z" />
                                                </svg>
                                                <?php echo $this->lang->line('save'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <legend>
                                <?php echo $this->lang->line('ylive_all_categories'); ?>
                            </legend>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <ul class="all-categories">
                                    </ul>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset class="fieldset-pagination">
                            <nav>
                                <ul class="pagination" data-type="categories">
                                </ul>
                            </nav>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>