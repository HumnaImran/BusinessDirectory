<?php
/*
Widget-title: Wisget last properties slim
Widget-preview-image: /assets/img/widgets_preview/right_lastproperties-slim.jpg
*/
?>

<div class="widget widget-other-location widget_edit_enabled">
    <h2 class="widget-title content t-left"><?php _l('Lastaddedproperties'); ?></h2>
    <div class="content">
         <?php foreach($last_estates as $item): ?>
        <div class="location-box">
            <a href="<?php echo $item['url']; ?>" title="<?php echo _ch($item['option_10']); ?>" class="preview-image image-cover-div object-fit-container compat-object-fit">
                <img src="<?php echo _simg($item['thumbnail_url'], '350x350'); ?>" alt="<?php echo _ch($item['option_10']); ?>">
            </a>
            <div class="location-box-content">
                <h3 class="title"><a href="<?php echo $item['url']; ?>" title="<?php echo _ch($item['option_10']); ?>"><?php echo _ch($item['option_10']); ?></a></h3>
                <div class="ratings">
                    <?php
                        $CI = &get_instance();
                        $CI->load->model('reviews_m');
                        $avarage_stars = intval($CI->reviews_m->get_avarage_rating($item['id'])+0.5);
                    ?>

                    <?php if(!empty($avarage_stars)):?>
                        <?php echo number_format($avarage_stars,1); ?> <i class="icon-star-ratings-<?php echo $avarage_stars; ?>"></i>
                    <?php elseif(!empty($item['option_56'])):?>
                        <?php echo number_format(_ch($item['option_56'],'0'),1); ?> <i class="icon-star-ratings-<?php echo _ch($item['option_56'],'0'); ?>"></i>
                    <?php endif;?>
                </div>
                <div class="types">
                    <?php _che($item['option_4']); ?>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>