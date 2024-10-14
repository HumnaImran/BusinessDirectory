<!DOCTYPE html>
<html lang="en">
    <head>
        <?php _widget('head');?>
    </head>
    <body class="<?php _widget('custom_paletteclass'); ?>">
        <header class="header">
            <?php _widget('custom_header_menu-for-loginuser');?>
            <?php _widget('header_main');?>
        </header><!-- /.header -->
        <?php _widget('top_title_grey');?>
        <main class="">
            <section class="section container container-palette">
                <div class="container">
                    <div class="widget widget-styles" id="content">
                        <div class="header content t-left">
                            <h2><?php echo lang_check('My rates and availability'); ?></h2>
                        </div>
                        <div class="content-box">
                            <div class="content widget-controls"> 
                                <?php echo anchor('rates/rate_edit/'.$lang_code.'#content', '<i class="icon-plus icon-white"></i>&nbsp;&nbsp;'.lang_check('Add rate'), 'class="btn btn-info"')?>
                            </div>
                            <div class="box-alert"> 
                                <?php if($this->session->flashdata('message')):?>
                                <?php echo $this->session->flashdata('message')?>
                                <?php endif;?>
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                            </div>
                            <table class="table table-striped footable">
                                <thead>
                                    <th>#</th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('From date');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('To date');?></th>
                                    <th data-type="html"><?php echo lang_check('Property');?></th>
                                    <th class="control" data-type="html"><?php echo lang_check('Edit');?></th>
                                    <th class="control" data-type="html"><?php echo lang_check('Delete');?></th>
                                </thead>
                               <?php if(sw_count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?></td>
                                        <td><?php echo $listing_item->date_from; ?></td>
                                        <td><?php echo $listing_item->date_to; ?></td>
                                        <td><?php echo $properties[$listing_item->property_id]; ?></td>
                                        <td><?php echo btn_edit('rates/rate_edit/'.$lang_code.'/'.$listing_item->id)?></td>
                                        <td><?php echo btn_delete('rates/rate_delete/'.$lang_code.'/'.$listing_item->id)?></td>
                                    
                                    </tr>
                                <?php endforeach;?>
                                <?php else:?>
                                    <tr>
                                    	<td ><?php echo lang_check('We could not find any');?></td>
                                    </tr>
                                <?php endif;?>       
                            </table>
                        </div>
                    </div> 
                    
                </div>
            </section> <!-- /.section-category -->
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>