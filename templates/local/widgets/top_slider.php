 <?php
/*
Widget-title: Slider
Widget-preview-image: /assets/img/widgets_preview/top_slider.jpg
 */
?>

<div class="widget-slider-owl owl-dots-local owl-nav-local container container-palette widget_edit_enabled">
    <div id="owl-slider" class="owl-slider owl-slider-content owl-carousel owl-theme">
        <?php $anim = 1; ?>
        <?php foreach($slideshow_images as $key=>$file): ?>
        <?php if($anim>5) $anim = 1; ?>
        <div class="item">
            <img src="<?php echo _simg($file['url'], '1800x600'); ?>" alt="<?php echo basename($file['url']);?>" />
            <div class="caption anim-<?php echo $anim;?>">
                <div class="container">
                    
                    <?php if(config_item('property_slider_enabled')===TRUE&&!empty($file['property_details'])):?>
                    <h2 class="title"><?php _che($file['property_details']['title']);?></h2>
                            <span class="subtitle">
                                <?php if(!empty($file['property_details']['option_chlimit_8'])):?>
                                    <?php _che($file['property_details']['option_chlimit_8']);?>
                                <?php endif;?>

                                <a href="<?php _che($file['property_details']['link']);?>" class="link"><span><?php echo _l('Click to show');?></span></a>
                            </span>
                    <?php elseif(!empty($file['title'])): ?>
                            <h2 class="title"><?php _che($file['title']);?></h2>
                            <span class="subtitle">
                            <?php if(!empty($file['description'])):?>
                                <?php _che($file['description']);?>
                                <?php if(!empty($file['link'])):?>
                                    <a href="<?php _che($file['link']);?>" class="link"><span><?php echo _l('Click to show');?></span></a>
                                <?php endif; ?>
                            <?php endif; ?>
                            </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php $anim++; endforeach;?>
    </div>  
</div>
