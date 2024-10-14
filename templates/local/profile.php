<?php
$CI = &get_instance();
$CI->load->model('estate_m');
$CI->load->model('option_m');

$estates = $this->estate_m->get_by(array('is_activated' => 1, 'language_id'=>$lang_id),  FALSE, NULL, NULL, NULL,  array(), NULL, $agent_profile['id']);
$options_name = $this->option_m->get_lang(NULL, FALSE, $lang_id);

$all_agent_estates = array();
$CI->generate_results_array($estates, $all_agent_estates, $options_name); 
$all_estates_center = calculateCenter($estates);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
    </head>
    <body class="<?php _widget('custom_paletteclass'); ?>">
        <header class="header">
            <?php _widget('custom_header_menu-for-loginuser_wide');?>
            <?php _widget('header_main_color');?>
        </header><!-- /.header -->
        <div class="container container-palette section-top section-profile">
            <div class="container">
                <div class="section-profile-box">
                    <div class="content">
                        <div class="profile-logo">
                            <img src="{agent_image_url}" alt="{page_title}" />
                        </div>
                        <div class="profile-body">
                            <h2 class="title">{page_title}</h2>
                            <div class="options">
                                <i class="ion-ios-list-outline primary-text-color"></i><?php echo sw_count($all_agent_estates);?> <?php echo lang_check('Listings');?>
                            </div>
                        </div>
                    </div>
                    <div class="right-bar">
                        <ul class="list-social-line">
                            <?php if(!empty($agent_profile['facebook_link'])): ?>
                                <li><a class="facebook"  href="<?php echo $agent_profile['facebook_link']; ?>"><i class="fa fa-facebook facebook"></i></a></li>
                            <?php endif; ?>
                            <?php if(!empty($agent_profile['youtube_link'])): ?>
                                <li><a class="twitter" href="<?php echo $agent_profile['youtube_link']; ?>"><i class="fa fa-youtube youtube"></i></a></li>
                            <?php endif; ?>
                            <?php if(!empty($agent_profile['gplus_link'])): ?>
                                <li><a class="google-plus" href="<?php echo $agent_profile['gplus_link']; ?>"><i class="fa fa-google-plus google"></i></a></li>
                            <?php endif; ?>
                            <?php if(!empty($agent_profile['twitter_link'])): ?>
                                <li><a class="twitter" href="<?php echo $agent_profile['twitter_link']; ?>"><i class="fa fa-twitter twitter"></i></a></li>
                            <?php endif; ?>
                            <?php if(!empty($agent_profile['linkedin_link'])): ?>
                                <li><a class="google-plus" href="<?php echo $agent_profile['linkedin_link']; ?>"><i class="fa fa-linkedin linkedin"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container container-palette bg-default">
            <div class="container">  
                <div class="swap-md-down row">
                    <div class="col-md-9 swap-bottom left-side">
                        <div class="widget widget-profile-results" id="ajax_results">
                            <div class="row result-container row-flex">
                                <?php if(!empty($agent_estates)):?>
                                    <?php foreach($agent_estates as $key=>$item): ?>
                                        <div class="col-xs-12">
                                            <div class="thumbnail thumbnail-property thumbnail-property-list nohover" data-number="<?php echo $key +1;?>">
                                                <div class="thumbnail-image">
                                                    <a href="<?php echo $item['url']; ?>">
                                                        <img src="<?php echo _simg($item['thumbnail_url'], '612x386'); ?>" alt="<?php echo basename($item['thumbnail_url']);?>">
                                                    </a>
                                                </div>
                                                <div class="caption">
                                                    <div class="header">
                                                        <div class="left">
                                                            <h2 class="thumbnail-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h2>
                                                            <div class="options">
                                                                <span class="thumbnail-ratings">
                                                                    <?php
                                                                        $CI = &get_instance();
                                                                        $CI->load->model('reviews_m');
                                                                        $avarage_stars = intval($CI->reviews_m->get_avarage_rating($item['id'])+0.5);
                                                                    ?>

                                                                    <?php if(!empty($avarage_stars)):?>
                                                                        <?php echo $avarage_stars; ?> <i class="icon-star-ratings-<?php echo $avarage_stars; ?>"></i>
                                                                    <?php elseif(!empty($item['option_56'])):?>
                                                                        <?php echo _ch($item['option_56'],'0'); ?> <i class="icon-star-ratings-<?php echo _ch($item['option_56'],'0'); ?>"></i>
                                                                    <?php endif;?>
                                                                </span>
                                                                <span class="type">
                                                                    <a href="<?php echo $item['url']; ?>"><?php _che($item['option_4']); ?></a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <div class="address"><?php _che($item['address']); ?></div>
                                                        </div>
                                                    </div>
                                                    <ul class="list-default">
                                                        <?php if(isset($item['option_8']) && !empty($item['option_8'])):?>
                                                        <li>
                                                            <p>
                                                                <?php echo character_limiter(strip_tags($item['option_8']), 40); ?>
                                                            </p>
                                                        </li>
                                                        <?php endif;?>

                                                        <li>
                                                            <p>
                                                            <?php
                                                                $custom_elements = _get_custom_items();
                                                                $i=0;
                                                                $k=0;
                                                                $c=0;
                                                                if(sw_count($custom_elements) > 0):
                                                                foreach($custom_elements as $key=>$elem):

                                                                //if($c==0)echo '<div class="options">';

                                                                if(!empty($item['option_'.$elem->f_id]) && $i++<3){
                                                                    if($elem->type == 'DROPDOWN' || $elem->type == 'INPUTBOX'):
                                                                     ?>
                                                                    <span class="cproperty-field" title="<?php _che(${"options_name_$elem->f_id"}, '-'); ?>"><i class="fa <?php _che($elem->f_class); ?>"></i><small><?php echo _ch($item['option_'.$elem->f_id], '-'); ?> <?php echo _ch(${"options_suffix_$elem->f_id"}, ''); ?> <span style="<?php _che($elem->f_style); ?>"><?php echo _ch(${"options_name_$elem->f_id"}, '-'); ?></span></small></span>
                                                                     <?php 
                                                                    elseif($elem->type == 'CHECKBOX'):
                                                                     ?>
                                                                    <span class="property-field" title="<?php _che(${"options_name_$elem->f_id"}, '-'); ?>"><i class="fa <?php _che($elem->f_class); ?>"></i><small> <strong class="<?php echo (!empty($item['option_'.$elem->f_id])) ? 'glyphicon glyphicon-ok':'glyphicon glyphicon-remove';  ?>"></strong> <?php echo _ch(${"options_name_$elem->f_id"}, '-'); ?></small></span>
                                                                     <?php 
                                                                    endif; 
                                                                    if( ($k+1)%2==0 )
                                                                    {
                                                                        //echo '</div><div class="options">';
                                                                    }
                                                                    $k++;
                                                                }
                                                                $c++;

                                                                endforeach;  
                                                                //echo '</div>';
                                                                else:
                                                            ?>
                                                                <?php if(isset($options_name_58) && !empty($options_name_58)):?>
                                                                <span class="property-field"><b><?php _che($options_name_58); ?></b> : <?php echo _ch($item['option_58']); ?></span>
                                                                <?php endif;?>
                                                                <?php if(isset($options_name_57) && !empty($options_name_57)):?>
                                                                <span class="property-field"> <b><?php echo lang_check('Size'); ?></b> : <?php echo _ch($options_prefix_57)._ch($item['option_57'])._ch($options_suffix_57); ?></span>
                                                                <?php endif;?>
                                                            <?php endif; ?>
                                                            </p>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div> 
                                    <?php endforeach;?>
                                    <nav class="text-center">
                                        <div class="pagination-ajax-results pagination  wp-block default product-list-filters light-gray pagination" rel="ajax_results">
                                            <?php echo $pagination_links_agent; ?>
                                        </div>
                                    </nav>
                                <?php else: ?>
                                    <div class="widget-content">
                                        <div class="col-xs-12 pt35">
                                            <div class="alert alert-success">
                                                <?php echo lang_check('Properties not available');?>
                                            </div>
                                        </div>
                                    </div> <!-- /. recent properties -->
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 swap-top right-side sidebar">
                        <div class="widget widget-styles widget-right-map">
                            <div class="header b link">
                                <h2><?php echo lang_check('Wide Map');?></h2>
                            </div>
                            <div class="body">
                                <div id="main-map-mini" class="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
        
        <script>
        $(function(){
            if ($('#main-map-mini').length) {
            var myLocationEnabled = true;
                  var style_map = [{"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{"color": "#444444"}]}, {"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#f2f2f2"}]}, {"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "road", "elementType": "all", "stylers": [{"saturation": -100}, {"lightness": 45}]}, {"featureType": "road.highway", "elementType": "all", "stylers": [{"visibility": "simplified"}]}, {"featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "transit", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#46bcec"}, {"visibility": "on"}]}];
                  var scrollwheelEnabled = false;

                  var markers = new Array();
                  var mapOptions = {
                      center: new google.maps.LatLng(<?php _che($all_estates_center);?>),
                      zoom: 7,
                      mapTypeId: google.maps.MapTypeId.ROADMAP,
                      scrollwheel: scrollwheelEnabled,
                      disableDefaultUI: true,
                      // styles:style_map
                  };
                  
                  var map = new google.maps.Map(document.getElementById('main-map-mini'), mapOptions);

                   <?php if(!empty($all_agent_estates))?>
                    <?php foreach($all_agent_estates as $key=>$item): ?>
                        <?php
                            if(!isset($item['gps']))break;
                            if(empty($item['gps']))continue;
                            
                        ?>
                    
                      var marker = new google.maps.Marker({
                          position: new google.maps.LatLng(<?php _che($item['gps']);?>),
                          map: map,
                          icon: 'assets/img/markers/marker-transparent.png'
                      });

                      var markerOptions_1 = {
                          content: '<div class="infobox infobox-mini">' +
                                      '<div class="preview-image"><a href="<?php echo slug_url($listing_uri.'/'.$item['id'].'/'.$lang_code.'/'.url_title_cro($item['option_10']));?>">' +
                                      '<img src="<?php echo _simg($item['thumbnail_url'], '70x70'); ?>" alt="<?php _che($item['option_10']); ?>">' +
                                      '</a></div>' +
                                      '<div class="content">' +
                                        '<div class="title"> <a href="<?php echo slug_url($listing_uri.'/'.$item['id'].'/'.$lang_code.'/'.url_title_cro($item['option_10']));?>"><?php _che($item['option_10']); ?></a></div>' +
                                    '</div>',
                          disableAutoPan: false,
                          maxWidth: 0,
                          pixelOffset: new google.maps.Size(-87, -276),
                          zIndex: null,
                          infoBoxClearance: new google.maps.Size(1, 1),
                          position: new google.maps.LatLng(<?php _che($item['gps']);?>),
                          isHidden: false,
                          pane: "floatPane",
                          enableEventPropagation: false,
                          closeBoxURL: "assets/img/close.png"
                      };
                      marker.infobox = new InfoBox(markerOptions_1);
                      marker.infobox.isOpen = false;
                      // marker
                      var markerOptions_2 = {
                          content: '<div class="google_marker"><img src="<?php _che($item['icon']); ?>" alt="icon"></div>',
                          disableAutoPan: true,
                          pixelOffset: new google.maps.Size(-20, -55),
                          position: new google.maps.LatLng(<?php _che($item['gps']);?>),
                          closeBoxMargin: "",
                          closeBoxURL: "",
                          isHidden: false,
                          //pane: "mapPane",
                          enableEventPropagation: true
                      };
                      marker.marker = new InfoBox(markerOptions_2);      
                      marker.marker.isHidden = false;      
                      marker.marker.open(map, marker);
                      markers.push(marker);

                      // action        
                      google.maps.event.addListener(marker, "click", function (e) {
                          var curMarker = this;

                          $.each(markers, function (index, marker) {
                              // if marker is not the clicked marker, close the marker
                              if (marker !== curMarker) {
                                  marker.infobox.close();
                                  marker.infobox.isOpen = false;
                              }
                          });

                          if (curMarker.infobox.isOpen === false) {
                              curMarker.infobox.open(map, this);
                              curMarker.infobox.isOpen = true;
                              map.panTo(curMarker.getPosition());
                          } else {
                              curMarker.infobox.close();
                              curMarker.infobox.isOpen = false;
                          }

                      });
                  <?php endforeach;?>

                  var mcOptions = {
                          gridSize: 40,
                          styles: [
                                  {
                                      height: 52,
                                      url: 'assets/img/cluster/m1.png',
                                      width: 52,
                                      textColor: '#fff'
                                  }
                          ]
                      };

                  var marker_clusterer = new MarkerClusterer(map, markers, mcOptions);
                  var clusterListener = google.maps.event.addListener(marker_clusterer, 'clusteringend', function (clusterer) {
                          var availableClusters = clusterer.getClusters();
                          var activeClusters = new Array();
                          $.each(availableClusters, function (index, cluster) {
                                  if (cluster.getMarkers().length > 1) {
                                          $.each(cluster.getMarkers(), (function (index, marker) {
                                                  if (marker.marker.isHidden == false) {
                                                          marker.marker.isHidden = true;
                                                          marker.marker.close();
                                                  }
                                          }));
                                  } else {
                                          $.each(cluster.getMarkers(), function (index, marker) {
                                                  if (marker.marker.isHidden == true) {
                                                          marker.marker.open(map, this);
                                                          marker.marker.isHidden = false;
                                                  }
                                          });
                                  }
                          });
                  });
              }
        })
        </script>
    </body>
</html>