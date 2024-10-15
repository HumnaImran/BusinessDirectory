 <?php
/*
Widget-title: Follow
Widget-preview-image: /assets/img/widgets_preview/footer_follow.jpg
 */
?>

<div class="col-md-3 col-sm-6 f-box widget_edit_enabled">
                    <div class="title"><?php echo lang_check('Follow Us');?></div>
                    <ul class="list-social">
                        <li><a href="https://www.facebook.com/share.php?u={homepage_url_lang}&amp;title={settings_websitetitle}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/intent/tweet?text={homepage_url_lang}"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="http://pinterest.com/pin/create/button/?url={homepage_url_lang}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="twitter"><i class="fa fa-pinterest-p"></i></a></li>
                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={homepage_url_lang}&title{settings_websitetitle}=&summary=&source=" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>