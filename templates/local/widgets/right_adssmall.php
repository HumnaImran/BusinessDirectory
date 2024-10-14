<?php
/*
Widget-title: Widget ads
Widget-preview-image: /assets/img/widgets_preview/right_ads.jpg
*/
?>
<aside class="widget widget-ads widget_edit_enabled">
    <div class="widget-header hidden vert-line-r-l vert-line-blue">
        <h2><?php echo lang_check('Ads');?></h2>
    </div>
    <div class="widget-content text-center">
        <?php if(file_exists(APPPATH.'controllers/admin/ads.php')):?>
        {has_ads_180x150px}
        <a href="{random_ads_180x150px_link}" target="_blank"><img src="{random_ads_180x150px_image}" alt="ads" /></a>
        {/has_ads_180x150px}
        <?php elseif(!empty($settings_adsense160_600)): ?>
            <?php echo $settings_adsense160_600; ?>
        <?php endif; ?>
    </div>
</aside> <!-- /. ads -->