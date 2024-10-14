 <?php
/*
Widget-title: Lastlistings slim
Widget-preview-image: /assets/img/widgets_preview/top_lastlistings_slim.jpg
 */
?>

<section class="section-picks section container container-palette widget_edit_enabled">
    <div class="container">
        <div class="section-title slim">
            <h2 class="title"><?php _l('Lastaddedproperties'); ?></h2>
        </div>
        <div class="row result-container row-flex">
            <?php foreach($last_estates as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-md-4 col-sm-12')); ?>              
            <?php endforeach;?>
        </div>
    </div>
</section> <!-- /.section-picks -->