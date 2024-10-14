 <?php
/*
Widget-title: Last listings
Widget-preview-image: /assets/img/widgets_preview/bottom_lastlistings.jpg
 */
?>

<section class="section-picks section container container-palette widget_edit_enabled">
    <div class="container">
        <div class="section-title">
            <h2 class="title"><?php _l('Lastaddedproperties'); ?></h2>
            <span class="subtitle"><?php echo lang_check('Maecenas mauris arcu, congue ac lorem vel libero.');?></span>
        </div>
        <div class="row result-container row-flex">
            <?php foreach($last_estates as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-md-4 col-sm-12')); ?>               
            <?php endforeach;?>
        </div>
    </div>
</section> <!-- /.section-picks -->