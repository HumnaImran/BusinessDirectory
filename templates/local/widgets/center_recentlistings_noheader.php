 <?php
/*
Widget-title: Recentlistings results no header
Widget-preview-image: /assets/img/widgets_preview/center_recentlistings_noheader.jpg
 */
?>

<section class="section widget-recentproperties widget-center-recentproperties bg-default pt35 widget_edit_enabled">
    <div class="header">
        <div class="filters filters-box list-view-box clearfix no-padding-v no-padding-wide-h">
            <div class="hidden-xs grid-type">
                <a href="#" class="view-type grid active" data-ref="grid"><i class="fa fa-th"></i></a>
                <a href="#" class="view-type list" data-ref="list"><i class="fa fa-list"></i></a>
            </div>
            <div class="sort-filter">
                <label><?php _l('OrderBy'); ?></label>
                <select class="selectpicker-small">
                    <option value="id ASC" <?php _che($order_dateASC_selected); ?>><?php _l('DateASC'); ?></option>
                    <option value="id DESC" <?php _che($order_dateDESC_selected); ?>><?php _l('DateDESC'); ?></option>
                    <option value="counter_views ASC" <?php _che($order_viewsASC_selected); ?>><?php _l('viewsASC'); ?></option>
                    <option value="counter_views DESC" <?php _che($order_viewsDESC_selected); ?>><?php _l('viewsDESC'); ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="result_preload_box" id="results_conteiner">
        {has_no_results}
        <div class="result-answer">
            <div class="alert alert-success">
                <?php _l('Noestates');?>
            </div>
        </div>
        {/has_no_results}
        <?php if(!empty($results)):?>
        <div class="row result-container row-flex">
            <?php foreach($results as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-lg-4 col-md-6 thumbnail-g')); ?>
            <?php endforeach;?>
        </div>
        <div class="text-center">
            <nav aria-label="Page navigation" class="pagination properties">
                {pagination_links}
            </nav>
        </div>
        <?php endif;?>
        <div class="result_preload_indic"></div>
    </div>
</section>
            