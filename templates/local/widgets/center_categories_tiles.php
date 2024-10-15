 <?php
/*
Widget-title: Categories tiles field #79 or #2
Widget-preview-image: /assets/img/widgets_preview/center_categories_tiles.jpg
 */
 
$treefields = array();
$CI = & get_instance();
$treefield_id = 79;

if(isset($options_name_79)){
    $CI->load->model('treefield_m');
    $CI->load->model('option_m');
    $CI->load->model('file_m');

    $check_option= $CI->option_m->get_by(array('id'=>$treefield_id));

    $tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL, FALSE, '.order', ',image_filename, repository_id');

    if(!empty($tree_listings) && isset($tree_listings[0])) {

        $_treefields = $tree_listings[0];
        $treefields = array();
        foreach ($_treefields as $val) {

            $options = $tree_listings[0][$val->id];
            $treefield = array();
            $field_name = 'value' ;
            $treefield['id'] = trim($options->id);
            $treefield['title'] = trim($options->$field_name);
            $treefield['title_chlimit'] = character_limiter($options->$field_name, 15);

            $treefield['url'] = '';
            /* link if have body */
            if(!empty($options->{'body'}))
            {
                $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
                if(config_item('json_url_encoding')!==FALSE){
                    $href = str_replace('}', '%7D', $href);
                    $href = str_replace('{', '%7B', $href);
                }
                $treefield['url'] = $href;
            } else {
                $href = site_url($lang_code.'/'.config_db_item("results_page_id").'/?search={"v_search_option_'.$treefield_id.'":"'.rawurlencode($treefield['title'].' - ').'"}');
                if(config_item('json_url_encoding')!==FALSE){
                    $href = str_replace('}', '%7D', $href);
                    $href = str_replace('{', '%7B', $href);
                }
                $treefield['url'] = $href;
            }
            /* end if have body */

            /* Icons(second images) and big image */
            $treefield['thumbnail_url_second'] = 'assets/img/icon/category.png';
            $treefield['image_url_second'] = 'assets/img/icon/category.png';
            if(!empty($options->image_filename) && !empty($options->repository_id))
            {
                $files_r = $CI->file_m->get_by(array('repository_id' => $options->repository_id),FALSE, 5,'id ASC');

                  if($files_r and isset($files_r[1]) and file_exists(FCPATH.'files/thumbnail/'.$files_r[1]->filename)) {
                    $treefield['thumbnail_url_second'] = base_url('files/thumbnail/'.$files_r[1]->filename);
                    $treefield['image_url_second'] = base_url('files/'.$files_r[1]->filename);
                  }

            }
            /* end Icons(second images) and big image */

            $treefields[] = $treefield;
        }
    }
} else {
    $treefield_id = 2;
    foreach ($options_values_arr_2 as $key => $value) {
        $treefield = array();
        $treefield['id'] = $key;
        $treefield['thumbnail_url_second'] = '';
        $treefield['image_url_second'] = '';
        $treefield['title'] = $value;
        $treefields[]=$treefield;
    }
}
?>

<section class="section widget-recentproperties widget-center-recentproperties bg-default pt95 widget_edit_enabled">
    <div class="header hidden">
        <div class="title-location">
            <h2 class="location"><b><?php echo _l('Results');?></b></h2>
            <div class="count"><span class='total_rows'><?php echo $total_rows; ?></span> <?php echo lang_check('Results Found');?></div>
        </div>
        <div class="filters filters-box clearfix">
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
        <section class="section-category section widget-type2-categories ptr0" data-option-id="<?php echo $treefield_id;?>">
            <div class="section-title">
                <h2 class="title"><?php echo lang_check('Categories');?></h2>
                <span class="subtitle"><?php echo lang_check('Curabitur commodo orci lacus, in lacinia ligula porta vitae.');?></span>
            </div>
            <div class="clearfix result-container">
                <div class="grid-tiles">
                    <?php foreach ($treefields as $key=>$item): ?>
                        <?php if(empty(trim($item['title'])))continue;?>
                        <div class="grid-tile">
                            <?php if($treefield_id==79):?>
                            <a href='<?php _che($item['url']);?>'  data-type="<?php _che($item['title']);?> -">
                            <?php else:?>
                            <a href='<?php _che($item['url']);?>'  data-type="<?php _che($item['title']);?>">
                            <?php endif;?>
                                <div class="preview">
                                    <i class="custom-icon-type_<?php echo $item['id'];?>"></i>
                                </div>
                                <div class="caption">
                                    <h2 class="title"><?php _che($item['title']);?></h2>
                                </div>
                            </a>
                        </div>                    
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <div class="result_preload_indic"></div>
    </div>
</section>
