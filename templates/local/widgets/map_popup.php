<!--

Widget-preview-category-path: <?php _che($option_79); ?>

-->


<div class="infobox-big infobox-default infobox_ini">
<div class="title"><a href="<?php _che($url, ''); ?>"> <?php _che($option_10, ''); ?></a></div>
<div class="content">
    <a href="<?php _che($url, ''); ?>" class="infobox-thumbnail">
        <img src="<?php echo _simg($thumbnail_url, '275x160'); ?>" alt="<?php _che($option_10, ''); ?>" alt="<?php _che($option_10, ''); ?>">
    </a>
  <div class="subtitle"><?php echo lang_check('Description');?></div>
  <p><?php echo _ch($option_chlimit_8); ?></p>
    <div class="subtitle"><?php echo lang_check('Address');?></div>
    <p><?php echo _ch($address); ?><br><br>
  <?php if(false):?>
  <br><b>Phone:</b> <a href="tel:350123456789" class="infobox-link">+350 123 456 789</a><br><b>e-mail:</b> <a href="mailto:kety@location.com" class="infobox-link">kety@location.com</a><br><b>www:</b> <a href="location.com" class="infobox-link">www.location.com</a></p>
  <?php endif;?>
   <?php if(!empty($option_7)):?>
   <b><?php echo _ch($options_name_7); ?>:</b> <span class="infobox-link">&nbsp;<?php echo _ch($option_7, '-'); ?></span><br/>
   <?php endif;?>
   <?php if(!empty($option_79)):?>
   <b><?php echo _ch($options_name_79); ?>:</b> <span class="infobox-link"> &nbsp;<?php echo _ch($option_79, '-'); ?></span><br/>
   <?php endif;?>
   <?php if(isset($options_name_57) && !empty($option_57)):?>
   <b><?php echo _ch($options_name_57); ?>:</b> <span class="infobox-link"> &nbsp;<?php echo _ch($options_prefix_57, ''); ?><?php echo _ch($option_57, '-'); ?><?php echo _ch($options_suffix_57, ''); ?></span><br/>
   <?php endif;?>
   <?php if(isset($options_name_19) && empty($option_19)):?>
   <b><?php echo _ch($options_name_19); ?>:</b> <span class="infobox-link"> &nbsp;<?php echo _ch($option_19, '-'); ?></span><br/>
   <?php endif;?>
    <?php if(FALSE)if(!empty($options_name_36) || !empty($option_37)): ?>
    <br/><b><?php echo lang_check('Price');?>:</b>
    <?php 
        if(!empty($option_36))echo $options_prefix_36.price_format($option_36, $lang_id).$options_suffix_36;
        if(!empty($option_37))echo ' '.$options_prefix_37.price_format($option_37, $lang_id).$options_suffix_37
    ?>
    <br/>
    <?php endif; ?>

</div>
<div class="iw-bottom-gradient"></div>
</div>

<div class="infobox infobox-middle hidden">
    <div class="preview-image">
        <a href="<?php _che($url, ''); ?>">
            <img src="<?php echo _simg($thumbnail_url, '275x160'); ?>" alt="<?php _che($option_10, ''); ?>" alt="<?php _che($option_10, ''); ?>">
        </a>
    </div>
    <div class="content">
      <div class="title"> <a href="<?php _che($url, ''); ?>"><?php _che($option_10, ''); ?></a></div>
      <div class="thumbnail-ratings">
        <?php
            $CI = &get_instance();
            $CI->load->model('reviews_m');
            $avarage_stars = intval($CI->reviews_m->get_avarage_rating($id)+0.5);
        ?>

        <?php if(!empty($avarage_stars)):?>
            <?php echo $avarage_stars; ?> <i class="icon-star-ratings-<?php echo $avarage_stars; ?>"></i>
        <?php elseif(!empty($option_56)):?>
            <?php echo _ch($option_56,'0'); ?> <i class="icon-star-ratings-<?php echo _ch($option_56,'0'); ?>"></i>
        <?php endif;?>
      </div>
      <div class="type">
         <?php _che($option_4); ?>
      </div>
    </div>
</div>
<?php if(false):?>
<div class="infobox infobox-middle hidden">
    <div class="preview-image">
        <a href="<?php _che($url, ''); ?>">
            <img src="<?php echo _simg($thumbnail_url, '275x160'); ?>" alt="<?php _che($option_10, ''); ?>" alt="<?php _che($option_10, ''); ?>">
        </a>
    </div>
    <div class="content">
      <div class="title"> <a href="<?php _che($url, ''); ?>"><?php _che($option_10, ''); ?></a></div>
      <div class="thumbnail-ratings">
        <?php
            $CI = &get_instance();
            $CI->load->model('reviews_m');
            $avarage_stars = intval($CI->reviews_m->get_avarage_rating($id)+0.5);
        ?>

        <?php if(!empty($avarage_stars)):?>
            <?php echo $avarage_stars; ?> <i class="icon-star-ratings-<?php echo $avarage_stars; ?>"></i>
        <?php elseif(!empty($option_56)):?>
            <?php echo _ch($option_56,'0'); ?> <i class="icon-star-ratings-<?php echo _ch($option_56,'0'); ?>"></i>
        <?php endif;?>
      </div>
      <div class="type">
         <?php _che($option_4); ?>
      </div>
    </div>
</div>
<?php endif;?>
<div class="infobox infobox-mini hidden">
    <div class="preview-image">
        <a href="<?php _che($url, ''); ?>">
            <img src="<?php echo _simg($thumbnail_url, '140x80'); ?>" alt="<?php _che($option_10, ''); ?>">
        </a>
    </div>
    <div class="content">
        <div class="title"> 
            <a href="<?php _che($url, ''); ?>"><?php echo _che($option_10, ''); ?></a>
        </div>
    </div>
</div>