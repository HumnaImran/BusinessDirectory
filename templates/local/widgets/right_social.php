 <?php
/*
Widget-title: Social Media
Widget-preview-image: /assets/img/widgets_preview/right_social.jpg
 */
?>

<div class="widget-styles widget-social widget_edit_enabled">
    <h2 class="widget-title content-box t-left"><?php echo lang_check('Social Media');?></h2>
    <div class="content-box pt0">
       <ul class="social-list">
            <li><a href="https://www.facebook.com/share.php?u={homepage_url_lang}&amp;title={settings_websitetitle}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/intent/tweet?text={homepage_url_lang}"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a></li>
            <li><a href="http://pinterest.com/pin/create/button/?url={homepage_url_lang}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-pinterest"></i></a></li>
            <li><a href="mailto:{settings_email}"><i class="fa fa-envelope"></i></a></li>
        </ul>
    </div>
</div>