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
                        <div class="header content t-left" id="form-block">
                            <h2>
                                <?php echo $page_title; ?>
                                <span>
                                <?php _l('You can withdraw up to:'); ?>
                                <?php
                                    $index=0;
                                    $currencies = array(''=>'');

                                    if(sw_count($withdrawal_amounts) == 0)echo '0';

                                    foreach($withdrawal_amounts as $currency=>$amount)
                                    {
                                        $currencies[$currency] = $currency;
                                        echo '<span class="label label-success">'.$amount.' '.$currency.'</span>&nbsp;';
                                    }
                                ?>
                                </span>
                                
                            </h2>
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
                            </div>
                              <?php echo form_open(current_url().'#form-block', array('class' => 'local-form form-estate', 'role'=>'form'))?>                              
                                <div class="form-group form-group row">
                                  <label class="col-lg-2 control-label"><?php _l('Amount')?></label>
                                  <div class="col-lg-10 controls">
                                  <div class="input-append">
                                    <?php echo form_input('amount', $this->input->post('amount') ? $this->input->post('amount') : '', 'class="form-control"'); ?>
                                  </div>
                                  </div>
                                </div>

                                <div class="form-group form-group row">
                                  <label class="col-lg-2 control-label"><?php _l('Currency code')?></label>
                                  <div class="col-lg-10 controls">
                                    <?php echo form_dropdown('currency', $currencies, $this->input->post('currency') ? $this->input->post('currency') : '', 'class="form-control"')?>
                                  </div>
                                </div>

                                <div class="form-group form-group row">
                                  <label class="col-lg-2 control-label"><?php _l('Withdrawal email')?></label>
                                  <div class="col-lg-10 controls">
                                  <div class="input-append">
                                    <?php echo form_input('withdrawal_email', $this->input->post('withdrawal_email') ? $this->input->post('withdrawal_email') : '', 'class="form-control"'); ?>
                                  </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <div class="controls">
                                    <?php echo form_submit('submit', lang_check('Request withdrawal'), 'class="btn btn-primary"')?>
                                    <a href="<?php echo site_url('rates/payments/'.$lang_code)?>#content" class="btn btn-default" type="button"><?php echo lang_check('Cancel')?></a>
                                  </div>
                                </div>
                            <?php echo form_close()?>
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


