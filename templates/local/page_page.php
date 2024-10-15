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
        <section class="section post-header container container-palette">
            <div class="container">
                <div class="post-title">
                    <h1 class="title">{page_title}</h1>
                </div>
                <div class="post-preview">
                    <?php if(isset($page_images) && !empty($page_images)):?>
                    <img src="<?php _che($page_images[0]->url);?>" alt="{page_title}" />
                    <?php endif;?>
                </div>
            </div>
        </section>
        <main class="main container container-palette">
            <div class="container container-palette">
                <div class="container">
                    <div class="post-content">
                        <div class="post-body">
                            {page_body}
                            {has_page_documents}
                            <h2><?php _l('Filerepository');?>{</h2>
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
            </div>
        </main>
        <?php _widget('bottom_imagegallery');?>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>