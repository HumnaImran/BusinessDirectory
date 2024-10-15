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
        <?php _widget('top_title');?>
        <main class="">
            <section class="section-category section container container-palette">
                <div class="container">
                    <div class="row row-flex">
                        <div class="col-sm-9">
                            <div class="widget widget-styles">
                                <h2 class="widget-title content-box content t-left">
                                    {page_title}
                                </h2>
                                <div class="content-box pt0"> 
                                 {page_body}
                                 {has_page_documents}
                                 <h5><?php _l('Filerepository');?>{</h5>
                                 <ul>
                                 {page_documents}
                                 <li>
                                     <a href="{url}">{filename}</a>
                                 </li>
                                 {/page_documents}
                                 </ul>
                                 {/has_page_documents}
                                    <?php if(file_exists(APPPATH.'controllers/admin/expert.php')):?>
                                    <div class="panel-group panel-content property_content_position panel-expert" id="accordionThree">
                                        <?php foreach($expert_module_all as $key=>$row):?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#accordionThree" href="#collapse<?php echo $key;?>" aria-expanded="false" class="collapsed">
                                                <i class="qmark">?</i>
                                                <h4 class="panel-title">
                                                        <?php echo $row->question; ?>                                        
                                                </h4>
                                                </a>
                                            </div>
                                            <div id="collapse<?php echo $key;?>" class="panel-collapse collapse <?php echo ($key==0) ? 'in' : '' ;?>" aria-expanded="<?php echo ($key==0) ? 'true' : 'false' ;?>" role="group">
                                                <div class="panel-body clearfix">
                                                    <?php if(!empty($row->answer_user_id) && isset($all_experts[$row->answer_user_id])): ?>
                                                    <a class="image_expert" href="<?php echo site_url('profile/'.$row->answer_user_id.'/'.$lang_code); ?>#content-position">
                                                        <img src="<?php echo $all_experts[$row->answer_user_id]['image_url']?>" alt="answer" />
                                                    </a>
                                                    <?php endif;?>
                                                    <?php echo $row->answer; ?>                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="widget widget-styles widget-form" id='form'>
                                <h2 class="widget-title text-center content"><?php echo lang_check('Ask');?></h2>
                                <div class="content-box">
                                    <form action="{page_current_url}#form" method="post">
                                        {validation_errors} {form_sent_message}
                                        <input type="hidden" name="form" value="contact" />
                                        <div class="form-group {form_error_firstname}">
                                            <input type="text" id="firstname" name='firstname' class="form-control" placeholder="<?php _l('FirstLast');?>" value="{form_value_firstname}">
                                        </div>
                                        <div class="form-group {form_error_email}">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="<?php _l('Email');?>" value="{form_value_email}">
                                        </div>
                                        <div class="form-group {form_error_phone}">
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="<?php _l('Phone');?>" value="{form_value_phone}" >
                                        </div>
                                        <div class="form-group {form_error_question}">
                                            <textarea id="question" name="question" rows="3" class="form-control" placeholder="<?php _l('Question');?>">{form_value_question}</textarea>
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
                                    <?php echo form_checkbox('option_agree_terms', 'true', set_value('option_agree_terms', false), 'class="novalidate" required="required" id="inputOption_terms"')?>
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
                                        <div class="form-group submit-box">
                                            <button type="submit" class="btn btn-custom btn-custom-grey btn-wide"><?php _l('Send');?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> <!-- /.section-category -->
            <?php _widget('bottom_imagegallery');?>
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>