<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
    </head>
    <body class="<?php _widget('custom_paletteclass'); ?>">
        <header class="header">
            <?php _widget('custom_header_menu-for-loginuser');?>
            <?php _widget('header_main');?>
        </header><!-- /.header -->
            <?php _widget('top_title_grey');?>
        <main class="">
            <section class="section container container-palette">
                <div class="container">
                    <?php if(file_exists(APPPATH.'controllers/admin/packages.php') && !empty($packages)): ?>
                    <div class="widget widget-styles">
                    <div class="header content t-left">
                        <h2><?php _l('AvailablePackages');?></h2>
                    </div>
                    <div class="content-box">
                        <?php if ($this->session->flashdata('error_package')): ?>
                            <p class="alert alert-error"><?php echo $this->session->flashdata('error_package') ?></p>
                        <?php endif; ?>
                        <table class="table table-striped footable">
                            <thead>
                            <th data-breakpoints="xs" data-type="number">#</th>
                            <th data-type="html"><?php echo lang_check('Package name'); ?></th>
                            <th data-type="html"><?php echo lang_check('Price'); ?></th>
                            <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Free property activation'); ?></th>
                            <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Days limit'); ?></th>
                            <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('Listings limit'); ?></th>
                            <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Free featured limit'); ?></th>
                            </thead>
                            <tbody>
                                <?php
                                if (sw_count($packages)): foreach ($packages as $package):
                                        ?>
                                        <tr>
                                            <td><?php echo $package->id; ?></td>
                                            <td>
                                                <?php echo $package->package_name; ?>
                                                <?php echo $package->show_private_listings == 1 ? '&nbsp;<i class="fa fa-eye-open"></i>' : '&nbsp;<i class="fa fa-eye-close"></i>'; ?>
                                            </td>
                                            <td><?php echo $package->package_price . ' ' . $package->currency_code; ?></td>
                                            <td><?php echo $package->auto_activation ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'; ?></td>
                                            <td><?php echo $package->package_days; ?></td>
                                            <td><?php echo $package->num_listing_limit ?></td>
                                            <td><?php echo $package->num_featured_limit ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td ><?php echo lang_check('Not available'); ?></td>
                                    </tr>
                                <?php endif; ?>           
                            </tbody>
                        </table>
                        <?php if (isset($settings_activation_price) && isset($settings_featured_price) &&
                                $settings_activation_price > 0 || $settings_featured_price > 0):
                            ?>
                            <p class="row-fluid clearfix">
                                <br/>
                                <?php if ($settings_activation_price > 0): ?>
                                    <?php echo lang_check('* Property activation price:') . ' ' . $settings_activation_price . ' ' . $settings_default_currency; ?><br />
                                <?php endif; ?>
                                <?php if ($settings_featured_price > 0): ?>
                                    <?php echo lang_check('* Property featured price:') . ' ' . $settings_featured_price . ' ' . $settings_default_currency; ?>
                            <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div> <!-- /. widget-AVAILABLE PACKAGES -->   
                <?php endif; ?>
            
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="widget widget-styles" id="form">
                                <div class="header content t-left">
                                    <h2><?php _l('Login');?></h2>
                                </div>
                                <div class="local-form content-box"> 
                                     <?php echo form_open(NULL, array('class' => 'local-form form-additional widget-content'))?>
                                        <div class="box-alert row">
                                        <?php if($is_login):?>
                                        <?php echo validation_errors()?>
                                        <?php if($this->session->flashdata('error')):?>
                                        <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                        <?php endif;?>
                                        <?php flashdata_message();?>
                                        <?php endif;?>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label" for="inputUsername"><?php echo lang('Username')?></label>
                                          <div class="controls">
                                              <?php echo form_input('username', $this->input->get('username'), 'class="form-control" id="inputUsername" placeholder="'.lang('Username').'"')?>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label" for="inputPassword"><?php echo lang('Password')?></label>
                                          <div class="controls">
                                              <?php echo form_password('password', $this->input->get('password'), 'class="form-control" id="inputPassword" placeholder="'.lang('Password').'"')?>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <div class="checkbox">
                                                    <label for="remember">
                                                        <input type="checkbox" name="remember" id="remember" value="true" /> <?php echo lang('Remember me')?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-danger"><?php echo lang('Sign in')?></button>
                                                <button type="reset" class="btn btn-default"><?php echo lang('Reset')?></button>
                                                <a href="<?php echo site_url('admin/user/forgetpassword'); ?>"><em><?php echo lang_check('Forget password?')?></em></a>
                                            </div>
                                        </div>
                                    <?php echo form_close()?>

                                    <?php if(config_item('app_type') == 'demo'):?>
                                        <p class="alert alert-info"><?php echo lang_check('User creditionals: user, user')?></p>
                                    <?php endif;?>

                                    <?php if(config_item('appId') != '' && !empty($login_url_facebook)): ?>
                                        <a href="<?php echo $login_url_facebook; ?>" style="text-align:center;display:block;"><img src="assets/img/login-facebook.png" alt="facebook"/></a>
                                    <?php endif;?>

                                    <?php if(config_item('glogin_enabled')): ?>
                                        <a href="<?php echo site_url('api/google_login/'.$lang_id); ?>" style="text-align:center;display:block;"><img src="assets/img/login-google.png" alt="google"/></a>
                                    <?php endif;?>
                                    <?php if(file_exists(APPPATH.'libraries/Twlogin.php')): ?>
                                        <?php 
                                            $CI = &get_instance();
                                            $CI->load->library('twlogin');
                                        ?>
                                        <?php if($CI->twlogin->__get('consumerKey') && $CI->twlogin->__get('consumerSecret')): ?>
                                            <a href="<?php echo site_url('api/twitter_login/'.$lang_id); ?>" title style="text-align:center;display:block;"><img src="assets/img/twitter_signin.png" alt="twitter_login" /></a>
                                        <?php endif;?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="widget widget-styles" id="form2">
                                <div class="header content t-left">
                                    <h2><?php _l('Register');?></h2>
                                </div>
                                <div class="local-form content-box">   
                                    <?php echo form_open(NULL, array('class' => 'local-form form-additional widget-content'))?>
                                        <div class="box-alert row">
                                        <?php if($this->session->flashdata('error_registration') != ''):?>
                                        <p class="alert alert-success"><?php echo $this->session->flashdata('error_registration')?></p>
                                        <?php endif;?>
                                        <?php if($is_registration):?>
                                        <?php echo validation_errors()?>
                                        <?php endif;?>
                                        </div>
                                        <?php if(config_db_item('register_reduced') == FALSE): ?>
                                        <div class="form-group">
                                            <label for="inputNameSurname" class="control-label"><?php echo lang('FirstLast') ?></label>
                                            <div class="controls">
                                                <?php echo form_input('name_surname', set_value('name_surname', ''), 'class="form-control" id="inputNameSurname" placeholder="' . lang('FirstLast') . '"') ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputUsername2" class="control-label"><?php echo lang('Username') ?></label>
                                            <div class="controls">
                                                <?php echo form_input('username', set_value('username', ''), 'class="form-control" id="inputUsername2" placeholder="' . lang('Username') . '"') ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label for="inputMail" class="control-label"><?php echo lang('Email') ?></label>
                                            <div class="controls">
                                                <?php echo form_input('mail', set_value('mail', ''), 'class="form-control" id="inputMail" placeholder="' . lang('Email') . '"') ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword2" class="control-label"><?php echo lang('Password')?></label>
                                            <div class="controls">
                                                <?php echo form_password('password', set_value('password', ''), 'class="form-control" id="inputPassword2" placeholder="'.lang('Password').'" autocomplete="new-password"')?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPasswordConfirm" class="control-label"><?php echo lang('Confirmpassword')?></label>
                                            <div class="controls">
                                                <?php echo form_password('password_confirm', set_value('password_confirm', ''), 'class="form-control" id="inputPasswordConfirm" placeholder="'.lang('Confirmpassword').'" autocomplete="new-password"')?>
                                            </div>
                                        </div>
                                        <?php if(config_db_item('register_reduced') == FALSE): ?>
                                        <div class="form-group">
                                            <label for="inputAddress" class="control-label"><?php echo lang('Address')?></label>
                                            <div class="controls">
                                                <?php echo form_textarea('address', set_value('address', ''), 'placeholder="'.lang('Address').'" id="inputAddress" rows="3" class="form-control"')?>
                                            </div>
                                        </div>          

                                        <div class="form-group">
                                            <label for="inputPhone" class="control-label"><?php echo lang('Phone')?> <?php echo lang_check('PhoneAdd')?></label>
                                            <div class="controls">
                                                <?php echo form_input('phone', set_value('phone', ''), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                                            </div>
                                          </div>
                                        <?php endif; ?>

                                       <?php if(config_db_item('terms_link') !== FALSE): ?>
                                        <?php
                                            $site_url = site_url();
                                            $urlparts = parse_url($site_url);
                                            $basic_domain = $urlparts['host'];
                                            $terms_url = config_db_item('terms_link');
                                            $urlparts = parse_url($terms_url);
                                            $terms_domain ='';
                                            if(isset($urlparts['host']))
                                                $terms_domain = $urlparts['host'];

                                            if($terms_domain == $basic_domain) {
                                                $terms_url = str_replace('en', $lang_code, $terms_url);
                                            }
                                        ?>
                                        <div class="control-group">
                                          <label class="control-label"> <?php echo lang_check('Accept tems');?></label>
                                          <div class="controls">
                                              <input type="checkbox" value="1" name="terms_user" class="terms_user" required="required"> <a target="_blank" href="<?php echo $terms_url; ?>" style="line-height: 24px;vertical-align: top;display: inline-block;"><?php echo lang_check('I accept the Terms and Conditions'); ?></a>
                                          </div>
                                        </div>
                                        <?php endif;?>
                                        <?php if(config_db_item('privacy_link') !== FALSE): ?>
                                        <?php

                                            $site_url = site_url();
                                            $urlparts = parse_url($site_url);
                                            $basic_domain = $urlparts['host'];
                                            $privacy_url = config_db_item('privacy_link');
                                            $urlparts = parse_url($privacy_url);
                                            $privacy_domain ='';
                                            if(isset($urlparts['host']))
                                                $privacy_domain = $urlparts['host'];

                                            if($privacy_domain == $basic_domain) {
                                                $privacy_url = str_replace('en', $lang_code, $privacy_url);
                                            }
                                        ?>
                                        <div class="control-group">
                                          <label class="control-label"><?php echo lang_check('Accept privacy');?></label>
                                          <div class="controls">
                                            <input type="checkbox" value="1" name="privacy_user" class="privacy_user" required="required"> <a target="_blank" href="<?php echo $privacy_url; ?>" style="line-height: 24px;vertical-align: top;display: inline-block;"><?php echo lang_check('I accept the Privacy'); ?></a>
                                          </div>
                                        </div>
                                        <?php endif;?>
                                    
                                    
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
                                            <label class="control-label captcha"></label>
                                            <div class="controls">
                                                <?php _recaptcha(true); ?>
                                           </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-danger"><?php echo lang('Register')?></button>
                                                <button type="reset" class="btn btn-success"><?php echo lang('Reset')?></button>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> <!-- /.section-category -->
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>