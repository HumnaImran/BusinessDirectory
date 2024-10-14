<footer class="footer container container-palette bg-first widget_edit">
    {is_logged_other}
    <div class="widget-controls-panel">
        <a href="<?php echo site_url('admin/templatefiles/edit/default.php/footers');?>" target="_blank" class="btn btn-edit"><i class="ion-edit"></i></a>
    </div>
    {/is_logged_other}
    <div class="container clearfix footer-inner-slim">
        <div class="copyright">
            <?php echo lang_check('All Right reserved');?> &#169;<?php echo date('Y');?>.  <?php echo lang_check('Made in');?> <a href="http://iwinter.com.hr" target="_blank">Winter DEV</a>
        </div>
        <div class="social">
            <ul class="list-social">
                <li><a href="https://www.facebook.com/share.php?u={homepage_url_lang}&amp;title={settings_websitetitle}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="facebook"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://twitter.com/intent/tweet?text={homepage_url_lang}"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="twitter"><i class="fa fa-twitter"></i></a></li>
                <li><a href="http://pinterest.com/pin/create/button/?url={homepage_url_lang}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="twitter"><i class="fa fa-pinterest-p"></i></a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={homepage_url_lang}&title{settings_websitetitle}=&summary=&source=" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
</footer><!-- /.footer -->