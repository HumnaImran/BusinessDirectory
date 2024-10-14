<?php if(!empty($settings_facebook_comments)): ?>
<div class="widget-styles widget_edit_enabled">
    <div class="header content t-left"><h2><?php echo lang_check('Facebook comments'); ?></h2></div>
    <div class="content-box">
        <?php echo str_replace('http://example.com/comments', $page_current_url, $settings_facebook_comments); ?>
    </div>
</div>
<?php endif;?>
