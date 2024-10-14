<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
    </head>
    <body class="<?php _widget('custom_paletteclass'); ?>">
        <?php _widget('custom_header_menu-for-loginuser_wide');?>
        <header class="header">
            <?php _widget('header_bannerfullheight_menu');?>
        </header><!-- /.header -->
        <main class="slim-sections">
            <div class="section-category section container container-palette">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <?php _widget('center_recentlistings');?>
                            <?php _widget('center_defaultcontent_border');?>
                        </div>
                        <div class="col-sm-3">
                            <?php _widget('right_searchvisual');?>  
                            <?php _widget('right_facebooklike');?>  
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php _widget('bottom_imagegallery');?>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>