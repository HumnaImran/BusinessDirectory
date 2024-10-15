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
        <main class="">
            <section class="section container container-palette">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <?php _widget('center_defaultcontent_border');?>
                            <div class="result agents-list row row-flex" id="gent-search">
                                <?php if(!empty($paginated_agents)):foreach($paginated_agents as $item):?>
                                <div class="col-md-4 col-sm-6 col-xs-12 listing_wrapper listing_wrapper_agents">
                                    <div class="agent_unit">
                                        <div class="agent-unit-img-wrapper">
                                            <a href="<?php  _che($item['agent_url']);?>">
                                                <img src="<?php echo _simg($item['image_url'], '375x285'); ?>" class="img-responsive wp-post-image" alt="<?php  _che($item['name_surname']);?>" /> 
                                            </a>
                                        </div>
                                        <div class="">
                                            <h4 class=""> 
                                                <a href="<?php  _che($item['agent_url']);?>"><?php  _che($item['name_surname']);?></a>
                                            </h4>
                                            <div class="agent_position"><?php  _che($item['address']);?></div>
                                            <div class="agent_detail"><i class="fa fa-phone"></i><?php  _che($item['phone']);?></div>
                                            <?php if(isset($item['phone2']) && !empty($item['phone2'])):?>
                                            <div class="agent_detail"><i class="fa fa-mobile"></i><?php  _che($item['phone2']);?></div>
                                            <?php endif;?>
                                            <div class="agent_detail"><i class="fa fa-envelope-o"></i><a href="mailto:<?php  _che($item['mail']);?>?subject=<?php echo rawurlencode(_ch($lang_Estateinqueryfor));?>:<?php echo rawurlencode(_ch($page_title));?>"><?php  _che($item['mail']);?></a></div>
                                            <div class="agent_detail"><i class="ion-ios-location"></i><?php  _che($item['address']);?></div> 
                                        </div>
                                        <div class="agent_unit_social agent_list">
                                            <div class="social-wrapper">
                                                <?php if(!empty($item['agent_profile']['facebook_link'])): ?>
                                                <a href="<?php echo $item['agent_profile']['facebook_link']; ?>"><i class="fa fa-facebook"></i></a>
                                                <?php endif; ?>
                                                <?php if(!empty($item['agent_profile']['youtube_link'])): ?>
                                                    <a href="<?php echo $item['agent_profile']['youtube_link']; ?>"><i class="fa fa-youtube"></i></a>
                                                <?php endif; ?>
                                                <?php if(!empty($item['agent_profile']['gplus_link'])): ?>
                                                    <a href="<?php echo $item['agent_profile']['gplus_link']; ?>"><i class="fa fa-google-plus"></i></a>
                                                <?php endif; ?>
                                                <?php if(!empty($item['agent_profile']['twitter_link'])): ?>
                                                    <a href="<?php echo $item['agent_profile']['twitter_link']; ?>"><i class="fa fa-twitter"></i></a>
                                                <?php endif; ?>
                                                <?php if(!empty($item['agent_profile']['linkedin_link'])): ?>
                                                    <a href="<?php echo $item['agent_profile']['linkedin_link']; ?>"><i class="fa fa-linkedin"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                <?php else:?>
                                    <div class="alert alert-success">
                                        <?php echo lang_check('Not available');?>
                                    </div>
                                <?php endif;?>
                                <nav class="text-center">
                                    <ul class="pagination">
                                        <?php echo $agents_pagination; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="widget widget-search">
                                <form  class="form-search agents widget-content" action="<?php echo current_url().'#gent-search'; ?>" method="get">
                                    <div class="input-group input-with-search color-primary clearfix">
                                        <input type="text" name="search-agent" value="<?php echo $this->input->get('search-agent'); ?>" class="form-control" placeholder="<?php _l('Search');?>">
                                        <button type="submit"  id="btn-search_showroom" class="input-group-addon"><i class="fa fa-search icon-white"></i></button>
                                    </div>
                                </form>
                            </div>
                            <?php _widget('right_lastproperties-slim');?>
                            <?php _widget('right_ads');?>
                        </div>
                    </div>
                </div>
            </section> <!-- /.section-category -->
            <?php _widget('bottom_imagegallery');?>
        </main>
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'default')); ?>
        <?php _widget('custom_popup');?>
        <?php _widget('custom_palette');?>
        <?php _widget('custom_javascript');?>
    </body>
</html>