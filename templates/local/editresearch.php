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
                <div class="container" id="content">
                    <div class="widget widget-styles" id="form-block">
                        <div class="header content t-left">
                            <h2><?php _l('Editresearch');?>, #<?php echo $listing['id']; ?></h2>
                        </div>
                        <div class="content-box form-local">
                            <div class="box-alerts"> 
                                <?php echo validation_errors()?>
                                <?php if($this->session->flashdata('message')):?>
                                <?php echo $this->session->flashdata('message')?>
                                <?php endif;?>
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                                <!-- Form starts.  -->
                                <?php echo form_open(NULL, array('class' => 'local-form form-estate', 'role'=>'form'))?>                              
                                
                                <div class="form-group">
                                    <label for="inputActivated" class="control-label"><?php echo lang_check('Activated')?></label>
                                    <div class="controls">
                                         <?php echo form_checkbox('activated', '1', set_value('activated', $listing['activated']), 'id="inputActivated"')?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang_check('Parameters')?></label>
                                    <div class="controls">
                                        <?php echo lang_check('Lang code').': '; ?><?php echo '['.strtoupper($listing['lang_code']).']'; ?><br />
                                        <?php
                                        $parameters = json_decode($listing['parameters']);
                                        foreach($parameters as $key=>$value){
                                            if(!empty($value) && $key != 'view' && $key != 'order')
                                            {
                                                if(is_array($value))
                                                {
                                                    $value = implode(', ', $value);
                                                }

                                                echo $key.': <b>'.$value.'</b><br />';
                                            }
                                        }

                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <div class="controls">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary"')?>
                                    <a href="<?php echo site_url('fresearch/myresearch/'.$lang_code)?>#content" class="btn btn-default" type="button"><?php echo lang('Cancel')?></a>
                                  </div>
                                </div>
                            <?php echo form_close()?>
                            </div>
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

