<?php if(sw_count($slideshow_property_images) > 2):?>
<div class="widget container container-palette listing-gallery widget_edit_enabled">
    <div class="container">
        <div class="content">
            <div class="row-s owl-carousel owl-theme">
                
            <?php foreach($slideshow_property_images as $file): ?>
                <div class="item"><a href="<?php _che($file['url']);?>" class="image-cover-div"><img src="<?php echo _simg($file['url'], '800x450', true);?>" alt="<?php echo _ch($file['alt'], '');?>" /></a></div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>  
<script>
$('.owl-carousel').owlCarousel({
    loop:false,
    margin:10,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        768:{
            items:2
        },
        1000:{
            items:3
        }
    }
})
</script>
<?php else :?>
<div class="widget container container-palette listing-gallery widget_edit_enabled">
    <div class="container">
        <div class="content">
            <div class="row-s row-flex center">
            <?php foreach($slideshow_property_images as $file): ?>
                <div class="col-sm-4"><a href="<?php _che($file['url']);?>" class="image-cover-div"><img src="<?php echo _simg($file['url'], '800x450', true);?>" alt="<?php echo _ch($file['alt'], '');?>" /></a></div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>  
<?php endif; ?>
