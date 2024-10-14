<?php 

if(isset($options_values_arr_4) && !empty($options_values_arr_4)):
    
$CI = &get_instance();
function _get_purpose($CI)
{
    if(isset($CI->select_tab_by_title))
    if($CI->select_tab_by_title != '')
    {
        $CI->data['purpose_defined'] = $CI->select_tab_by_title;
        return $CI->select_tab_by_title;
    }

    if(isset($CI->data['is_purpose_sale'][0]['count']))
    {
        $CI->data['purpose_defined'] = lang('Sale');
        return lang('Sale');
    }

    if(isset($CI->data['is_purpose_rent'][0]['count']))
    {
        $CI->data['purpose_defined'] = lang('Rent');
        return lang('Rent');
    }

    if(config_item('all_results_default') === TRUE)
    {
        $CI->data['purpose_defined'] = '';
        return '';
    }

    $CI->data['purpose_defined'] = lang('Sale');
    return lang('Sale');
}
?>
<div class="form-group col-sm-12" style="">
    <label class="checkbox">
        <input type="radio" rel="" name="search_option_4" value="" checked=""> <?php echo lang_check('All');?>
    </label>
    <?php foreach ($options_values_arr_4 as $value):if(empty($value)) continue;?>
        <label class="checkbox">
            <input type="radio" rel="" name="search_option_4" value="<?php _che($value);?>" <?php echo (_get_purpose($CI)==strtolower($value)) ? 'checked=""' : '';?>> <?php _che($value);?>
        </label>
    <?php endforeach;?>
</div><!-- /.form-group -->
<?php endif;?>