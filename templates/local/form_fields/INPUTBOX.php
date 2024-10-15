<?php
    $col=12;
    $f_id = $field->id;
    $placeholder = _ch(${'options_name_'.$f_id});
    $direction = $field->direction;
    if($direction == 'NONE'){
        $col=12;
        $direction = '';
    }
    else if(empty($field->class)) {
        $placeholder = $placeholder.' ('.lang_check($direction).')';
        $direction=strtolower('_'.$direction);
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
        $class_add = ' col-sm-'.$col;
    
    ?>

<div class="form-group <?php echo $class_add; ?>" style="<?php _che($field->style); ?>">
<?php
    /* if definend '|', example '2000,3000,5000,10000,20000|3000,5000,10000,20000,100000' */
    if($direction != 'NONE' && !empty(${'options_obj_'.$f_id}->values) && strpos(${'options_obj_'.$f_id}->values, '|') !== FALSE) :?>
    <?php
       $from_to_values_arr = explode('|', ${'options_obj_'.$f_id}->values);
       
       $value= '';
       if($direction == '_from') {
           $values = $from_to_values_arr[0];
       } else if($direction == '_to') {
           $values = $from_to_values_arr[1];
       }
       /* parse values */
       $values_arr = explode(',', $values);
    ?>
    <select id="search_option_<?php echo $f_id.$direction; ?>" class="form-control selectpicker">
        <option value=""><?php echo $placeholder ?><?php echo $suf_pre; ?></option>
    <?php foreach ($values_arr as $key => $value): if(empty($value)) continue;?>
        <option value="<?php _che($value);?>" <?php echo (search_value($f_id)==$value)? 'selected="selected"':''; ?>><?php _che($value);?></option>
    <?php endforeach;?>
    </select>
<?php else: ?>
    <input id="search_option_<?php echo $f_id.$direction; ?>" type="text" class="form-control" placeholder="<?php echo $placeholder ?><?php echo $suf_pre; ?>" value="<?php echo search_value($f_id); ?>" />
<?php endif;?>
</div><!-- /.form-group -->