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

<div class="widget-styles widget_edit_enabled widget-property_center_map">
    <div class="header content t-left"><h2><?php _l('Propertylocation');?></h2></div>
    <div class="content-box">
        <?php if(!empty($estate_data_gps)): ?>
        <div class="places_select" style="display: none;">
            <a class="btn btn-large" data-rel="hospital,health"><img src="assets/img/places_icons/hospital.png" alt='hospital,health'/> <?php _l('Health');?></a>
            <a class="btn btn-large" data-rel="park"><img src="assets/img/places_icons/park.png" alt='park' /> <?php _l('Park');?></a>
            <a class="btn btn-large" data-rel="atm,bank"><img src="assets/img/places_icons/atm.png" alt='atm'/> <?php _l('ATMBank');?></a>
            <a class="btn btn-large" data-rel="gas_station"><img src="assets/img/places_icons/petrol.png" alt="gas_station"/> <?php _l('PetrolPump');?></a>
            <a class="btn btn-large" data-rel="food,bar,cafe,restourant"><img src="assets/img/places_icons/restourant.png" alt="food" /> <?php _l('Restourant');?></a>
            <a class="btn btn-large" data-rel="store"><img src="assets/img/places_icons/store.png" alt="store"/> <?php _l('Store');?></a>
        </div>
        <div class="property-map" id='property-map' style='height: 385px;'></div>
        <?php else: ?>
            <p class="alert alert-success"><?php _l('Not available'); ?></p>
        <?php endif;?>
        <div class="address"><i class="fa fa-map-marker text-color-primary"></i><?php _che($estate_data_address);?></div>
        <form class="route_suggestion local-form form-inline" action="">
            <input id="route_from" class="inputtext w360 form-control" type="text" value="" placeholder="<?php echo lang_check('Type your address');?>" name="route_from" required="required" />
            <button id="route_from_button" href="#" class="btn btn-custom btn-custom-grey"><?php echo _l('Suggest route');?></button>
        </form>
    </div>
</div>
<?php if(!empty($estate_data_gps)): ?>
<script>
(function(){
     
var IMG_FOLDER = "assets/js/dpejes";
var map;
$(document).ready(function(){
    var myLocationEnabled = true;
    //var style_map =[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
    var scrollwheelEnabled = false;
        
             <?php if(config_db_item('map_version') =='open_street'):?>
            
        <?php 
            $estate_data_icon = '';
            if(!empty($estate_data_option_79) && isset($values[$estate_data_option_79])){
                $estate_data_icon = $values[$estate_data_option_79];
            }
        ?>        
                    
                    
            var property_map;
            property_map = L.map('property-map', {
                center: [{estate_data_gps}],
                zoom: {settings_zoom}+6,
                scrollWheelZoom: scrollWheelEnabled,
                dragging: !L.Browser.mobile,
                tap: !L.Browser.mobile
            });     
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(property_map);
            var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(property_map);
            var property_marker = L.marker(
                [{estate_data_gps}],
                {icon: L.divIcon({
                        html: '<img src="<?php _jse($estate_data_icon); ?>">',
                        className: 'open_steet_map_marker google_marker',
                        iconSize: [40, 46],
                        popupAnchor: [1, -35],
                        iconAnchor: [20, 46],
                    })
                }
            ).addTo(property_map);

            property_marker.bindPopup("{estate_data_address}<br />{lang_GPS}: {estate_data_gps}");

       <?php else:?>   
        
    // map init    
    if($('#property-map').length){

        var markers1 = new Array();
        var mapOptions1 = {
            center: new google.maps.LatLng({estate_data_gps}),
            zoom: {settings_zoom},
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: scrollwheelEnabled,
            styles: mapStyle
        };

        map = new google.maps.Map(document.getElementById('property-map'), mapOptions1);
        map_propertyLoc = map  


        <?php 
            $estate_data_icon = '';
            if(!empty($estate_data_option_79) && isset($values[$estate_data_option_79])){
                $estate_data_icon = $values[$estate_data_option_79];
            }
        ?>

        var content= '<div class="infobox infobox-mini infobox-property">' +
                        '<div class="content">' +
                    '<div class="title"> <?php echo lang_check('Address');?>: <?php _jse($estate_data_address); ?> </a></div>' +
                '</div>';
        var myLatlng = new google.maps.LatLng({estate_data_gps});
        var callback = {
                    'click': function(map, e){
                        var activemarker = e.activemarker;
                        this.activemarker = false;

                        sw_infoBox.close();
                        if(activemarker) {
                            e.activemarker = false;
                            return true;
                        }
                        var content= '<div class="infobox infobox-mini infobox-property">' +
                                        '<div class="content">' +
                                    '<div class="title"> <?php echo lang_check('Address');?>: <?php _jse($estate_data_address); ?> </a></div>' +
                                '</div>';
                        
                        var boxOptions = {
                            content: content,
                            disableAutoPan: false,
                            alignBottom: true,
                            maxWidth: 0,
                            pixelOffset: new google.maps.Size(-74, -27),
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
        var marker_inner ='<img src="<?php _jse($estate_data_icon); ?>">';
        var marker = new CustomMarker(myLatlng,map_propertyLoc,marker_inner,callback);

        markers1.push(marker);
        

        if(myLocationEnabled){
            var controlDiv = document.createElement('div');
            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
            HomeControl(controlDiv, map)
        }

    } 
     
    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>       
    // init_gmap_searchbox();
    if (typeof swplaces_init_directions == 'function')
     {
         $(".places_select a").click(function(){
             init_places($(this).attr('data-rel'), $(this).find('img').attr('src'));
         });

         var selected_place_type = 4;

         swplaces_init_directions();
         directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});


         directionsDisplay.setMap(map);
         init_places($(".places_select a:eq("+selected_place_type+")").attr('data-rel'), $(".places_select a:eq("+selected_place_type+") img").attr('src'));

     }
    <?php endif;?>
    <?php endif;?>   
        
}); 

<?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js') && config_db_item('map_version') !='open_street'): ?>  
var map_propertyLoc;
var markers = [];
var generic_icon;

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var placesService;

function init_places(places_types, icon) {
    var pyrmont = new google.maps.LatLng({estate_data_gps});

    setAllMap_near(null);

    generic_icon = icon;


    var places_type_array = places_types.split(','); 

    var request = {
        location: pyrmont,
        radius: 2000,
        types: places_type_array
    };

    infowindow = new google.maps.InfoWindow();
    placesService = new google.maps.places.PlacesService(map);
    placesService.nearbySearch(request, callback);

}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}

function setAllMap_near(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

function calcRoute(source_place, dest_place) {
  var selectedMode = 'WALKING';
  var request = {
      origin: source_place,
      destination: dest_place,
      // Note that Javascript allows us to access the constant
      // using square brackets and a string value as its
      // "property."
      travelMode: google.maps.TravelMode[selectedMode]
  };

  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      //console.log(response.routes[0].legs[0].distance.value);
    }
  });
}

function createMarker(place) {
  var placeLoc = place.geometry.location;
  var propertyLocation = new google.maps.LatLng({estate_data_gps});

    if(place.icon.indexOf("generic") > -1)
    {
        place.icon = generic_icon;
    }

    var image = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25)
    };

  var marker = new google.maps.Marker({
    map: map,
    icon: image,
    position: place.geometry.location
  });

  markers.push(marker);

  var distanceKm = (calcDistance(propertyLocation, placeLoc)*1.2).toFixed(2);
  var walkingTime = parseInt((distanceKm/5)*60+0.5);

  google.maps.event.addListener(marker, 'click', function() {

        //drawing route
        calcRoute(propertyLocation, placeLoc);

    // Fetch place details
    placesService.getDetails({ placeId: place.place_id }, function(placeDetails, statusDetails){



        //open popup infowindow
        infowindow.setContent(place.name+'<br /><?php _l('Distance');?>: '+distanceKm+'<?php _l('Km');?>'+
                              '<br /><?php _l('WalkingTime');?>: '+walkingTime+'<?php _l('Min');?>'+
                              '<br /><a target="_blank" href="'+placeDetails.url+'"><?php _l('Details');?></a>');
        infowindow.open(map_propertyLoc, marker);
    });

  });
}

//calculates distance between two points
function calcDistance(p1, p2){
  return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
}
<?php endif;?>

$(".route_suggestion").submit(function (e) { 
    e.preventDefault();
    window.open("https://maps.google.com/maps?saddr="+$("#route_from").val()+"&daddr={estate_data_address}@{estate_data_gps}&hl={lang_code}",'_blank');
    return false;
}); 
 })()  
       
</script>
<?php endif;?>