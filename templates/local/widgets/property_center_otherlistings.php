<?php if(sw_count($agent_estates) > 0): ?>
<div class="widget widget-other-location widget_edit_enabled"> 
    <h2 class="widget-title content t-left"><?php _l('Agentestates');?></h2>
    <div id="ajax_results" class="content">
        <div class="row result-container row-flex">
            <?php foreach($agent_estates as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-lg-4 col-md-6 thumbnail-g')); ?>
            <?php endforeach;?>
        </div>
        <div class="text-center">
            <div class="pagination-ajax-results pagination properties wp-block default product-list-filters light-gray pagination" rel="ajax_results">
               <?php echo $pagination_links_agent; ?>
            </div>
        </div>
     </div>
 </div>
<?php endif;?>