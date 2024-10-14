 <?php
/*
Widget-title: Banner full height with menu
Widget-preview-image: /assets/img/widgets_preview/header_bannerfullheight_menu.jpg
 */
?>
<div class="widget_edit_enabled">
    <div class="container container-palette top-bar overflow top-bar-white t-overflow affix-menu affix-menu-m21">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left logo"> 
                    <a href="{homepage_url_lang}">
                   <?php if(!empty($website_logo_url) && stripos($website_logo_url, 'assets/img/logo.png') === FALSE):?>
                        <img src="<?php echo $website_logo_url; ?>" alt="{settings_websitetitle}">
                     <?php else:?>
                        <?php echo $settings_websitetitle;?>
                    <?php endif;?>
                    </a>
                </div>
                <?php _widget('custom_langmenu');?>
                <div class="top-bar-btns">
                    <ul class="nav-items">
                    <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                    {not_logged}
                        <li><a href="{front_login_url}#content" data-toggle="modal" data-target="#login-modal" class="btn btn-custom-default"><?php echo lang_check('Log In');?></a></li>
                    {/not_logged}
                    {is_logged_user}
                        <li><a href="{logout_url}" class="btn btn-custom-default"><?php _l('Logout');?></a></li>
                    {/is_logged_user}
                    {is_logged_other}
                        <li><a href="{logout_url}" class="btn btn-custom-default"><?php _l('Logout');?></a></li>
                    {/is_logged_other}
                    <?php endif;?>
                        <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                            <?php if(config_db_item('enable_qs') == 1): ?>
                                <li><a href="<?php echo site_url('fquick/submission/'.$lang_code); ?>" class="btn btn-custom-primary"><?php echo lang_check('Add listing');?></a></li>
                            <?php else: ?>
                                <li><a href="{myproperties_url}" class="btn btn-custom-primary"><?php echo lang_check('Add listing');?></a></li>
                            <?php endif; ?>
                        <?php endif;?>
                    </ul>
                    <button type="button" class="navbar-toggle" id="navigation-toogle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="pull-right navigation-wrapper">
                    <a href="" class="button-close"></a> 
                    <div class="logo"><a href="{homepage_url_lang}">{settings_websitetitle}</a></div>
                    <?php _widget('custom_mainmenu');?>
                    <?php _widget('custom_lang-menu-mobile');?>
                    <ul class="lang-menu-mobile actions-mobile">
                    <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                        {not_logged}
                        <li><a href="{front_login_url}#content" data-toggle="modal" data-target="#login-modal" class="btn btn-custom-primary"><?php echo lang_check('Log In');?></a></li>
                        {/not_logged}
                        {is_logged_user}
                            <li><a href="{logout_url}" class="btn btn-custom-primary"><?php _l('Logout');?></a></li>
                        {/is_logged_user}
                        {is_logged_other}
                            <li><a href="{logout_url}" class="btn btn-custom-primary"><?php _l('Logout');?></a></li>
                        {/is_logged_other}
                        <?php endif;?>
                            <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                                <?php if(config_db_item('enable_qs') == 1): ?>
                                    <li><a href="<?php echo site_url('fquick/submission/'.$lang_code); ?>" class="btn btn-custom-primary"><?php echo lang_check('Add listing');?></a></li>
                                <?php else: ?>
                                    <li><a href="{myproperties_url}" class="btn btn-custom-primary"><?php echo lang_check('Add listing');?></a></li>
                                <?php endif; ?>
                            <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="container container-palette section widget-top-parralax full-vh scroll-box" data-parallax="scroll" data-image-src="assets/img/pic/dsc0017.jpg">
        <div class="container">
            <div class="body">
                <h1 class="title">{page_title}</h1>
                <span class="subtitle"><?php echo lang_check('Get in touch with us');?></span>
            </div>
            <div class="scroll-button"></div>
        </div>
    </section>
</div>