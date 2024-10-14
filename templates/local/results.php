
    {has_no_results}
    <div class="result-answer">
        <div class="alert alert-success">
            <?php _l('Noestates');?>
        </div>
    </div>
    {/has_no_results}
    <?php if(!empty($results)):?>
    <div class="row result-container row-flex">
        {has_view_grid}      
            <?php foreach($results as $key=>$item): ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-lg-4 col-md-6 thumbnail-g')); ?>
            <?php endforeach;?>
        {/has_view_grid}
        {has_view_list}
            <?php _widget('results_list');?>
        {/has_view_list}
    </div>
    <div class="text-center">
        <nav aria-label="Page navigation" class="pagination properties">
            {pagination_links}
        </nav>
    </div>
    <?php endif;?>
    <div class="result_preload_indic"></div>


<script>
$('.result_preload_indic').hide();
$('#results_conteiner').closest('.widget-recentproperties').removeClass('hidden');
</script>