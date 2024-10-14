<?php
$tree_field_id = 79;
$CI = & get_instance();
$values = array();
$CI->load->model('treefield_m');
$CI->load->model('file_m');
$check_option = $CI->treefield_m->get_lang(NULL, FALSE, $lang_id);
foreach ($check_option as $key => $value) {
    if($value->field_id==$tree_field_id){
        $icon = 'assets/img/markers/piazza.png';
        // Thumbnail and big image
        if(!empty($value->image_filename))
        {
            $files_r = $CI->file_m->get_by(array('repository_id' => $value->repository_id),FALSE, 5,'id ASC');
            // check second image
            if($files_r and isset($files_r[1]) and file_exists(FCPATH.'files/thumbnail/'.$files_r[1]->filename)) {
                $icon = base_url('files/'.$files_r[1]->filename);
            }
        }
        $values[$value->value_path]= $icon;
    }
}
?>

<div id="main-map" class="map">
</div>
<script>

    var markers = new Array();
    var map;
    var marker_clusterer ;
    $(document).ready(function(){
        // option
        var myLocationEnabled = true;
        var style_map = mapStyle;
        var scrollwheelEnabled = false;
        
        <?php if(config_db_item('map_version') =='open_street'):?>
                
        if($('#main-map').length){    
            map = L.map('main-map', {
                <?php if(config_item('custom_map_center') === FALSE): ?>
                center: [{all_estates_center}],
                <?php else: ?>
                center: [<?php echo config_item('custom_map_center'); ?>],
                <?php endif; ?>
                zoom: {settings_zoom}-2,
                scrollWheelZoom: scrollwheelEnabled,
                dragging: !L.Browser.mobile,
                tap: !L.Browser.mobile
            });     
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);

            <?php foreach($all_estates as $item): ?>
                <?php
                    if(!isset($item['gps']))break;
                    if(empty($item['gps']))continue;
                ?>
                <?php 
                    $item['icon'] = '';
                    if(!empty($item['option_79']) && isset($values[$item['option_79']])){
                        $item['icon'] = $values[$item['option_79']];
                    }
                ?>           
                            
                var marker = L.marker(
                    [<?php _che($item['gps']); ?>],
                    {icon: L.divIcon({
                            html: '<img src="<?php _che($item['icon'])?>">',
                            className: 'open_steet_map_marker google_marker',
                            iconSize: [40, 46],
                            popupAnchor: [1, -35],
                            iconAnchor: [20, 46],
                        })
                    }
                )/*.addTo(map)*/;

                marker.bindPopup("<?php echo _generate_popup($item, true); ?>", jpopup_customOptions);
                clusters.addLayer(marker);
                markers.push(marker);
            <?php endforeach; ?>
            map.addLayer(clusters);    
            <?php if(config_db_item('map_fixed_position') == FALSE): ?>
            /* set center */
            if(markers.length){
                var limits_center = [];
                for (var i in markers) {
                    if(typeof markers[i]['_latlng'] == 'undefined') continue;
                    var latLngs = [ markers[i].getLatLng() ];
                    limits_center.push(latLngs)
                };
                var bounds = L.latLngBounds(limits_center);
                <?php if(config_db_item('auto_set_zoom_disabled') != FALSE): ?>
                    map.setView(bounds.getCenter());
               <?php else:?>
                    map.fitBounds(bounds);
               <?php endif;?>
            }
            <?php endif;?>
        } 
        window.dispatchEvent(new Event('resize'));
        <?php else:?>
        if($('#main-map').length){


        var mapOptions = {
            <?php if(config_item('custom_map_center') === FALSE): ?>
            center: new google.maps.LatLng({all_estates_center}),
            <?php else: ?>
            center: new google.maps.LatLng(<?php echo config_item('custom_map_center'); ?>),
            <?php endif; ?>
            zoom: {settings_zoom},
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: scrollwheelEnabled,
            mapTypeControlOptions: {
              mapTypeIds: c_mapTypeIds,
              position: google.maps.ControlPosition.TOP_RIGHT
            },
            styles: mapStyle
        };

                map = new google.maps.Map(document.getElementById('main-map'), mapOptions);

                <?php foreach($all_estates as $item): ?>
                    <?php
                        if(!isset($item['gps']))break;
                        if(empty($item['gps']))continue;
                    ?>
                                
                    <?php 
                        $item['icon'] = '';
                        if(!empty($item['option_79']) && isset($values[$item['option_79']])){
                            $item['icon'] = $values[$item['option_79']];
                        }
                    ?>

                var myLatlng = new google.maps.LatLng(<?php _che($item['gps']); ?>);
                var callback = {
                                'click': function(map, e){
                                    var activemarker = e.activemarker;
                                    jQuery.each(markers, function(){
                                        this.activemarker = false;
                                    })

                                    sw_infoBox.close();
                                    if(activemarker) {
                                        e.activemarker = false;
                                        return true;
                                    }
                                    
                                    var boxOptions = {
                                        content: "<?php echo _generate_popup($item, true); ?>",
                                        disableAutoPan: false,
                                        alignBottom: true,
                                        maxWidth: 0,
                                        pixelOffset: new google.maps.Size(-87, -55),
                                        zIndex: null,
                                        closeBoxMargin: "0",
                                        closeBoxURL: "",
                                        infoBoxClearance: new google.maps.Size(1, 1),
                                        isHidden: false,
                                        pane: "floatPane",
                                        enableEventPropagation: false,
                                        closeBoxURL: "assets/img/close.png"
                                    };
                            
                                    sw_infoBox.setOptions( boxOptions);
                                    sw_infoBox.open( map, e );

                                    e.activemarker = true;
                                }
                        };
                var marker_inner ='<img src="<?php _che($item['icon'])?>">';
                var marker = new CustomMarker(myLatlng,map,marker_inner,callback);
                markers.push(marker);


                <?php endforeach; ?>

                marker_clusterer = new MarkerClusterer(map, markers, clusterConfig);

        if(mapSearchbox){   
            init_map_searchbox(map);
        }  

        if(myLocationEnabled){
            var controlDiv = document.createElement('div');
            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
            HomeControl(controlDiv, map)
            }
        }


        if(rectangleSearchEnabled)
         {
             var controlDiv2 = document.createElement('div');
             controlDiv2.index = 2;
             map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv2);
             RectangleControl(controlDiv2, map)
         } 

        <?php endif;?>
    })

    </script>