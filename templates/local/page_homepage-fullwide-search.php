<!DOCTYPE html>
<html lang="en">
    <head>
         <?php _widget('head');?>
    </head>
    <body>
        <header class="header">
            <?php _widget('custom_header_menu-for-loginuser_wide');?>
            <?php _widget('header_main_color');?>
        </header><!-- /.header -->
        <div class="container container-palette container-wide bg-tr">
            <div class="flex-md row-fluid bg-tr">
                <div class="col-md-6 left-side">
                    <?php _widget('custom_fullwide_search');?>
                </div>
                <div class="col-md-6 right-side bg-default">
                    <?php _widget('custom_fullwide_random_categories');?>
                    <?php _widget('custom_fullwide_new_listings');?>
                </div>
            </div>
        </div> 
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'slim_center_grey')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>