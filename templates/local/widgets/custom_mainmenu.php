<?php
if ( ! function_exists('get_menu_custom'))
{
//menu generate function
function get_menu_custom ($array, $child = FALSE, $lang_code='en')
{
       $CI =& get_instance();
       $str = '';

   $is_logged_user = ($CI->user_m->loggedin() == TRUE);

       if (sw_count($array)) {
           $str .= $child == FALSE ? '<ul class="nav navbar-nav nav-items default-menu" id="main-menu">' . PHP_EOL : '<ul class="dropdown-menu">' . PHP_EOL;
                               $position = 0;
               foreach ($array as $key=>$item) {
                       $position++;

           $active = $CI->uri->segment(2) == url_title_cro($item['id'], '-', TRUE) ? TRUE : FALSE;

           if($position == 1 && $child == FALSE){
               //$item['navigation_title'] = '<img src="assets/img/home-icon.png" alt="'.$item['navigation_title'].'" />';

               if($CI->uri->segment(2) == '')
                   $active = TRUE;
           }

           if($item['is_visible'] == '1')
           if(empty($item['is_private']) || $item['is_private'] == '1' && $is_logged_user)
                       if (isset($item['children']) && sw_count($item['children'])) {

               $href = slug_url($lang_code.'/'.$item['id'].'/'.url_title_cro($item['navigation_title'], '-', TRUE), 'page_m');
               if(substr($item['keywords'],0,4) == 'http')
                   $href = $item['keywords'];

               if(substr($item['keywords'],0,6) == 'search')
               {
                    $href = $href.'?'.$item['keywords'];
                    $href = str_replace('"', '%22', $href);
               }

                $target = '';
                if(substr($item['keywords'],0,4) == 'http')
                {
                    $href = $item['keywords'];
                    if(substr($item['keywords'],0,10) != substr(site_url(),0,10))
                    {
                        $target=' target="_blank"';
                    }
                }

               if($item['keywords'] == '#')
                   $href = '#';

                               $str .= $active ? '<li class="dropdown active">' : '<li class="dropdown">';
                               $str .= '<a href="' . $href . '" class="dropdown-toggle" data-toggle="dropdown" '.$target.'>' . $item['navigation_title'];
                               $str .= ' <span class="caret"></span></a>' . PHP_EOL;

                               $str .= get_menu_custom($item['children'], TRUE, $lang_code);
                       }
                       else {

               $href = slug_url($lang_code.'/'.$item['id'].'/'.url_title_cro($item['navigation_title'], '-', TRUE), 'page_m');
               if(substr($item['keywords'],0,4) == 'http')
                   $href = $item['keywords'];

               if(substr($item['keywords'],0,6) == 'search')
               {
                    $href = $href.'?'.$item['keywords'];
                    $href = str_replace('"', '%22', $href);
               }

               if(substr($item['keywords'],0,6) == 'search')
               {
                    $href = $href.'?'.$item['keywords'];
                    $href = str_replace('"', '%22', $href);
               }

                $target = '';
                if(substr($item['keywords'],0,4) == 'http')
                {
                    $href = $item['keywords'];
                    if(substr($item['keywords'],0,10) != substr(site_url(),0,10))
                    {
                        $target=' target="_blank"';
                    }
                }

                $target = '';
                if(stripos($item['keywords'], '%site_domain$s') !== FALSE)
                {
                    $item['keywords'] = str_replace('%site_domain$s', '', $item['keywords']);
                    $item['keywords'] = str_replace('/index.php', '', $item['keywords']);
                    $href = site_url($item['keywords']);
                }

               if($item['keywords'] == '#')
                   $href = '#';

                               $str .= $active ? '<li class="active">' : '<li>';
                               $str .= '<a href="' . $href . '" '.$target.'>' . $item['navigation_title'] . '</a>';

                               $str .= '</li>' . PHP_EOL;
                       }
               }

               $str .= '</ul>' . PHP_EOL;
       }

       return $str;
}
}
?>
<?php
   $CI =& get_instance();
   echo get_menu_custom($CI->temp_data['menu'], FALSE, $lang_code);
?>
