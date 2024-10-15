 <?php
/*
Widget-title: Recent reviews
Widget-preview-image: /assets/img/widgets_preview/bottom_recentreviews.jpg

Widget-options: recent_reviews_subtitle
 */
?>

<?php

if(!file_exists(APPPATH.'controllers/admin/swin_reviews.php'))
{
    return false;
}

$CI = &get_instance();
$CI->load->model('reviews_m');
$reviews_all = $CI->reviews_m->get_listing(array('message !='=>''));

if(empty($reviews_all)) {
    return false;
}
?>


<section class="section-reviews section container container-palette widget_edit_enabled">
    <div class="container">
        <div class="section-title">
            <h2 class="title"><?php echo lang_check('Recent Reviews');?></h2>
            <span class="subtitle"><?php echo get_widget_option('recent_reviews_subtitle', 'bottom_recentreviews', $page_id, $lang_id,lang_check('Donecos a lacus ut nisl mattis sodales.'));?></span>
        </div>
        <div class="reviews-carousel">
            <div class="nav-r">
                <a href="#" class="nav-r-btn btn-left"><i class="ion-ios-arrow-left"></i></a>
                <a href="#" class="nav-r-btn btn-right"><i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="reviews-results clearfix">
                <?php $i=0; foreach ($reviews_all as $key => $value):?>
                <?php if ($i>5) break; ?>
                <div class="review <?php if($key==0):?>show<?php endif;?>">
                    <div class="rating">
                        <i class="icon-star-ratings-<?php _che($value['stars']);?>"></i></div>
                    <div class="description">
                        <?php _che($value['message']);?>
                    </div>
                    <div class="user-card">
                        <div class="user-card-image image-cover">
                            <?php if(isset($value['image_user_filename']) && file_exists(FCPATH.'files/thumbnail/'.$value['image_user_filename'])): ?>
                            <img src="<?php echo base_url('files/thumbnail/'.$value['image_user_filename']); ?>"  alt="<?php echo $value['image_user_filename'];?>"/>
                            <?php else: ?>
                            <img src="assets/img/user-agent.png" alt="agent"/>
                            <?php endif; ?>
                        </div>
                        <div class="body">
                            <h3 class="name"><?php _che($value['name_surname']);?></h3>
                                <div class="contact"><span><?php echo lang_check('review for');?></span> 
                                <?php
                                $listing = $CI->estate_m->get_dynamic_array($value['listing_id']);
                                $title = _ch($listing['option10_'.$lang_id]);
                                ?>
                                <a href="<?php echo site_url($this->data['listing_uri'].'/'.$value['listing_id'].'/'.$lang_code);?>" class="link"><?php _che($title);?></a>
                            </div>
                        </div>
                    </div>
                </div>   
                <?php $i++; endforeach;?>
            </div>
        </div>
    </div>
</section> <!-- /.section-reviews -->