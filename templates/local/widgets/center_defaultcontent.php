 <?php
/*
Widget-title: Content
Widget-preview-image: /assets/img/widgets_preview/center_defaultcontent.jpg
 */
?>

<?php if(!empty($page_body)):?>
<div class="widget section-body widget_edit_enabled">
    <div class="clearfix">
        {page_body}
    </div>
    <script>

    $('document').ready(function(){
        $(".section-body p, .section-body br").each(function(){
            if( $.trim($(this).text()) == "" ){
                $(this).remove();
            }
        });
    })

    </script>
</div>

<?php endif;?>