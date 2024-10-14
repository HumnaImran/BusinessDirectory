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
        <?php _widget('top_geomapsearch');?>
        <main class="slim-sections">
            <div class="section-category section container container-palette">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <?php _widget('center_recentlistings');?>
                        </div>
                        <div class="col-sm-3">
                            <?php _widget('right_facebooklike');?>  
                            <?php _widget('right_customfilter');?>  
                            <?php _widget('right_categoriesmenu');?>  
                            <?php _widget('right_mortgage');?>
                            <?php _widget('right_ads');?>  
                            <?php _widget('right_lastproperties-slim');?>  
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php _widget('bottom_toplistings_slim');?>
        <?php _widget('bottom_how_it_works_html');?>
        <?php _widget('bottom_banner_html');?>
        <?php _widget('bottom_defaultcontent');?>
        <?php _widget('bottom_imagegallery_section');?>
        
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'slim')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>