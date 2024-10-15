 <?php
/*
Widget-title: Default content
Widget-preview-image: /assets/img/widgets_preview/bottom_defaultcontent.jpg
 */
?>

<?php if(!empty($page_body)):?>
<section class="section container container-palette section-body widget_edit_enabled">
    <div class="container">
        <div class="section-title slim">
            <h2 class="title">{page_title}</h2>
        </div>
        <div class="row-fluid">
            {page_body}
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
</section> <!-- /. page_body -->
<?php endif;?>