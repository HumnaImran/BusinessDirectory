 <?php
/*
Widget-title: Top places
Widget-preview-image: /assets/img/widgets_preview/footer_topplaces.jpg
 */
?>

<?php

if(!isset($last_estates)){
    $CI = &get_instance();
    $CI->load->model('estate_m');
    $CI->load->model('option_m');

    $last_n = 4;
    if(config_item('last_estates_limit'))
        $last_n = config_item('last_estates_limit');

   $top_n_estates = $this->estate_m->get_by(array('is_activated' => 1, 'language_id'=>$lang_id), FALSE, $last_n, 'id DESC');
   $options_name = $this->option_m->get_lang(NULL, FALSE, $lang_id);

   $top_estates_num = $last_n;
   $last_estates = array();
   $CI->generate_results_array($top_n_estates, $last_estates, $options_name); 
}
?>


<div class="col-md-3 col-sm-6 f-box widget_edit_enabled">
    <div class="title"><?php _l('Lastaddedproperties'); ?></div>
    <ul class="list-f">
        <?php foreach($last_estates as $item): ?>
        <li><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></li>
        <?php endforeach;?>
    </ul>
</div>    