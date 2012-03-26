<script type="text/javascript">
    function input_change(obj){
    if($(obj).val()!=''){
        $(obj).next().animate({
            opacity:0
        },200);
    }else{
        $(obj).next().animate({
            opacity:1
        },200);
    }
}
</script>
<div id="login-container">
    <div class="blank" style="height: 50px;"></div>
    <div class="blank" style="height: 40px;"></div>
    <div id="form-container">
        <div id="login-form">
            <div id="login-title">
                <p>
                    Please enter your username and password
                </p>
            </div>
            <form method="post" action="<?php echo base_url();?>main/submit_login">
            <div class="input-wrap">
                <input class="login-input" id="username" type="text" name="username" oninput="input_change(this)" value="" autocomplete="off"/>
                <span class="login-input-holder">username</span>
            </div>
            <div class="input-wrap">
                <input class="login-input" id="password" type="password" name="password" oninput="input_change(this)"/>
                <span class="login-input-holder">password</span>
            </div>
            <div class="status-wrap">
            </div>
            <div class="submit-wrap">
                <a class="forget-pass" href="<?php echo base_url(); ?>#">forgot your password?</a>
                <input class="submit-button" type="image" src="<?php echo base_url(); ?>script/images/login-button.png" />
            </div>
            </form>
        </div>
    </div>
</div>