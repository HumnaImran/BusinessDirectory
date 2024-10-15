<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
        <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/dpejes/dpe.js')): ?>
        <script src="assets/js/dpejes/dpe.js"></script>
        <?php endif; ?>
        <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>
        <script src="assets/js/places.js"></script>
        <?php endif; ?>
    </head>
    <body class="<?php _widget('custom_paletteclass'); ?>">
        <?php if (!empty($settings_facebook_jsdk) && (config_db_item('appId') == '' || !file_exists(FCPATH . 'templates/' . $settings_template . '/assets/js/like2unlock/js/jquery.op.like2unlock.min.js'))): ?>
        <?php
        if (!empty($lang_facebook_code))
            $settings_facebook_jsdk = str_replace('en_EN', $lang_facebook_code, $settings_facebook_jsdk);
        ?>
        <?php echo $settings_facebook_jsdk; ?>
        <?php endif; ?>
        <header class="header">
            <?php _widget('custom_header_menu-for-loginuser_wide');?>
            <?php _widget('header_main_color');?>
        </header><!-- /.header -->
        <main class="main container container-palette"> 
            <?php _widget('property_top_images_carousel');?>
            <?php _widget('property_top_title');?>
            <div class="container container-palette widget">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <?php
                            foreach ($widgets_order->center as $widget_filename) {
                                _widget('property_'.$widget_filename);
                            }
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            foreach ($widgets_order->right as $widget_filename) {
                                _widget('property_'.$widget_filename);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
        
        <script>
            $(document).ready(function() {
            <?php if(file_exists(APPPATH.'controllers/admin/favorites.php')):?>
                // [START] Add to favorites //  

                $("#add_to_favorites").click(function(){

                    var data = { property_id: {estate_data_id} };

                    var load_indicator = $(this).find('.load-indicator');
                    load_indicator.css('display', 'inline-block');
                    $.post("{api_private_url}/add_to_favorites/{lang_code}", data, 
                           function(data){

                        ShowStatus.show(data.message);

                        load_indicator.css('display', 'none');

                        if(data.success)
                        {
                            $("#add_to_favorites").css('display', 'none');
                            $("#remove_from_favorites").css('display', 'inline-block');
                        }
                    });

                    return false;
                });

                $("#remove_from_favorites").click(function(){

                    var data = { property_id: {estate_data_id} };

                    var load_indicator = $(this).find('.load-indicator');
                    load_indicator.css('display', 'inline-block');
                    $.post("{api_private_url}/remove_from_favorites/{lang_code}", data, 
                           function(data){

                        ShowStatus.show(data.message);

                        load_indicator.css('display', 'none');

                        if(data.success)
                        {
                            $("#remove_from_favorites").css('display', 'none');
                            $("#add_to_favorites").css('display', 'inline-block');
                        }
                    });

                    return false;
                });

                // [END] Add to favorites //  
            <?php endif; ?>
            });

        </script>
        {is_logged_other}
        <div class="widget-controls-panel-template">
            <a href="<?php echo site_url('admin/templates');?>" class="btn btn-edit"><i class="ion-edit"></i></a>
        </div>
        {/is_logged_other}
    </body>
</html>