<?php
/*
Widget-title: Destinations
Widget-preview-image: /assets/img/widgets_preview/top_destinations.jpg
 */
?>

<?php

if(!function_exists('recursion_calc_count')) {
    function recursion_calc_count ($result_count, $tree_listings, $parent_title, $id, &$child_count){
        if (isset($tree_listings[$id]) && sw_count($tree_listings[$id]) > 0){
            foreach ($tree_listings[$id] as $key => $_child) {
                $options = $tree_listings[$_child->parent_id][$_child->id];
                if(isset($result_count[strtolower($parent_title.' - '.$options->value.' -')]))
                    $child_count+= $result_count[strtolower($parent_title.' - '.$options->value.' -')];

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
$CI->load->model('option_m');
$CI->load->model('file_m');

$treefields = array();

$check_option= $CI->option_m->get_by(array('id'=>$treefield_id));
// check if option exists
if(!$check_option)
    return false;

if($check_option[0]->type!='TREE')
    return false;

$tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL, FALSE, '.order', ',image_filename, repository_id, description');

if(empty($tree_listings) || !isset($tree_listings[0]))
    return false;

$_treefields = $tree_listings[0];
$treefields = array();
foreach ($_treefields as $val) {
    $options = $tree_listings[0][$val->id];
    $treefield = array();
    $field_name = 'value' ;
    $treefield['id'] = trim($options->id);
    $treefield['title'] = trim($options->$field_name);
    $treefield['title_chlimit'] = character_limiter($options->$field_name, 15);
    $treefield['description'] = trim($options->description);
    $treefield['description_chlimit'] = character_limiter($options->description, 50);
    
    $treefield['count'] = 0;
    
    $treefield['url'] = '';
    /* link if have body */
    if(!empty($options->{'body'}))
    {
        $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
        $treefield['url'] = $href;
    } else {
        $href = site_url($lang_code.'/'.config_db_item("results_page_id").'/?search={"v_search_option_'.$treefield_id.'":"'.rawurlencode($treefield['title'].' - ').'"}');
        $treefield['url'] = $href;
    }
    /* end if have body */
    
    // Thumbnail and big image
    $treefield['thumbnail_url'] = 'assets/img/no_image.jpg';
    $treefield['image_url'] = 'assets/img/no_image.jpg';
    
    if(!empty($options->image_filename) and file_exists(FCPATH.'files/thumbnail/'.$options->image_filename))
    {
        // check first image
        $treefield['thumbnail_url'] = base_url('files/thumbnail/'.$options->image_filename);
        $treefield['image_url'] = base_url('files/'.$options->image_filename);
        
    }
    
    $childs = array();
    if (isset($tree_listings[$val->id]) && sw_count($tree_listings[$val->id]) > 0)
        foreach ($tree_listings[$val->id] as $key => $_child) {
            $child = array();
            $options = $tree_listings[$_child->parent_id][$_child->id];
            $field_name = 'value';
            $child['title'] = trim($options->$field_name);
            
            $child['url'] = '';
            /* link if have body */
                if(!empty($options->{'body'}))
                {
                    // If slug then define slug link
                    $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
                    $child['url'] = $href;
                } 
            /* end if have body */

            /* link if have body */
            if(!empty($options->{'body'}))
            {
                $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
                $child['url'] = $href;
            } else {
                $href = slug_url($lang_code.'/'.config_db_item("results_page_id").'/?search={"v_search_option_'.$treefield_id.'":"'.rawurlencode($treefield['title'].' - '.$child['title'].' - ').'"}');
                $child['url'] = $href;
            }

            /* end if have body */        
            
        }

    
    $treefield['childs'] = $childs;
    $treefield['childs_more'] = array_slice($childs, 8);
    $treefield['childs_8'] = array_slice($childs, 0, 8);
    $treefields[] = $treefield;
}

?>
<?php if(search_value($treefield_id)) : ?>
<?php _widget('top_recentlistings');?>  
<?php else: ?>
<section class="section-category section container container-palette section-top-destinations widget_edit_enabled">
    <div class="container">
        <div class="section-title">
            <h2 class="title"><?php echo lang_check('Our Top Destinations');?></h2>
            <span class="subtitle"><?php echo lang_check('Integer eu tincidunt gravida nulla.');?></span>
        </div>
        <div class="row result-container row-flex">
            <?php $i=1;  foreach ($treefields as $key=>$item): ?>
            <?php if($i==7)echo '<div class="other-locations" style="display:none;">';?>
            <div class="col-md-4 col-sm-6">
                <div class="card card-destinations">
                    <img src="<?php _che($item['image_url']);?>" class="preview" alt="<?php _che($item['title']);?>" />
                    <div class="title">
                        <h3 class="title"><?php _che($item['title']);?></h3>
                    </div>
                    <div class="hover">
                        <?php if (sw_count($item['childs_8']) > 0): foreach ($item['childs_8'] as $child): ?>
                            <?php if(!empty($child['url'])): ?>
                                <a class="item" href='<?php _che($child['url']); ?>'><?php _che($child['title']); ?></a>
                            <?php endif;?>
                        <?php endforeach; ?>
                        <?php else: ?>
                             <a class="item" href='<?php _che($item['url']); ?>'><?php echo lang_check('More');?></a>
                        <?php endif;?>
                    </div>
                </div>
            </div>            
            <?php if($i==sw_count($treefields))echo '</div>';?>
            <?php $i++; endforeach; ?>
            <div class="text-center col-sm-12">
                <a href="#" class="btn btn-custom btn-custom-secondary btn-more-locations">
                    <span class="toogle"><?php echo lang_check("See more results");?></span>
                    <span class="toogled hidden"><?php echo lang_check("Less results");?></span>
                </a>
            </div>
        </div>
    </div>
</section> <!-- /.section-category -->
<?php endif;?>