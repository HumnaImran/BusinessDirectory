<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
    </head>
    <body class="<?php _widget('custom_paletteclass'); ?>">
        <header class="header">
            <?php _widget('custom_header_menu-for-loginuser_wide');?>
            <?php _widget('header_searchbanner_menu_map_guide');?>
        </header><!-- /.header -->
        <main class="slim-sections">
            <?php _widget('top_categories_tiles');?>
            <?php _widget('top_lastlistings');?>
            <?php _widget('top_banner_wp_html');?>
            <?php _widget('top_location');?>
        </main>
        
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>