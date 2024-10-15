<div class="row-fluid clearfix">
<?php

    if(isset($_GET['search']))$search_json = json_decode($_GET['search']);
    
    $search_query = '';
    if(isset($search_json->v_search_option_smart))
    {
        $search_query=$search_json->v_search_option_smart;
    }
    
    ?>

<div class="form-group col-sm-7">
    <input id="search_option_smart" value="<?php _che($search_query); ?>" type="text"  class="form-control typeahead_autocomplete" placeholder="<?php _l('CityorCounty'); ?>" />
</div><!-- /.form-group -->
<div class="form-group col-sm-5">
    <div class="select-wrapper-1">
        <select id="search_radius" name="search_radius" class="form-control selectpicker">
<?php
    $sel_values = array(0,50,100,200,500);
    $suffix = lang_check('km');
    $curr_value=NULL;
    
    if(isset($_GET['search']))$search_json = json_decode($_GET['search']);
    if(isset($search_json->v_search_radius))
    {
        $curr_value=$search_json->v_search_radius;
    }
    
    foreach($sel_values as $key=>$val)
    {
        if($curr_value == $val)
        {
            echo "<option value=\"$val\" selected>$val$suffix</option>\r\n";
        }
        else
        {
            echo "<option value=\"$val\">$val$suffix</option>\r\n";
        }
    }
?>
        </select>
    </div><!-- /.select-wrapper -->

</div><!-- /.form-group -->
</div>