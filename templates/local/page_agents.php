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
        <?php _widget('top_title');?>
        <main class="main section  container container-palette">
            <div class="container">
                <div class="widget widget-styles">
                     <div class="content-box">
                         {page_body}
                         {has_page_documents}
                         <h5><?php _l('Filerepository');?>{</h5>
                         <ul>
                         {page_documents}
                         <li>
                             <a href="{url}">{filename}</a>
                         </li>
                         {/page_documents}
                         </ul>
                         {/has_page_documents}
                     </div>
                 </div> 
            </div>
            <?php _widget('bottom_imagegallery');?>
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>