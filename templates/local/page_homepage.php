<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
    </head>
    <body class="<?php _widget('custom_paletteclass'); ?> page-page_homepage">
        <header class="header">
            <?php _widget('custom_header_menu-for-loginuser');?>
            <?php _widget('header_main');?>
        </header><!-- /.header -->
        <?php _widget('top_map');?>
        <main class="slim-sections">
            <?php _widget('top_search');?>
            <?php _widget('top_recentlistings');?>
            <?php _widget('top_categories_slim');?>
            <?php _widget('top_how_it_works_html');?>
            <?php _widget('top_toplistings_slim');?>
        </main>
        <?php _widget('bottom_banner_html');?>
        <?php _widget('bottom_defaultcontent');?>
        <?php _widget('bottom_imagegallery_section');?>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'slim')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>