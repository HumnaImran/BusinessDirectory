 <?php
/*
Widget-title: Featuredproperties carousel
Widget-preview-image: /assets/img/widgets_preview/bottom_featuredproperties_carousel.jpg
 */
?>

<section class="section-picks section container container-palette widget_edit_enabled">
    <div class="container">
        <div class="section-title slim">
            <h2 class="title"><?php echo lang_check('Featured');?></h2>
        </div>
        <div id="owl-carousel-items" class="owl-carousel-items owl-carousel owl-theme owl-carousel-property">
            <?php foreach($featured_properties as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'item')); ?>
            <?php endforeach;?>
        </div>
    </div>
</section> <!-- /.section-picks -->
