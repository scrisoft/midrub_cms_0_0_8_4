<section class="ylive-page" data-csrf-name="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-hash="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
        <div class="col-xl-2 theme-box">
            <?php get_the_file(MIDRUB_BASE_USER_APPS_YLIVE . 'views/menu.php'); ?>    
        </div>
        <div class="col-xl-10">
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="audit-small-widget theme-box">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php echo $this->lang->line('ylive_total_messages'); ?>
                            </div>
                            <div class="panel-body p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <p>
                                            <?php echo $total_messages; ?>
                                        </p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="audit-small-widget theme-box">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php echo $this->lang->line('ylive_commenters'); ?>
                            </div>
                            <div class="panel-body p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <p>
                                            <?php echo $total_commenters; ?>
                                        </p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="audit-small-widget theme-box">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php echo $this->lang->line('ylive_youtube_channels'); ?>
                            </div>
                            <div class="panel-body p-3 text-center">
                                <div class="row">
                                    <div class="col-6">
                                        <p>
                                            <?php echo $total_channels; ?>
                                        </p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <i class="icon-social-youtube"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="audit-large-widget theme-box">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-6 col-lg-8">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
                                        </svg>
                                        <?php echo $this->lang->line('ylive_messages_stats'); ?>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="dropdown dropdown-suggestions">
                                            <button class="btn btn-secondary dropdown-toggle ylive-select-stats-youtube-channels btn-select" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo $this->lang->line('ylive_all_youtube_channels'); ?>
                                            </button>
                                            <div class="dropdown-menu ylive-suggestions-dropdown" aria-labelledby="dropdownMenuButton" x-placement="bottom-start">
                                                <div class="card">
                                                    <div class="card-head">
                                                        <input type="text" class="ylive-search-for-stats-youtube-channels" placeholder="<?php echo $this->lang->line('ylive_search_channels'); ?>">
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group ylive-stats-channels-list">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body p-3">
                                <canvas id="messages-stats-chart" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="audit-large-widget theme-box">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-6 col-lg-8">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-menu-button-wide" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M0 1.5A1.5 1.5 0 0 1 1.5 0h13A1.5 1.5 0 0 1 16 1.5v2A1.5 1.5 0 0 1 14.5 5h-13A1.5 1.5 0 0 1 0 3.5v-2zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-13zM14 7H2a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1zM2 6a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H2z"></path>
                                            <path fill-rule="evenodd" d="M15 11H1v-1h14v1zM2 12.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-10a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"></path>
                                            <path d="M12.823 2.823l-.396-.396A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0z"></path>
                                        </svg>
                                        <?php echo $this->lang->line('ylive_keywords_popularity'); ?>
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        <div class="dropdown dropdown-suggestions">
                                            <button class="btn btn-secondary dropdown-toggle ylive-select-keywords-youtube-channels btn-select" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo $this->lang->line('ylive_all_youtube_channels'); ?>
                                            </button>
                                            <div class="dropdown-menu ylive-suggestions-dropdown" aria-labelledby="dropdownMenuButton" x-placement="bottom-start">
                                                <div class="card">
                                                    <div class="card-head">
                                                        <input type="text" class="ylive-search-for-keywords-youtube-channels" placeholder="<?php echo $this->lang->line('ylive_search_channels'); ?>">
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group ylive-keywords-stats-channels-list">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <?php echo $this->lang->line('ylive_keywords'); ?>
                                                </th>
                                                <th scope="col">
                                                    <?php echo $this->lang->line('ylive_response'); ?>
                                                </th>
                                                <th scope="col">
                                                    <?php echo $this->lang->line('ylive_replied'); ?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <nav>
                                                        <ul class="pagination" data-type="popularity-messages">
                                                        </ul>
                                                    </nav>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>