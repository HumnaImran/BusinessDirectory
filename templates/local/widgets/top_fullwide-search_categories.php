<?php
/*
Widget-title: Fullwide side search with categories
Widget-preview-image: /assets/img/widgets_preview/top_fullwide-search_categories.jpg
 */
?>


<div class="container container-palette container-wide bg-tr widget_edit_enabled">
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