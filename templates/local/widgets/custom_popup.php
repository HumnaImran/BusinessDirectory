<?php
$CI = &get_instance();
if(!isset($login_url_facebook)){
$login_url_facebook = '';
    if($CI->config->item('facebook_api_version') == '2.4' || floatval($this->config->item('facebook_api_version')) >= 2.4
          || version_compare($CI->config->item('facebook_api_version'), 2.4, '>') 
        )
    {
        $user_facebook = FALSE;
        if($CI->config->item('appId') != '')
        {   
            $CI->load->library('facebook/Facebook'); // Automatically picks appId and secret from config
            $user_facebook = $CI->facebook->getUser();
        }
        if ($user_facebook) {
        } else if($CI->config->item('appId') != ''){
            $login_url_facebook = $CI->facebook->login_url();
        }
    }
    else
    {
        $user_facebook = FALSE;
        if($CI->config->item('appId') != '')
        {
            $CI->load->library('facebook'); // Automatically picks appId and secret from config
            $user_facebook = $CI->facebook->getUser();
        }   
        $login_url_facebook = '';
        if ($user_facebook) {
        } else if($CI->config->item('appId') != ''){
            $login_url_facebook = $CI->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('frontend/login/'.$this->data['lang_code']), 
                'scope' => array("email") // permissions here
            ));
        }
    }

}
?>





<div class="modal fade modal-form" id="login-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo lang_check('Log in to');?> {settings_websitetitle}</h4>
            </div>
            <div class="modal-body">
                <form  id="popup_form_login">
                    <div class="alerts-box">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="<?php echo lang_check('Username');?>" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="<?php echo lang_check('Password');?>" />
                    </div>                            
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom btn-custom-secondary btn-wide"><?php echo lang_check('Login'); ?>
                            <span class="spinner hidden ajax-indicator">
                                <span class="bounce1"></span>
                                <span class="bounce2"></span>
                                <span class="bounce3"></span>
                            </span>
                        
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <?php if (config_item('appId') != '' && !empty($login_url_facebook)): ?>
                    <div class="form-group">
                        <a href="<?php echo $login_url_facebook; ?>" class="btn btn-custom btn-custom-primary btn-wide"><?php echo lang_check('Log In With Facebook');?></a>
                    </div>                    
                <?php endif; ?>
                <?php if (config_item('glogin_enabled')): ?>
                    <div class="form-group">
                        <a href="<?php echo site_url('api/google_login/'.$lang_id); ?>" class="btn btn-custom btn-custom-secondary btn-wide"><?php echo lang_check('Google+'); ?></a>
                    </div>                    
                <?php endif; ?>
                <div class="bottom-actions">
                    <?php echo lang_check('New to');?> {settings_websitetitle}? <a href="#" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#creataccount-modal" class="link"><?php echo lang_check('Create an account');?></a>
                </div>
                <div class="bottom-actions">
                    <?php echo lang_check('Forgot Password?');?> <a href="<?php echo site_url('admin/user/forgetpassword'); ?>" class="link"><?php echo lang_check('Reset password');?></a>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade modal-form" id="creataccount-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo lang_check('Create An Account');?></h4>
            </div>
            <div class="modal-body">
            <?php echo form_open(NULL, array('class' => 'clearfix', 'id'=>'popup_form_register')) ?>
                <div class="alerts-box">
                </div>
                <?php if(config_db_item('register_reduced') == FALSE): ?>
                <div class="form-group">
                    <div class="controls">
                        <?php echo form_input('name_surname', set_value('name_surname', ''), 'class="form-control" id="inputNameSurname" placeholder="' . lang('FirstLast') . '"') ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <?php echo form_input('username', set_value('username', ''), 'class="form-control" id="inputUsername2" placeholder="' . lang('Username') . '"') ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="controls">
                        <?php echo form_input('mail', set_value('mail', ''), 'class="form-control" id="inputMail" placeholder="' . lang('Email') . '"') ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="controls">
                        <?php echo form_password('password', set_value('password', ''), 'class="form-control" id="inputPassword2" placeholder="'.lang('Password').'" autocomplete="off"')?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="controls">
                        <?php echo form_password('password_confirm', set_value('password_confirm', ''), 'class="form-control" id="inputPasswordConfirm" placeholder="'.lang('Confirmpassword').'" autocomplete="off"')?>
                    </div>
                </div>
                <?php if(config_db_item('register_reduced') == FALSE && FALSE): ?>
                <div class="form-group">
                    <div class="controls">
                        <?php echo form_textarea('address', set_value('address', ''), 'placeholder="'.lang('Address').'" id="inputAddress" rows="3" class="form-control"')?>
                    </div>
                </div>          

                <div class="form-group">
                    <div class="controls">
                        <?php echo form_input('phone', set_value('phone', ''), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                    </div>
                  </div>
                <?php endif; ?>

                <?php if(config_item('captcha_disabled') === FALSE): ?>
                <div class="form-group" >
                    <label class="control-label captcha"><?php echo $captcha['image']; ?></label>
                    <div class="controls">
                        <input class="captcha form-control" name="captcha" type="text" placeholder="<?php _l('Captcha');?>" value="" />
                        <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                    </div>
                </div>
                <?php endif; ?>
                <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
                <div class="form-group" >
                    <div class="controls">
                        <?php _recaptcha(true); ?>
                   </div>
                </div>
                <?php endif; ?>
                <div class="form-group text-center">
                    <div class="controls">
                        <button type="submit" class="btn btn-danger"><?php echo lang('Register')?></button>
                        <button type="reset" class="btn btn-success"><?php echo lang('Reset')?></button>
                    </div>
                </div>
            <?php echo form_close();?>
            </div>
            <div class="modal-footer">
                <?php if (config_item('appId') != '' && !empty($login_url_facebook)): ?>
                    <div class="form-group">
                        <a href="<?php echo $login_url_facebook; ?>" class="btn btn-custom btn-custom-primary btn-wide"><?php echo lang_check('Log In With Facebook');?></a>
                    </div>                    
                <?php endif; ?>
                <?php if (config_item('glogin_enabled')): ?>
                    <div class="form-group">
                        <a href="<?php echo site_url('api/google_login/'.$lang_id); ?>" class="btn btn-custom btn-custom-secondary btn-wide"><?php echo lang_check('Google+'); ?></a>
                    </div>                    
                <?php endif; ?>           
                <div class="bottom-actions">
                    <?php echo lang_check('Already on');?> {settings_websitetitle}? <a href="{front_login_url}#content" class="link"><?php echo lang_check('Log in');?></a>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

$('document').ready(function(){
    
    $('form#popup_form_login').submit(function(e){
        e.preventDefault();
        var data = $('form#popup_form_login').serializeArray();
        //console.log( data );
        $('form#popup_form_login .ajax-indicator').removeClass('hidden');
        // send info to agent
        $.post("<?php echo site_url('api/login_form/'.$lang_code); ?>", data,
        function(data){
            if(data.success)
            {
                // Display agent details
                $('form#popup_form_login .alerts-box').html('');
                if(data.message){
                    ShowStatus.show(data.message)
                }
                if(data.redirect) {
                    location.href = data.redirect;
                }
                /*location.reload();*/
            }
            else
            { 
                if(data.message){
                    ShowStatus.show(data.message)
                }
                $('form#popup_form_login .alerts-box').html(data.errors);
            }
        }).success(function(){$('form#popup_form_login .ajax-indicator').addClass('hidden');});
        return false;
    });
    
    
    $('form#popup_form_register').submit(function(e){
        e.preventDefault();
        var data = $('form#popup_form_register').serializeArray();
        //console.log( data );
        $('form#popup_form_register .ajax-indicator').removeClass('hidden');
        // send info to agent
        $.post("<?php echo site_url('api/register_form/'.$lang_code); ?>", data,
        function(data){
            if(data.success)
            {
                // Display agent details
                $('#popup_form_register .alerts-box').html('');
                if(data.message){
                    ShowStatus.show(data.message)
                }
                if(data.redirect) {
                    //location.href = data.redirect;
                }
                //location.reload();
            }
            else
            { 
                if(data.message){
                    ShowStatus.show(data.message)
                }
                $('form#popup_form_register .alerts-box').html(data.errors);
            }
        }).success(function(){$('form#popup_form_register .ajax-indicator').addClass('hidden');});
        return false;
    });
    
    
    
})


</script>
