 <?php
/*
Widget-title: Toplistings slim
Widget-preview-image: /assets/img/widgets_preview/top_lastlistings_slim.jpg
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



<section class="section-picks section container container-palette widget_edit_enabled">
    <div class="container">
        <div class="section-title slim">
            <h2 class="title"><?php echo lang_check('Popular Places'); ?></h2>
        </div>
        <div class="row result-container row-flex">
            <?php foreach($top_estates as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-md-4 col-sm-12')); ?>
            <?php endforeach;?>
        </div>
    </div>
</section> <!-- /.section-picks -->