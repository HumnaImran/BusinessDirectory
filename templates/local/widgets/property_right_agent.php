{has_agent}
<div class="widget-styles agent-box widget_edit_enabled">
    <div class="content">
        <div class="preview-image"><a href="{agent_url}">
                <?php if(strripos($agent_name_surname, 'user-agent.png') === FALSE):?>
                    <img src="<?php echo _simg($agent_image_url, "133x133");?>" alt="<?php  _che($agent_name_surname);?>" />
                <?php else:?>
                    <img src="{agent_image_url}" alt="<?php  _che($agent_name_surname);?>" />
                <?php endif;?>
            </a>
        </div>
        <div class="content-box">
            <h2 class="title"><a href="{agent_url}" title='<?php  _che($agent_name_surname);?>'><?php  _che($agent_name_surname);?></a></h2>
            <div class="description">{agent_phone}</div>
            <div class="description">{agent_address}</div>
            <a href="mailto:<?php  _che($agent_mail);?>?subject=<?php _l('Estateinqueryfor');?>: {estate_data_id}, {page_title}" title="<?php  _che($agent_mail);?>" class="btn btn-custom btn-custom-secondary btn-wide"><i class="ion-email"></i></a>
        </div>
    </div>
</div>
{/has_agent}
