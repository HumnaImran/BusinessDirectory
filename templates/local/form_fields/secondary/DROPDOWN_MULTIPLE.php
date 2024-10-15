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
    
    
    $f_id = $field->id;
    $class_add = $field->class;
    if(empty($class_add))
        $class_add = '';
    
?>
<div class="<?php echo $class_add; ?>" style="<?php _che($field->style); ?>">
    <div class="form-group">
        <select  option_id="<?php echo $f_id; ?>" class="form-control input_am multi_am id_<?php echo $f_id; ?> <?php echo $class_add; ?>" title="<?php echo _l('Choose');?> <?php _che(${'options_name_'.$f_id}); ?>" multiple="multiple" size="3">
            <?php if(isset(${'options_values_arr_'.$f_id}) && !empty(${'options_values_arr_'.$f_id}))
                    foreach (${'options_values_arr_'.$f_id} as $key => $value):?>
                    <option value="<?php _che($value);?>"><?php _che($value);?></option>
            <?php endforeach;?>
        </select>
    </div>
</div>