<div class="widget widget-styles widget-form widget_edit_enabled" id='form'>
    <h2 class="widget-title text-center content"><?php echo lang_check('Contact Us');?></h2>
    <div class="content-box">
        <form action="{page_current_url}#form" method="post" class="local-form">
            {validation_errors} {form_sent_message}
            <!-- The form name must be set so the tags identify it -->
            <input type="hidden" name="form" value="contact" />

            <div class="form-group {form_error_firstname}">
                <input class="form-control" id="firstname" name="firstname" type="text" placeholder="<?php _l('FirstLast');?>" value="{form_value_firstname}" />
            </div>
            <div class="form-group {form_error_email}">
                <input class="form-control" id="email" name="email" type="text" placeholder="<?php _l('Email');?>" value="{form_value_email}" />
            </div>
            <div class="form-group {form_error_phone}">
                <input class="form-control" id="phone" name="phone" type="text" placeholder="<?php _l('Phone');?>" value="{form_value_phone}" />
            </div>
             <div class="form-group {form_error_address}">
                <input class="form-control" id="address" name="address" type="text" placeholder="<?php _l('Address');?>" value="{form_value_address}" />
            </div>

            <?php if(config_item('reservations_disabled') === FALSE ||
            (file_exists(APPPATH.'controllers/admin/booking.php') && sw_count($is_purpose_rent) && $this->session->userdata('type')=='USER' && config_item('reservations_disabled') === FALSE)): ?>
                {is_purpose_rent}
                <div class="form-group {form_error_fromdate}">
                    <input class="form-control"  id="datetimepicker1" name="fromdate" type="text" placeholder="<?php _l('FromDate');?>" value="{form_value_fromdate}" />
                </div><!-- /.form-group -->
                <div class="form-group {form_error_todate}">
                    <input class="form-control" id="datetimepicker2" name="todate" type="text" placeholder="<?php _l('ToDate');?>" value="{form_value_todate}" />
                </div><!-- /.form-group -->
            {/is_purpose_rent}
            <?php endif; ?>

            <div class="form-group {form_error_message}">
                <textarea id="message" name="message" rows="3" class="form-control resize-vertical" placeholder="<?php _l('Message');?>">{form_value_message}</textarea>
            </div>

            <?php if(config_item( 'captcha_disabled')===FALSE): ?>
            <div class="form-group {form_error_captcha}">
                <div class="row">
                    <div class="col-lg-12">
                        <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="<?php _l('Captcha');?>" value="" />
                        <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                        <br/>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $captcha[ 'image']; ?>
                    </div>
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
                                <div class="control-group control-gt-terms">
                                  
                                  <div class="controls">
                                    <?php echo form_checkbox('option_agree_terms', 'true', set_value('option_agree_terms', false), 'class="ezdisabled" id="inputOption_terms"')?>
                                  <a target="_blank" href="<?php echo $terms_url; ?>"><?php echo lang_check('I Agree To The Terms & Conditions'); ?></a>
</div>
                                </div>
                                <?php endif; ?>
                                



                                <?php if(config_db_item('privacy_link') !== FALSE && sw_count($not_logged)>0): ?>
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
                                <div class="control-group control-gt-terms">
                                  
                                  <div class="controls">
                                    <?php echo form_checkbox('option_privacy_link', 'true', set_value('option_privacy_link', false), 'class="novalidate" required="required" id="inputOption_privacy_link"')?>
                                 <a target="_blank" href="<?php echo $privacy_url; ?>"><?php echo lang_check('I Agree The Privacy'); ?></a>
 </div>
                                </div>
                                <?php endif; ?>
            <button type="submit" class="btn btn-custom btn-custom-grey btn-wide"><?php echo lang_check('Send Message');?></button>
        </form>
    </div>
</div>