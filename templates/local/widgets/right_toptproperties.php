 <?php
/*
Widget-title: Top properties
Widget-preview-image: /assets/img/widgets_preview/right_toptproperties.jpg
 */
?>

 <?php
 $CI = &get_instance();
 $CI->load->model('estate_m');
 $CI->load->model('option_m');

$last_n = 3;

$top_n_estates = $this->estate_m->get_by(array('is_activated' => 1, 'language_id'=>$lang_id), FALSE, $last_n, 'counter_views DESC');
$options_name = $this->option_m->get_lang(NULL, FALSE, $lang_id);

$top_estates_num = $last_n;
$top_estates = array();
$CI->generate_results_array($top_n_estates, $top_estates, $options_name); 
 
?>


<div class="widget-styles widget-other-location widget_edit_enabled">
    <h2 class="widget-title content-box t-left"><?php echo lang_check('Popular Places'); ?></h2>
    <div class="content-box">
        <?php foreach($top_estates as $item): ?>
        <div class="location-box">
            <a href="<?php echo $item['url']; ?>" title="<?php echo _ch($item['option_10']); ?>" class="preview-image image-cover-div object-fit-container compat-object-fit">
                <img src="<?php echo _simg($item['thumbnail_url'], '250x250'); ?>" alt="<?php echo _ch($item['option_10']); ?>">
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