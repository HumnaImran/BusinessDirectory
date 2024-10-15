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
        <?php _widget('top_title_4');?>
        <?php _widget('top_contact_map');?>
        <main class="">
            <div class="section container container-palette">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="widget body">
                                {page_body}
                            </div>
                            <?php _widget('center_contact_form');?>
                        </div>
                        <div class="col-sm-3">
                            <?php _widget('right_ads');?>
                        </div>
                    </div>
                </div>
            </div> <!-- /.section-form -->
            <?php _widget('bottom_imagegallery');?>
        </main>
        
        
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>