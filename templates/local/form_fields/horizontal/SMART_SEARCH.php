<?php
    $sel_values = array(0,50,100,200,500);
    $suffix = lang_check('km');
    $curr_value=NULL;
    
    if(isset($_GET['search']))$search_json = json_decode($_GET['search']);
    
    $search_query = '';
    if(isset($search_json->v_search_radius))
    {
        $curr_value=$search_json->v_search_radius;
    }
    if(isset($search_json->v_search_option_location))
    {
        $search_query=$search_json->v_search_option_location;
    }
    
?>

<?php
    $col=3;
    $f_id = $field->id;
    $placeholder = _ch(${'options_name_'.$f_id});
    $direction = $field->direction;
    if($direction == 'NONE'){
        $col=6;
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
        $class_add = ' col-md-6 col-sm-9';
    
    if(isset($_GET['search']))$search_json = json_decode($_GET['search']);
    
    $search_query = '';
    if(isset($search_json->v_search_option_smart))
    {
        $search_query=$search_json->v_search_option_smart;
    }
    if(isset($search_json->v_search_option_location))
    {
        $search_query=$search_json->v_search_option_location;
    }
?>


<div class="<?php echo $class_add;?> form-group-smart">
<div class="row clearfix">


<div class="form-group form-group-location col-sm-6">
    <input id="search_option_smart" value="<?php _che($search_query); ?>" type="text"  class="form-control locationautocomplete" placeholder="<?php echo lang_check('Where?');?>" />
    <i class="fa fa-crosshairs" aria-hidden="true"></i>
</div><!-- /.form-group -->
<div class="form-group col-sm-6 form-group-scale">
    
        <div class="scale-range" id="nonlinear-radius">
            <div class="hidden config-range"
              data-min="0"
              data-max="500"
              data-sufix="<?php echo $suffix; ?>"
              data-prefix=""
              data-infinity="false"
              data-predifinedValue="<?php echo $curr_value; ?>"
            >
            </div>
            <div class="scale-range-value">
                <span class="scale-range-label"><?php echo lang_check('Distance around position');?></span>
                <span class="nonlinear-val"></span>
            </div>
            <div class="nonlinear"></div>
            <input id="search_radius" name="search_radius" type="text" class="value hidden" value="<?php echo search_value('36_from'); ?>" />
            <input id="search_36_to" name="search_36_to" type="text" class="value-max hidden" value="<?php echo search_value('36_to'); ?>" />
        </div>
</div><!-- /.form-group -->
</div>
</div>