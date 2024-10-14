<div class="widget widget-search widget-customside_center_recentlistings  widget-top_search-cityguide scale-hidden">
    <div class="filters filters-box">
        {is_logged_other}
        <div class="widget-controls-panel">
            <a href="<?php echo site_url('admin/forms/edit/3');?>" target="_blunk" class="btn btn-edit"><i class="ion-edit"></i></a>
        </div>
        {/is_logged_other}
        <form action="{page_current_url}#search-form" class="local-form search-form">
            <input id="rectangle_ne" type="text" class="hidden" />
            <input id="rectangle_sw" type="text" class="hidden" />
            <div class="row">
                <?php _search_form_primary(3, 'horizontal/') ;?> 
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom btn-custom-secondary btn-wide btn-search-icon" id="search-start"><i class="ion-ios-search-strong hide_on_ajax"></i><i class="fa fa-spinner fa-spin fa-ajax-indicator ajax_v hidden"></i></button>
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>
<div class="widget widget-recentproperties">
        <div class="header">
            <div class="title-location">
                <h2 class="location"><b><?php echo _l('Results');?></b></h2>
                <div class="count"><span class='total_rows'><?php echo $total_rows; ?></span> <?php echo lang_check('Results Found');?></div>
            </div>
            <div class="filters filters-box list-view-box">
                <div class="hidden-xs grid-type">
                    <a href="#" class="view-type grid" data-ref="grid"><i class="fa fa-th"></i></a>
                    <a href="#" class="view-type list active" data-ref="list"><i class="fa fa-list"></i></a>
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
        <div class="result_preload_box results-col-sm-2" id="results_conteiner">
            {has_no_results}
            <div class="result-answer">
                <div class="alert alert-success">
                    <?php _l('Noestates');?>
                </div>
            </div>
            {/has_no_results}
            <?php if(!empty($results)):?>
                <div class="row result-container row-flex">
                    <?php _widget('results_list');?>
                </div>
                <div class="text-center">
                    <nav aria-label="Page navigation" class="pagination properties">
                        {pagination_links}
                    </nav>
                </div>
            <?php endif;?>
            <div class="result_preload_indic"></div>
        </div>
    </div>
