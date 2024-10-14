<?php
/*
Widget-title: Geo map with search Visual
Widget-preview-image: /assets/img/widgets_preview/top_geomapsearch.jpg
*/

$CI = &get_instance();
$CI->config->set_item('auto_map_search', TRUE);
?>
<div class="section widget-geomap container container-palette">
<?php  
/* update map to version 2, if need */
if(file_exists(FCPATH.'files/treefield_64_map.svg')){
    $svg_map_file = file_get_contents(FCPATH.'files/treefield_64_map.svg');
    if(stripos($svg_map_file, 'data-sw_geomodule-version="2.0"') === FALSE && stripos($svg_map_file, "data-sw_geomodule-version='2.0'") === FALSE){
    $root_name ='';
    $match = '';
    preg_match_all('/(data-title-map)=("[^"]*")/i', $svg_map_file, $match);
    if(!empty($match[2])) {
        $root_name = trim(str_replace('"', '', $match[2][0]));
    } else if(stristr($svg_map_file, "http://amcharts.com/ammap") != FALSE ) {
        $root_name = 'undefined';
        $match='';
        preg_match_all('/(SVG map) of ([^"]* -)/i', $svg_map_file, $match2);
        if(!empty($match2) && isset($match2[2][0])) {
            $title = str_replace(array(" -","High","Low"), '', $match2[2][0]);
           $root_name = trim($title);
        }
    }
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false; 
    $dom->formatOutput = true; 
    $dom->loadXml($svg_map_file);
    /* set version */
    $root_svg = $dom->getElementsByTagName('svg')->item(0);
    $root_svg->setAttribute('data-sw_geomodule-version', '2.0');
    $paths = $dom->getElementsByTagName('path'); //here you have an corresponding object
        foreach ($paths as $path) {
            $lvl_1 = $path->getAttribute('data-name');
            if($lvl_1 && !empty($lvl_1)){
                $lvl_1 = trim($lvl_1);
                $path->setAttribute('data-name-lvl_0', $root_name);
                $path->setAttribute('data-name-lvl_1', $lvl_1);
                $path->setAttribute('data-name', $lvl_1.', '.$root_name);
            }
        }     
    $g = $dom->getElementsByTagName('g'); //here you have an corresponding object
        foreach ($g as $path) {
            $lvl_1 = $path->getAttribute('data-name');
            if($lvl_1 && !empty($lvl_1)){
                $lvl_1 = trim($lvl_1);
                $path->setAttribute('data-name-lvl_0', $root_name);
                $path->setAttribute('data-name-lvl_1', $lvl_1);
                $path->setAttribute('data-name', $lvl_1.', '.$root_name);
            }
        }     
    $svg= $dom->saveXML();
    file_put_contents(FCPATH.'files/treefield_64_map.svg', $svg);
}
}
?>

<?php
if(!function_exists('recursion_calc_count')) {
    function recursion_calc_count ($result_count, $tree_listings, $parent_title, $id, &$child_count){
        if (isset($tree_listings[$id]) && sw_count($tree_listings[$id]) > 0){
            foreach ($tree_listings[$id] as $key => $_child) {
                $options = $tree_listings[$_child->parent_id][$_child->id];
                if(isset($result_count[$parent_title.' - '.$options->value.' -']))
                    $child_count+= $result_count[$parent_title.' - '.$options->value.' -'];

                $_parent_title = $parent_title.' - '.$options->value;
                if (isset($tree_listings[$_child->id]) && sw_count($tree_listings[$_child->id]) > 0){    
                    recursion_calc_count($result_count, $tree_listings, $_parent_title, $_child->id, $child_count);
                }
            }
        }
    }
}

$CI = & get_instance();
$treefield_id = 64;

$CI->load->model('treefield_m');

// init varibles
$treefields = array();
$tree_listings_default = array();
$tmpfile ='';
$error_svg_widget='';
$widget_fatal_error = false;

$check_option= $CI->option_m->get_by(array('id'=>$treefield_id));
// check if option exists
if(!$check_option)
    $widget_fatal_error = true;

if($check_option[0]->type!='TREE')
    $widget_fatal_error = true;

if(isset($_GET['geo_map_preview']) &&  !empty($_GET['geo_map_preview'])) {
    $geo_map_preview = trim($_GET['geo_map_preview']);
    
    $tmpfile = 'assets/cache/'.$geo_map_preview.'.svg';
    
     if(file_exists(FCPATH.'templates/'.$this->data['settings']['template'].'/assets/svg_maps/'.$geo_map_preview.'.svg')) {
        // get svg
        $svg = file_get_contents(FCPATH.'templates/'.$this->data['settings']['template'].'/assets/svg_maps/'.$geo_map_preview.'.svg');

        $match = '';
        $title = '';
        $root_name ='';
        preg_match_all('/(data-title-map)=("[^"]*")/i', $svg, $match);
        if(!empty($match[2])) {
            $title = trim(str_replace('"', '', $match[2][0]));
            $root_name = trim($title);
        } else if(stristr($svg, "http://amcharts.com/ammap") != FALSE ) {
            $svg = str_replace('title', 'data-name', $svg);
            $match2='';
            preg_match_all('/(SVG map) of ([^"]* -)/i', $svg, $match2);
            if(!empty($match2) && isset($match2[2][0])) {
                $title='';
                $title = str_replace(array(" -","High","Low"), '', $match2[2][0]);
                $title = trim($title);
                $svg = str_replace('<svg', '<svg data-title-map="'.trim($title).'"', $svg);
                $root_name = trim($title);
            }
        }
        // tmp svg map save in cache
        
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false; 
        $dom->formatOutput = true; 
        $dom->loadXml($svg);
        /* set version */
        $root_svg = $dom->getElementsByTagName('svg')->item(0);
        $root_svg->setAttribute('data-sw_geomodule-version', '2.0');
        $paths = $dom->getElementsByTagName('path'); //here you have an corresponding object
            foreach ($paths as $path) {
                $lvl_1 = $path->getAttribute('data-name');
                if($lvl_1 && !empty($lvl_1)){
                    $lvl_1 = trim($lvl_1);
                    $path->setAttribute('data-name-lvl_0', $root_name);
                    $path->setAttribute('data-name-lvl_1', $lvl_1);
                    $path->setAttribute('data-name', $lvl_1.', '.$root_name);
                }
            }     
        $g = $dom->getElementsByTagName('g'); //here you have an corresponding object
            foreach ($g as $path) {
                $lvl_1 = $path->getAttribute('data-name');
                if($lvl_1 && !empty($lvl_1)){
                    $lvl_1 = trim($lvl_1);
                    $path->setAttribute('data-name-lvl_0', $root_name);
                    $path->setAttribute('data-name-lvl_1', $lvl_1);
                    $path->setAttribute('data-name', $lvl_1.', '.$root_name);
                }
            }     
        $svg= $dom->saveXML();
        
        
        if(!empty($title)){
            file_put_contents(FCPATH.'templates/'.$this->data['settings']['template'].'/'.$tmpfile, $svg);

            /* changed emulations arrays */
            $treefields = array();
            $treefields_parent = new stdClass();
            $treefields_parent->id = '1';
            $treefields_parent-> value = $title;
            $treefields_parent-> parent_id = '0';
            $treefields_parent-> body = '';
            $treefields_parent-> repository_id = '';
            preg_match_all('/(data-name-lvl_1)=("[^"]*")/i', $svg, $matches);

            $_k=2;
            $treefields_childs = array();
            if(!empty($matches[2]))
                foreach ($matches[2] as $value) {
                    $value = str_replace('"', '', $value);      
                    $data= new stdClass();;
                    $data->id = $_k;
                    $data->value = $value;
                    $data->parent_id = '1';
                    $data->body = '';
                    $data->repository_id = '';
                    $treefields_childs[$_k] = $data;
                    $_k++;
                }
            $treefields[0][1]=$treefields_parent;
            $treefields[1]=$treefields_childs;
            $tree_listings=$treefields;

            $tree_listings_default= array();
            $tree_listings_default = $treefields_childs;
            $tree_listings_default[1] = $treefields_parent;
        } else {
            
        }
    } 

} // if not demo map preview
else {
    $tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL, FALSE, '.order', ',repository_id');
    $tree_listings_default = $CI->treefield_m->get_table_tree('1', $treefield_id, NULL, true, '.order', ',repository_id');
}

if(empty($tree_listings) || !isset($tree_listings[0]))
    $widget_fatal_error = true;

if(!$widget_fatal_error){
// count listing
/*SELECT `property`.id, 
`property`.`is_activated`,
`property_value`.`property_id`,
`property_value`.`value`, 
COUNT(value)
FROM `property`
LEFT JOIN `property_value` ON `property`.id = `property_value`.`property_id`
 WHERE `option_id`= 64 and `language_id`=1 and `is_activated`=1 GROUP BY `value`
*/
$this->db->select('property_value.value, COUNT(value) as count');

$this->db->join('property_value', 'property.id = property_value.property_id');

$this->db->group_by('property_value.value');  
$this->db->where('option_id', $treefield_id);
$this->db->where('language_id', $lang_id);
$this->db->where('is_activated', 1);
$this->db->where('is_visible', 1);

if(config_db_item('listing_expiry_days') !== FALSE)
{
    if(is_numeric(config_db_item('listing_expiry_days')) && config_db_item('listing_expiry_days') > 0)
    {
        $this->db->where('date_modified >', date("Y-m-d H:i:s" , time() - config_db_item('listing_expiry_days')*86400));
    }
}

$query= $this->db->get('property');


$result_count = array();

if($query){
    $result = $query->result();
    foreach ($result as $key => $value) {
        if(!empty($value->value))
            $result_count[$value->value]= $value->count;
    }
}

$_treefields = $tree_listings[0];

$root_value = '';
$ariesInfo = array();
$treefields = array();
foreach ($_treefields as $val) {
   
    $options = $tree_listings[0][$val->id];
    $treefield = array();
    $field_name = 'value' ;
    $treefield['id'] = $val->id;
    $treefield['title'] = $options->$field_name;
    
    if(empty($root_value))
        $root_value = $options->$field_name;
    
    $treefield['title_chlimit'] = character_limiter($options->$field_name, 15);

    $field_name = 'body';
    $treefield['descriotion'] = $options->$field_name;
    $treefield['description_chlimit'] = character_limiter($options->$field_name, 50);
    
    $treefield['count'] = 0;
    if(isset($result_count[$treefield['title'].' -']))
        $treefield['count'] = $result_count[$treefield['title'].' -'];
    
    $treefield['url'] = '';
    
    /* link if have body */
    if(!empty($options->$field_name))
    {
        $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
        $treefield['url'] = $href;
    }
    /* end if have body */
    
    $treefield['repository_id'] = $options->repository_id;
    
    $ariesInfo[$tree_listings_default[$val->id]->value]['name']=$treefield['title'];
    $ariesInfo[$tree_listings_default[$val->id]->value]['count']=$treefield['count'];
     
    $childs = array();
    if (isset($tree_listings[$val->id]) && sw_count($tree_listings[$val->id]) > 0)
        foreach ($tree_listings[$val->id] as $key => $_child) {
            $child = array();
            $options = $tree_listings[$_child->parent_id][$_child->id];
            $child['id'] = $_child->id;
            $field_name = 'value';
            $child['title'] = $options->$field_name;
            $child['title_chlimit'] = character_limiter($options->$field_name, 10);

            $field_name = 'body';
            $child['descriotion'] = $options->$field_name;
            $child['descriotion_chlimit'] = character_limiter($options->$field_name, 50);
            
            $child['count']= 0;
            if(isset($result_count[$treefield['title'].' - '.$child['title'].' -']))
                $child['count'] = $result_count[$treefield['title'].' - '.$child['title'].' -'];
          
            $child['url'] = '';
            
            /* link if have body */
                if(!empty($options->$field_name))
                {
                    // If slug then define slug link
                    $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
                    $child['url'] = $href;
                }
            /* end if have body */
            
            if (isset($tree_listings[$_child->id]) && sw_count($tree_listings[$_child->id]) > 0){
                $parent_title = $treefield['title'].' - '.$child['title'];
                recursion_calc_count($result_count, $tree_listings, $parent_title, $_child->id, $child['count']);
            }       
                
            $childs[] = $child;
            $ariesInfo[$tree_listings_default[$_child->id]->value.', '.$tree_listings_default[$_child->parent_id]->value]['name']=$child['title'].', '.$treefield['title'];
            $ariesInfo[$tree_listings_default[$_child->id]->value.', '.$tree_listings_default[$_child->parent_id]->value]['count']=$child['count'];
            $ariesInfo[$tree_listings_default[$val->id]->value]['count'] += $child['count'];
        }

    $treefield['childs'] = $childs;
    $treefields[] = $treefield;
}

$CI->load->model('file_m');
$svg_map='';
if(isset($treefields[0]['repository_id']) && !empty($treefields[0]['repository_id'])) {
    $repository = $CI->file_m->get_by(array('repository_id'=>$treefields[0]['repository_id']));
    if($repository){
        $filename = $repository[0]->filename;
        if(!empty($filename) and file_exists(FCPATH.'files/'.$filename))
        {
            $svg_map = base_url('files/'.$filename);
        }
    }
}

}

/*
echo '<pre>';
print_r($treefields);
echo '</pre>';*/
?>

<style>
    .geo-menu  {
        margin-left: 50px !important;  
        padding-top: 20px;
    }
    
    .geo-menu > ul {
        margin-left: 20px !important;  
    }
    
    .geo-menu ul > li> a {
        font-weight: 500;
    }
    
    .geo-menu  a:not(:hover):not(.c-base) {
        color: #666;
    }
    
    .geo-menu ul > li {
        display: inline-block;
        margin: 5px 10px;
    }
    
    .geo-menu ul > li >ul {
        display: none;  
    }
    
    
    .geo-menu ul > li >ul.open {
        display: block;  
    }
    
    .geo-menu ul > li >ul li {
        opacity: 0; 
    }
    
    .geo-menu ul > li >ul.open li {
        
        transition: all .5s;
        opacity: 1; 
    }
    
    .geo-menu ul > li >ul.open li.active a  {
        font-weight: 600;
    }
    
    .geo-menu-breadcrumb {
        margin-top: 25px;
        margin-left: 25px;
        display: none;
    }
    
    .geo-menu-breadcrumb {
        color: black;
        font-weight: bold;
    }
    
    .map-geo-widget .highlight {
        background: red;
    }
    
    .map-geo-widget #path12534, 
    .map-geo-widget .highlight, 
    .area:hover,
    .map-geo-widget path:hover {
        fill: lightyellow;
        stroke: black;
        background: red;
    }
    
    .area:hover {
        fill: lightyellow;
        stroke: black;
        background: red;
    }
    
    #svgmap {
        width: 100%;
        margin-top: 5px;
    }
    
    #map-geo-tooltip {
        position: fixed;
        z-index: 999999;
        color: white;
        padding: 5px 15px;
        background: #565656;
        border: 2px solid #000;
        border-radius: 3px;
    }
    
    
    .geo-menu li.active > ul {
        display: block;
        margin-top: -5px;
        margin-left: -10px;
    }
    
    .geo-menu li.active > a {
        font-weight: 600;
    }
    
    .geo-menu li.active > ul > li {
        transition: all .5s;
        opacity: 1; 
    }
        
    .geo-menu .more-tags {
        /*border-bottom: 1px dotted black;*/
        text-decoration: underline;
        font-weight: bold;
    }
    
    @media (max-width: 768px) {
        .geo-menu > ul {
            margin-left: 0 !important;
        }
    }
    
</style>

<style>
    
    @media(min-width: 768px) {
        .widget-map-geo > div.row {
            display: flex;
        }

        .geo-menu  {
            display: flex;
            align-items: center;
        }
    }
    
    .geo-menu > ul {
        margin-left: 20px !important;  
    }
    
    .geo-menu ul > li> a {
        font-weight: 500;
    }
    
    .geo-menu ul > li {
        display: inline-block;
        margin: 5px 10px;
    }
    
    .geo-menu ul > li >ul {
        display: none;  
    }
    
    
    .geo-menu ul > li >ul.open {
        display: block;  
    }
    
    .geo-menu ul > li >ul li {
        opacity: 0; 
    }
    
    .geo-menu ul > li >ul.open li {
        
        transition: all .5s;
        opacity: 1; 
    }
    
    .geo-menu ul > li >ul.open li.active a  {
        font-weight: 600;
    }
    
    .geo-menu-breadcrumb {
        margin-top: 25px;
        margin-left: 25px;
        display: none;
    }
    
    .geo-menu-breadcrumb {
        color: black;
        font-weight: bold;
    }
    
    .map-geo-widget .highlight {
        background: red;
    }
    
    .map-geo-widget #path12534, 
    .map-geo-widget .highlight, 
    .area:hover,
    .map-geo-widget path:hover {
        fill: lightyellow;
        stroke: black;
        background: red;
    }
    
    .area:hover {
        fill: lightyellow;
        stroke: black;
        background: red;
    }
    
    #svgmap {
        width: 100%;
        margin-top: 5px;
    }
    
    #map-geo-tooltip {
        position: fixed;
        z-index: 999999;
        color: white;
        padding: 5px 15px;
        background: #565656;
        border: 2px solid #000;
        border-radius: 3px;
    }
    
    
    .geo-menu li.active > ul {
        display: block;
        margin-top: -5px;
        margin-left: -10px;
    }
    
    .geo-menu li.active > a {
        font-weight: 600;
    }
    
    .geo-menu li.active > ul > li {
        transition: all .5s;
        opacity: 1; 
    }
        
    .geo-menu .more-tags {
        /*border-bottom: 1px dotted black;*/
        text-decoration: underline;
        font-weight: bold;
    }
    
    .geo-menu li {
        width: 50%;
        margin: 0 !important;
        padding: 2px 10px !important;
        
    }
    
    .geo-menu li li {
        
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #353535;
        font-weight: 500;
    }
    
    .geo-menu ul.treefield-tags>li {
        width: 100%;
    }
    
    .geo-menu ul li a,
    .geo-menu ul > li> a {
        font-size: 18px;
        font-weight: 500;
        color: #353535;
        transition: all .15s;
        -o-transition: all .15s;
        -ms-transition: all .15s;
        -moz-transition: all .15s;
        -webkit-transition: all .15s;
        text-decoration: none;
    }
    
    .geo-menu ul li a:hover,
    .geo-menu ul > li> a:hover {
        font-weight: 800;
        color: #000;
    }
    
</style>

<?php if(!$widget_fatal_error):?>

<script>

/*
 * Set item in geo menu
 * @param dataPath (string) value-path for treefield field ("Croatia - Zagreb")
 * 
 */

/*
 * 
 * Styles for svg
 * 
 */
var svg_default_area_color = 'rgb(249, 249, 249)' /* default color*/
var svg_selected_area_color = '#DA3743' /* selected color*/
var svg_hover_area_color = '#DA3743' /* hover color*/
var firstload = true;
var svg_selected_country_color = '#fff6b4';

function set_path (dataPath, apply_in_search, tree_field) {
        /*console.log(true)*/
        /*console.log(dataPath);*/
        
        if (typeof apply_in_search === 'undefined') apply_in_search = true;
        if (typeof tree_field === 'undefined') tree_field = true;
        var dataPath_origin = dataPath;
        // refresh
        var s_values_splited = (dataPath+" ").split(" - "); 
        
        var _last_element = $.trim(s_values_splited[s_values_splited.length-1]);
        
        if($('.geo-menu a[data-region="'+_last_element+'"]').closest('li').hasClass('active')) {
            delete s_values_splited[s_values_splited.length-1];
        }
        
        $('.geo-menu li').removeClass('active');
        
        $('.geo-menu ul > li li').css('display', 'none');
        $('.geo-menu ul > li').css('display', 'inline-block');
        $('.geo-menu ul a').css('display', 'initial')
    
        var _dataPath = '';
        
        $.each(s_values_splited, function(key, val){
            if(key>1) return false;
            /*console.log('key: '+key, 'val: '+val)*/
            
            val = $.trim(val);
            
            if(!$('.geo-menu a[data-region="'+val+'"]').length) return false;
            var _this =  $('.geo-menu a[data-region="'+val+'"]');
            var parent = _this.closest('li');
            
            if( parent.hasClass('active')) {
                parent.removeClass('active')
                return false;
            }
            
            parent.addClass('active')
               
            if(parent.find('li').length){
                $(' > li', parent.parent()).not(parent).css('display', 'none');
                _this.css('display', 'none')
                $(' li', parent).css('display', 'inline-block');

                $('.geo-menu ul'+_this.attr('href')).show();
            }
            if(_dataPath == '')
                _dataPath += '' + val;
            else
                _dataPath += ' - ' + val;
        })
        
        if(apply_in_search){
            $('.geo-menu-breadcrumb').html(_dataPath);
            /*console.log(_dataPath)*/
            if(_dataPath !='')
                $('.search_option_<?php _che($treefield_id);?>').val(dataPath_origin);
            else 
                $('.search_option_<?php _che($treefield_id);?>').val('');
        }
        
        if(apply_in_search && tree_field && $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?>').length){
            var dataPath = _dataPath;
            var load_val = $.trim(dataPath) ;
            if(!load_val || load_val=='') {
               $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select').selectpicker('val','')
               $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select option:first-child').attr('selected','selected')
               $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select').selectpicker('refresh');
               <?php if(config_item('auto_category_display')=== TRUE):?>
               $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select').eq(0).closest('.field-tree').nextAll().hide();
               <?php endif;?>
           // return false
            }

            var s_values_splited = (load_val+" - ").split(" - "); 
            if(s_values_splited[0] != '')
            {
                var first_select = $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?>').find('select:first');
                var id = first_select.find('option').filter(function () { return $(this).html() ==  s_values_splited[0]; }).attr('selected', 'selected').val();

                /* beta fix selected */ 
                var val =  first_select.find('option').filter(function () { return $(this).html() ==  s_values_splited[0]; }).val()
                $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select').selectpicker('val',val)
                /* end beta fix selected */ 

                load_by_field(first_select, true, s_values_splited);
                first_select.selectpicker('refresh');

            }
        }
        

        /* short-more tags*/
        /*console.log('path: '+dataPath_origin)*/
        dataPath_origin = $.trim(dataPath_origin)
        
        if(firstload && dataPath_origin[dataPath_origin.length-1] == '-') {
            dataPath_origin = dataPath_origin.slice(0, -1);
            dataPath_origin = $.trim(dataPath_origin)
        }
        
        var _p = (dataPath_origin+"  ").split(" - ") || false;
        if(_p && _p[_p.length-2]) {
            var selector = $.trim(_p[_p.length-2]);
            if($('a[data-region="'+selector+'"]').closest('li').find('ul li .more-tags').length && $('a[data-region="'+selector+'"]').closest('li').find('ul li .more-tags').attr('data-close') == 'false'){
            } else {
                hideShow_tags(selector);
            }
        } else if(firstload && _p && _p[_p.length-1]){
            var selector = $.trim(_p[_p.length-1]);
            if($('a[data-region="'+selector+'"]').closest('li').find('ul li .more-tags').length && $('a[data-region="'+selector+'"]').closest('li').find('ul li .more-tags').attr('data-close') == 'false'){
            } else {
                hideShow_tags(selector);
            }
        }
        
        firstload = false;
}

/* menu geo */
$(document).ready(function(){

    // if search_option_$treefield_id input missing
    if(!$('#TREE-GENERATOR_ID_<?php echo $treefield_id;?>').length) {
        $('.search-form').append('<input type="text" class="hidden form-control search_option_<?php echo $treefield_id;?> skip-input" name="search_option_<?php echo $treefield_id;?>" value="" id="search_option_<?php echo $treefield_id;?>">')
    }
    
    $('.geo-menu  a').click(function(e){
        e.preventDefault();
        
        var dataPath =  $(this).attr('data-path')  || '';
        set_path (dataPath)
    })
    
})

/* additional methds for svg map */
jQuery.fn.myAddClass = function (classTitle) {
   return this.each(function() {
     var oldClass = jQuery(this).attr("class") || '';
     oldClass = oldClass ? oldClass : '';
     jQuery(this).attr("class", (oldClass+" "+classTitle));
   });
 }
 $.fn.myRemoveClass = function (classTitle) {
   return this.each(function() {
       var oldClass = $(this).attr("class") || '';
       var newClass = oldClass.replace(classTitle, '');
       $(this).attr("class", newClass);
   });
 }
 $.fn.myHasClass = function (classTitle) {
    var current_class = $(this).attr("class") || '';

    if(current_class.indexOf(classTitle)=='-1') {
        return false;
    } else {
        return true;
    }
 }

 // map
 $(window).load(function () {
    if($('#svgmap').length) { 
     
    var nameAreaRoot = false;
    var nameArea = [];
    var nameCount = [];
    var trigger = false;
    var first_load_map = true; 
    
    <?php if(isset($ariesInfo) && !empty($ariesInfo)) foreach ($ariesInfo as $key => $value):?>
        if(nameAreaRoot==false)  
            nameAreaRoot = "<?php echo $value['name'];?>";
        
        nameArea["<?php echo $key;?>"] = "<?php echo $value['name'];?>";
        nameCount["<?php echo $key;?>"] = "<?php echo $value['count'];?>";
    <?php endforeach;?>

    var svgobject = document.getElementById('svgmap');
    if ('contentDocument' in svgobject) {             
        var svgdom = jQuery(svgobject.contentDocument);  
    }
    
    if(!$('[data-map-type="multimap"]', svgdom).length) {
        svg_selected_country_color = svg_default_area_color;
    }
    
    /* colors */
    $('*', svgdom).css('stroke', 'rgb(64, 64, 64)');

    
    /* change primary color*/
    $('*[data-name]', svgdom).not('.area').css('fill', svg_default_area_color);
    /* end colors */
    
    
    /* from dropdown if null id*/
    $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select').change(function(){
        if(!$(this).val()) {
            $('*[data-name]', svgdom).myRemoveClass('highlight');
        }
    })
    
 
    $('.treefield-tags a:not(.geo-menu-back)').click(function(){
        
        // country hover
        if($('.geo-menu .treefield-tags >li.active >a').attr('data-name-lvl_0'))
            $('*[data-name-lvl_0="'+$('.geo-menu .treefield-tags >li.active >a').attr('data-name-lvl_0')+'"]:not(.highlight)', svgdom).css('fill', svg_selected_country_color);
        
        if($(this).attr('data-region') && $(this).attr('data-name-lvl_0')) {
            if($('*[data-name="'+$(this).attr('data-path-map-origin')+'"]', svgdom).length) {
                 trigger = true
                $('*[data-name="'+$(this).attr('data-path-map-origin')+'"]', svgdom).trigger('click');
                
            } else {
                $('*[data-name]', svgdom).myRemoveClass('highlight');
            }
        } 
        else {
            $('*[data-name]', svgdom).myRemoveClass('highlight');
        }
    })
    
    $('.geo-menu .geo-menu-back').click(function(e){
        e.preventDefault();
        $('*[data-name]', svgdom).myRemoveClass('highlight');
        $('*[data-name]', svgdom).not('.area').css('fill', svg_default_area_color);
    })
    
    /* start selected area */
    $('*[data-name]', svgdom).click(function(){
        
        if($(this).myHasClass('highlight')) {
            $('*[data-name]', svgdom).myRemoveClass('highlight'); 
            $('*[data-name]', svgdom).not('.area').css('fill', svg_default_area_color);
           
           if(!trigger && $(this).attr('data-name-lvl_1') && nameArea[$(this).attr('data-name')]) {
                var dataPath = $('.geo-menu a[data-region="'+nameArea[$(this).attr('data-name')]+'"]').attr('data-path')  || '';
                dataPath = dataPath.replace($(this).attr('data-name-lvl_1')+' - ',"");
                set_path (dataPath);
           }
           
            <?php  if(config_item('auto_map_search')===TRUE):?>
            if(!firstload && !trigger) {
               $('#search-start').trigger('click'); 
            }
            <?php endif;?>
            return false;
        }
        
        $('*[data-name]', svgdom).myRemoveClass('highlight');
        $('*[data-name]', svgdom).not('.area').css('fill', svg_default_area_color);
        
        /* highlight country */ 
        $('*[data-name-lvl_0="'+$(this).attr('data-name-lvl_0')+'"]', svgdom).css('fill', svg_selected_country_color);
        
        $(this).myAddClass('highlight');
        if(!$(this).myHasClass('area'))
            $(this).css('fill', svg_selected_area_color);
        if(!trigger && $(this).attr('data-name-lvl_1') && nameArea[$(this).attr('data-name')]) {
            var dataPath = $('.geo-menu a[data-path-map="'+nameArea[$(this).attr('data-name')]+'"]').attr('data-path')  || '';
            set_path (dataPath);
        }
        
        <?php  if(config_item('auto_map_search')===TRUE):?>
        if(!firstload && !trigger) {
           $('#search-start').trigger('click'); 
        }
        <?php endif;?>
       
       trigger = false;
    })
    /* end selected area */  
    
    $('*[data-name]', svgdom).hover(function(){
        if(!$(this).myHasClass('highlight') && !$(this).myHasClass('area'))
            $(this).css('fill', svg_hover_area_color);
        }, function(){
        if(!$(this).myHasClass('highlight') && !$(this).myHasClass('area'))
            $(this).css('fill', svg_default_area_color);
        
            if($('.geo-menu .treefield-tags >li.active >a').attr('data-name-lvl_0') && ($('#sinputOption_1_64_level_0').val() || $('#search_option_64').val()))
                $('*[data-name-lvl_0="'+$('.geo-menu .treefield-tags >li.active >a').attr('data-name-lvl_0')+'"]:not(.highlight)', svgdom).css('fill', svg_selected_country_color);
        }
    )
    /* end hover area */   
    
    // init map first load with data
    if(first_load_map) {
        var init_dataPath = '<?php echo search_value($treefield_id); ?>' || '<?php echo $root_value;?> - ' || 'Croatia - ';
       
        /* do empty for geo in root */
        init_dataPath='';
        
        var init_s_values_splited = (init_dataPath+" ").split(" - "); 
        $.each(init_s_values_splited, function(key, val){
            val = $.trim(val);
            if(val) {
                if($('*[data-name="'+val+'"]', svgdom).length) {
                     trigger = true
                    $('*[data-name="'+val+'"]', svgdom).trigger('click');
                    hideShow_tags('Europe');
                } 
            } 
        })
        
        /* fix proporties svg file from amcharts */
        var attr = $('svg', svgdom).attr('xmlns:amcharts');
        if(typeof attr !== typeof undefined && attr !== false) {
            /*console.log($('svg', svgdom).find('g'));*/
            var _h = $('svg', svgdom).find('g').get(0).getBoundingClientRect().height || 500;
            var _w = $('svg', svgdom).find('g').get(0).getBoundingClientRect().width || 1000;
            $('svg', svgdom).attr('viewBox', '0 0 '+_w+' '+(_h+10)+'');
        }
        
        /* end fix proporties svg file */
        
    }
    first_load_map = false;
    
    /* start hint */
    $('*[data-name]', svgdom).hover(function(e){
        var textHin = '';
        $(this).css('cursor', 'pointer');
        if($(this).attr('data-name') && nameArea[$(this).attr('data-name')]) {
            textHint = nameArea[$(this).attr('data-name')];
            
            if(nameCount[$(this).attr('data-name')]) 
                textHint+=' '+' ('+nameCount[$(this).attr('data-name')]+')';
        } else if($(this).attr('title-hint')) {
            textHint = $(this).attr('title-hint');
        } else {
           return false; 
        }
        
        <?php if(sw_count($treefields)<2):?>
        textHint = textHint.replace(', <?php _che($tree_listings_default[$treefields[0]['id']]->value);?> ', '');
        <?php endif;?>
        
        $('body').append('<div id="map-geo-tooltip">'+textHint+'</div>')
        
        var mapCoord = document.getElementById("svgmap").getBoundingClientRect();
        $(this).mouseover(function(){
            $('#map-geo-tooltip').css({opacity:0.8, display:"none"}).fadeIn(200);
        }).mousemove(function(kmouse){
            
            var max_right = mapCoord.right - 150;
            if(max_right<kmouse.pageX)
                $('#map-geo-tooltip').css({left: 'initial',right:mapCoord.right-kmouse.pageX+10, top:mapCoord.top+kmouse.pageY+10});
            else 
                $('#map-geo-tooltip').css({right: 'initial',left:mapCoord.left+kmouse.pageX+10, top:mapCoord.top+kmouse.pageY+10});
            
        });
        
    }, function() {
        $('#map-geo-tooltip').fadeOut(100).remove();
    })
    /* end hint */
    
}

})
 
</script>

<script>
// change dropdown tree if exist
$('document').ready(function(){
    
    $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select').change(function(e, trigger){
        if (typeof trigger === 'undefined') trigger = [];
        if(trigger.isTrigger) {
            return false;
        }
        
        if(firstload) {
            return false;
        }
        
        var id_region = $(this).val();
        var tre_id_split = $(this).attr('id').split('_');
        var _this = $(this);
        while (!id_region) {
            if(_this.parent().prev().find('select').length) {
                id_region = _this.parent().prev().find('select').val();
                _this = _this.parent().prev().find('select');
            }
            else {
                set_path('');
                break;
            }
          }
          
        dataPath = $('.geo-menu a[data-id="'+id_region+'"').attr('data-path');
        if(!dataPath) {
            dataPath='';
            $.each($('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $treefield_id;?> select'), function(){
                if($(this).val() != '')
                {
                    if(dataPath == undefined)
                        dataPath = '';

                    dataPath+= $(this).find("option:selected").text()+' - ';
                }
            });
        }
        
        set_path (dataPath, true, false);
        
        dataRegion= $('.geo-menu a[data-id="'+id_region+'"').attr('data-path-map');
        /* start selected area */
        if($('#svgmap').length && tre_id_split[4]<2){   
            var svgobject = document.getElementById('svgmap');
            if ('contentDocument' in svgobject) {             
                var svgdom = jQuery(svgobject.contentDocument);  
            }
            $('*[data-name]', svgdom).myRemoveClass('highlight');
            
            $('*[data-name]', svgdom).not('.area').css('fill', svg_default_area_color);
            
            $('*[data-name="'+dataRegion+'"]', svgdom).myAddClass('highlight');
            $('*[data-name="'+dataRegion+'"]', svgdom).not('.area').css('fill', svg_selected_area_color);
        }
        /* end selected area */   
        
    })
})

</script>

<script>
/* for first load */
$(window).load(function(){
    var dataPath = '<?php echo search_value($treefield_id); ?>' || '';
    set_path (dataPath, false);
})


function hideShow_tags(parent_seletor) {
    if (typeof parent_seletor === 'undefined') return false;
    if($('a[data-region="'+parent_seletor+'"]').closest('li').find('ul li').length>5) {
        
        var _Liselector = $('a[data-region="'+parent_seletor+'"]').closest('li').find('ul li');
        var _count = 0;
        
        if(_Liselector.hasClass('active'))
            _count = 1;
        
        $.each(_Liselector, function(key, value){
            if(!$(this).hasClass('active') && !$(this).find('a').hasClass('more-tags') && _count>5){
                $(this).css('display', 'none');
            } else {
                $(this).css('display', 'inline-block');
            }
            if(!$(this).hasClass('active'))
                _count++;
        })
        
        if(!$('a[data-region="'+parent_seletor+'"]').closest('li').find('ul li .more-tags').length) {
            $('<li> <a href="#" class="more-tags c-base" data-close="true">more</a></li>').appendTo($('a[data-region="'+parent_seletor+'"]').closest('li').find('ul')).find('.more-tags').click(function(){
               if($(this).attr('data-close') == 'true') {
                    $(this).closest('ul').find('li').css('display', 'inline-block');
                    $(this).attr('data-close', 'false').html('<?php echo _l('short');?>')
                } else if($(this).attr('data-close') == 'false') {
                    hideShow_tags(parent_seletor);
                }
            })
        } else {
          $('a[data-region="'+parent_seletor+'"]').closest('li').find('ul li .more-tags').attr('data-close', 'true').html('<?php echo _l('more');?>')
        }
    } else {
    
    }
}
</script>
<?php endif;?>
        
            <div class="container">
                <div class="geomap-title">
                    <span class="mark-c">{settings_websitetitle}</span> <?php echo lang_check('will help to discover perfect places.');?> <br/>
                    <?php echo lang_check('Perfect experience at the city.');?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="local-form">
                            <form action="{page_current_url}#search-form" class="search-form">
                                <div class="row">
                                    <?php _search_form_primary(1) ;?> 
                                </div>
                                
                                <div class="form-group form-group-btns">
                                    <button type="submit" class="btn btn-custom btn-custom-secondary btn-wide" id="search-start"><?php echo lang_check('Search');?><i class="fa fa-spinner fa-spin fa-ajax-indicator hidden"></i></button>
                                </div>
                                <input id="search_option_<?php _che($treefield_id);?>" type="hidden" class="span3 search_option_<?php _che($treefield_id);?> skip-input" placeholder="{options_name_<?php _che($treefield_id);?>}" value="<?php echo search_value($treefield_id); ?>" />
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php if(!$widget_fatal_error):?>
                        <div class="geo-menu hidden">
                            <div class="geo-menu-breadcrumb"></div>
                            <ul class="treefield-tags">
                                <?php foreach ($treefields as $key => $item) : ?>
                                    <li class=''><a href="#<?php echo str_replace(' ', '-', $item['title']); ?>" data-region='<?php _che($item['title']); ?>' data-path-map-origin="<?php _che($tree_listings_default[$item['id']]->value);?>"  data-path-map="<?php _che($item['title']); ?>" data-name-lvl_0="<?php _che($item['title']); ?>" data-path='<?php _che($item['title']); ?> - ' data-id='<?php _che($item['id']); ?>'><?php _che($item['title']); ?></a>
                                        <ul class='' id="<?php echo str_replace(' ', '-', $item['title']); ?>">
                                            <li><a href="#back" class='geo-menu-back' data-path=''> <i class="fa fa-arrow-left"></i> <?php echo _l('back'); ?> </a></li>
                                            <?php if (sw_count($item['childs']) > 0): ?> 
                                            <?php
                                             /* show empty childs in bottom */
                                                $top=array();
                                                $bottom = array();
                                                foreach ($item['childs'] as $v) {
                                                    if(!empty($v['count'])) {
                                                        $top [] = $v;
                                                    } else {
                                                        $bottom [] = $v;
                                                    }
                                                }
                                                $item['childs'] = $top;
                                                foreach ($bottom as $v) {
                                                    $item['childs'][] = $v;
                                                }
                                            ?>
                                                <?php foreach ($item['childs'] as $child): ?>
                                                    <li><a href="#" data-path-map-origin="<?php _che($tree_listings_default[$child['id']]->value);?>, <?php _che($tree_listings_default[$item['id']]->value);?>" data-path-map="<?php _che($child['title']); ?>, <?php _che($item['title']); ?>" data-region='<?php _che($child['title']); ?>' data-name-lvl_0="<?php _che($item['title']); ?>" data-path='<?php _che($item['title']); ?> - <?php _che($child['title']); ?>' data-id='<?php _che($child['id']); ?>'><?php _che($child['title']); ?> <span class="item-count">(<?php _che($child['count']); ?>)</span></a>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="" id="map-geo">
                            <?php if (isset($_GET['geo_map_preview']) && !empty($_GET['geo_map_preview']) && isset($svg)): ?>
                                <object  data="<?php echo $tmpfile; ?>" type="image/svg+xml" id="svgmap" width="500" height="360">
                                </object>                                 
                            <?php else: ?>
                                <?php if (file_exists(FCPATH . 'files/treefield_64_map.svg')): ?>
                                    <object data="<?php echo base_url('files/treefield_64_map.svg');?>" type="image/svg+xml" id="svgmap" width="500" height="360"></object>                                 
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php else:?>
                            <p class="alert alert-success" style="margin: 15px 0;">
                            <?php echo lang_check('Map didn`t create, please contact on mail: '.$settings_email);?>
                            </p>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
