<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
    <style>
        
        #codeigniter_profiler {
            display: none;
        }
        
    </style>
    </head>
    <body class="wrap-side">
        <div class="fullscreen-top-md">
            <?php _widget('custom_header_menu-for-loginuser_wide');?>
            <?php _widget('customside_header_main_color');?>
        </div>
        <div class="container container-palette container-wide">
            <div class="flex-md swap-md-down">
                <div class="col-md-6 swap-bottom left-side fullscreen-inner-md">
                    <?php _widget('customside_center_recentlistings_list');?>
                </div>
                <div class="col-md-6 swap-top right-side fullscreen-map-md">
                    <?php _widget('customside_center_map');?>
                </div>
            </div>
        </div> 
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>