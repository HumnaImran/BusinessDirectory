<footer class="footer container container-palette bg-first widget_edit">
    {is_logged_other}
    <div class="widget-controls-panel">
        <a href="<?php echo site_url('admin/templatefiles/edit/default.php/footers');?>" target="_blank" class="btn btn-edit"><i class="ion-edit"></i></a>
    </div>
    {/is_logged_other}
    <div class="footer-bottom">
        <div class="container">
            <span> <?php echo lang_check('All Right reserved');?> &#169;<?php echo date('Y');?>.  <?php echo lang_check('Made in');?> <a href="http://iwinter.com.hr" target="_blank">Winter DEV</a></span>
        </div>
    </div>
</footer>