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
        <?php _widget('top_slider');?>
        <?php _widget('top_searchvisual');?>
        <main class="zebra-childs">
            <?php _widget('top_recentlistings_list');?>
            <?php _widget('top_categories2_64');?>
            <?php _widget('top_lastlistings');?>
            <?php _widget('top_recentreviews');?>
            <?php _widget('top_recentarticles');?>
            <?php _widget('bottom_defaultcontent');?>
            <?php _widget('bottom_imagegallery_section');?>
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>