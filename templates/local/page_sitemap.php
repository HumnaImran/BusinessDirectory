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
            <?php _widget('bottom_defaultcontent_border');?>
            <section class="section-category section container container-palette">
                <div class="container">
                    <?php if(file_exists(APPPATH.'controllers/admin/treefield.php')):?>
                    <div class="widget widget-styles">
                        <h2 class="widget-title content-box content t-left">
                            <?php echo lang_check('Neighborhood Sitemap');?>
                        </h2>
                        <div class="content-box"> 
                            <?php echo treefield_sitemap(64, $lang_id, 'ul'); ?>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="widget widget-styles widget-sitemap">
                        <h2 class="widget-title content-box content t-left">
                            <?php echo lang_check('Website sitemap');?>
                        </h2>
                        <div class="content-box"> 
                             <?php echo website_sitemap($lang_id, 'ul'); ?>
                        </div>
                    </div>
                </div>
            </section> <!-- /.section-category -->
        </main>
        <?php _widget('bottom_imagegallery_section');?>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>