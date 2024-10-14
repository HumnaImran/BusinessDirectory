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
        <?php _widget('top_title_3');?>
        <main class="">
            <section class="section-category section container container-palette">
                <div class="container">
                    <div class="widget widget-agents-listing box box-fill" id="news">
                        <div class="">
                            {page_body}
                        </div>
                    </div>
                    <div class="list-result property_content_position">
                        <div class="row row-flex">
                        <?php foreach ($news_articles as $key => $row): ?>
                            <div class="col-sm-4">
                                <div class="thumbnail thumbnail-property no-cover">
                                    <div class="thumbnail-image">
                                        <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                                        <img src="<?php echo _simg('files/'.$row->image_filename, '855x495', FALSE); ?>" alt="<?php _che($row->title);?>" />
                                        <?php else:?>
                                            <img src="assets/img/no_image.jpg" alt="new-image">
                                        <?php endif;?>
                                        <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>">
                                        </a>
                                        <div class="icons sample">
                                            <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><i class="ion-forward"></i></a>
                                        </div>
                                    </div>
                                    <div class="caption caption-blog">
                                        <h3 class="thumbnail-title"><a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h3>
                                        <span class="date">
                                            <i class="ion-clock"></i>                                                    
                                            <?php
                                            $timestamp = strtotime($row->date);
                                            $m = strtolower(date("F", $timestamp));
                                            echo lang_check('cal_' . $m) . ' ' . date("j, Y", $timestamp);
                                            ?>
                                            ∙ 
                                            <?php foreach (explode(',', $row->keywords) as $val): ?>
                                               <?php echo trim($val); ?> 
                                            <?php endforeach; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>   
                    </div>
                </div>
            </section> <!-- /.section-category -->
        </main>
        <?php _widget('bottom_imagegallery');?>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
        <script>
            $(document).ready(function(){
                $("#btn-search_showroom").click( function(e) { 
                    e.preventDefault();
                    if($('#search_showroom').val().length > 2 || $('#search_showroom').val().length == 0)
                    {
                        $.post('<?php echo $ajax_showroom_load_url; ?>', {search: $('#search_showroom').val()}, function(data){
                            $('.list-result').html(data.print);
                            reloadElements();
                        }, "json");
                    }
                });
            });    
        </script>
    </body>
</html>