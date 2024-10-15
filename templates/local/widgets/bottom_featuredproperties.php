 <?php
/*
Widget-title: Featuredproperties
Widget-preview-image: /assets/img/widgets_preview/bottom_featuredproperties.jpg
 */
?>

<section class="section-picks section container container-palette widget_edit_enabled">
    <div class="container">
        <div class="section-title">
            <h2 class="title"><?php echo lang_check('Featured');?></h2>
        </div>
        <div class="row result-container row-flex">
            <?php foreach($featured_properties as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-lg-4 col-md-6 thumbnail-g')); ?>
            <?php endforeach;?>
        </div>
    </div>
</section>