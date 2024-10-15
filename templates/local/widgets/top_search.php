 <?php
/*
Widget-title: Search form #2 (horizontal) 2
Widget-preview-image: /assets/img/widgets_preview/top_search.jpg
 */
 
$tree_field_id = 64;
$breadcrump_tree_string ='';
if(search_value($tree_field_id)){
    $CI = & get_instance();
    $values = array();
    $CI->load->model('treefield_m');
    $check_option = $CI->treefield_m->get_lang(NULL, FALSE, $lang_id);
    foreach ($check_option as $key => $value) {
        if($value->field_id==$tree_field_id){
            $item= new stdClass();
            $item->value = $value->value;
            $item->value_path = $value->value_path;
            $item->parent_id = $value->parent_id;
            $item->treefield_id = $value->treefield_id;
            $item->level = $value->level;
            $values[$value->value_path.' -']= $item;
        }
    }
    /*
    <a href="#" class="home any bread-item" data-lvl="0" data-id="64"><i class="fa fa-home"></i></a>
    <a href="#" class="bread-item" data-lvl="0" data-id="0">Albania</a>
    <a href="#" class="bread-item" data-lvl="1" data-id="36">Berat</a>
    <a href="#" class="bread-item any" data-lvl="2" data-id="84">Any regions</a></h2>
    */
    $breadcrump_tree_string = '';
    if(isset($values[trim(search_value($tree_field_id))])) {
        $field = $values[trim(search_value($tree_field_id))];
        
        $a = '<a href="#" class="bread-item" data-lvl="'._ch($field->level,'0').'" data-id="'._ch($field->treefield_id,'0').'">';
        $a .= lang_check('Any regions');
        $a .= '</a>';
        $breadcrump_tree_string = $a.$breadcrump_tree_string;
        
        $a = '<a href="#" class="bread-item" data-lvl="'._ch($field->level,'0').'" data-id="'._ch($field->parent_id,'0').'">';
        $a .= $field->{'value'};
        $a .= '</a>';
        $breadcrump_tree_string = $a.$breadcrump_tree_string;
        
        if(!empty($field->parent_id))
            $field = $CI->treefield_m->get_lang($field->parent_id, FALSE, $lang_id);
        else 
            $field = false;
        
        while ($field) {
            $a = '<a href="#" class="bread-item" data-lvl="'._ch($field->level,'0').'" data-id="'._ch($field->parent_id,'0').'">';
            $a .= $field->{'value_'.$lang_id};
            $a .= '</a>';
            $breadcrump_tree_string = $a.$breadcrump_tree_string;
            if(!empty($field->parent_id))
                $field = $CI->treefield_m->get_lang($field->parent_id, FALSE, $lang_id);
            else 
                $field = false;
        };
    }
}

$treefields = array();
$CI = & get_instance();
$treefield_id = 79;
if(isset($options_name_79)){
    $CI->load->model('treefield_m');
    $CI->load->model('option_m');
    $CI->load->model('file_m');

    $check_option= $CI->option_m->get_by(array('id'=>$treefield_id));

    $tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL, FALSE, '.order', ',image_filename, repository_id, font_icon_code');

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
            $treefield['font_icon_code'] = $options->font_icon_code;
             
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

<div class="widget widget-search scale-hidden widget_edit">
    <div class="container container-palette">
        <div class="filters filters-box">
            <div class="container">
                <form action="{page_current_url}#search-form" class="local-form search-form">
                    <input id="rectangle_ne" type="text" class="hidden" />
                    <input id="rectangle_sw" type="text" class="hidden" />
                    <div class="col-md-3 hidden">
                        <div class="form-group">
                            <select class="form-control selectpicker wtl_search_types_input" name="search_option_<?php echo $treefield_id;?>" id="search_option_<?php echo $treefield_id;?>">
                                <option value=""><?php echo lang_check('Select category');?></option>
                                <?php foreach ($treefields as $key=>$item): ?>
                                    <?php if($treefield_id==79):?>
                                    <option value="<?php _che($item['title']);?> -" <?php echo(trim(search_value('79'))== _ch($item['title'])." -") ? 'selected="selected"' : '';?>><?php _che($item['title']);?></option>
                                    <?php else:?>
                                    <option value="<?php _che($item['title']);?>" <?php echo(trim(search_value('79'))== _ch($item['title'])) ? 'selected="selected"' : '';?>><?php _che($item['title']);?></option>
                                    <?php endif;?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    {is_logged_other}
                    <div class="widget-controls-panel widget_controls_panel"  data-widgetfilename="top_search">
                        <a href="<?php echo site_url('admin/forms/edit/2');?>" target="_blunk" target="_blunk" class="btn btn-edit"><i class="ion-edit"></i></a>
                    </div>
                    {/is_logged_other}
                    <div class="row">
                        <?php _search_form_primary(2, 'horizontal/') ;?> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-custom btn-custom-secondary btn-wide" id="search-start"><?php echo lang_check('Search');?><i class="fa fa-spinner fa-spin fa-ajax-indicator hidden"></i></button>
                            </div>
                        </div>
                        <input type="text" class="hidden" name="search_option_<?php _che($tree_field_id);?>" id="search_option_<?php _che($tree_field_id);?>" value="<?php echo search_value('64'); ?>">
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <div class="container container-palette">
        <div class="widget-title-location bg-first wtl-tree">
            <div class="container">
                <div class="wtl-tree-bread">
                    <h2 class="location">
                        <a href="#" class="home any bread-item" data-lvl="0" data-id="<?php echo $tree_field_id;?>"><i class="fa fa-home"></i></a>
                        <?php if(!empty($breadcrump_tree_string)):?>
                            <?php echo $breadcrump_tree_string;?>
                        <?php else:?>
                            <a href="#" class="any bread-item" data-lvl="0" data-id="<?php echo $tree_field_id;?>"><?php echo lang_check('Any regions');?></a>
                        <?php endif;?>
                    </h2>
                    <div class="count"><span class='total_rows'><?php echo $total_rows; ?></span> <?php echo lang_check('Results Found');?></div>
                </div>
                <div class="wtl-tree-subs counter_by_id_enabled">
                    <?php foreach ($treefields as $key=>$item): ?>
                       <?php if($treefield_id==79):?>
                        <a href="#" class="tree-tag live <?php echo(trim(search_value('79'))== _ch($item['title'])." -") ? 'active' : '';?>" data-type="<?php _che($item['title']);?> -" data-value="<?php _che($item['title']);?> -">  
                        <?php else:?>
                        <a href="#" class="tree-tag live <?php echo(search_value($treefield_id)== _ch($item['title'])." -") ? 'active' : '';?>" data-type="<?php _che($item['title']);?>" data-value="<?php _che($item['title']);?>">  
                        <?php endif;?>
                            <i class="<?php _che($item['font_icon_code']);?>"></i>
                            <?php _che($item['title']);?>
                            <span></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


<script>
    $(function(){
        tree_tags_search();
        function tree_tags_search(){
            $('.wtl-tree .location .bread-item').off();
            $('.location_modal #location_modal_options').off();
            
            $('.wtl-tree .location .bread-item').on('click', function(e){
                e.preventDefault();
                $('#search-start').find('.fa-ajax-indicator').removeClass('hidden');

                var prev_id = $(this).prev().attr('data-id') || '<?php _che($tree_field_id);?>';
                var prev_lvl = $(this).prev().attr('data-lvl') || 0;
                var s_id = $(this).attr('data-id');
                var s_level = parseInt($(this).attr('data-lvl'));
                var self = $(this);
                
                var return_parent_location = function() {
                    var tree_val ='';
                    if(!self.hasClass('home'))
                    $('.wtl-tree .location .bread-item:not(.home):not(.any)').each(function(){
                        if($(this).text() == self.text())  {
                            return false; 
                        }
                        tree_val+=$(this).text()+' - ';
                    })

                    return tree_val;
                }
                var parent_tree = return_parent_location();
                
                
                if(s_id =="<?php _che($tree_field_id);?>")
                    s_id = 0;
                    
                $.getJSON( "<?php echo site_url('api/get_level_values_select/'.$lang_id.'/'.$tree_field_id); ?>/"+s_id+"/"+s_level, function( data ) {
                    var list=''
                    var options=''
                    list +='<div class="grid"><a href="#" class="tree-tag" data-lvl="'+(prev_lvl)+'" data-value="" data-id="'+prev_id+'"><?php echo lang_check('Any Regions');?></a></div>';
                    options +='<option><?php echo lang_check('Choose');?></option>';
                    options +='<option value="" data-lvl="'+(prev_lvl)+'" data-id="'+prev_id+'"><?php echo lang_check('Any Regions');?></option>';
                    $.each(data.values_arr, function(i,v){
                        if(i=='') return;
                        list +='<div class="grid"><a href="#" class="tree-tag" data-lvl="'+(s_level+1)+'" data-full-value="'+parent_tree+v+' -" data-value="'+v+'" data-id="'+i+'">'+v+'<span></span></a></div>';
                        options +='<option value="'+v+'" data-lvl="'+(s_level+1)+'" data-id="'+i+'">'+v+'</option>';
                    })
                    $('.location_modal .locations-list').html(list);  
                    $('.location_modal #location_modal_options').html(options)
                                                                .selectpicker('refresh');
                    
                }).success(function(){
                    /* counting results */
                    showCountersBy_tree(self);
                
                    var set_location = function(s_id,s_level,value,level,id) {
                        if(self.hasClass('home'))
                            self.parent().find('.home').nextAll().remove();
                        else if(self.hasClass('any') || value=='')
                            self.prev().nextAll().remove();
                        else
                            self.nextAll().remove();
                                
                        if(value=='') 
                            $('.wtl-tree .location').append('<a href="#" class="bread-item any" data-lvl="'+level+'" data-id="'+id+'"><?php echo lang_check('Any Regions');?></a>')
                        else{
                            if(!self.hasClass('home'))
                                self.remove();
                            $('.wtl-tree .location').append('<a href="#" class="bread-item" data-lvl="'+s_level+'" data-id="'+s_id+'">'+value+'</a>')
                            $('.wtl-tree .location').append('<a href="#" class="bread-item any" data-lvl="'+level+'" data-id="'+id+'"><?php echo lang_check('Any Regions');?></a>')
                        }
                        
                        /* set search value and search */
                        var tree_val ='';
                        $('.wtl-tree .location .bread-item:not(.home):not(.any)').each(function(){
                            tree_val+=$(this).text()+' - ';
                        })
                        
                        $('#search_option_<?php _che($tree_field_id);?>').val(tree_val);
                        $('#location_modal').modal('hide')
                        manualSearch(0, false);
                        $('#search-start').find('.fa-ajax-indicator').addClass('hidden');
                        tree_tags_search();
                    }
                    
                    $('#location_modal').modal('show')
                    
                    var value ='';
                    var id ='';
                    
                    $('.location_modal .locations-list a').click(function(e){
                        e.preventDefault();
                        value = $(this).attr('data-value');
                        level = $(this).attr('data-lvl');
                        id = $(this).attr('data-id');
                        set_location(s_id,s_level,value,level,id)
                   });
                    
                    $('.location_modal #location_modal_options').change(function(e){
                        var $this = $('.location_modal #location_modal_options option[value="'+$(this).val()+'"]');
                        value = $(this).val();
                        level = $this.attr('data-lvl');
                        id = $this.attr('data-id');
                        set_location(s_id,s_level,value,level,id)
                    })
               })
            })
        }
    })


function showCountersBy_tree(self)
    {
        var data = {
            order: $('.selectpicker-small').val(),
            view: $('.view-type.active').attr('data-ref'),
        };
        if($('#booking_date_from').length > 0)
        {
            if($('#booking_date_from').val() != '')
                data['v_booking_date_from'] = $('#booking_date_from').val();
        }
        if($('#booking_date_to').length > 0)
        {
            if($('#booking_date_to').val() != '')
                data['v_booking_date_to'] = $('#booking_date_to').val();
        }
        $(".tabbed-selector").each(function() {
            var selected_text = $(this).find(".active:not(.all-button) a").html();
            data['v_'+$(this).attr('id')] = selected_text;
        });
        $('.search-form  input:not(.skip), .search-form  select:not(.skip)').each(function (i) {
            if($(this).attr('type') == 'checkbox')
            {
                if ($(this)[0].checked)
                {
                    data['v_'+$(this).attr('id')] = $(this).val();
                }
            }
            else if($(this).attr('type') == 'radio')
            {   
                if ($(this)[0].checked)
                {
                    data['v_'+$(this).attr('name')] = $(this).attr('rel');
                }
            }
            else if($(this).hasClass('tree-input'))
            {
                if($(this).val() != '')
                {
                    var tre_id_split = $(this).attr('id').split('_');
                    if(data['v_search_option_'+tre_id_split[2]] == undefined)
                        data['v_search_option_'+tre_id_split[2]] = '';

                    data['v_search_option_'+tre_id_split[2]]+= $(this).find("option:selected").text()+' - ';
                }
            }
            else
            {
                if(typeof $(this).attr('id') !='undefined' && $(this).attr('id') !='undefined' && $(this).val() != '' && $(this).val() != 'NULL' && $(this).val() != null){
                    data['v_'+$(this).attr('id')] = $(this).val();
                }
            }
        });
        
        var pre_params = data;
        $.post('<?php echo site_url('api/get_all_counters_by_id/'.$lang_id.'/64')?>', pre_params, function(data){

            // remove all
            $('.location_modal .locations-list .tree-tag').find('span').html('&nbsp(0)');
            
            $.each(data.counters, function( index, obj ) {
              var m_id = obj.value;
                $('.location_modal .locations-list .tree-tag[data-full-value="'+m_id+'"]').find('span').html('&nbsp('+obj.count+')');
            });

        }, "json");
    }

</script>

<!-- Modal -->
<div class="modal fade location_modal" id="location_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang_check("Select region");?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="select-block">
                    <div class="location_modal_s_t"><?php echo lang_check("Popular region");?></div>
                     <div class="form-group">
                          <select class="form-control selectpicker" name="location_modal_options" id="location_modal_options">
                          </select>
                    </div>
                </div>
                <div class="list-block">
                    <div class="locations-list">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>