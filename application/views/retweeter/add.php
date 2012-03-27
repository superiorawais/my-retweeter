<script type="text/javascript" src="<?php echo base_url(); ?>script/js/retweeter.js"></script>
<div id="retweeter-list">
    <div class="content-box"><!-- Start Content Box -->
        <div class="content-box-header">
            <h3>Add Retweeter Account</h3>
            <h5><a href="<?php echo base_url();?>main/logout">logout</a></h5>
            <div class="clear"></div>
        </div> <!-- End .content-box-header -->
        <div class="content-box-content">
            <div id="tab1" class="tab-content default-tab" style="display: block;"> <!-- This is the target div. id must match the href of this div's tab -->
                <?php if (!$can_add): ?>
                    <div class="notification png_bg error">
                        <a class="close" href="#">
                            <img alt="close" title="Close this notification" src="<?php echo base_url(); ?>script/images/cross_grey_small.png" />
                        </a>
                        <div>
                            This account is already in database. click logout if you wish to use another account and sign in with another twitter account
                        </div>
                    </div>
                <?php endif; ?>
                <div id="user-profile">
                    <?php //var_dump($user); ?>
                    <div class="twttr-dialog-container draggable ui-draggable" id="mini-profile">
                        <div class="profile-modal">
                            <div class="profile-modal-header js-twttr-dialog-draggable">
                                <a data-element-term="view_profile_link" href="http://twitter.com/<?php echo $user->screen_name; ?>" class="account-group js-account-group js-bubble-event">
                                    <img data-user-id="<?php echo $user->id; ?>" alt="<?php echo $user->name; ?>" src="<?php echo $user->profile_image_url; ?>" class="avatar"/>
                                </a>
                                <div class="profile-modal-header-inner">
                                    <h2 class="fullname">
                                        <a href="http://twitter.com/<?php echo $user->screen_name; ?>"><?php echo $user->name; ?></a>
                                    </h2>
                                    <h3 class="username">
                                        <a href="http://twitter.com/<?php echo $user->screen_name; ?>" class="pretty-link js-screen-name"><span>@</span><?php echo $user->screen_name; ?></a>
                                    </h3>
                                </div>
                            </div>
                            <div class="profile-modal-extended">
                                <p class="bio "><?php echo $user->description; ?></p>
                            </div>
                            <div class="mini-profile-footer ">
                                <div class="follow-bar">
                                    <?php if($can_add):?>
                                    <a class="follow-btn" href="<?php echo base_url();?>retweeter/add_submit">
                                        <div class="action-text">
                                            Add This Account
                                        </div>
                                    </a>
                                    <?php else:?>
                                    <a class="follow-btn" href="<?php echo base_url();?>retweeter/logout">
                                        <div class="action-text">
                                            Logout This Account
                                        </div>
                                    </a>
                                    <?php endif;?>
                                    <a class="follow-btn" href="<?php echo base_url();?>retweeter">
                                        <div class="action-text">
                                            Back To List
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End #mini-profile -->
                </div>
            </div>     
        </div> <!-- End .content-box-content -->
    </div>
</div>