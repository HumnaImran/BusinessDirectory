"use strict";
$(document).on('ready', function () {
    /* placeholder for IE */
    $.support.placeholder = ('placeholder' in document.createElement('input'));
    
    //fix for IE
    if (!$.support.placeholder) {
        $("[placeholder]").on('focus', function () {
            if ($(this).val() === $(this).attr("placeholder"))
                $(this).val("");
        }).on('blur', function () {
            if ($(this).val() === "")
                $(this).val($(this).attr("placeholder"));
        }).on('blur');

        $("[placeholder]").parents("form").on('submit', function () {
            $(this).find('[placeholder]').each(function () {
                if ($(this).val() === $(this).attr("placeholder")) {
                    $(this).val("");
                }
            });
        });
    }
    /* end placeholder for IE */

    $('.selectpicker').selectpicker({
        style: 'selectpicker-primary',
    });
    

    $('.selectpicker-small').selectpicker({
        style: 'selectpicker-primary selectpicker-small',
    });
    
    if(typeof $.fn.picker  === 'function')
        $('.filters .picker').picker(
                {
                    texts: {
                        trigger : "<i class='ion-android-options'></i>More Filters",
                        noResult : "No results",
                        search : "Search"
                    }
                }
        );
    
    
    /* create label-cntrl for employers */
    $('.employers.navigation .cntrl').first().addClass('active');   
    /* END create label-cntrl for slide */  
    $('.reviews-carousel .nav-r-btn.btn-right').on('click', function(e) {
        e.preventDefault();
        var _this = $('.reviews-carousel .review.show');
        _this.animate({opacity:0},{duration:250}).removeClass('show'); 
        if(_this.next().length){
            _this.next().animate({opacity:1},250).addClass('show');  
        } else {
            _this.parent().find('.review').first().animate({opacity:1},250).addClass('show'); 
        }
    })   
    $('.reviews-carousel .nav-r-btn.btn-left').on('click', function(e) {
        e.preventDefault();
        var _this = $('.reviews-carousel .review.show');
        _this.animate({opacity:0},{duration:250}).removeClass('show'); 
        if(_this.prev().length){
            _this.prev().animate({opacity:1},250).addClass('show');  
        } else {
            _this.parent().find('.review').last().animate({opacity:1},250).addClass('show'); 
        }
    })
    if ($('.reviews-results').length) {
        setInterval(function(){
            if (!$('.reviews-results:hover').length) {
                $('.reviews-carousel .nav-r-btn.btn-right').trigger('click')
            }
        }, 15000);
    }
    
    // Find all data-toggle="sticky-onscroll" elements
    $('.affix-menu').each(function () {
        if(!$('.dissable-sticky').length){
            var sticky = $(this);
            var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
            sticky.before(stickyWrapper);
        }
    })
    .affix({
        offset: {
            top: 250
                } 
        })
    .on('affix.bs.affix', function(){
        if(!$('.affix-menu.affix-menu-m21,.affix-menu.overflow').length && !$('.dissable-sticky').length){
            $('.sticky-wrapper').height($('.affix-menu').outerHeight(true));
        }
        // IOS hook
        setTimeout(function(){$('.affix-menu').css('border-top-color','red');},100);
        
    })
    .on('affixed-top.bs.affix', function(){ 
        $('.sticky-wrapper').height('auto');
        // IOS hook
        setTimeout(function(){$('.affix-menu').css('border-top-color','white');},100);
    });
    
    $('#navigation-toogle,.navbar-toggle, .navigation-wrapper .button-close').on('click', function(e){ e.preventDefault(); $('body').toggleClass('navigation-open')})
    
    /* Start carusel */
    var owl = $("#owl-slider");
    if (owl && owl.length) {
        owl.owlCarousel({
            nav: true,
            loop: true,
            singleItem: true,
            autoplay: true,
            animateOut: 'fadeOut',
            items:1,
        });
    }
    
    var owl = $("#owl-slider-fullh");
    if (owl && owl.length) {
        owl.owlCarousel({
            nav: true,
            loop: true,
            singleItem: true,
            //autoplay: true,
            animateOut: 'slideOutDown',
            animateIn: 'fadeIn',
            items:1,
        });
    }

    $('#owl-video').owlCarousel({
        items:1,
        merge:true,
        loop:true,
        margin:15,
        video:true,
        lazyLoad:true,
        center:true,
        responsive:{
            767:{
                items:1
            },
            768:{
                items:3
            }
        }
    })
    
    var owl2 = $("#owl-carousel-items");
    if (owl2 && owl2.length) {
        owl2.owlCarousel({
            nav: true,
            loop:true,
            dots: false,
            responsive:{
                0:{
                    items:1
                },
                768:{
                    items:2
                },
                1200:{
                    items:3
                }
            },
        });
    }
    /* End carusel */
    
    /* Start menu dropdown */
    $('ul.nav li.dropdown .dropdown-submenu a').on({
            /*'mouseover': function () {
                if ($(window).outerWidth() > 768)
                    $(this).closest('.dropdown-submenu').addClass('open').stop(true, true).delay(100).fadeIn(120);
            },
            'mouseout' : function () {
                if ($(window).outerWidth() > 768)
                    $(this).closest('.dropdown-submenu').removeClass('open').find('.dropdown-menu').stop(true, true).delay(50).fadeOut(50);
            }*/
            
        }
    );
    
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().removeClass('open');
        $(this).parent().toggleClass('open');
    });

    /* End menu dropdown */
    /* start image cover ( use class object-fit-container  as div.object-fit-container > img) */
    object_cover();
    /* end image cover */
    
        /* Start Image gallery 
     *    use css/blueimp-gallery.min.css
     *    use js/blueimp-gallery.min.js
     *    use config assets/js/realsite.js
     *    Site https://github.com/blueimp/Gallery/blob/master/README.md#setup
     *   
     *
     */
    $('body').append('<div id="blueimp-gallery" class="blueimp-gallery">\n\
                        <div class="slides"></div>\n\
                        <h3 class="title"></h3>\n\
                        <a class="prev">&lsaquo;</a>\n\
                        <a class="next">&rsaquo;</a>\n\
                        <a class="close">&times;</a>\n\
                        <a class="play-pause"></a>\n\
                        <ol class="indicator"></ol>\n\
                        </div>')
    $(document).on('click', '.images-gallery .card-gallery:not(.type-file) a', function (e) {
        e.preventDefault();
        var myLinks = new Array();
        var current = $(this).attr('href');
        var curIndex = 0;

        $('.images-gallery .card-gallery:not(.type-file) a').each(function (i) {
            var img_href = $(this).attr('href');
            myLinks[i] = img_href;
            if (current === img_href)
                curIndex = i;
        });

        var options = {index: curIndex}

        blueimp.Gallery(myLinks, options);

        return false;
    });
    
    $(document).on('click', '.listing-gallery .content a', function (e) {
        e.preventDefault();
        var myLinks = new Array();
        var current = $(this).attr('href');
        var curIndex = 0;

        $('.listing-gallery .content a').each(function (i) {
            var img_href = $(this).attr('href');
            myLinks[i] = img_href;
            if (current === img_href)
                curIndex = i;
        });

        var options = {index: curIndex}

        blueimp.Gallery(myLinks, options);

        return false;
    });
    /* End Image gallery */
    
    //click on button, that scrolls page
    $('.scroll-button').on('click', function(){
        $('body, html').animate({'scrollTop':$('.scroll-box').outerHeight(true)});
        return false;
    });
    
    /* load extern scripts */
    if($('#main-map').length && typeof LoadMap_main === 'function'){
        LoadMap_main();
    }    
        
    /* load extern scripts */
    if($('#main-map-template').length && typeof LoadMap_main_default === 'function'){
        LoadMap_main_default();
    }    
    /* load extern scripts */
    if($('#main-map-mini').length && typeof LoadMap_main_mini === 'function'){
        LoadMap_main_mini();
    }    
    
    if($('#property-map').length && typeof map_property === 'function'){
        map_property();
    }
    
    if($('#map_bg').length && typeof map_e === 'function'){
        map_e();
    }
    
    if(typeof codemirror_init === 'function'){
        codemirror_init();
    }
    
    if(typeof custom_template_style === 'function'){
        custom_template_style();
    }
    
    if(typeof footable_init === 'function'){
        footable_init();
    }
    
    if($('#mapsAddress').length && typeof mapEdit === 'function'){
        mapEdit();
    }
    
    /* rtl version */
    
    if(typeof getParameterByName === 'function'){
        if(getParameterByName('test') && getParameterByName('test') === 'rtl') {
            
            $('a').not('[data-toggle="collapse"]').each(function(i) {
                var href = $(this).attr('href');
                if(href && href!=='#' && href !== '#carousel-example-generic')
                $(this).attr('href', href+'?test=rtl');
            })
            
            $('.lang-manu a,.lang-menu-mobile a').not('.rtl').each(function(i) {
                var href = window.location.href;
                href = href.replace( /\?test=rtl/i, "" );;
                
                $(this).attr('href', href);
            })
            
            $('.lang-manu span').first().html('AR');
            $('head').append('<link rel="stylesheet" id="style_rtl" href="assets/css/styles_rtl.css" onload="$(window).trigger(\'resize\')"/>');
            $('body').addClass('rtl');
        }
    }
    
    /* end rtl version */
    
    var geomap = $('#geo-map');
    if (geomap && geomap.length) {
        geomap.geo_map();
        
        /*
        geomap.geo_map('set_config',{
               'color_hover': '#000',
               'color_active': '#000',
               'color_default': '#000',
               'color_border': '#000',
           })*/
        
        geomap.geo_map('generate_map','usa')
        geomap.on('clickArea.geo_map', function (event) {
            $('#location_geo').val(event.location);
        })

        if($('#location-select').length) {
           $('#location-select').on('change',function(){
               geomap.geo_map('generate_map',$(this).val())
           }) 
        }
    }
    /*
    var search_types_tags = $('#search_types');
    var search_types_input = $('#search_types_option');
    
    if(search_types_input && search_types_tags && search_types_tags.length && search_types_input.length) {
        
        search_types_tags.find('a').on('click', function(e){
            e.preventDefault();
            
            var type = $(this).attr('data-type');
            if(type){
                search_types_input.val(type);
                search_types_input.selectpicker('refresh')
            }
        })
    }
    */
   /*
    $("#add_to_favorites, .add_to_favorites").click(function(e){
        e.preventDefault();
        ShowStatus.show("Favorite Saved");
        return false;
    });
    
    $("#submit_review").click(function(e){
        e.preventDefault();
        ShowStatus.show("Thanks on review!");
        return false;
    });
    */
    /* ratings */
    
    $('.rating-action i').on({
            'mouseover': function (e) {
                $(this) .prevAll().addClass('fa-star')
                        .removeClass('fa-star-o');
                
                $(this) .addClass('fa-star')
                        .removeClass('fa-star-o')
                        .nextAll()
                        .addClass('fa-star-o')
                        .removeClass('fa-star');
            },
            'click': function() {
                $(this) .prevAll().addClass('fa-star')
                        .removeClass('fa-star-o');
                
                $(this) .addClass('fa-star')
                        .removeClass('fa-star-o')
                        .nextAll()
                        .addClass('fa-star-o')
                        .removeClass('fa-star');
            }
        })
        
    var fullscreen_md = $('.fullscreen-top-md');    
    if(fullscreen_md && fullscreen_md.length) {
        var fullscreen_map_md= $('.fullscreen-map-md');
        var map= fullscreen_map_md.find('.map');
        var fullscreen_inner_md= $('.fullscreen-inner-md');
       
            var h = fullscreen_md.outerHeight();
            fullscreen_md.removeClass("affix-menu")
            $(window).off('.affix');
            fullscreen_md
                .removeClass("affix affix-top affix-bottom")
                .removeData("bs.affix");
        
                             map.css("height", 'calc(100vh - '+ h +'px')
                                .css("left", fullscreen_map_md.offset().left+'px')
                                .css("width", fullscreen_map_md.outerWidth() +'px')
                                .css("top", h +'px');
                     
            fullscreen_inner_md.css("padding-top", h +'px');
            $(window).on('resize', function(){
                var h = fullscreen_md.outerHeight();
                map.css("height", 'calc(100vh - '+ h +'px')
                                .css("left", fullscreen_map_md.offset().left+'px')
                                .css("width", fullscreen_map_md.outerWidth() +'px')
                                .css("top", h +'px');
                        
                fullscreen_inner_md.css("padding-top", h +'px');
            })
    }
    
    $('[data-image-src]:not([data-parallax="scroll"])').each(function(){
        if($(this).data('image-src')) {
            $(this).css({
                        'background':'url("'+$(this).data('image-src')+'") no-repeat',
                        'background-size':'cover'
                        });
        }
        
        
    })
        
    if(typeof palette_init === 'function'){
        palette_init();
    }
    
    if($('.locationautocomplete').length){
        $('.locationautocomplete').each(function(){
            if(typeof google !== 'undefined')
                var autocomplete = new google.maps.places.Autocomplete($(this)[0]);
        })
        
        $('.locationautocomplete').parent().find('i').click(function(){
            // Try HTML5 geolocation
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    
                if(typeof google !== 'undefined'){
                    var latlng = new google.maps.LatLng(position.coords.latitude,
                                                     position.coords.longitude);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': latlng}, function(results, status)
                    {
                          if (status == google.maps.GeocoderStatus.OK)
                          {
                              var address = results[0].formatted_address;
                              $('.locationautocomplete').val(address);
                    }
                    });
                } else {
                    $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+position.coords.latitude+'&lon='+position.coords.longitude, function(data){
                        if(typeof data.address) {
                            if(typeof data.address.city)
                                $('.locationautocomplete').val(data.address.city);
                            else if(typeof data.address.state)
                                $('.locationautocomplete').val(data.address.state);
                        } else {
                            ShowStatus.show("Address not found");
                            return;
                        }
                    });
                }
                
              }, function() {
                // Not has permission
              });
            } else {
              // Browser doesn't support Geolocation

            }
        })
    }
    
    if($('.section-top-destinations .btn-more-locations').length){
        $('.btn-more-locations').click(function(e){
            e.preventDefault();
            var box = $(this).parent().parent().find('.other-locations');
            var top_pos = box.parent().parent().offset().top
            if(box.is(':visible')) {
                $('.toogle', this).removeClass('hidden');
                $('.toogled', this).addClass('hidden');
                $('html, body').animate({
                    scrollTop: (top_pos-120) + 'px'
                }, 500, 'swing');
            } else {
                $('.toogle', this).addClass('hidden');
                $('.toogled', this).removeClass('hidden');
            }
            box.slideToggle(500);
        }) 
    }
    
        
    if ($('#nonlinear-radius').length){
        
        var conf_min = '0';
        var conf_max = '200';
        var conf_sufix= '';
        var conf_prefix= '';
        var conf_infinity = '';
        var conf_predifinedValue = 25;
        
        if($('#nonlinear-radius').find('.config-range').length ) {
            var $config = $('#nonlinear-radius').find('.config-range');
            conf_min = $config.attr('data-min') || 0;
            conf_max = $config.attr('data-max') || 200;
            conf_sufix= $config.attr('data-sufix') || '';
            conf_prefix= $config.attr('data-prefix') || '';
            conf_infinity = $config.attr('data-infinity') || "false";
            conf_predifinedValue = $config.attr('data-predifinedValue') || 25;
        }
        scale_range_single('#nonlinear-radius',conf_min,conf_max,conf_prefix,conf_sufix,conf_infinity,conf_predifinedValue);
    }
    
})

function getParameterByName(name, url) {
    if (typeof url === 'undefined')
        url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

/* only for demo */
/*
$(window).on('load', function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");
});
*/
function object_cover() {
     if (!Modernizr.prefixed('objectFit')) {
        $('.image-cover, .thumbnail.thumbnail-property-list .thumbnail-image a img').each(function () {
            if($(this).hasClass('compat-object-fit')) return;
            var $container = $(this);
            $(this).addClass('object-fit-container');
            var imgUrl = $container.find('img').prop('src');
            if (imgUrl) {
                $container
                        .css('background-image', 'url("' + imgUrl + '")')
                        .addClass('compat-object-fit');
            }
        });
    }
    
    if (true) {
        $('.owl-slider .item, .image-cover-div, .card-gallery a,.card.card-category a').each(function () {
            if($(this).find('.object-fit-imagediv').length) return;
            var $container = $(this);
            $(this).addClass('object-fit-container');
            var imgUrl = $container.find('img').prop('src');
            if (imgUrl) {
                $container.addClass('compat-object-fit')
                        .prepend('<div class="object-fit-imagediv"></div>').find('.object-fit-imagediv')
                        .css('background-image', 'url("' + imgUrl + '")');
            }
        });
    }
    
    if (true) {
        $('img.bg-parralax').each(function () {
            if($(this).find('.object-fit-imagediv').length) return;
            var $container = $(this).parent();
            $(this).addClass('object-fit-container');
            var imgUrl = $(this).prop('src');
            if (imgUrl) {
                $container.addClass('compat-object-fit')
                        .prepend('<div class="object-fit-imagediv"></div>').find('.object-fit-imagediv')
                        .css('background-image', 'url("' + imgUrl + '")');
            }
        });
    }
}


 /*
 * Scale range
 * @param {type} object selector for scale-range box
 * @param {type} min min value
 * @param {type} max max value
 * @param {type} prefix
 * @param {type} sufix
 * @param {type} infinity, is infinity
 * @param {type} predifinedMin value
 * @param {type} predifinedMax value
 * @returns {Boolean}
 * 
 * 
 * Example html :
    <div class="scale-range" id="nonlinear-price">
        <label>Price</label>
        <div class="nonlinear"></div>
        <div class="scale-range-value">
            <span class="nonlinear-min"></span>
            <span class="nonlinear-max"></span>
        </div>
        <input id="from" type="text" class="value-min hidden" placeholder="" value="" />
        <input id="to" type="text" class="value-max hidden" placeholder="" value="" />
    </div>
* Example js :                                                                                                                                                                                                                           
     scale_range('#nonlinear-price',0, 500000, '$', 'k', true, '','');
*/

function scale_range_single(object, min, max, prefix, sufix, infinity, predifinedValue) {
    if (typeof object == 'undefined')
        return false;
    if (typeof min == 'undefined' || min=='')
        var min = 0;
    if (typeof max == 'undefined' || max=='')
        return false;
    if (typeof prefix == 'undefined' || prefix=='')
        var prefix = '';
    if (typeof sufix == 'undefined' || sufix=='')
        var sufix = '';
    if (typeof infinity === 'infinity' || infinity=='')
        var infinity = true;
    if(infinity == "false") infinity = false;
    
    var $ = jQuery;
    if (typeof predifinedValue == 'undefined' || predifinedValue ==''){
        var predifinedValue = min || 0;
        predifinedValue-=10;
    }
    
    /* errors */
    
    if(!$(object + ' .value').length) {
        console.log('Scale range: missing input');
        return false;
    }
    
    var r = 0;
    if(infinity) {
        r = 10;
    }
    
    if ($(object + ' .nonlinear').length) { 
        var nonLinearSlider = document.querySelector(object + ' .nonlinear');
        noUiSlider.create(nonLinearSlider, {
            start: [predifinedValue],
            step: 25,
            range: {
                'min': [parseInt(min)-r],
                'max': [parseInt(max)+r]
            }
        });
        

        var nodes = [
            document.querySelector(object + ' .nonlinear-val'), // 0
        ];
        
        var inputs = [
            document.querySelector(object + ' .value'), // 0
        ];

        // Display the slider value and how far the handle moved
        nonLinearSlider.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            if(parseInt(values[handle]) > max && infinity){
                nodes[handle].innerHTML = prefix + parseInt(max).toFixed() + sufix+'+';
                inputs[handle].value = '';
            }
            else if(parseInt(values[handle]) < min && infinity){
                nodes[handle].innerHTML = prefix + parseInt(min).toFixed() + sufix+'-';
                inputs[handle].value = '';
            }
            else {
                nodes[handle].innerHTML = prefix + parseInt(values[handle]).toFixed() + sufix;
                inputs[handle].value = parseInt(values[handle]).toFixed();
            }
            
            $(object + ' .value').trigger('change')
        });
    }
    
}
