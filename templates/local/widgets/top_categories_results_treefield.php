 <?php
/*
Widget-title: Categories results treefield
Widget-preview-image: /assets/img/widgets_preview/top_categories_results_treefield.jpg
 */
?>

<?php

if(!function_exists('recursion_calc_count')) {
    function recursion_calc_count ($result_count, $tree_listings, $parent_title, $id, &$child_count){
        if (isset($tree_listings[$id]) && sw_count($tree_listings[$id]) > 0){
            foreach ($tree_listings[$id] as $key => $_child) {
                $options = $tree_listings[$_child->parent_id][$_child->id];
                if(isset($result_count[$parent_title.' - '.$options->value.' -']))
                    $child_count+= $result_count[$parent_title.' - '.$options->value.' -'];

                $_parent_title = $parent_title.' - '.$options->value;
                if (isset($tree_listings[$_child->id]) && sw_count($tree_listings[$_child->id]) > 0){    
                    recursion_calc_count($result_count, $tree_listings, $_parent_title, $_child->id, $child_count);
                }
            }
        }
    }
}

$CI = & get_instance();
$treefield_id = 64;

$CI->load->model('treefield_m');

$treefields = array();

$check_option= $CI->option_m->get_by(array('id'=>$treefield_id));

$disabled = false;
// check if option exists
if(!$check_option)
    $disabled = true;

if($check_option[0]->type!='TREE')
    $disabled = true;

$tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL, FALSE, '.order', ',image_filename');

if(empty($tree_listings) || !isset($tree_listings[0]))
    $disabled = true;

// count listing
/*SELECT `property`.id, 
`property`.`is_activated`,
`property_value`.`property_id`,
`property_value`.`value`, 
COUNT(value)
FROM `property`
LEFT JOIN `property_value` ON `property`.id = `property_value`.`property_id`
 WHERE `option_id`= 64 and `language_id`=1 and `is_activated`=1 GROUP BY `value`
*/

if(!$disabled) {
    $this->db->select('property_value.value, COUNT(value) as count');

    $this->db->join('property_value', 'property.id = property_value.property_id');

    $this->db->group_by('property_value.value');  
    $this->db->where('option_id', $treefield_id);
    $this->db->where('language_id', $lang_id);
    $this->db->where('is_activated', 1);
    $this->db->where('is_visible', 1);

    if(config_db_item('listing_expiry_days') !== FALSE)
    {
        if(is_numeric(config_db_item('listing_expiry_days')) && config_db_item('listing_expiry_days') > 0)
        {
            $this->db->where('date_modified >', date("Y-m-d H:i:s" , time() - config_db_item('listing_expiry_days')*86400));
        }
    }
    
    $query= $this->db->get('property');

    $result_count = array();

    if($query){
        $result = $query->result();
        foreach ($result as $key => $value) {
            if(!empty($value->value))
                $result_count[$value->value]= $value->count;
        }
    }

    $_treefields = $tree_listings[0];

    $treefields = array();
    foreach ($_treefields as $val) {

        $options = $tree_listings[0][$val->id];
        $treefield = array();
        $field_name = 'value' ;
        $treefield['title'] = $options->$field_name;
        $treefield['title_chlimit'] = character_limiter($options->$field_name, 15);

        $field_name = 'body';
        $treefield['descriotion'] = $options->$field_name;
        $treefield['description_chlimit'] = character_limiter($options->$field_name, 50);

        $treefield['count'] = 0;
        if(isset($result_count[$treefield['title'].' -']))
            $treefield['count'] = $result_count[$treefield['title'].' -'];

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

        // Thumbnail and big image
        if(!empty($options->image_filename) and file_exists(FCPATH.'files/thumbnail/'.$options->image_filename))
        {
            $treefield['thumbnail_url'] = base_url('files/thumbnail/'.$options->image_filename);
            $treefield['image_url'] = base_url('files/'.$options->image_filename);
        }
        else
        {
            $treefield['thumbnail_url'] = 'assets/img/no_image.jpg';
            $treefield['image_url'] = 'assets/img/no_image.jpg';
        }

        $childs_count = 0;
        $childs = array();
        if (isset($tree_listings[$val->id]) && sw_count($tree_listings[$val->id]) > 0)
            foreach ($tree_listings[$val->id] as $key => $_child) {
                $child = array();
                $options = $tree_listings[$_child->parent_id][$_child->id];
                $field_name = 'value';
                $child['title'] = $options->$field_name;
                $child['title_chlimit'] = character_limiter($options->$field_name, 10);

                $field_name = 'body';
                $child['descriotion'] = $options->$field_name;
                $child['descriotion_chlimit'] = character_limiter($options->$field_name, 50);

                $child['count']= 0;
                if(isset($result_count[$treefield['title'].' - '.$child['title'].' -']))
                    $child['count'] = $result_count[$treefield['title'].' - '.$child['title'].' -'];

                $child['url'] = '';

                /* link if have body */
                    if(!empty($options->$field_name))
                    {
                        // If slug then define slug link
                        $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
                        $child['url'] = $href;
                    }
                /* end if have body */
                    
                if (isset($tree_listings[$_child->id]) && sw_count($tree_listings[$_child->id]) > 0){
                    $parent_title = $treefield['title'].' - '.$child['title'];
                    recursion_calc_count($result_count, $tree_listings, $parent_title, $_child->id, $child['count']);
                }   
                    
                $childs_count+=$child['count'];
                $childs[] = $child;
            }

        $treefield['count'] += $childs_count;
        $treefield['childs'] = $childs;
        $treefield['childs_more'] = array_slice($childs, 8);
        $treefield['childs_8'] = array_slice($childs, 0, 8);
        $treefields[] = $treefield;
    }
}

?>

<?php if(search_value($treefield_id)) : ?>
<?php _widget('top_recentlistings');?>  
<?php else: ?>
    
<section class="section widget-recentproperties container container-palette bg-default widget_edit_enabled">
    <div class="header hidden">
        <div class="container">
            <div class="title-location">
                <h2 class="location"><b><?php echo _l('Results');?></b></h2>
                <div class="count"><span class='total_rows'><?php echo $total_rows; ?></span> <?php echo lang_check('Results Found');?></div>
            </div>
        </div>
        <div class="filters filters-box">
            <div class="container">
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
    </div>
    <div class="container result_preload_box" id="results_conteiner">
       
    <?php if(!$disabled): ?>
        <div class='row row-flex'>
        <?php foreach ($treefields as $key=>$item): ?>

        <div class="col-md-4 col-sm-6">
            <div class="thumbnail thumbnail-property">
                <div class="thumbnail-image">
                    <img src="<?php echo _simg($item['thumbnail_url'], '380x250'); ?>" alt="<?php _che($item['title']); ?>" />
                    <!--  <img class="mobile-preview" src="<?php echo _simg($item['thumbnail_url'], '612x386'); ?>" alt="<?php _che($item['option_10']); ?>"> -->
                    <a href="<?php echo $item['url']; ?>"></a>
                    <div class="icons">
                    </div>
                </div>
                <div class="caption caption-blog">
                    <h3 class="thumbnail-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['title']); ?></a></h3>
                    <div class="date">
                        <ul class="treefield-categories-list">
                            <?php if (count($item['childs_8']) > 0) foreach ($item['childs_8'] as $child): ?>
                                <?php if(!empty($child['url'])): ?>
                                <li>
                                    <a class="treefield-box-item btn-default" href="<?php _che($child['url']); ?>"><?php _che($child['title']); ?></a>
                                    <span class="count text-color-primary"><?php _che($child['count']);?></span>
                                </li>
                                <?php else:?>
                                <li>
                                    <?php 
                                    $href = site_url($lang_code.'/'.config_db_item("results_page_id").'/?search={"v_search_option_'.$treefield_id.'":"'.$item['title'].' - '.$child['title'].' - '.'"}');
                                    if(config_item('json_url_encoding')!==FALSE){
                                        $href = str_replace('}', '%7D', $href);
                                        $href = str_replace('{', '%7B', $href);
                                    }
                                    ?>
                                    <a class="treefield-box-item btn-default" href='<?php echo $href; ?>'><?php _che($child['title']); ?></a>
                                    <span class="count text-color-primary"><?php _che($child['count']);?></span>
                                </li>           
                                <?php endif;?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>   
        <?php endforeach; ?>
        </div>
    <?php endif;?>
     <div class="result_preload_indic"></div>
    </div>
</section>
<?php endif;?>

<script>
    $('document').ready(function(){
        $('#search-start').on('click', function(){
            $('.widget-recentproperties .header').removeClass('hidden');
        })
    })
</script>