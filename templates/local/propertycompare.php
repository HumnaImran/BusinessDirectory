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
        <main class="main section container container-palette">
            <div class="container">
                <div class="widget widget-styles">
                     <div class="content-box">
                        <?php if(isset($property_compare['address'])&&sw_count($property_compare['address'])>0):?>
                        <table class="table table-bordered  table-hover table-compare">
                            <thead>
                                <th></th>
                                <?php $i=1; foreach ($property_compare['url']['values'] as $k => $val):?>
                                <th>
                                    <a href='<?php _che($val); ?>'><?php echo lang_check('Estate');?>  <?php echo $i;?></a>
                                </th>
                                <?php $i++; endforeach; ?>
                            </thead>

                            <tr>
                                <?php _che($property_compare['address']['tr']);?>
                            </tr>
                            <tr>
                                <?php _che($property_compare['agent_name']['tr']);?>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo lang_check('Image');?>
                                </td>
                                <?php foreach ($property_compare['thumbnail_url']['values'] as $k => $val):?>
                                <td style="text-align:center">
                                    <img src='<?php echo _simg($val, '150x100')?>' alt="<?php echo basename($val);?>"/>
                                </td>
                                <?php endforeach; ?>
                            </tr>

                            <?php 
                            // options fetch
                            foreach ($property_compare as $field_key => $values):
                            ?>
                            <?php if(!preg_match('/^option_/', $field_key)) continue;?>
                            <?php if(isset($values['empty'])&&$values['empty']!==false) continue;?>
                            <?php /*video skip*/ if($field_key=='option_12') continue;?>
                            <tr>
                                <?php _che($values['tr']);?>
                            </tr>
                            <?php endforeach; ?>

                            <tr>
                                <td>
                                </td>
                                <?php foreach ($property_compare['url']['values'] as $k => $val):?>
                                <td>
                                    <a class="btn btn-info" href='<?php _che($val); ?>'> <?php echo lang_check('open property');?></a>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                        <?php endif;?>
                     </div>
                 </div> 
            </div>
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'slim')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>