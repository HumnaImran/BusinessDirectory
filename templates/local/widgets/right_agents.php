 <?php
/*
Widget-title: Agents
Widget-preview-image: /assets/img/widgets_preview/right_agents.jpg
 */
?>


<div class="widget widget-other-location widget_edit_enabled">
    <h2 class="widget-title content t-left"><?php echo lang_check('Agents'); ?></h2>
    <div class="content">
         <?php foreach($paginated_agents as $item): ?>
        <div class="location-box">
            <a href="<?php echo $item['agent_url']; ?>" title="<?php echo _ch($item['name_surname']); ?>" class="preview-image image-cover-div object-fit-container compat-object-fit">
                <img src="<?php echo _simg($item['image_url'], '250x250'); ?>" alt="<?php echo _ch($item['name_surname']); ?>">
            </a>
            <div class="location-box-content">
                <h3 class="title"><a href="<?php echo $item['agent_url']; ?>" title="<?php echo _ch($item['name_surname']); ?>"><?php echo _ch($item['name_surname']); ?></a></h3>
                <div class="types">
                    <?php  _che($item['phone']);?>
                </div>
                <div class="types">
                    <a href="mailto:<?php  _che($item['mail']);?>" title="<?php  _che($item['mail']);?>"><?php  _che($item['mail']);?></a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>