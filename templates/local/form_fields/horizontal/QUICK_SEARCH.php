<?php
    $col=3;
    $f_id = $field->id;
    $placeholder = _ch(${'options_name_'.$f_id});
    $direction = $field->direction;
    if($direction == 'NONE'){
        $col=3;
        $direction = '';
    }
    else
    {
        $placeholder = lang_check($direction);
        $direction=strtolower('_'.$direction);
    }
    
    $suf_pre = _ch(${'options_prefix_'.$f_id}, '')._ch(${'options_suffix_'.$f_id}, '');
    if(!empty($suf_pre))
        $suf_pre = ' ('.$suf_pre.')';
    
    $class_add = $field->class;
    if(empty($class_add))
        $class_add = ' col-sm-3';
        
    
    if(isset($_GET['search']))$search_json = json_decode($_GET['search']);
    
    $search_query = '';
    if(isset($search_json->v_search_option_quick))
    {
        $search_query=$search_json->v_search_option_quick;
    }
?>


<div class="<?php echo $class_add;?>">
    <div class="form-group">
        <input id="search_option_quick" type="text" class="form-control typeahead_autocomplete" value="<?php echo $search_query;?>" placeholder="<?php echo lang_check('I’m looking for...');?>" autocomplete="off" />
    </div>
</div>