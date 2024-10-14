<footer class="footer container container-palette">
    <div class="footer-content section">
        <div class="container">
            <div class="row footer-results">
                <?php _widget('footer_logo');?>
                <?php _widget('footer_menu');?>
                <?php _widget('footer_topplaces');?>
                <?php _widget('footer_follow');?>
            </div>
        </div>
    </div>
    <div class="footer-bottom widget_edit">                
        {is_logged_other}
        <div class="widget-controls-panel">
            <a href="<?php echo site_url('admin/templatefiles/edit/default.php/footers');?>" target="_blank" class="btn btn-edit"><i class="ion-edit"></i></a>
        </div>
        {/is_logged_other}
        <div class="container">
            <span><?php echo lang_check('All Right reserved');?> &#169;<?php echo date('Y');?>.  <?php echo lang_check('Made in');?> <a href="http://iwinter.com.hr" target="_blank">Winter DEV</a></span>
        </div>
    </div>
</footer> <!-- /.footer -->