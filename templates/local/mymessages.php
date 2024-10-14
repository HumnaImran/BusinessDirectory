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
                            <h2><?php _l('My messages'); ?></h2>
                        </div>
                        <div class="content-box">
                            <div class="box-alerts"> 
                                <?php if($this->session->flashdata('message')):?>
                                <?php echo $this->session->flashdata('message')?>
                                <?php endif;?>
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                            </div>
                                                        <table class="table table-striped footable-sort" data-sorting="true">
                                <thead>
                                    <th>#</th>
                                    <th data-type="html"><?php _l('Date');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Mail');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Message');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Estate');?></th>
                                    <th class="control" data-type="html"><?php _l('Edit');?></th>
                                    <th class="control" data-type="html"><?php _l('Delete');?></th>
                                </thead>
                                <?php if(sw_count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?>&nbsp;&nbsp;<?php echo $listing_item->readed == 0? '<span class="label label-warning">'.lang_check('Not readed').'</span>':''?></td>
                                        <td><?php echo $listing_item->date; ?></td>
                                        <td><?php echo $listing_item->mail; ?></td>
                                        <td><?php echo $listing_item->message; ?></td>
                                        <td><?php echo $all_estates[$listing_item->property_id]; ?></td>
                                        <td><?php echo btn_edit('fmessages/edit/'.$lang_code.'/'.$listing_item->id)?></td>
                                        <td><?php echo btn_delete('fmessages/delete/'.$lang_code.'/'.$listing_item->id)?></td>
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

