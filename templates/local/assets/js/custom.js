"use strict";

function custom_template_style(){
    var boxed = false; // true to boxed version, false = deafault
    var hide_palette = false; // true to hide Customizer, false show
    var colorTopBar = false ; // true if color top bar
    if(boxed) {
        $('.custom-palette-box input[name="type-site"][value="boxed"]').attr('checked','checked');
        $('body').addClass('boxed');
    }
    
    if(colorTopBar) {
        $('.top-bar').removeClass('t-overflow')
                                   .removeClass('overflow')
                                   .addClass('top-bar-white')
                                   .addClass('top-bar-color');
        $('#color-top-bar-bg').closest('.custom-palette-color').removeClass('hidden')
    }

    if(hide_palette) {
        $('.custom-palette').css('cssText', 'display: none !important;');
    }

}

$(document).ready(function(){
        
    var search_types_tags = $('#search_types');
    var search_types_input = $('.search_types_input');
    
    if(search_types_input && search_types_tags && search_types_tags.length && search_types_input.length) {
        
        search_types_tags.find('a').on('click', function(e){
            e.preventDefault();
            if(!$(this).hasClass('active')){
                var type = $(this).attr('data-type');
                if(type){
                    search_types_input.val(type);
                    search_types_input.selectpicker('refresh')
                }
                search_types_tags.find('a').removeClass('active')
                $(this).addClass('active')
            } else {
                search_types_input.val('');
                search_types_input.selectpicker('refresh')
                search_types_tags.find('a').removeClass('active')
            }
        })
        
        search_types_input.on('change', function(e){
            e.preventDefault();
            var type = $(this).val();
            search_types_tags.find('a').removeClass('active')
            search_types_tags.find('a[data-type="'+type+'"]').addClass('active')
        })
    }
        
    /* top_search-cityguide.php */
        
    var wtl_search_types_tags = $('.widget-title-location .wtl-tree-subs');
    var wtl_search_types_input = $('.wtl_search_types_input');
    
    if(wtl_search_types_input && wtl_search_types_tags && wtl_search_types_tags.length && wtl_search_types_input.length) {
        
        wtl_search_types_tags.find('a').on('click', function(e){
            $('#search-start').find('.fa-ajax-indicator').removeClass('hidden');
            e.preventDefault();
            if(!$(this).hasClass('active')){
                var type = $(this).attr('data-type');
                if(type){
                    wtl_search_types_input.val(type);
                    wtl_search_types_input.selectpicker('refresh')
                }
                wtl_search_types_tags.find('a').removeClass('active')
                $(this).addClass('active')
            } else {
                wtl_search_types_input.val('');
                wtl_search_types_input.selectpicker('refresh')
                wtl_search_types_tags.find('a').removeClass('active')
            }
            manualSearch(0, false);
            $('#search-start').find('.fa-ajax-indicator').addClass('hidden');
        })
        
        wtl_search_types_input.on('change', function(e){
            e.preventDefault();
            var type = $(this).val();
            wtl_search_types_tags.find('a').removeClass('active')
            wtl_search_types_tags.find('a[data-type="'+type+'"]').addClass('active')
        })
    }
        
    var wtlvisual_search_types_tags = $('.widget-title-location .wtl-tree-subs');
    var wtlvisual_search_types_input = $('.wtl_search_types_input_tree[name="option79_1_level_0"]') || $('#sinputOption_1_79_level_0');
    
    if(wtlvisual_search_types_input && wtlvisual_search_types_tags && wtlvisual_search_types_tags.length && wtlvisual_search_types_input.length) {
        
        wtlvisual_search_types_tags.find('a').on('click', function(e){
            $('#search-start').find('.fa-ajax-indicator').removeClass('hidden');
            e.preventDefault();
            if(!$(this).hasClass('active')){
                var type = $(this).attr('data-type');
                if(type){
                    wtlvisual_search_types_input.val(type);
                    wtlvisual_search_types_input.selectpicker('refresh')
                }
                wtlvisual_search_types_tags.find('a').removeClass('active')
                $(this).addClass('active')
            } else {
                wtlvisual_search_types_input.val('');
                wtlvisual_search_types_input.selectpicker('refresh')
                wtlvisual_search_types_tags.find('a').removeClass('active')
            }
            manualSearch(0, false);
            $('#search-start').find('.fa-ajax-indicator').addClass('hidden');
        })
        
        
        wtlvisual_search_types_input.on('change', function(e){
            e.preventDefault();
            var that = $(this);
            setTimeout(function(){
                if(that.closest('.tree').find('.sel_class').length){
                    var type = that.val();
                    console.log(type);
                    wtlvisual_search_types_tags.find('a').removeClass('active')
                    wtlvisual_search_types_tags.find('a[data-type="'+type+'"]').addClass('active')
                }
            },500);
        })
    }
    
    $('#location_modal').on('hidden.bs.modal', function () {
        $('#search-start').find('.fa-ajax-indicator').addClass('hidden');
    })
    
    /* anchor */
    
    $('a[href^="#"]').bind('click',function(e){
        e.preventDefault();
        var hash = $(this).attr('href');
        if(hash.length > 1  && $(hash).length && !$(this).hasClass('no-swing')){
            $('html, body').animate({
                scrollTop: ($(hash).offset().top-100) + 'px'
            }, 800, 'swing');
        }
    });
    
    
    /* anchor */
    
})

function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}


function support_history_api()
{
    return !!(window.history && history.pushState);
}

/* End Image gallery script. Big Image */ 

function custom_number_format(val)
{
    return val.toFixed(2);
}

function map_e() {

    var map;
    if ($('#map_bg').length) {
        var myLocationEnabled = true;
        var style_map = null;
        var scrollwheelEnabled = false;

        var position = $('#map_bg').attr('data-location') || '45.812231, 15.920618';
        var latlng = position.split(',');
        
        var markers = new Array();
        if(typeof google !== 'undefined'){
            var mapOptions = {
                center: new google.maps.LatLng(parseFloat(latlng[0]), parseFloat(latlng[1])),
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: scrollwheelEnabled,
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: false
                //styles:style_map
            };

            var map = new google.maps.Map(document.getElementById('map_bg'), mapOptions);

            var input = document.getElementById('location');
            var autocomplete = new google.maps.places.Autocomplete(input,{types: ['(cities)']});


            autocomplete.addListener('place_changed', function() {
              var place = autocomplete.getPlace();


              if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
              } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); 
              }
            });
        } else if(typeof L !== 'undefined'){
                position = position.split(',');
                var map = L.map('map_bg', {
                    center: new L.LatLng(position[0], position[1]),
                    zoom: 11,
                });     
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
        }
    }

}

function encodeHTML(s) {
    return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
}

function cleanerHTML(s) {
    return s.replace(/&/g, '').replace(/</g, '').replace(/"/g, '');
}

// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

function array_move(arr, old_index, new_index) {
    if (new_index >= arr.length) {
        var k = new_index - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    return arr; // for testing
};