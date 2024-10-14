<?php
    if(isset($_GET['search']))$search_json = json_decode($_GET['search']);
    
    $search_query = '';
    if(isset($search_json->v_search_option_quick))
    {
        $search_query=$search_json->v_search_option_quick;
    }
?>

<div class="row-fluid clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <input id="search_option_quick" type="text" class="form-control typeahead_autocomplete" value="<?php echo $search_query;?>" placeholder="<?php echo lang_check('Quick search');?>" autocomplete="off" />
        </div>
    </div>
</div>