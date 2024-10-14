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
                    <div class="row row-flex">
                        <div class="col-sm-8">
                            <div class="widget widget-agents-listing box box-fill" id="news">
                                <div class="">
                                    {page_body}
                                </div>
                            </div>
                            <div class="row">
                                <?php if(file_exists(APPPATH.'controllers/admin/news.php')):?> 
                                <div class="list-result property_content_position">
                                <?php foreach ($news_module_all as $key => $row): ?>
                                    <div class="col-xs-12">
                                        <div class="thumbnail thumbnail-property b thumbnail-blog-open">
                                            <div class="thumbnail-image full-width">
                                                <?php if (file_exists(FCPATH . 'files/thumbnail/' . $row->image_filename)): ?>
                                                    <img src="<?php echo _simg('files/' . $row->image_filename, '850x500', TRUE); ?>" alt="<?php _che($row->title); ?>" />
                                                <?php else: ?>
                                                    <img src="assets/img/no_image.jpg" alt="new-image">
                                                <?php endif; ?>
                                                <a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>"></a>
                                            </div>
                                            <div class="caption caption-blog">
                                                <h3 class="thumbnail-title"><a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h3>
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
                                                <div class="description">
                                                    <?php echo $row->description; ?>
                                                </div>
                                                <a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>" class="btn btn-custom btn-custom-secondary"><?php echo lang_check('View Post');?></a>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <?php endforeach; ?>
                                    <nav class="text-center">
                                        <div class="pagination news">
                                            <?php echo $news_pagination; ?>
                                        </div>
                                    </nav>
                                </div>   
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="col-sm-4  extra-b-title">
                            <?php if(file_exists(APPPATH.'controllers/admin/news.php')):?>
                            <?php if (true): ?>
                            <div class="widget-styles widget-search-box">
                                <div class="content-box">
                                    <form action="#" class="local-form">
                                        <div class="input-group input-with-search color-primary clearfix">
                                            <input type="text" id="search_news" name="search-agent" value="" class="form-control" placeholder="<?php _l('Search');?>">
                                            <button type="submit"  id="btn-search_news" class="input-group-addon"><i class="fa fa-search icon-white"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!--<div class="widget-styles widget">
                                <ul class="nav nav-tabs nav-stacked news-cat">
                                    <?php foreach ($categories as $id => $category_name): ?>
                                        <?php if ($id != 0): ?>
                                            <li><a href="{page_current_url}?cat=<?php echo $id; ?>#news"><?php echo $category_name; ?></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>-->
                            <div class="widget-styles widget-categories">
                                <h2 class="widget-title content-box t-left"><?php echo lang_check('Categories');?></h2>
                                <div class="content-box pt0">
                                    <ul class="categories-list">
                                        <?php foreach ($categories as $id => $category_name): ?>
                                            <?php if ($id != 0): ?>
                                                <li><a href="{page_current_url}?cat=<?php echo $id; ?>#news"><?php echo $category_name; ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php echo _widget('right_toptproperties');?>
                            <?php echo _widget('right_social');?>
                            <?php echo _widget('right_ads');?>
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
        <script>
            $(document).ready(function () {
                $("#btn-search_news").click(function (e) {
                    e.preventDefault();
                    if ($('#search_news').val().length > 2 || $('#search_news').val().length == 0)
                    {
                        $.post('<?php echo $ajax_news_load_url; ?>', {search: $('#search_news').val()}, function (data) {
                            $('.list-result').html(data.print);
                            console.log('list-result')
                            reloadElements();
                        }, "json");
                    }
                });
            });
        </script>
    </body>
</html>