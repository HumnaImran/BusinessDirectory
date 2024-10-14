 <?php
/*
Widget-title: Default content with border
Widget-preview-image: /assets/img/widgets_preview/center_defaultcontent_border.jpg
 */
?>

<?php if(!empty($page_body)):?>
<div class="section container container-palette section-body pbr0 widget_edit_enabled">
    <div class="container">
        <div class="widget widget-styles widget-center_defaultcontent_border">
            <div class="content-box">
                {page_body}
            </div>
        </div>
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
</div> <!-- /. page_body -->
<?php endif;?>