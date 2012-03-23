<script type="text/javascript" src="<?php echo base_url();?>script/js/retweeter.js"></script>
<div id="retweeter-list">
    <div class="content-box"><!-- Start Content Box -->
        <div class="content-box-header">
            <h3>Retweeter Account List</h3>
            <div class="clear"></div>
        </div> <!-- End .content-box-header -->
        <div class="content-box-content">
            <div id="tab1" class="tab-content default-tab" style="display: block;"> <!-- This is the target div. id must match the href of this div's tab -->
                <?php if($this->session->flashdata('rn_add')):?>
                <div class="notification png_bg <?php echo $this->session->flashdata('rn_add');?>">
                    <a class="close" href="#">
                        <img alt="close" title="Close this notification" src="<?php echo base_url(); ?>script/images/cross_grey_small.png" />
                    </a>
                    <div>
                        <?php echo $this->session->flashdata('rn_add_content');?>
                    </div>
                </div>
                <?php endif;?>
                <table>
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Account</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="add">
                                    <a class="follow-btn" href="<?php echo base_url();?>retweeter/authorize">
                                        <div class="action-text">
                                            Add New Account
                                        </div>
                                    </a>
                                </div>
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
                        <?php $i=0;?>
                        <?php foreach ($retweeter->result() as $account): ?>
                            <tr <?php echo(($i % 2) == 0) ? 'class="alt-row"' : ''; ?>>
                                <td class="td-no"><?php echo $i + 1; ?></td>
                                <td><?php echo $account->username;?></td>
                                <td>
                                    <?php if($account->status==1):?>
                                    <a title="title" href="<?php echo base_url();?>retweeter/disable/<?php echo $account->id;?>" class="active-account">
                                        Enabled
                                    </a>
                                    <?php else:?>
                                    <a title="title" href="<?php echo base_url();?>retweeter/enable/<?php echo $account->id;?>" class="inactive-account">
                                        Disabled
                                    </a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <!-- Icons -->
                                    <!-- <a title="Edit Account" href="#"><img alt="Edit Account" src="<?php echo base_url(); ?>script/images/pencil.png" /></a> -->
                                    <a id="delete-retweeter" onclick="return confirm('Are you sure want to Delete this account?');" title="Delete Account" href="<?php echo base_url();?>retweeter/delete/<?php echo $account->id;?>"><img alt="Delete Account" src="<?php echo base_url(); ?>script/images/cross.png" /></a> 
                                    <a id="manage-retweeter" title="Manage Source Account" href="#"><img alt="Manage Source Account" src="<?php echo base_url(); ?>script/images/hammer_screwdriver.png" /></a>
                                </td>
                            </tr>
                            <?php $i++;?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>     
        </div> <!-- End .content-box-content -->
    </div>
</div>