 <?php
/*
Widget-title: Recent articles
Widget-preview-image: /assets/img/widgets_preview/top_recentarticles.jpg
 */
?>

<?php


?>

<section class="section-blog section container container-palette widget_edit_enabled">
    <div class="container">
        <div class="section-title">
            <h2 class="title"><?php echo lang_check('Latestnews');?></h2>
            <span class="subtitle"><?php echo lang_check('Curabitur commodo orci lacus, in lacinia ligula porta vitae.');?></span>
        </div>
        <div class="row">
            <?php $i=0; foreach($news_module_latest_5 as $key=>$row):?> 
            <?php if ($i>2) break; ?>
            <div class="col-md-4 col-sm-12">
                <div class="thumbnail thumbnail-property">
                    <div class="thumbnail-image">
                        <img src="<?php echo _simg('files/'.$row->image_filename, '735x465'); ?>" alt="<?php echo $row->title;?>" />
                        <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"></a>
                        <div class="icons sample">
                            <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><i class="ion-forward"></i></a>
                        </div>
                    </div>
                    <div class="caption caption-blog">
                        <h3 class="thumbnail-title"><a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h3>
                        <span class="date">
                            <?php
                            $month = date("M", strtotime($row->date_publish));
                            ?>
                            <i class="ion-clock"></i><?php echo _l('cal_'.strtolower($month));?> <?php echo date("d, Y", strtotime($row->date_publish));?>
                        </span>
                    </div>
                </div>
            </div>       
            <?php $i++; endforeach;?>
        </div>
    </div>
</section> <!-- /.section-blog -->