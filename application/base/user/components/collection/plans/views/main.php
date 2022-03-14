<section class="plans-page">
    <div class="container">
        <?php
        if($upgrade) {
            ?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="reached-plan-limit">
                        <div class="row">
                            <div class="col-xl-9">
                                <i class="icon-info"></i>
                                <?php echo $upgrade; ?> 
                            </div>
                            <div class="col-xl-3 text-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-12">
                <h1>
                    <?php echo $this->lang->line('plans_choose_your_plan'); ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4>
                    <?php echo $this->lang->line('plans_choose_your_plan_description'); ?>
                </h4>
            </div>
        </div>
        <?php

        // Get plans
        $plans = the_visible_plans();   

        ?>
        <div class="row">
            <div class="<?php echo empty($user_plan_data[0]['visible'])?'col-md-12':'col-md-9'; ?>">
                <div class="panel panel-default">
                    <?php if ( !empty($user_plan_data[0]['visible']) ) { ?>
                    <div class="panel-heading">
                        <?php echo $this->lang->line('plans_all_public_plans'); ?>
                    </div>
                    <?php } ?>
                    <div class="panel-body">
                        <?php if ( !empty($plans[0]['plans']) ) { ?>
                        <div class="row">
                            <div class="col-12 text-center">
                                <?php
                                
                                    // Set nav start
                                    echo '<ul class="nav plans-groups-nav justify-content-center" id="plans-tab" role="tablist">';

                                    // Set groups
                                    $groups = $plans;

                                    // List groups
                                    foreach ( $groups as $group ) {

                                        // Nav active
                                        $nav_active = ( $groups[0]['group_id'] === $group['group_id'] )?' active':'';

                                        // Set nav's item
                                        echo '<li class="nav-item">'
                                                . '<a class="nav-link' . $nav_active . '" id="tab-' . $group['group_id'] . '-tab" data-toggle="tab" href="#tab-' . $group['group_id'] . '" role="tab" aria-controls="tab-' . $group['group_id'] . '" aria-selected="true">'
                                                    . $group['group_name']
                                                . '</a>'
                                            . '</li>';


                                    }

                                    echo '</ul>';
                                
                                ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                        <?php

                        // Verify if is not a group
                        if ( empty($plans[0]['plans']) ) {

                            // List all plans
                            foreach ($plans as $the_plan) {
                                ?>
                                <div class="card col">
                                    <div class="card-header">
                                        <h2>
                                            <?php echo $the_plan['plan_name']; ?>
                                        </h2>
                                        <h3>
                                            <?php echo $the_plan['header']; ?>
                                        </h3>
                                        <h5>
                                            <?php echo $the_plan['currency_sign']; ?> <?php echo $the_plan['plan_price']; ?>
                                        </h5>                                         
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <tbody>
                                                <?php

                                                // Verify if features exists
                                                if ($the_plan['features']) {

                                                    // Explode features
                                                    $features = explode("\n", $the_plan['features']);

                                                    // List all features
                                                    foreach ($features as $feature) {

                                                        // Verify if feature is not empty
                                                        if ( empty($feature) ) {
                                                            continue;
                                                        }

                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                                                </svg>
                                                                <?php echo $feature ?>
                                                            </td>
                                                        </tr>
                                                        <?php

                                                    }

                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                    <?php
                                $cplan = 1;
                                $plan_end = time() + 86400;
                                if ( $user_plan ) {

                                    foreach ( $user_plan as $up ) {

                                        if ( $up->meta_name == 'plan' ) {

                                            $cplan = $up->meta_value;

                                        }

                                        if ( $up->meta_name == 'plan_end' ) {

                                            $plan_end = strtotime($up->meta_value);

                                        }

                                    }

                                }

                                if ( ( $cplan != $the_plan['plan_id'] ) || ( ( $plan_end + 864000) < time() ) ) {
                                    ?>
                                    <a href="<?php echo ($the_plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $the_plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $the_plan['plan_id']); ?>" role="button" class="btn btn-success <?php echo str_replace(' ', '-', strtolower($the_plan['plan_name'])) ?>">
                                        <?php echo $this->lang->line('plans_order_now'); ?>
                                    </a>
                                    <?php
                                } elseif ( ( ( $plan_end + 864000) > time() ) && ( ( $plan_end - 432000 ) < time() ) && !the_user_option( 'subscription', $this->user_id ) ) { 
                                    ?>
                                    <a href="<?php echo ($the_plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $the_plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $the_plan['plan_id']); ?>" role="button" class="btn btn-default plans-renew-plan">
                                        <?php echo $this->lang->line('plans_renew_current_plan'); ?>
                                    </a>                        
                                    <?php 
                                } else {
                                    ?>
                                    <a href="#" role="button" class="btn btn-default plans-disabled-current disabled">
                                        <?php echo $this->lang->line('plans_current_plan'); ?>
                                    </a>
                                    <?php 
                                } 
                                ?>
                                    </div>  
                                </div>
                                <?php

                            }

                        } else if ( !empty($plans[0]['plans']) ) { 

                            // Set tabs
                            echo '<div class="col-12">'
                                    . '<div class="tab-content" id="plans-tabs-parent">';

                            // Set groups
                            $groups = $plans;

                            // List groups
                            foreach ( $groups as $group ) {

                                // Tab active
                                $tab_active = ( $groups[0]['group_id'] === $group['group_id'] )?' show active':'';

                                // Set Tab Start
                                echo '<div class="tab-pane fade' . $tab_active . '" id="tab-' . $group['group_id'] . '" role="tabpanel" aria-labelledby="tab-' . $group['group_id'] . '-tab">';

                                // Set row
                                echo '<div class="row">';

                                // Get group's plans
                                $plans = $group['plans'];

                                // List all plans
                                foreach ($plans as $the_plan) {

                                    ?>
                                    <div class="card col">
                                        <div class="card-header">
                                            <h2>
                                                <?php echo $the_plan['plan_name']; ?>
                                            </h2>
                                            <h3>
                                                <?php echo $the_plan['header']; ?>
                                            </h3>
                                            <h5>
                                                <?php echo $the_plan['currency_sign']; ?> <?php echo $the_plan['plan_price']; ?>
                                            </h5>                                         
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tbody>
                                                    <?php

                                                    // Verify if features exists
                                                    if ($the_plan['features']) {

                                                        // Explode features
                                                        $features = explode("\n", $the_plan['features']);

                                                        // List all features
                                                        foreach ($features as $feature) {

                                                            // Verify if feature is not empty
                                                            if ( empty($feature) ) {
                                                                continue;
                                                            }

                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                                                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                                                    </svg>
                                                                    <?php echo $feature ?>
                                                                </td>
                                                            </tr>
                                                            <?php

                                                        }

                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer">
                                        <?php
                                    $cplan = 1;
                                    $plan_end = time() + 86400;
                                    if ( $user_plan ) {

                                        foreach ( $user_plan as $up ) {

                                            if ( $up->meta_name == 'plan' ) {

                                                $cplan = $up->meta_value;

                                            }

                                            if ( $up->meta_name == 'plan_end' ) {

                                                $plan_end = strtotime($up->meta_value);

                                            }

                                        }

                                    }

                                    if ( ( $cplan != $the_plan['plan_id'] ) || ( ( $plan_end + 864000) < time() ) ) {
                                        ?>
                                        <a href="<?php echo ($the_plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $the_plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $the_plan['plan_id']); ?>" role="button" class="btn btn-success <?php echo str_replace(' ', '-', strtolower($the_plan['plan_name'])) ?>">
                                            <?php echo $this->lang->line('plans_order_now'); ?>
                                        </a>
                                        <?php
                                    } elseif ( ( ( $plan_end + 864000) > time() ) && ( ( $plan_end - 432000 ) < time() ) && !the_user_option( 'subscription', $this->user_id ) ) { 
                                        ?>
                                        <a href="<?php echo ($the_plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $the_plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $the_plan['plan_id']); ?>" role="button" class="btn btn-default plans-renew-plan">
                                            <?php echo $this->lang->line('plans_renew_current_plan'); ?>
                                        </a>                        
                                        <?php 
                                    } else {
                                        ?>
                                        <a href="#" role="button" class="btn btn-default plans-disabled-current disabled">
                                            <?php echo $this->lang->line('plans_current_plan'); ?>
                                        </a>
                                        <?php 
                                    } 
                                    ?>
                                        </div>  
                                    </div>
                                    <?php

                                }

                                // End row
                                echo '</div>';

                                // Set Tab End
                                echo '</div>';

                            }

                            // Set Tabs End
                            echo '</div></div>';

                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ( !empty($user_plan_data[0]['visible']) ) { ?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo $this->lang->line('plans_hidden_plan'); ?>
                    </div>
                    <div class="panel-body pl-0">
                        <div class="card col">
                            <div class="card-header">
                                <h2>
                                    <?php echo $user_plan_data[0]['plan_name']; ?>
                                </h2>
                                <h3>
                                    <?php echo $user_plan_data[0]['header']; ?>
                                </h3>
                                <h5>
                                    <?php echo $user_plan_data[0]['currency_sign']; ?> <?php echo $user_plan_data[0]['plan_price']; ?>
                                </h5>                                         
                            </div>
                            <div class="card-footer">
                                <?php if ( ( ( $plan_end + 864000) > time() ) && ( ( $plan_end - 432000 ) < time() ) && !the_user_option( 'subscription', $this->user_id ) ) {  ?>
                                <a href="<?php echo ($user_plan_data[0]['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $user_plan_data[0]['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $user_plan_data[0]['plan_id']); ?>" role="button" class="btn btn-success plans-renew-plan">
                                    <?php echo $this->lang->line('plans_renew_current_plan'); ?>
                                </a>
                                <?php } else { ?>
                                <a href="#" role="button" class="btn btn-default plans-disabled-current disabled">
                                    <?php echo $this->lang->line('plans_current_plan'); ?>
                                </a>
                                <?php } ?> 
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>                       
        </div>
    </div>
</section>