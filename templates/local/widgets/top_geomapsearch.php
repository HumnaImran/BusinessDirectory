<?php
/*
Widget-title: Geo map with search
Widget-preview-image: /assets/img/widgets_preview/top_geomapsearch.jpg
*/

$CI = &get_instance();
$CI->config->set_item('auto_map_search', TRUE);
?>
<div class="section widget-geomap container container-palette widget_edit_enabled">
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
var geo_trigger_treefield = false;

function geo_strclear(str) {
    return str.replace(/./g, '');
}

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
                
                $('.geo-menu ul'+geo_strclear(_this.attr('href'))).show();
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
        
        if(apply_in_search && tree_field){
            var dataPath = _dataPath;
            
            var e = $('.geo-menu a[data-path-map="'+dataPath+'"]');
            if(!e.length)
                e = $('.geo-menu a[data-path="'+dataPath+'"]')
            
            var id = e.attr('data-id');
            var dropdown = jQuery('.group_location_id .winter_dropdown_tree');
            geo_trigger_treefield = true;
            dropdown.find('.list_items li[key="'+id+'"]').trigger('click');
            geo_trigger_treefield = false;
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
    
     $('.group_location_id input[name="search_option_64"]').change(function(e, trigger){
        if(geo_trigger_treefield) {
            return false;
        }
        
        if(firstload) {
            return false;
        }
        
        var id_region = $(this).val();
        dataPath = $('.geo-menu a[data-id="'+id_region+'"').attr('data-path') || '';
        
        set_path (dataPath, true, false);
        
        dataRegion= $('.geo-menu a[data-id="'+id_region+'"').attr('data-path-map-origin') || '';
        
        var tre_id_split = dataPath.split('_');
        /* start selected area */
        if($('#svgmap').length /*&& tre_id_split[4]<*/){   
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control typeahead_autocomplete" id="search_option_smart" value="<?php _che($search_query); ?>" placeholder="<?php echo lang_check('I’m looking for...');?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group group_location_id">
                                            <?php echo form_treefield('search_option_64', 'treefield_m', _che($search_option_64), 'value', $lang_id, 'field_search_', true, lang_check('Where?'), 64, 'class="form-control locationautocomplete"');?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                           <?php if(config_item('tree_field_enabled') === TRUE):?>
                                            <?php
                                                $f_id = 79;
                                            ?>
                                            <script>
                                                /* [START] TreeField */
                                                $(function() {
                                                    $(".search-form .TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $f_id;?> select").change(function(e, trigger){
                                                        if (typeof trigger === 'undefined') trigger = [];

                                                        var s_value = $(this).val();
                                                        var s_name_splited = $(this).attr('name').split("_"); 
                                                        var s_level = parseInt(s_name_splited[3]);
                                                        var s_lang_id = s_name_splited[1];
                                                        var s_field_id = s_name_splited[0].substr(6);
                                                        // console.log(s_value); console.log(s_level); console.log(s_field_id);
                                                        //var isTrigger = isTrigger || false;

                                                        if(trigger.isTrigger)
                                                            load_by_field($(this), true, trigger.s_values_splited);
                                                        else
                                                            load_by_field($(this));

                                                        // Reset child selection and value generator
                                                        var generated_val = '';
                                                        var last_selected_numeric = '';
                                                        $(this).parent().parent()
                                                        .find('select').each(function(index){
                                                            // console.log($(this).attr('name'));
                                                            if(index > s_level)
                                                            {
                                                                //$(this).html('<option value=""><?php echo lang_check('No values found'); ?></option>');
                                                                if(!trigger.isTrigger) {
                                                                    $(this).find("option:gt(0)").remove();
                                                                    $(this).val('');
                                                                    $(this).selectpicker('refresh');
                                                                }
                                                            }
                                                            else
                                                            {
                                                                last_selected_numeric = $(this).val();
                                                                generated_val+=$(this).find("option:selected").text()+" - ";
                                                            }    
                                                        });
                                                        //console.log(generated_val);
                                                        $("#sinputOption_"+s_lang_id+"_"+s_field_id).val(generated_val);

                                                        $("#inputOption_"+s_lang_id+"_"+s_field_id).attr('rel', last_selected_numeric);
                                                        $("#inputOption_"+s_lang_id+"_"+s_field_id).val(generated_val);
                                                        $("#inputOption_"+s_lang_id+"_"+s_field_id).trigger("change");

                                                    });



                                                });

                                                function load_by_field(field_element, autoselect_next, s_values_splited, first_load)
                                                {
                                                    if (typeof first_load === 'undefined') first_load = false;
                                                    if (typeof autoselect_next === 'undefined') autoselect_next = false;
                                                    if (typeof s_values_splited === 'undefined') s_values_splited = [];

                                                   /* console.log('load_by_field');*/
                                                   // console.log('isTrigger ' + first_load)
                                                    var s_value = field_element.val();
                                                    var s_name_splited = field_element.attr('name').split("_"); 
                                                    var s_level = parseInt(s_name_splited[3]);
                                                    var s_lang_id = s_name_splited[1];
                                                    var s_field_id = s_name_splited[0].substr(6);
                                                    // console.log(s_value); console.log(s_level); console.log(s_field_id);


                                                    // Load values for next select
                                                    var ajax_indicator = field_element.parent().parent().parent().find('.ajax_loading');
                                                    var select_element = $("select[name=option"+s_field_id+"_"+s_lang_id+"_level_"+parseInt(s_level+1)+"]");
                                                    if(select_element.length > 0 && s_value != '')
                                                    {
                                                        ajax_indicator.css('display', 'block');
                                                        $.getJSON( "<?php echo site_url('api/get_level_values_select'); ?>/"+s_lang_id+"/"+s_field_id+"/"+s_value+"/"+parseInt(s_level+1), function( data ) {
                                                            //console.log(data.generate_select);
                                                            //console.log("select[name=option"+s_field_id+"_"+s_lang_id+"_level_"+parseInt(s_level+1)+"]");
                                                            ajax_indicator.css('display', 'none');

                                                            select_element.html(data.generate_select);
                                                            select_element.selectpicker('refresh');

                                                            //cuSel({changedEl: ".select_styled", visRows: 8, scrollArrows: true});



                                                            if(autoselect_next)
                                                            {
                                                                if(s_values_splited[s_level+1] != '')
                                                                {
                                                                    var id = select_element.find('option').filter(function () { return $(this).html() == s_values_splited[s_level+1]; }).attr('selected', 'selected').val();
                                                                    select_element.selectpicker('val', id);
                                                                    load_by_field(select_element, true, s_values_splited);

                                                                }
                                                            }
                                                            if(first_load === true){
                                                                var trigger = {'isTrigger' : true, 's_values_splited':s_values_splited};
                                                                $(".search-form .TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $f_id;?>").find('select:first').trigger('change', [trigger]);
                                                            }

                                                        })
                                                        <?php if(config_item('auto_category_display')=== TRUE):?>
                                                        .success(function(data){
                                                            //console.log(Object.keys(data.values_arr).length);
                                                            // For old browser
                                                            var count = 0;
                                                            var i;
                                                            for (i in data.values_arr) {
                                                                if (data.values_arr.hasOwnProperty(i)) {
                                                                    count++;
                                                                }
                                                            }
                                                            //count = object.keys(data.values_arr).length;
                                                            if(field_element.val() !='' &&  count > 1) {
                                                                field_element.closest('.field-tree').next().show();
                                                            } else {
                                                                field_element.closest('.field-tree').nextAll().hide().find('select').val('');
                                                            }
                                                        });
                                                        <?php endif;?>
                                                    } else {
                                                        <?php if(config_item('auto_category_display')=== TRUE):?>
                                                        field_element.closest('.field-tree').nextAll().hide().find('select').val('');
                                                        <?php endif;?>
                                                    }

                                                }

                                                /* [END] TreeField */

                                            </script>

                                            <!-- [START] TreeSearch -->
                                            <?php if(config_item('tree_field_enabled') === TRUE):?>
                                            <div>
                                                <div class="form-group form-group-lg field_select">
                                            <?php
                                                $CI =& get_instance();
                                                $CI->load->model('treefield_m');
                                                $field_id = $f_id;
                                                $drop_options = $CI->treefield_m->get_level_values($lang_id, $field_id);
                                                $drop_selected = array();
                                                echo '<div class="tree TREE-GENERATOR" id="TREE-GENERATOR_ID_'.$f_id.'">';
                                                echo '<div class="field-tree">';
                                                echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_0', $drop_options, $drop_selected, 'class="form-control selectpicker base no-padding tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_0'.'"');
                                                echo '</div>';

                                                $levels_num = $CI->treefield_m->get_max_level($field_id);

                                                if($levels_num>0)
                                                for($ti=1;$ti<=$levels_num;$ti++)
                                                {
                                                    $lang_empty = lang('treefield_'.$field_id.'_'.$ti);
                                                    if(empty($lang_empty))
                                                        $lang_empty = lang_check('Please select parent');

                                                    echo '<div class="field-tree">';
                                                    echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_'.$ti, array(''=>$lang_empty), array(), 'class="form-control selectpicker base no-padding tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_'.$ti.'"');
                                                    echo '</div>';
                                                }
                                                echo '</div>';

                                            ?>
                                                </div><!-- /.select-wrapper -->
                                            </div><!-- /.form-group -->
                                            <script>
                                            $(window).load(function()  {
                                                    var load_val = '<?php echo search_value($field_id); ?>';
                                                    var s_values_splited = (load_val+" ").split(" - "); 
                                                    var first_load = true;
                                                    if(s_values_splited[0] != '')
                                                    {
                                                        var first_select = $('.TREE-GENERATOR#TREE-GENERATOR_ID_<?php echo $f_id;?>').find('select:first');
                                                        var id = first_select.find('option').filter(function () { return $(this).html() ==  s_values_splited[0]; }).attr('selected', 'selected').val();

                                                        /* test fix */
                                                        first_select.val(id)
                                                        first_select.selectpicker('refresh')
                                                        /* end test fix */

                                                        //first_select.selectpicker('val', id);
                                                        load_by_field(first_select, true, s_values_splited, first_load);
                                                        first_load = false;
                                                    }

                                                });
                                                </script>
                                            <?php endif; ?>
                                            <!-- [END] TreeSearch -->
                                            <?php 
                                            echo form_input('option' . $field_id . '_' . $lang_id, '', 'class="form-control tree-input-value hidden skip" id="inputOption_' . $lang_id . '_' . $field_id . '" rel=""'); 
                                            ?>
                                            <?php endif; ?>

                                            <?php if(config_item('auto_category_display')=== TRUE):?>
                                            <style>
                                                #TREE-GENERATOR_ID_<?php echo $f_id;?> .field-tree:not(:first-child) {
                                                    display: none;
                                                } 
                                            </style>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="advanced-form-part hidden">
                                    <div class="form-row-space"></div>

                                    <input id="search_option_<?php _che($treefield_id);?>" type="text" class="span3 search_option_<?php _che($treefield_id);?> skip-input" placeholder="{options_name_<?php _che($treefield_id);?>}" value="<?php echo search_value($treefield_id); ?>" />

                                    <?php if(config_db_item('secondary_disabled') === TRUE): ?>
                                     <!--
                                    <input id="search_option_36_from" type="text" class="span3 mPrice" placeholder="<?php _l('Fromprice');?> ({options_prefix_36}{options_suffix_36})" value="<?php echo search_value('36_from'); ?>" />
                                    <input id="search_option_36_to" type="text" class="span3 xPrice" placeholder="<?php _l('Toprice');?> ({options_prefix_36}{options_suffix_36})" value="<?php echo search_value('36_to'); ?>" />
                                    -->
                                     <input id="search_option_19" type="text" class="span3 Bathrooms" placeholder="{options_name_19}" value="<?php echo search_value(19); ?>" />
                                    <input id="search_option_20" type="text" class="span3" placeholder="{options_name_20}" value="<?php echo search_value(20); ?>" />
                                    <div class="form-row-space"></div>
                                    <?php if(file_exists(APPPATH.'controllers/admin/booking.php')):?>
                                    <input id="booking_date_from" type="text" class="span3 mPrice" placeholder="<?php _l('FromDate');?>" value="<?php echo search_value('date_from'); ?>" />
                                    <input id="booking_date_to" type="text" class="span3 xPrice" placeholder="<?php _l('ToDate');?>" value="<?php echo search_value('date_to'); ?>" />
                                    <div class="form-row-space"></div>
                                    <?php endif; ?>
                                    <?php if(config_db_item('search_energy_efficient_enabled') === TRUE): ?>
                                    <select id="search_option_59_to" class="span3 selectpicker nomargin">
                                        <option value="">{options_name_59}</option>
                                        <option value="50">A</option>
                                        <option value="90">B</option>
                                        <option value="150">C</option>
                                        <option value="230">D</option>
                                        <option value="330">E</option>
                                        <option value="450">F</option>
                                        <option value="999999">G</option>
                                    </select>
                                    <div class="form-row-space"></div>
                                    <?php endif; ?>
                                    <label class="checkbox">
                                    <input id="search_option_11" type="checkbox" class="span1" value="true{options_name_11}" <?php echo search_value('11', 'checked'); ?>/>{options_name_11}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_22" type="checkbox" class="span1" value="true{options_name_22}" <?php echo search_value('22', 'checked'); ?>/>{options_name_22}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_25" type="checkbox" class="span1" value="true{options_name_25}" <?php echo search_value('25', 'checked'); ?>/>{options_name_25}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_27" type="checkbox" class="span1" value="true{options_name_27}" <?php echo search_value('27', 'checked'); ?>/>{options_name_27}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_28" type="checkbox" class="span1" value="true{options_name_28}" <?php echo search_value('28', 'checked'); ?>/>{options_name_28}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_29" type="checkbox" class="span1" value="true{options_name_29}" <?php echo search_value('29', 'checked'); ?>/>{options_name_29}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_32" type="checkbox" class="span1" value="true{options_name_32}" <?php echo search_value('32', 'checked'); ?>/>{options_name_32}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_30" type="checkbox" class="span1" value="true{options_name_30}" <?php echo search_value('30', 'checked'); ?>/>{options_name_30}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_33" type="checkbox" class="span1" value="true{options_name_33}" <?php echo search_value('33', 'checked'); ?>/>{options_name_33}
                                    </label>
                                    <label class="checkbox">
                                    <input id="search_option_23" type="checkbox" class="span1" value="true{options_name_23}" <?php echo search_value('23', 'checked'); ?>/>{options_name_23}
                                    </label>
                                    <?php else: ?>
                                    <?php _search_form_secondary_hidden(1); ?>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group form-group-btns">
                                    <button type="submit" class="btn btn-custom btn-custom-secondary btn-wide" id="search-start"><?php echo lang_check('Search');?><i class="fa fa-spinner fa-spin fa-ajax-indicator hidden"></i></button>
                                </div>
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
