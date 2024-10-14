<?php
$tree_field_id = 79;
$CI = & get_instance();
$values = array();
$CI->load->model('treefield_m');
$CI->load->model('file_m');
$check_option = $CI->treefield_m->get_lang(NULL, FALSE, $lang_id);
foreach ($check_option as $key => $value) {
    if($value->field_id==$tree_field_id){
        $values[$value->value_path]= $value->font_icon_code;
    }
}
?>

<div class="section-s">
    <div class="section-title box-v text-left">
        <h2 class="title"><?php echo lang_check('Explore New Listings');?></h2>
        <span class="subtitle"><?php echo lang_check('Maecenas mauris arcu, congue ac lorem vel libero.');?></span>
    </div>
    <div class="row result-slim">
        {has_no_results}
        <div class="result-answer">
            <div class="alert alert-success">
                <?php _l('Noestates');?>
            </div>
        </div>
        {/has_no_results}
        <?php if(!empty($results)):?>
        <div class="row result-slim row-flex">
            <?php $i=0; foreach($results as $key=>$item): ?>
                <?php if ($i>6) break; ?>
            
                <?php 
                    $item['icon'] = '';
                    if(!empty($item['option_79']) && isset($values[$item['option_79']])){
                        $item['icon'] = $values[$item['option_79']];
                    }
                ?>
            
                <?php if ($i<3):?>
                    <div class="col-sm-4">
                        <figure class="card card-location">
                            <img src="<?php echo _simg($item['thumbnail_url'], '612x386'); ?>" alt="<?php _che($item['option_10']); ?>" />
                            
                            <div class="budget budget-type"><i class="<?php _che($item['icon']); ?>"></i></div>
                            
                            <a href="<?php echo $item['url']; ?>" class="description description-hidden"> 
                                <h2 class="title"><?php _che($item['option_10']); ?></h2>
                                <div class="sub-title"><?php _che($item['address']); ?></div>
                            </a>
                            <figcaption class="description">
                                <h2 class="title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h2>
                                <div class="sub-title"><?php _che($item['address']); ?></div>
                            </figcaption>
                        </figure>
                    </div> 
                <?php else: ?>
                    <div class="col-lg-3 col-md-6 col-sm-3">
                        <figure class="card card-location">
                            <img src="<?php echo _simg($item['thumbnail_url'], '612x386'); ?>" alt="<?php _che($item['option_10']); ?>" />
                            <div class="budget budget-type"><i class="<?php _che($item['icon']); ?>"></i></div>
                            
                            <a href="<?php echo $item['url']; ?>" class="description description-hidden"> 
                                <h2 class="title"><?php _che($item['option_10']); ?></h2>
                                <div class="sub-title"><?php _che($item['address']); ?></div>
                            </a>
                            <figcaption class="description">
                                <h2  class="title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h2>
                                <div class="sub-title"><?php _che($item['address']); ?></div>
                            </figcaption>
                        </figure>
                    </div> 
                <?php endif;?>

            
            <?php $i++; endforeach; ?>
        </div>
        <?php endif;?>
    </div>
</div>