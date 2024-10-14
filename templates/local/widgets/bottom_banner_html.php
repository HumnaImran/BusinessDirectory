 <?php
/*
Widget-title: Banner (HTML)
Widget-preview-image: /assets/img/widgets_preview/bottom_banner_html.jpg
 */
?>

<section class="section container container-palette bg-mask-imp section-inv widget_edit_enabled" data-parallax="scroll" data-image-src="assets/img/pic/places/offers.jpg">
    <div class="container">
        <div class="inv-block">
            <h2 class="title"><?php echo lang_check('Start Exploring Today');?></h2>
            <a href="<?php echo  site_url($lang_code.'/'.config_db_item("results_page_id"));?>" class="btn btn-custom btn-custom-secondary"><?php echo lang_check('Search');?></a>
        </div>
    </div>
</section>