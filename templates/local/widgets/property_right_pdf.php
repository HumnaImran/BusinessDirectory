<?php if(file_exists(APPPATH.'libraries/Pdf.php')) : ?>
<div class="widget widget-styles widget_edit_enabled">
    <h2 class="widget-title text-center content"><?php echo lang_check('Pdf Export');?></h2>
    <div class="content-box pt0">
        <a class='text-center block' href='<?php echo site_url('api/pdf_export/'.$property_id.'/'.$lang_code) ;?>'>
            <img src='assets/img/icons/filetype/pdf.png' alt="<?php echo lang_check('Pdf Export');?>"/>
        </a>
    </div>
</div>
<?php endif;?>