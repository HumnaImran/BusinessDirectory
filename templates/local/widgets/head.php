<meta charset="UTF-8">
<title>{page_title}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- SEO -->
<!-- For Google -->
<meta name="description" content="{page_description}" />
<meta name="keywords" content="{page_keywords}" />
<meta name="author" content="" />
<meta name="application-name" content="" />
<?php
    echo generate_alternate_meta();
?>

<!-- For Facebook -->
<meta property="fb:app_id" content="" />
<meta property="og:site_name" content="<?php _che($settings_websitetitle, '');?>" />
<meta property="og:title" content="<?php _che($settings_websitetitle, '');?> - {page_title}" />

<?php if(isset($page_images) && !empty($page_images)):?>
<meta property="og:image" content="<?php _che($page_images[0]->url);?>" />
<?php else:?>
<meta property="og:image" content="<?php _che($website_logo_url);?>" />
<?php endif;?>

<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:description" content="{page_description}" />

<!-- For Twitter -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?php _che($settings_websitetitle, '');?> - {page_title}" />
<meta name="twitter:description" content="{page_description}" />

<?php if(isset($page_images) && !empty($page_images)):?>
<meta name="twitter:image" content="<?php _che($page_images[0]->url);?>" />
<?php else:?>
<meta name="twitter:image" content="<?php _che($website_logo_url);?>" />
<?php endif;?>
<!-- END SEO -->

<link rel="canonical" href="<?php echo slug_url(uri_string());?>" />
<link rel="shortcut icon" href="<?php echo $website_favicon_url;?>" type="image/png" />

<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900%7COpen+Sans:300,400,600,700,800&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">


<?php cache_file('big_css.css', 'assets/libraries/font-awesome/css/font-awesome.min.css'); ?>
<?php cache_file('big_css.css', 'assets/libraries/ionicons-2.0.1/css/ionicons.min.css'); ?>

<!-- Start Jquery -->
<?php cache_file('big_js_critical.js', 'assets/js/jquery-2.2.1.min.js'); ?>
<?php cache_file('big_js_critical.js', 'assets/libraries/jquery.mobile/jquery.mobile.custom.min.js'); ?>
<!-- End Jquery -->

<!-- Start BOOTSTRAP -->

<?php cache_file('big_css.css', 'assets/libraries/bootstrap/dist/css/bootstrap.min.css'); ?>
<?php cache_file('big_css.css', 'assets/css/bootstrap-select.min.css'); ?>
<?php cache_file('big_css.css', 'assets/libraries/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/bootstrap/dist/js/bootstrap.min.js'); ?>
<?php cache_file('big_js.js', 'assets/js/bootstrap-select.min.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js'); ?>
<!-- End Bootstrap -->
<!-- Start Template files -->
<?php cache_file('big_css.css', 'assets/css/local.css'); ?>
<?php cache_file('big_css.css', 'assets/css/local-media.css'); ?>
<?php cache_file('big_js.js', 'assets/js/local.js'); ?>
<!-- End  Template files -->
<!-- Start blueimp  -->

<?php cache_file('big_css.css', 'assets/css/blueimp-gallery.min.css'); ?>
<?php cache_file('big_js.js', 'assets/js/blueimp-gallery.min.js'); ?>
<!-- End blueimp  -->

<?php cache_file('big_css.css', 'assets/libraries/owl.carousel/dist/css/owl.carousel.min.css'); ?>
<?php cache_file('big_css.css', 'assets/libraries/owl.carousel/dist/css/owl.theme.default.css'); ?>
<?php cache_file('big_css.css', 'assets/libraries/owl.carousel/dist/css/animate.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/owl.carousel/dist/owl.carousel.min.js'); ?>
<!-- Start custom styles  -->
<!-- Start select-picke  -->
<?php cache_file('big_css.css', 'assets/libraries/select-picker-auhau/dist/picker.min.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/select-picker-auhau/dist/picker.min.js'); ?>
<!-- End select-picke  -->

<?php cache_file('big_css.css', 'assets/js/winter_treefield/winter.css'); ?>
<?php cache_file('big_js.js', 'assets/js/winter_treefield/winter.js'); ?>

<?php load_map_api(config_db_item('map_version'), $lang_code);?>
    
<?php if(config_db_item('map_version') !='open_street'):?>
<?php cache_file('big_js.js', 'assets/js/map_infobox.js'); ?>
<?php cache_file('big_js.js', 'assets/js/custom_google_marker.js'); ?>
<?php cache_file('big_js.js', 'assets/js/markerclusterer.js'); ?>
<?php endif;?>

<?php cache_file('big_css.css', 'assets/css/map.css'); ?>
<!-- End JS MAP  -->
<?php cache_file('big_js.js', 'assets/libraries/parallax/parallax.js'); ?>

<?php cache_file('big_js.js', 'assets/libraries/bootstrap-3-typeahead/bootstrap3-typeahead.min.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/customd-jquery-number/jquery.number.min.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/h5Validate-master/jquery.h5validate.js'); ?>
<?php cache_file('big_js.js', 'assets/js/jquery.helpers.js'); ?>

<?php cache_file('big_js.js', 'assets/js/moment-with-locales.min.js'); ?>
<?php cache_file('big_js.js', 'assets/js/moment-timezone-with-data.js'); ?>
<?php cache_file('big_js.js', 'assets/js/facebook.js'); ?>

<?php cache_file('big_css.css', 'assets/libraries/owl.carousel/dist/css/owl.carousel.min.css'); ?>
<?php cache_file('big_css.css', 'assets/libraries/owl.carousel/dist/css/owl.theme.default.css'); ?>
<?php cache_file('big_css.css', 'assets/libraries/owl.carousel/dist/css/animate.css'); ?>
<?php cache_file('big_js_critical.js', 'assets/libraries/owl.carousel/dist/owl.carousel.min.js'); ?>

<!-- fileupload -->
<?php cache_file('big_css.css', 'assets/css/jquery.fileupload-ui.css'); ?>
<?php cache_file('big_css.css', 'assets/css/jquery.fileupload-ui-noscript.css'); ?> 

<?php //cache_file('big_js.js', 'assets/js/load-image.js'); ?>
<?php cache_file('big_js.js', 'assets/js/jquery-ui-1.10.3.custom.min.js'); ?>

<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.iframe-transport.js'); ?>
<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.fileupload.js'); ?>
<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.fileupload-fp.js'); ?>
<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.fileupload-ui.js'); ?>
<!-- end fileupload -->

<!-- Start bootstrap-datetimepicker-master -->
<?php cache_file('big_css.css', 'assets/libraries/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js'); ?>
<!-- End bootstrap-datetimepicker-master -->

<!-- magnific-popup -->
<!-- url https://plugins.jquery.com/magnific-popup/ -->
<?php if(config_item('report_property_enabled') == TRUE): ?>
<?php cache_file('big_js.js', 'assets/libraries/magnific-popup/jquery.magnific-popup.js'); ?>
<?php cache_file('big_css.css', 'assets/libraries/magnific-popup/magnific-popup.css'); ?>
<?php endif;?>
<!--end magnific-popup -->

<!-- Start foodtable-jquery -->	
<?php cache_file('big_js.js', 'assets/libraries/footable-jquery/js/footable.js'); ?>
<?php cache_file('big_js.js', 'assets/js/footable_custom.js'); ?>
<!-- End footable-jquery -->

<?php cache_file('big_css.css', 'assets/libraries/footable-jquery/css/footable.bootstrap.min.css'); ?>
<?php cache_file('big_css.css', 'assets/css/custom.css'); ?>
<?php cache_file('big_css.css', 'assets/css/custom_media.css'); ?>
<?php cache_file('big_js.js', 'assets/js/custom.js'); ?>
<!-- End custom styles  -->
<?php cache_file('big_js_critical.js', 'assets/js/modernizr.custom.js'); ?>

<!-- Start palette -->
<?php cache_file('big_css.css', 'assets/css/palette.css'); ?>
<?php cache_file('big_js.js', 'assets/js/palette.js'); ?>
<!-- End palette -->

<!-- Start nouislider -->
<?php cache_file('big_css.css', 'assets/libraries/nouislider/nouislider.min.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/nouislider/nouislider.min.js'); ?>
<!-- End nouislider -->

<!-- Start masonry -->
<?php cache_file('big_js.js', 'assets/libraries/masonry/dist/masonry.pkgd.min.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/masonry/dist/imagesloaded.pkgd.min.js'); ?>
<!-- End masonry -->

<?php cache_file('big_css.css', NULL); ?>
<?php cache_file('big_js_critical.js', NULL); ?>

{is_rtl}
<link href="assets/css/styles_rtl.css" rel="stylesheet">
{/is_rtl}

<style>
.thumbnail .thumbnail-image .purpose-badget.<?php $a=strtolower(lang_check('Sale')); echo str_replace(' ', '_', $a);?> {
    background: #f69505;
}
.thumbnail .thumbnail-image .purpose-badget.<?php $a=strtolower(lang_check('Sale and Rent')); echo str_replace(' ', '_', $a);?> {
    background: #686868;
}
</style>
<?php
/*
 *  Start Custom style`s (palette)
 * 
 */
if(isset($settings_color) and !empty($settings_color)):
   $settings_color = json_decode($settings_color); 
?>

        <style id="custom_scheme">
            
        <?php if(isset($settings_color->primary_color) and !empty($settings_color->primary_color)):?>

            .btn-custom-secondary, .owl-dots-local .owl-theme .owl-dots .owl-dot:hover span,
                    .affix-menu.affix.top-bar .default-menu .dropdown-menu>li.dropdown-submenu:hover > a, .affix-menu.affix.top-bar .default-menu .dropdown-menu>li>a:hover,
                    .c_purpose-tablet li.active, .c_purpose-tablet li:hover,.infobox-big .title,
                    .cluster div:after,
                    .google_marker:before,
                    .owl-carousel-items.owl-theme .owl-dots .owl-dot.active span,
                    .owl-carousel-items.owl-theme .owl-dots .owl-dot:hover span,
                    .hidden-subtitle,
                    .btn-marker:hover .box,
                    .affix-menu.affix.top-bar .default-menu .dropdown-menu>li>a:hover, .affix-menu.affix.top-bar .default-menu .dropdown-menu>li.active>a, .affix-menu.affix.top-bar .default-menu .dropdown-menu>li.dropdown.dropdown-submenu:hover > a,
                    .owl-nav-local  .owl-theme .owl-nav [class*="owl-"]:hover,
                    .color-mask:after,
                    .owl-dots-local .owl-theme .owl-dots .owl-dot.active span {
                    background-color: <?php _che($settings_color->primary_color);?>;
                 }
            
            @media (min-width: 768px){.top-bar.t-overflow:not(.affix) .default-menu .dropdown-menu>li>a:hover{
                    color: <?php _che($settings_color->primary_color);?> !important;
                 }}
            
            .pagination>li a:hover, .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover,
                .custom_infowindow .gm-style-iw + div,.infoBox > img, 
                .infobox-big, 
                .infobox:before,
                .infobox-big:before,
                .infobox {
                border-color: <?php _che($settings_color->primary_color);?> !important;
             }

            [class*="icon-star-ratings"]:after {
                color: <?php _che($settings_color->primary_color);?> !important;
             }

            .text-color-primary, .primary-text-color, .primary-link:hover,.caption .date i,
            .caption .date i,
            .invoice-intro.invoice-logo a,
            .commten-box .title a:hover,
            .commten-box .action a:hover,
            .author-card .name_surname a:hover,
            p.note:before,
            .location-box .location-box-content .title a:hover,
            .list-navigation li.return a,
            .filters .picker .pc-select .pc-list li:hover,
            .mark-c,
            .pagination>li a:hover, .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover,
            .infobox .content .title a:hover,
            .thumbnail.thumbnail-type .caption .title a:hover,
            .thumbnail.thumbnail-video .thumbnail-title a:hover,
            .card.card-category:hover .badget.b-icon i,
            .btn-marker:hover .title,
            .btn-marker .box,
            .thumbnail.thumbnail-property .thumbnail-title a:hover,
            .rating-action,
            .bootstrap-select  .dropdown-menu > li > a:hover .glyphicon,
            .grid-tile a:hover .title,
            .grid-tile .preview i,
            .lang-manu:hover .caret,  
            .lang-manu .dropdown-menu > li > a:hover,  
            .lang-manu.open .caret,  
            .top-bar .nav-items li.open>a >span, .top-bar .nav-items li> a:hover >span,
            .top-bar.t-overflow:not(.affix) .default-menu .dropdown-menu > li.active > a, .top-bar.t-overflow:not(.affix) .default-menu .dropdown-menu > li.active > a,
            .top-bar.t-overflow:not(.affix) .default-menu .dropdown-menu>li.active>a:hover,
            .top-bar.t-overflow:not(.affix) .default-menu .dropdown-menu>li>a:hover,
            body:not(.navigation-open) .top-bar.t-overflow:not(.affix) .default-menu .dropdown-menu > li.dropdown.dropdown-submenu.open > a, body:not(.navigation-open) .top-bar.t-overflow:not(.affix) .default-menu .dropdown-menu > li.dropdown.dropdown-submenu:hover > a,
            .scale-range .nonlinear-val,.top-bar .logo a, 
            .default-menu .dropdown-menu>li.active>a, .default-menu .dropdown-menu>li>a:hover {
                color: <?php _che($settings_color->primary_color);?>;
            }

            #main-map-color .cluster div, .google_marker {
                border-color: <?php _che($settings_color->primary_color);?>;
            }[class*="icon-star-ratings"]:after{
                color: <?php _che($settings_color->primary_color);?> !important;
             }
             

            .primary-color {
                background-color: <?php _che($settings_color->primary_color);?>;
            }
<?php endif;?> 
                <?php if(isset($settings_color->secondary_color) and !empty($settings_color->secondary_color)):?>
            .color-secondary {
                background: <?php _che($settings_color->secondary_color);?> !important;
            }
            
            .btn-custom-primary {
                background: <?php _che($settings_color->secondary_color);?>;
            }
            
            .border-color-secondary {
                border-color: <?php _che($settings_color->secondary_color);?> !important;
            }
            
            .top-bar .nav-items > li> a.btn.btn-custom-primary,
            .btn-custom-primary {
                border-color: <?php _che($settings_color->secondary_color);?>;
            }
            
            .text-color-secondary
            {
                color: <?php _che($settings_color->secondary_color);?> !important;
            }
                
                
                <?php endif;?> 
                <?php if(isset($settings_color->color_titles) and !empty($settings_color->color_titles)):?>
            .post-comments .post-comments-title,.reply-box .reply-title,.post-header .post-title .title,.widget-listing-title .options .options-body .title,
                .widget-styles .caption-title h2, .widget-styles .caption-title, .widget .widget-title, .widget-styles .header h2, .widget-styles .header,
                .header .title-location .location,.user-card .body .name,.section-title .title {
                    color: <?php _che($settings_color->color_titles);?>;
                 }
                 <?php endif;?> 
                <?php if(isset($settings_color->color_subtitles) and !empty($settings_color->color_subtitles)):?>
            .thumbnail.thumbnail-video .type,.caption .date,.thumbnail.thumbnail-property-list .header .right .address,.thumbnail.thumbnail-property .type,
                .post-header .post-title .subtitle,.header .title-location .count,.section-title .subtitle {
                    color: <?php _che($settings_color->color_subtitles);?>;
                 }
                 <?php endif;?> 
                <?php if(isset($settings_color->color_titles_primary) and !empty($settings_color->color_titles_primary)):?>
            .post-social .hash-tags a,.user-card .body .contact .link,.thumbnail.thumbnail-property .thumbnail-title a {
                    color: <?php _che($settings_color->color_titles_primary);?>;
                 }
                 <?php endif;?> 
                <?php if(isset($settings_color->color_titles_secondary) and !empty($settings_color->color_titles_secondary)):?>
            .caption.caption-blog .thumbnail-title a,.list-category-item .title, .list-category-item .title a,.grid-tile .title,.btn-marker .title,.commten-box .title a,
                .thumbnail.thumbnail-type .caption .title, .thumbnail.thumbnail-type .caption .title a, .author-card .name_surname a {
                    color: <?php _che($settings_color->color_titles_secondary);?>;
                 }
                 <?php endif;?> 
                <?php if(isset($settings_color->color_content) and !empty($settings_color->color_content)):?>
            .thumbnail .caption,.thumbnail.thumbnail-type .caption .description,.author-card .author-body, 
                body,.author-card .author-body,.post-body,.thumbnail.thumbnail-type .caption .description {
                    color: <?php _che($settings_color->color_content);?>;
                 }
                 <?php endif;?> 
                <?php if(isset($settings_color->color_primary_btnhover) and !empty($settings_color->color_primary_btnhover)):?>
            .btn-custom-secondary:hover {
                    background: <?php _che($settings_color->color_primary_btnhover);?>;
                 }
                 <?php endif;?> 
                <?php if(isset($settings_color->color_primary_btn) and !empty($settings_color->color_primary_btn)):?>
            .btn-custom-secondary {
                    background: <?php _che($settings_color->color_primary_btn);?>;
                 }
                <?php endif;?> 
                <?php if(isset($settings_color->font_family) and !empty($settings_color->font_family)):?>
            body {
                    font-family: "<?php _che($settings_color->font_family);?>";
                 }
                 <?php endif;?>   
    <?php if(isset($settings_color->font_size) and !empty($settings_color->font_size)):?>
            .owl-slider-content .item .title  {
                font-size: <?php echo (40+$settings_color->font_size);?>px;
             }  .widget-geomap .geomap-title,.h-area .title  {
                 font-size: <?php echo (36+$settings_color->font_size);?>px;
             }  .widget-listing-title .options .options-body .title,.section-title .title  {
                 font-size: <?php echo (32+$settings_color->font_size);?>px;
             }  .footer .logo a,.top-bar .logo a  {
                 font-size: <?php echo (30+$settings_color->font_size);?>px;
             }  .h3, h3 {
                 font-size: <?php echo (24+$settings_color->font_size);?>px;
             }  .section-profile-box .content .title,.section.widget-recentproperties .header .title-location .location,.section-title.slim .title,.caption.caption-blog .thumbnail-title a {
                 font-size: <?php echo (20+$settings_color->font_size);?>px;
             }  .agent-box .title a, .thumbnail.thumbnail-offers .thumbnail-title a, .card.card-pricing .title, .list-category-item .title, .list-category-item .title a, .thumbnail.thumbnail-type .caption .title, .thumbnail.thumbnail-type .caption .title a, .owl-slider-content .item .subtitle, .thumbnail.thumbnail-property .thumbnail-title a, .thumbnail.thumbnail-type .caption .title, .thumbnail.thumbnail-type .caption .title a, .owl-slider-content .item .subtitle, .thumbnail.thumbnail-property .thumbnail-title a,
            .thumbnail.thumbnail-offers .thumbnail-title a, .card.card-pricing .title, .list-category-item .title, .list-category-item .title a,
            .thumbnail.thumbnail-type .caption .title, .thumbnail.thumbnail-type .caption .title a, .owl-slider-content .item .subtitle, .thumbnail.thumbnail-property .thumbnail-title a,
            .thumbnail.thumbnail-type .caption .title, .thumbnail.thumbnail-type .caption .title a, .owl-slider-content .item .subtitle, .thumbnail.thumbnail-property .thumbnail-title a {
                 font-size: <?php echo (18+$settings_color->font_size);?>px;
             }  .section-profile-box .content .options,.grid-tile .title,.h-area .subtitle,.f-box .title,.user-card .body .name,.section-title .subtitle {
                 font-size: <?php echo (16+$settings_color->font_size);?>px;
             }  .btn-custom,.header .title-location .location,.thumbnail.thumbnail-property-list .header .right .address {
                 font-size: <?php echo (15+$settings_color->font_size);?>px;
             }  .list-navigation li,.btn,body,.top-bar .nav-items li  {
                 font-size: <?php echo (14+$settings_color->font_size);?>px;
             }  .card.card-pricing .price-box .notice,.list-suggestions li,.thumbnail.thumbnail-property-list .list-comment p,.thumbnail.thumbnail-type .caption .description,.thumbnail.thumbnail-video .type,
            .section-search-area .tags ul li,.f-box .list-f a,.caption .date,.btn-marker .title,.thumbnail.thumbnail-property .typ {
                 font-size: <?php echo (13+$settings_color->font_size);?>px;
             }
         <?php endif;?>   
            
    
        <?php if(isset($settings_color->background_image) and !empty($settings_color->background_image)):
            $background_image='';
            $pos = strrpos($settings_color->background_image, "assets/img/");
            $background_image = substr($settings_color->background_image, $pos);
        ?>
            .section-parallax,
            body {
                background: url(<?php _che($background_image);?>);
                
                <?php if(isset($settings_color->background_image_style) and $settings_color->background_image_style=='fixed'):?>
                    background-repeat :no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                <?php elseif(isset($settings_color->background_image_style) and $settings_color->background_image_style=='repeat'):?>
                    background-repeat: repeat;
                <?php else:?>
                    background-repeat :no-repeat;
                    background-attachment: fixed;
                <?php endif;?>
            }
        <?php elseif(isset($settings_color->background_color) and !empty($settings_color->background_color)):?>
            body {
                background-color: <?php _che($settings_color->background_color);?>;
            }
        
        <?php endif;?>


        </style>
<?php endif;?>
        
<script>
var location_hash = '';

// to top right away
if ( window.location.hash ) {
    location_hash = window.location.hash;
    window.location.hash ='';
};

</script>
{settings_tracking}