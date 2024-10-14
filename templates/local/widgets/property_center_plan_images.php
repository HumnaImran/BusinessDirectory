<?php
/*  The Gallery as lightbox dialog, should be a child element of the document body 
*    use css/blueimp-gallery.min.css
*    use js/blueimp-gallery.min.js
*    use config assets/js/realsite.js
*   site https://github.com/blueimp/Gallery/blob/master/README.md#setup
*/
?>

<?php
//Fetch repository
$file_rep = array();

if(!empty($estate_data_option_65) && is_numeric($estate_data_option_65)){
    $rep_id = $estate_data_option_65;
    $file_rep = $this->file_m->get_by(array('repository_id'=>$rep_id));
}

// If not defined in this language
if(sw_count($file_rep) == 0)
{
    //Fetch option for default language
    $def_lang_id = $this->language_m->get_default_id();
    if(!empty($def_lang_id))
    {
        $def_lang_rep_id = $this->option_m->get_property_value($def_lang_id, $estate_data_id, 65);

        if(!empty($def_lang_rep_id))
        $file_rep = $this->file_m->get_by(array('repository_id'=>$def_lang_rep_id));
    }
}

$rep_value = '';
if(sw_count($file_rep))
{
    echo '<div class="widget-styles images-gallery widget_edit_enabled">';
    echo '<div class="header content t-left">';
    echo '<h2>'.$options_name_65.'</h2>';
    echo '</div>';
    
    $rep_value.= '<div class="content-box"> ';
    foreach($file_rep as $file_r)
    {
        if(file_exists(FCPATH.'/files/thumbnail/'.$file_r->filename))
        {
            $rep_value.=
            '<div class="col-sm-6 col-md-3">'.
            '   <div class="card card-gallery">'.
            '    <a target="_blank" href="'.base_url('files/'.$file_r->filename).'" title="'.$file_r->filename.'" download="'.base_url('files/'.$file_r->filename).'" class="preview show-icon direct-download">'.
            '        <img src="'.base_url('files/thumbnail/'.$file_r->filename).'" data-src="'.base_url('files/'.$file_r->filename).'" alt="'.$file_r->filename.'" class="" />'.
            '    </a>'.
            '    </div>'.
            '</div>';
        }
        else if(file_exists(FCPATH.'/templates/'.$settings_template.'/assets/img/icons/filetype/'.get_file_extension($file_r->filename).'.png'))
        {
            $rep_value.=
            '<div class="col-sm-6 col-md-3">'.
            '   <div class="card card-gallery type-file">'.
            '    <a target="_blank" href="'.base_url('files/'.$file_r->filename).'" title="'.$file_r->filename.'" download="'.base_url('files/'.$file_r->filename).'" class="preview show-icon direct-download">'.
            '        <img src="assets/img/icons/filetype/'.get_file_extension($file_r->filename).'.png" data-src="'.base_url('files/'.$file_r->filename).'" alt="'.$file_r->filename.'" class="" />'.
            '    </a>'.
            '    </div>'.
            '</div>';
        }
    }
    $rep_value.= '</div>';

    echo $rep_value;
    echo '</div>';
}
?>