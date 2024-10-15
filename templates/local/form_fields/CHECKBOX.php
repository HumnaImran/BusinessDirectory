<?php
    $col=6;
    $f_id = $field->id;
    $placeholder = _ch(${'options_name_'.$f_id});
    $direction = $field->direction;
    if($direction == 'NONE'){
        $col=12;
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
        $class_add = ' col-sm-6';
    
?>
<div class="col-xs-12">
    <div class="form-group-checkbox-line">
       <label class="checkbox">
        <input rel="<?php _che(${'options_name_'.$f_id}); ?>" name="search_option_<?php echo $f_id; ?>" id="search_option_<?php echo $f_id; ?>" class="checkbox_live" type="checkbox" value="true<?php _che(${'options_name_'.$f_id}); ?>" />
        <?php _che(${'options_name_'.$f_id}); ?>
        <span class="text-color-primary"></span>
       </label>
    </div>
</div>