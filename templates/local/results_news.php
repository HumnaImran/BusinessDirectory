<?php foreach ($news_module_all as $key => $row): ?>
    <div class="col-xs-12">
        <div class="thumbnail thumbnail-property b thumbnail-blog-open">
            <div class="thumbnail-image full-width">
                <?php if (file_exists(FCPATH . 'files/thumbnail/' . $row->image_filename)): ?>
                    <img src="<?php echo _simg('files/' . $row->image_filename, '850x500', TRUE); ?>" alt="<?php _che($row->title); ?>" />
                <?php else: ?>
                    <img src="assets/img/no_image.jpg" alt="new-image">
                <?php endif; ?>
                <a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>"></a>
            </div>
            <div class="caption caption-blog">
                <h3 class="thumbnail-title"><a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h3>
                <span class="date">
                    <i class="ion-clock"></i>                                                           
                        <?php
                        $timestamp = strtotime($row->date_publish);
                        $m = strtolower(date("F", $timestamp));
                        echo lang_check('cal_' . $m) . ' ' . date("j, Y", $timestamp);
                        ?>
                        ∙ 
                        <?php foreach (explode(',', $row->keywords) as $val): ?>
                           <?php echo trim($val); ?> 
                        <?php endforeach; ?>
                </span>
                <div class="description">
                    <?php echo $row->description; ?>
                </div>
                <a href="<?php echo site_url($lang_code . '/' . $row->id . '/' . url_title_cro($row->title)); ?>" class="btn btn-custom btn-custom-secondary"><?php echo lang_check('View Post');?></a>
            </div>
        </div>
    </div>                                   
    <?php endforeach; ?>
    <nav class="text-center">
        <div class="pagination news">
            <?php echo $news_pagination; ?>
        </div>
    </nav>