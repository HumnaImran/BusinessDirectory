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
                            <h2><?php _l('Myfavorites');?></h2>
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
                            <table class="table table-striped footable">
                                <thead>
                                    <th>#</th>
                                    <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Property');?></th>
                                    <th data-breakpoints="xs sm md" data-type="html" ><?php echo lang_check('Language');?></th>
                                    <th data-breakpoints="xs sm md" data-type="html" class="control"><?php echo lang_check('Open');?></th>
                                    <th data-breakpoints="xs sm md" data-type="html" class="control"><?php echo lang_check('Delete');?></th>
                                </thead>
                                <?php if(sw_count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?></td>
                                        <td><?php echo $properties[$listing_item->property_id]; ?></td>
                                        <td><?php echo '['.strtoupper($listing_item->lang_code).']'; ?></td>
                                        <td>
                                        <a href="<?php echo site_url($listing_uri.'/'.$listing_item->property_id.'/'.$listing_item->lang_code); ?>" class="btn"><i class="icon-white icon-search"></i><?php echo lang_check('Open');?></a>
                                        </td>
                                        <td><?php echo btn_delete('ffavorites/myfavorites_delete/'.$lang_code.'/'.$listing_item->id)?></td>
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

