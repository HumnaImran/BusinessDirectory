<?php foreach ($showroom_module_all as $key => $row): ?>
    <div class="col-sm-4">
        <div class="thumbnail thumbnail-property no-cover">
            <div class="thumbnail-image">
                <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                <img src="<?php echo _simg('files/'.$row->image_filename, '855x495', FALSE); ?>" alt="<?php _che($row->title);?>" />
                <?php else:?>
                    <img src="assets/img/no_image.jpg" alt="new-image">
                <?php endif;?>
                <a href="<?php echo site_url('showroom/'.$row->id.'/'.$lang_code); ?>">
                </a>
            </div>
            <div class="caption caption-blog">
                <h3 class="thumbnail-title"><a href="<?php echo site_url('showroom/'.$row->id.'/'.$lang_code); ?>">Perfect Places With Pool</a></h3>
                <span class="date">
                    <i class="ion-clock"></i>                                                    
                    <?php
                    $timestamp = strtotime($row->date);
                    $m = strtolower(date("F", $timestamp));
                    echo lang_check('cal_' . $m) . ' ' . date("j, Y", $timestamp);
                    ?>
                    ∙ 
                    <?php foreach (explode(',', $row->keywords) as $val): ?>
                       <?php echo trim($val); ?> 
                    <?php endforeach; ?>
                </span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <nav class="text-center">
        <div class="pagination news">
            <?php echo $showroom_pagination; ?>
        </div>
    </nav>