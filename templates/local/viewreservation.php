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
                            <h2>
                                 <?php echo $page_title; ?>
                            </h2>
                        </div>
                        <div class="content-box">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                <th class="span5">#</th>
                                    <th><?php echo lang_check('Info');?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    <td><?php echo lang_check('Reservation id');?></td>
                                    <td>#<?php echo $reservation['id']; ?></td>
                                </tr>       
                                <tr>
                                    <td><?php echo lang_check('Dates range');?></td>
                                    <td><?php echo date('Y-m-d', strtotime($reservation['date_from'])).' - '.date('Y-m-d', strtotime($reservation['date_to'])); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Property');?></td>
                                    <td><?php echo isset($options[$reservation['property_id']][10])?'<a href="'.site_url('property/'.$reservation['property_id'].'/'.$lang_code).'">'.$options[$reservation['property_id']][10].', #'.$reservation['property_id'].'</a>':''?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Total price');?></td>
                                    <td><?php echo $reservation['total_price'].' '.$reservation['currency_code']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Total paid');?></td>
                                    <td><?php echo $reservation['total_paid'].' '.$reservation['currency_code']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Is booked');?></td>
                                    <td>
                                        <?php if($reservation['is_confirmed'] == 0):?>
                                        &nbsp;<span class="label label-important"><?php echo lang_check('Not confirmed')?></span>
                                        <?php else: ?>
                                        &nbsp;<span class="label label-success"><?php echo lang_check('Confirmed')?></span>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <?php if($reservation['total_paid'] == 0): ?>
                                <tr>
                                    <td><?php echo lang_check('Pay advance and reservation');?>, <?php echo number_format($reservation['total_price']*0.2, 2).' '.$reservation['currency_code']; ?></td>

                                    <?php if(config_db_item('payments_enabled') == 1 && !_empty(config_db_item('paypal_email'))): ?>
                                    <td><a href="<?php echo site_url('frontend/do_purchase/'.$this->data['lang_code'].'/'.$reservation['id'].'/'.number_format($reservation['total_price']*0.2, 2)); ?>"><img style="height:36px;" src="assets/img/pay-now-paypal.png" alt="paypal"/></a></td>
                                    <?php endif; ?>

                                </tr>
                                <?php endif; ?>
                                <?php if($reservation['total_paid'] < $reservation['total_price']): ?>
                                <tr>
                                    <td><?php echo lang_check('Pay total');?>, <?php echo number_format($reservation['total_price']-$reservation['total_paid'], 2).' '.$reservation['currency_code']; ?></td>
                                    <?php if(config_db_item('payments_enabled') == 1 && !_empty(config_db_item('paypal_email'))): ?>
                                    <td><a href="<?php echo site_url('frontend/do_purchase/'.$this->data['lang_code'].'/'.$reservation['id'].'/'.number_format($reservation['total_price']-$reservation['total_paid'], 2)); ?>"><img style="height:36px;" src="assets/img/pay-now-paypal.png" alt="paypal" /></a></td>
                                    <?php endif; ?>
                                </tr>
                                <?php endif; ?>
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

