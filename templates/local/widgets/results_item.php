<?php
$col_sm = '4';
if(isset($columns) && $columns == 3)
{
    $col_sm = '4';
}

if(isset($columns) && $columns == 4)
{
    $col_sm = '3';
}
if(isset($columns) && $columns == 2)
{
    $col_sm = '6';
}

if(isset($columns) && $columns == 12)
{
    $col_sm = '12';
}
$class='';
if(isset($custom_class) && !empty($custom_class))
{
    $class = $custom_class;
} else {
    $class = 'col-md-'.$col_sm;
}

$video_ext = array('webp','mp4','wmv','3gp','m4v','flv','mkv','webm','mpg','mpeg');
?>


<div class="<?php echo $class; ?>">
    <div class="thumbnail thumbnail-property <?php echo ($item['is_featured']==1) ? 'features':''; ?>">
        <div class="thumbnail-image">
            <?php if(file_exists(FCPATH.'files/'.$item['image_filename']) && in_array(pathinfo($item['image_filename'], PATHINFO_EXTENSION), $video_ext)):?>
                <video controls="controls" preload="metadata" style="width:100%;height:100%;object-fit:cover;position:relative;z-index: 3;">
                    <source  src="<?php echo str_replace('index.php/','',site_url('files/'.$item['image_filename']));?>#t=15">
                </video>
            <?php else: ?>
                <img src="<?php echo _simg($item['thumbnail_url'], '735x465'); ?>" alt="<?php _che($item['alt']); ?>" />
                <!--  <img class="mobile-preview" src="<?php echo _simg($item['thumbnail_url'], '612x386'); ?>" alt="<?php _che($item['option_10']); ?>"> -->
                <a href="<?php echo $item['url']; ?>"></a>
                <div class="icons">
                    <a href="<?php echo "https://www.facebook.com/share.php?u=".rawurlencode($item['url'])."&amp;title=".rawurlencode(_ch($item['option_10']))."&amp;picture=".rawurlencode(_simg($item['thumbnail_url'], '612x386'));?>" target="_blank"><i class="ion-android-share-alt"></i></a>
                    <span class="favorites-actions">
                        <a href="#" data-id="<?php echo _ch($item['id']); ?>" class="add-to-favorites add-favorites-action" style="<?php echo ($item['is_favorite'])?'display:none;':''; ?>">
                            <i class="ion-android-favorite"></i>
                        </a>
                        <a href="#" data-id="<?php echo _ch($item['id']); ?>" class="remove-from-favorites remove-favorites-action" style="<?php echo (!$item['is_favorite'])?'display:none;':''; ?>">
                            <i class="ion-android-favorite"></i>
                        </a>
                    </span>
                    <a target="_blank" href="<?php echo $item['url']; ?>"><i class="ion-location"></i></a>
                    <a target="_blank" href="<?php echo $item['url']; ?>"><i class="ion-forward"></i></a>
                </div>
            <?php endif;?>
            <?php if(!empty($item['option_4']) && FALSE):?>
            <div class="purpose-badget <?php $a='';$a=strtolower($item['option_4']);echo url_title_cro( str_replace(' ','_',$a));?>"><?php echo _ch($item['option_4']); ?></div>
            <?php endif; ?>

            <?php if(!empty($item['option_54']) && FALSE):?>
            <div class="ownership-badget fea_<?php echo _ch($item['is_featured']); ?>"><?php echo _ch($item['option_54']); ?></div>
            <?php endif;?>

            <?php if(($item['is_featured'])):?>
            <img class="featured-icon" alt="Featured" src="assets/img/featured-icon.png" />
            <?php endif;?>
            
            <?php if(!empty($item['option_38'])):?>
            <div class="badget"><img src="<?php echo _ch($item['badget']); ?>" alt="<?php echo _ch($item['option_38']); ?>"/></div>
            <?php endif; ?>
        </div>
        <div class="caption flex">
            <div class="caption-ls">
                <h3 class="thumbnail-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h3>
                <span class="thumbnail-ratings">
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
                    
                    <?php if(!empty($item['option_36']) || !empty($item['option_37'])): ?>
                    <span class="price">
                    <?php 
                        if(!empty($item['option_36']))echo $options_prefix_36.price_format($item['option_36'], $lang_id).$options_suffix_36;
                        if(!empty($item['option_37']))echo ' '.$options_prefix_37.price_format($item['option_37'], $lang_id).$options_suffix_37
                    ?>
                    </span> 
                    <?php endif; ?>
                </span>
                <span class="type">
                    <a href="<?php echo $item['url']; ?>"><?php _che($item['option_4']); ?></a>
                </span>
            </div>
            <div class="caption-rs">
                <a href="<?php echo $item['url']; ?>" class="btn-marker">
                    <span class="box"><i class="fa fa-map-marker"></i></span>
                    <span class="title"><?php echo lang_check('Location');?></span>
                </a>
            </div>
        </div>
        <div class="caption-footer">
            <ul class="list row">
                <?php
                    $custom_elements = _get_custom_items();
                    $i=0;
                    if(sw_count($custom_elements) > 0):
                    foreach($custom_elements as $key=>$elem):

                    if(!empty($item['option_'.$elem->f_id]) && $i++<3)
                    if($elem->type == 'DROPDOWN' || $elem->type == 'INPUTBOX'):
                     ?>
                <li class="text-center"><i class="fa <?php _che($elem->f_class); ?>"></i><small><?php echo _ch($item['option_'.$elem->f_id], '-'); ?> <?php echo _ch(${"options_suffix_$elem->f_id"}, ''); ?> <span style="<?php _che($elem->f_style); ?>"><?php echo _ch(${"options_name_$elem->f_id"}, '-'); ?></span></small></li>
                     <?php 
                    elseif($elem->type == 'CHECKBOX'):
                     ?>
                <li class="text-center"><i class="fa <?php _che($elem->f_class); ?>"></i><small> <strong class="<?php echo (!empty($item['option_'.$elem->f_id])) ? 'glyphicon glyphicon-ok':'glyphicon glyphicon-remove';  ?>"></strong> <?php echo _ch(${"options_name_$elem->f_id"}, '-'); ?></small></li>
                     <?php 
                    endif;                    
                    endforeach;  
                    elseif(false):
                ?>
                <li class="text-center"><i class="fa fa-building"></i><small><?php echo _ch($item['option_57'], '-'); ?> <?php echo _ch($options_suffix_57, '-'); ?></small></li>
                <li class="text-center"><i class="fa fa-tint"></i> <small><?php echo _ch($item['option_19'], '-'); ?> <?php echo _ch($options_name_19, '-'); ?></small></li>
                <li class="text-center hidden_centerwidget-lg"><i class="fa fa-car"></i> <small> <strong class="<?php echo (!empty($item['option_32'])) ? 'glyphicon glyphicon-ok':'glyphicon glyphicon-remove';  ?>"></strong> <?php echo _ch($options_name_32, '-'); ?></small></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>   