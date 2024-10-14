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
                    <div class="widget widget-styles">
                        <div class="header content t-left">
                            <h2><?php _l('Myreservations');?></h2>
                        </div>
                        <div class="content-box">
                            <div class="box-alerts"> 
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                            </div>
                            <table class="table table-striped footable">
                                <thead>
                                    <th>#</th>
                                    <th data-type="html"><?php echo lang('Dates');?></th>
                                    <!-- Dynamic generated -->
                                    <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                                    <th data-breakpoints="xs sm md"  data-type="html"><?php echo $row->option?></th>
                                    <?php endforeach;?>
                                    <!-- End dynamic generated -->
                                    <th class="control" style="width: 120px;" data-type="html"><?php echo lang('Edit');?></th>
                                    <th class="control" data-type="html"><?php echo lang('Delete');?></th>
                                </thead>
                                <tbody>
                                    <?php if(sw_count($estates)): foreach($estates as $estate):?>
                                    <tr>
                                        <td><?php echo $estate->id?></td>
                                        <td>
                                        <?php echo anchor('frontend/viewreservation/'.$lang_code.'/'.$estate->id, date('Y-m-d', strtotime($estate->date_from)).' - '.date('Y-m-d', strtotime($estate->date_to)))?>
                                        <?php if($estate->is_confirmed == 0):?>
                                        &nbsp;<span class="label label-important"><?php echo lang_check('Not confirmed')?></span>
                                        <?php else: ?>
                                        &nbsp;<span class="label label-success"><?php echo lang_check('Confirmed')?></span>
                                        <?php endif;?>
                                        </td>
                                        <!-- Dynamic generated -->
                                        <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                                        <td>
                                        <?php echo isset($options[$estate->property_id][$row->option_id])?$options[$estate->property_id][$row->option_id]:'-'?></td>
                                        <?php endforeach;?>
                                        <!-- End dynamic generated -->
                                        <td><?php echo anchor('frontend/viewreservation/'.$lang_code.'/'.$estate->id, '<i class="icon-shopping-cart icon-white"></i> '.lang_check('View/Pay'), array('class'=>'btn btn-info'))?></td>
                                        <td><?php if($estate->is_confirmed == 0):?><?php echo anchor('frontend/deletereservation/'.$lang_code.'/'.$estate->id, '<i class="icon-remove"></i> '.lang('Delete'), array('onclick' => 'return confirm(\''.lang_check('Are you sure?').'\')', 'class'=>'btn btn-danger'))?><?php endif;?></td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php else:?>
                                        <tr>
                                            <td ><?php echo lang_check('No reservations available');?></td>
                                        </tr>
                                    <?php endif;?>      
                                </tbody>
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

