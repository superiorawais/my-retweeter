<script type="text/javascript" src="<?php echo base_url(); ?>script/js/retweeter.js"></script>
<div id="retweeter-list">
    <div class="content-box"><!-- Start Content Box -->
        <div class="content-box-header">
            <h3><?php echo $retweeter->username; ?> Source List</h3>
            <h5><a href="<?php echo base_url();?>main/logout">logout</a></h5>
            <div class="clear"></div>
        </div> <!-- End .content-box-header -->
        <div class="content-box-content">
            <div id="tab1" class="tab-content default-tab" style="display: block;"> <!-- This is the target div. id must match the href of this div's tab -->
                <?php if ($this->session->flashdata('sn_add')): ?>
                    <div class="notification png_bg <?php echo $this->session->flashdata('sn_add'); ?>">
                        <a class="close" href="#">
                            <img alt="close" title="Close this notification" src="<?php echo base_url(); ?>script/images/cross_grey_small.png" />
                        </a>
                        <div>
                            <?php echo $this->session->flashdata('sn_add_content'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="twttr-dialog-container draggable ui-draggable" id="mini-profile">
                    <div class="profile-modal">
                        <div class="profile-modal-header js-twttr-dialog-draggable">
                            <a data-element-term="view_profile_link" href="http://twitter.com/<?php echo $user->screen_name; ?>" class="account-group js-account-group js-bubble-event">
                                <img data-user-id="<?php echo $user->id;?>" alt="<?php echo $user->name; ?>" src="<?php echo $user->profile_image_url; ?>" class="avatar"/>
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
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Account</th>
                            <th>Hashtag</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="add" id="add-trigger">
                                    <a class="follow-btn" href="#">
                                        <div class="action-text" id="add-hashtag-button">
                                            Add New Hashtag
                                        </div>
                                    </a>
                                    <a class="follow-btn" href="<?php echo base_url();?>retweeter">
                                        <div class="action-text">
                                            Back To Retweeter
                                        </div>
                                    </a>
                                </div>
                                <div id="add-hashtag" class="add">
                                    <form action="<?php echo base_url();?>retweeter/hashtag_submit/<?php echo $retweeter->id;?>" method="post">
                                        <div class="placeholding-input">
                                            <input type="text" maxlength="255" name="username" autocomplete="off" class="text-input" oninput="input_change(this)"/>
                                            <span class="placeholder">@username</span>
                                        </div>
                                        <div class="placeholding-input">
                                            <input type="text" maxlength="255" name="hashtag" autocomplete="off" class="text-input" oninput="input_change(this)"/>
                                            <span class="placeholder">#hashtag,#hashtag</span>
                                        </div>
                                        <div class="placeholding-input">
                                            <input class="submit" type="submit" value="Submit"/>
                                        </div>
                                        <a class="follow-btn" href="#">
                                            <div class="action-text" id="add-hashtag-cancel">
                                                Cancel
                                            </div>
                                        </a>
                                    </form>
                                </div>
                                <!--
                                <div class="pagination">
                                    <a title="First Page" href="#">« First</a><a title="Previous Page" href="#">« Previous</a>
                                    <a title="1" class="number" href="#">1</a>
                                    <a title="2" class="number" href="#">2</a>
                                    <a title="3" class="number current" href="#">3</a>
                                    <a title="4" class="number" href="#">4</a>
                                    <a title="Next Page" href="#">Next »</a><a title="Last Page" href="#">Last »</a>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($hashtag->result() as $h): ?>
                            <tr <?php echo(($i % 2) == 0) ? 'class="alt-row"' : ''; ?>>
                                <td class="td-no"><?php echo $i + 1; ?></td>
                                <td class="td-no"><?php echo $h->username;?></td>
                                <td><?php echo $h->hashtag; ?></td>
                                <td>
                                    <?php if ($h->status == 1): ?>
                                        <a title="title" href="<?php echo base_url(); ?>retweeter/disable_ht/<?php echo $retweeter_id; ?>/<?php echo $h->id; ?>" class="active-account">
                                            Enabled
                                        </a>
                                    <?php else: ?>
                                        <a title="title" href="<?php echo base_url(); ?>retweeter/enable_ht/<?php echo $retweeter_id; ?>/<?php echo $h->id; ?>" class="inactive-account">
                                            Disabled
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Icons -->
                                    <!-- <a title="Edit Account" href="#"><img alt="Edit Account" src="<?php echo base_url(); ?>script/images/pencil.png" /></a> -->
                                    <a id="delete-hashtag" onclick="return confirm('Are you sure want to DELETE this hashtag?');" title="Delete Hashtag" href="<?php echo base_url(); ?>retweeter/delete_ht/<?php echo $retweeter_id; ?>/<?php echo $h->id; ?>"><img alt="Delete Hashtag" src="<?php echo base_url(); ?>script/images/cross.png" /></a> 
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="blank" style="height: 40px;"></div>
                <table>
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Account</th>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="add" id="add-time-trigger">
                                    <a class="follow-btn" href="#">
                                        <div class="action-text" id="add-time-button">
                                            Add New Time
                                        </div>
                                    </a>
                                    <a class="follow-btn" href="<?php echo base_url();?>retweeter">
                                        <div class="action-text">
                                            Back To Retweeter
                                        </div>
                                    </a>
                                </div>
                                <div id="add-time" class="add">
                                    <form action="<?php echo base_url();?>retweeter/time_submit/<?php echo $retweeter->id;?>" method="post">
                                        <div class="placeholding-input">
                                            <input type="text" maxlength="255" name="username" autocomplete="off" class="text-input" oninput="input_change(this)"/>
                                            <span class="placeholder">@username</span>
                                        </div>
                                        <div class="placeholding-input">
                                            <select name="day">
                                                <option class="dummy" value="-1">-- DAY --</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                                <option value="5">Friday</option>
                                                <option value="6">Saturday</option>
                                                <option value="7">Sunday</option>
                                            </select>
                                        </div>
                                        <div class="placeholding-input">
                                            <select name="start_time">
                                                <option class="dummy" value="-1">-- START TIME --</option>
                                                <?php for($i=0;$i<2400;$i+=100):?>
                                                <option value="<?php echo $i;?>"><?php echo sprintf("%02d",($i/100)).":".sprintf("%02d",($i%100));?></option>
                                                <?php endfor;?>
                                            </select>
                                        </div>
                                        <div class="placeholding-input">
                                            <select name="end_time">
                                                <option class="dummy" value="-1">-- END TIME --</option>
                                                <?php for($i=100;$i<=2400;$i+=100):?>
                                                <option value="<?php echo $i;?>"><?php echo sprintf("%02d",($i/100)).":".sprintf("%02d",($i%100));?></option>
                                                <?php endfor;?>
                                            </select>
                                        </div>
                                        <div class="placeholding-input">
                                            <input class="submit" type="submit" value="Submit"/>
                                        </div>
                                        </a>
                                        <a class="follow-btn" href="#">
                                            <div class="action-text" id="add-time-cancel">
                                                Cancel
                                            </div>
                                        </a>
                                    </form>
                                </div>
                                <!--
                                <div class="pagination">
                                    <a title="First Page" href="#">« First</a><a title="Previous Page" href="#">« Previous</a>
                                    <a title="1" class="number" href="#">1</a>
                                    <a title="2" class="number" href="#">2</a>
                                    <a title="3" class="number current" href="#">3</a>
                                    <a title="4" class="number" href="#">4</a>
                                    <a title="Next Page" href="#">Next »</a><a title="Last Page" href="#">Last »</a>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                            $i = 0; 
                            $days = array(1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday');
                        ?>
                        <?php foreach ($st->result() as $s): ?>
                            <tr <?php echo(($i % 2) == 0) ? 'class="alt-row"' : ''; ?>>
                                <td class="td-no"><?php echo $i + 1; ?></td>
                                <td class="td-no"><?php echo $s->username;?></td>
                                <td><?php echo $days[$s->day]; ?></td>
                                <td><?php echo sprintf("%02d",($s->start_time/100)).":".sprintf("%02d",($s->start_time%100)); ?></td>
                                <td><?php echo sprintf("%02d",($s->end_time/100)).":".sprintf("%02d",($s->end_time%100)); ?></td>
                                <td>
                                    <?php if ($s->status == 1): ?>
                                        <a title="title" href="<?php echo base_url(); ?>retweeter/disable_st/<?php echo $retweeter_id; ?>/<?php echo $s->id; ?>" class="active-account">
                                            Enabled
                                        </a>
                                    <?php else: ?>
                                        <a title="title" href="<?php echo base_url(); ?>retweeter/enable_st/<?php echo $retweeter_id; ?>/<?php echo $s->id; ?>" class="inactive-account">
                                            Disabled
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Icons -->
                                    <!-- <a title="Edit Account" href="#"><img alt="Edit Account" src="<?php echo base_url(); ?>script/images/pencil.png" /></a> -->
                                    <a id="delete-hashtag" onclick="return confirm('Are you sure want to DELETE this item?');" title="Delete Hashtag" href="<?php echo base_url(); ?>retweeter/delete_st/<?php echo $retweeter_id; ?>/<?php echo $s->id; ?>"><img alt="Delete Hashtag" src="<?php echo base_url(); ?>script/images/cross.png" /></a> 
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>     
        </div> <!-- End .content-box-content -->
    </div>
</div>