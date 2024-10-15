<?php if(file_exists(APPPATH.'controllers/admin/booking.php') && sw_count($property_rates)>0):?>

<div class="widget-styles widget_edit_enabled">
    <div class="header content t-left">
       <h2><?php echo lang_check('Rates');?></h2>
    </div>
<div class="content-box">
<table class="table table-striped">
    <thead>
    <tr>
    <th><?php _l('From');?></th>
    <th><?php _l('To');?></th>
    <th><?php _l('Nightly');?></th>
    <th><?php _l('Weekly');?></th>
    <th><?php _l('Monthly');?></th>
    <th><?php _l('MinStay');?></th>
    <th><?php _l('ChangeoverDay');?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($property_rates as $key=>$rate): ?>
    <tr>
    <td><?php echo date('Y-m-d', strtotime($rate->date_from)); ?></td>
    <td><?php echo date('Y-m-d', strtotime($rate->date_to)); ?></td>
    <td><?php echo $rate->rate_nightly.' '.$rate->currency_code; ?></td>
    <td><?php echo $rate->rate_weekly.' '.$rate->currency_code; ?></td>
    <td><?php echo $rate->rate_monthly.' '.$rate->currency_code; ?></td>
    <td><?php echo $rate->min_stay; ?></td>
    <td><?php echo $changeover_days[$rate->changeover_day]; ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<div class="caption-title t-left content">
   <h2><?php _l('AvailabilityCalender');?></h2>
</div>
<div class="content-box">
<div class="av_calender row-flex">
<?php
    $row_break=0;

    foreach($months_availability as $v_month)
    {
        echo '<div class="month_container col-sm-4">'.$v_month.'</div>';

        $row_break++;
        //if($row_break%3 == 0)
        //echo '<div style="clear: both;height:10px;"></div>';
    }
?>
<br style="clear: both;" />
</div>
</div> 
</div> 
<?php endif;?>