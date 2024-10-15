<?php

$similar_estates = array();

$CI =& get_instance();

$where = array();
$where['language_id']  = $lang_id;
$where['is_activated'] = 1;
if(isset($CI->data['settings_listing_expiry_days']))
{
    if(is_numeric($CI->data['settings_listing_expiry_days']) && $CI->data['settings_listing_expiry_days'] > 0)
    {
         $where['property.date_modified >']  = date("Y-m-d H:i:s" , time()-$CI->data['settings_listing_expiry_days']*86400);
    }
}

//where (similar properties) price, purpose, county
if(!empty($estate_data_option_37))
{
    $where['field_37_int >'] = 0.7*(int)$estate_data_option_37;
    $where['field_37_int <'] = 1.3*(int)$estate_data_option_37;
}
    
if(!empty($estate_data_option_36))
{
    $where['field_36_int >'] = 0.7*(int)$estate_data_option_36;
    $where['field_36_int <'] = 1.3*(int)$estate_data_option_36;
}
    
if(!empty($estate_data_option_4))
{
    $where['field_4'] = $estate_data_option_4;
}

$where['is_activated'] = 1;
$where['property.id !='] = $property_id;

$similar_estates = $CI->estate_m->get_by($where, FALSE, 3, 'RAND()', 0, array(), NULL);

$similar_estates_array = array();
$CI->generate_results_array($similar_estates, $similar_estates_array, $options_name);

if(sw_count($similar_estates_array) > 0): ?>
<div class="widget widget-other-location widget_edit_enabled"> 
    <h2 class="widget-title content t-left"><?php echo lang_check('Similar properties'); ?></h2>
    <div class="content">
        <?php foreach($similar_estates_array as $key=>$item): ?>
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
<?php endif;?>




    

