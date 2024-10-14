 

<?php
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
                        $treefield['image_url_second'] = base_url('files/'.rawurlencode($files_r[1]->filename));
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

<div class="section-search-area section"  data-parallax="scroll" data-image-src="assets/img/pic/places/moon.jpg">
    <div class="">
        <div class="body">
            <div class="h-area">
                <h1 class="title">
                    Find the perfect places to
                    eat, drink, shop and simply rest.
                </h1>
            </div>
            <div class="local-form">
             <form action="{page_current_url}#main-search" class="search-form redirect_search">
                    <input id="rectangle_ne" type="text" class="hidden" />
                    <input id="rectangle_sw" type="text" class="hidden" />
                    <input type="text" name="search_option_<?php echo $treefield_id;?>" id="search_option_<?php echo $treefield_id;?>" class="hidden form-control search_types_input">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control typeahead_autocomplete" id="search_option_smart" value="<?php _che($search_query); ?>" placeholder="<?php echo lang_check('I’m looking for...');?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group form-group-location">
                                <input type="text" class="form-control locationautocomplete" name="search_option_location" value="" id="search_option_location" placeholder="<?php echo lang_check('Where?');?>">
                                <i class="fa fa-crosshairs" aria-hidden="true"></i>
                            </div>       
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-group-btns">
                                <a href="#"  id="search-start"  class="btn btn-custom btn-custom-secondary"><?php echo lang_check('Search');?><i class="fa fa-spinner fa-spin fa-ajax-indicator hidden"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tags">
                <ul class="list-tags" id="search_types">
                    <?php foreach ($treefields as $key=>$item): ?>
                        <li>
                            <a href="#" data-type="<?php _che($item['title']);?> -">
                                <img src="<?php echo $item['image_url_second'];?>" alt="<?php _che($item['title']);?>" class="icon">
                                <?php _che($item['title']);?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- /.section-search-area -->