<?php if (file_exists(APPPATH . 'controllers/admin/swin_reviews.php') && $settings_reviews_enabled):;?>
<div class="widget-styles widget-reviews widget_edit_enabled" id="form_review">
    
    
    <?php if($settings_reviews_public_visible_enabled): ?>
    <div class="header content t-left"><h2><?php echo lang_check('Reviews & Tips');?></h2></div>
        <?php if(sw_count($not_logged) && !$settings_reviews_public_visible_enabled): ?>
        <div class="content-box">
        <p class="alert alert-success">
            <?php echo lang_check('LoginToReadReviews'); ?>
        </p>
        </div>
        <?php else: ?>
            <?php if(sw_count($reviews_all) > 0): ?>
                <ul class="list-reviews">
                <?php foreach($reviews_all as $review_data): ?>
                    <li class="content-box">
                        <a href="<?php echo site_url('profile/'.$review_data['user_id'].'/'.$lang_code);?>">
                            <?php if(isset($review_data['image_user_filename'])): ?>
                            <img src="<?php echo _simg('files/thumbnail/'.$review_data['image_user_filename'], '70x70');?>" alt="<?php echo $review_data['image_user_filename'];?>" />
                            <?php else: ?>
                            <img src="assets/img/user-agent.png" alt="agent" />
                            <?php endif; ?>
                        </a>
                        <div class="list-reviews-body">
                            <div class="list-reviews-title">
                                <h2><a href="<?php echo site_url('profile/'.$review_data['user_id'].'/'.$lang_code);?>"><?php echo $review_data['name_surname']; ?></a></h2>
                            </div>
                            <div class="raiting"><i class="icon-star-ratings-<?php echo $review_data['stars']; ?>"></i></div>
                            <div class="description">
                                <?php if($review_data['is_visible']): ?>
                                <?php echo $review_data['message']; ?>
                                <?php else: ?>
                                <?php echo lang_check('HiddenByAdmin'); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="content-box">
                    <p class="alert alert-success">
                        <?php echo lang_check('SubmitFirstReview'); ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="caption-title t-left content" id="write_review"><?php echo lang_check('Rate and Write a Review');?></div>
    <div class="content-box">
    <?php if(sw_count($not_logged)): ?>
    <p class="alert alert-success">
        <?php echo lang_check('Please');?> 
        <a href="{front_login_url}#content" data-toggle="modal" data-target="#login-modal"><?php echo lang_check('login');?></a> 
        <?php echo lang_check('or');?> 
        <a href="{front_login_url}#content"><?php echo lang_check('register');?></a> 
        <?php echo lang_check('to write your review');?>
    </p>
    <?php else: ?>
        <?php if($reviews_submitted == 0): ?>
            <form action="{page_current_url}#form_review" method="post" class="local-form">
                <?php if(isset($reviews_validation_errors) && !empty($reviews_validation_errors)):?>
                <?php echo $reviews_validation_errors;?>
                <?php endif;?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group form-group-rating">
                            <input type="radio" name="stars" value=""  class="hidden" checked="checked" />
                            <fieldset class="rating-action rating" required>
                                <input type="radio" id="star1" name="stars" value="5" />
                                <label class="full" for="star1" title="<?php echo lang_check('Awesome - 5 stars');?>"></label>
                                <input type="radio" id="star2" name="stars" value="4" />
                                <label class="full" for="star2" title="<?php echo lang_check('Pretty good - 4 stars');?>"></label>
                                <input type="radio" id="star3" name="stars" value="3" />
                                <label class="full" for="star3" title="<?php echo lang_check('Meh - 3 stars');?>"></label>
                                <input type="radio" id="star4" name="stars" value="2" />
                                <label class="full" for="star4" title="<?php echo lang_check('Kinda bad - 2 stars');?>"></label>
                                <input type="radio" id="star5" name="stars" value="1" />
                                <label class="full" for="star5" title="<?php echo lang_check('Very bad - 1 star');?>"></label>
                            </fieldset>
                            <span><?php echo lang_check('Select Your Rating');?></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="5" placeholder="<?php echo lang_check('Help other to choose perfect place');?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="cliearfix">
                    <button type="submit" class="btn btn-custom btn-custom-secondary"><?php echo lang_check('Submit Review');?></button>
                </div>
            </form>
        <?php else: ?>
        <p class="alert alert-info">
            <?php echo lang_check('ThanksOnReview'); ?>
        </p>
        <?php endif; ?>
    <?php endif; ?>
    </div>
</div>
<?php endif;?>
