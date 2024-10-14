<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * 
 *  Address from gps for export was commented. If need address, plese uncomment "Address from gps" Line 659/*
 * 
 */


class Xml2u {
    
    /* list all option, witch use on site */
    protected $option_list;
    
    /* array id of langs, witchuse on sile */
    protected $langs_id;
    
    /* default lang code */
    protected $default_lang_code;
    protected $default_lang_id;
    
    /* options script*/
    private $options = array(
            'inline_file_types' => '/\.(gif|jpe?g|png)$/i',
            'max_properties_import' => '20',
    );
    
    private $dom;
    public $ajax_limit = 5;

    public function __construct() {
        
        /* add libraries and model */
        $this->CI = &get_instance();
        $this->CI->load->model('estate_m');
        $this->CI->load->model('option_m');
        $this->CI->load->model('file_m');
        $this->CI->load->model('language_m');
        $this->CI->load->model('repository_m');
        $this->CI->load->library('uploadHandler', array('initialize'=>FALSE));
        $this->CI->load->library('ghelper');
        
        
        /* class var */
        $this->option_list=$this->get_option_list();
        
        $this->langs_id=$this->CI->option_m->languages;
        
        $this->default_lang_code=$this->CI->language_m->get_default();
        $this->default_lang_id = $this->CI->language_m->get_default_id();
        $this->_count_key_skip = 0;
        $this->_count=0;
        $this->_count_skip=0;
        $this->output_mode = false;
    }
    
    
    /*
     * Start Import
     * 
     * @param string $file path and file name with csv
     * @param (string, int) $max_images, count of max images per property for import
     * 
     * @param boolen $developer_mode ignore $overwrite param
     * 
     * return array with id of new estate => address
     */
    public function import_process($file_data=null, $overwrite = FALSE, $google_gps = TRUE, $max_images=1, $limit = NULL, $user_id=NULL, $activated = TRUE, $developer_mode = FALSE) {
        $time_start = microtime(true);
        $max_exec_time = 120;
        if(config_item('max_exec_time'))
            $max_exec_time = config_item ('max_exec_time');

        //ini_set('max_execution_time', $max_exec_time);

        if(empty($file_data)) {
            return false;
        }

        
        $_count=0;
        $_count_skip=0;
        $_count_exists=0;
        $_count_exists_overwrite=0;
        $i = 0;
        $this->_count_all = sw_count($file_data);
        /* start add new estate */
        $info=array();
        foreach ($file_data as $key => $xml_property) {
            /* Offset */
            $this->_count_key = $key;
            if($this->_count_key_skip > $key) continue;
                     
            if($limit && (sw_count($info)-$_count_skip+1)>$limit) {
               break;
            }
            
            $id=NULL;
            $is_exists = false;
            $data=array();
            
            $time_end = microtime(true);
            $execution_time = $time_end - $time_start;
            if($execution_time>=$max_exec_time){
                // break import
                return array(
                    'info'=> $info,
                    'count_skip' => $this->_count_skip,
                    'count_exists_overwrite' => $_count_exists_overwrite,
                    'count_exists' => $_count_exists,
                    'message' => lang_check('max_exec_time reached, you can import again')
                );
            }
                                    
            if($limit && $this->_count >= $limit) {
                break;
            }    
            
            // if this estate exists
            //$developer_mode = true;
            if(!$developer_mode){
                if(!$overwrite){
                $id_transitions=trim(str_replace('-','', $this->get_XmlValue($xml_property, 'propertyid', '')));
                $query = $this->CI->db->get_where('property', array('id_transitions' =>$id_transitions));
                    if($query->row()) {
                    $this->_count++;
                    $this->_count_skip++;
                        $info[]=array(
                            'address'=> '<a target="_blank" href="'.slug_url('admin/estate/edit/'.$query->row()->id).'">#'.$this->get_XmlValue($xml_property, 'propertyid', '').', '.$query->row()->address.'</a> <span class="label label-danger">'.lang_check('Listing exists').'</span>',
                            'id'=> $this->get_XmlValue($xml_property, 'propertyid', ''),
                            'preview_id'=> $query->row()->id
                        );
                        continue;
                    }
                }

                // if overwright
                if($overwrite){
                    $id_transitions=trim(str_replace('-','', $this->get_XmlValue($xml_property, 'propertyid', '')));
                    $query = $this->CI->db->get_where('property', array('id_transitions' =>$id_transitions));
                     if($query->row()) {
                        $id=$query->row()->id;
                        $_count_exists_overwrite++;
                        $is_exists= true;
                        $data['repository_id'] = $query->row()->repository_id;
                     }
                }
            }
            /* main param */
            
            
            if(!$is_exists){
                $data["date"]= date('Y-m-d H:i:s');
                $data["date_modified"]= date('Y-m-d H:i:s');
            }
            
            // address
            $address= '';
            
            $xml_address = $this->get_XmlValue($xml_property, 'Address', '');
      
            if($xml_address){
                if($this->get_XmlValue($xml_address,'street'))
                    $address.= $this->get_XmlValue($xml_address,'street');
                
                if($this->get_XmlValue($xml_address,'number'))
                    $address.= $this->get_XmlValue($xml_address,'number');

                if($this->get_XmlValue($xml_address,'location'))
                    $address.= ', '.$this->get_XmlValue($xml_address,'location');
                if($this->get_XmlValue($xml_address,'region'))
                    $address.= ', '.$this->get_XmlValue($xml_address,'region');

                if($this->get_XmlValue($xml_address,'country'))
                    $address.= ', '.$this->get_XmlValue($xml_address,'country');
            }
            $address = trim($address, ',');
            
            /* address by Google API
            if(empty($address)) {
                $lat= $this->get_XmlValue($xml_address,'latitude');
                $lng= $this->get_XmlValue($xml_address,'longitude');
                if(!empty($lat) && !empty($lng)) {
                    if(@$json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng)) {
                        $json= json_decode($json);
                        if(isset($json->results[0]) and isset($json->results[0]->formatted_address))
                        $address = $json->results[0]->formatted_address;
                    }
                    sleep(1);
                }
            }*/
            
            $data["address"]=$address;                 
            
            $latitude = $this->get_XmlValue($xml_address,'latitude');
            $longitude =  $this->get_XmlValue($xml_address,'longitude');

            if(!empty($latitude) and !empty($longitude)) {
                $data["gps"]=$latitude.", ".$longitude;
            } else {
                if($google_gps){
                    // gps 
                    $gps = $this->CI->ghelper->getCoordinates($data["address"]);
                    $data["gps"]=$gps['lat'].", ".$gps['lng'];
                }
            }

            $data["is_featured"]= 0;
            $data["is_activated"]=((bool)$activated) ? '1' : '0';
            $data["id_transitions"]= str_replace('-','', $this->get_XmlValue($xml_property, 'propertyid', '')); 
            
            if($is_exists)
                $data["date_modified"]= date('Y-m-d H:i:s');
            
            //$data["date_activated"]= $data["date"];
            $data["type"]=NULL;
            
            $data['activation_paid_date']=NULL;
            $data['featured_paid_date']=NULL;
            /* end main param */ 
            
            // add options for property
            // dinamic option 
            $options_data= array();
            $options_data = $this->get_option($xml_property);
            
            if(empty($user_id))
                $options_data['agent']=$this->CI->session->userdata('id');
            else 
                $options_data['agent']= $user_id;
            /* skip */
            
            if(isset($options_data['field_error'])) {
                $this->_count++;
                $this->_count_skip++;
                $info[]=array(
                    'error'=> $options_data['field_error'],
                    'address'=> '',
                    'id'=> $this->get_XmlValue($xml_property, 'propertyid', '')
                );
                continue;
            }
            
            /* end skip */
            
            /* added new property */
            if(!$is_exists || !isset($data['repository_id']) || empty($data['repository_id'])){
                // Create repository only foor new listings
                $repository_id = $this->CI->repository_m->save(array('name'=>'estate_m'));
                // Update estate object with new repository_id
                $data['repository_id'] = $repository_id;
            } 
            
            $insert_id = $this->CI->estate_m->save($data, $id);  
            if(empty($insert_id))
            {
                echo 'QUERY: '.$this->CI->db->last_query();
                echo '<br />';
                echo 'ERROR: '.$this->CI->db->_error_message();
                exit();
            }
            
            $this->CI->estate_m->save_dynamic($options_data, $insert_id);
            
            /* end added new property */
            
            /* hot fix json_object = 0 */
            /*$result = $this->CI->db->get_where('property_lang', array('json_object' =>'0', 'property_id'=>$insert_id));
            if($result->row()){
                $this->CI->session->set_flashdata('error', 
                        lang_check('Not created json_object in property id = "'.$result->row()->property_id.'" '));
                redirect('admin/estate/import_xml2u');
                exit();
            }*/
            /* hot fix json_object = 0 */
            
            /* search values */ 
            $data['search_values'] ='id: '.$insert_id;
            $data['search_values'] .= ' '.$data['address'];
            foreach($options_data as $key=>$val)
            {
                $pos = strpos($key, '_');
                $option_id = substr($key, 6, $pos-6);
                $language_id = substr($key, $pos+1);
                
                if(!isset($options_type[$option_id]['TEXTAREA']) && !isset($options_type[$option_id]['CHECKBOX'])){
                   $data['search_values'].=' '.$val;
                }
                
                //  values for each language for selected checkbox
                if(isset($options_type[$option_id]['CHECKBOX'])){
                    if(!empty($val))
                    {
                        $data['search_values'].=' true'.$options_name[$option_id][$language_id];
                    }
                }
            }

            /* end search values */
                    
            /* Add file to repository */
            // upload foto;
            if(!$is_exists && !empty($this->get_XmlValue($xml_property, 'images', ''))) {
                $xml_images = $this->get_XmlValue($xml_property, 'images', '');
                if(!empty($xml_images)) {
                    $next_order=0;
                    foreach ($xml_images as $key => $xml_image) {
                        if($next_order >= $max_images) break;
                        $image_link = $this->get_XmlValue($xml_image, 'image');
                    
                        if(!empty($image_link) && $file_name = $this->do_upload_optimization(trim($image_link))){
                            $file_id = $this->CI->file_m->save(array(
                            'repository_id' => $data['repository_id'],
                            'order' => $next_order,
                            'filename' => $file_name,
                            'filetype' => 'image/jpeg'
                            )); 
                            $next_order++;
                        } 
                    }  
                }
            }
            /* create  image_repository and image_filename */
            
            // $repository_id
            $update_data = array();
            $update_data['search_values'] = $data['search_values'];
            $this->CI->estate_m->save($update_data, $insert_id);  
            // add options for property
            
            /* end create  image_repository and image_filename */
            
            /* end Add file to repository */
            $this->_count++;
            
            $info_address = $data["address"];
            if(empty($info_address) && isset($options_data['option10_'.$this->default_lang_id]))
                $info_address = $options_data['option10_'.$this->default_lang_id];
            
            if($is_exists)
                $info_address.= ' <span class="label label-danger">'.lang_check('overwritten').'</span>';
            
            $info[]=array(
                'address'=> '<a target="_blank" href="'.slug_url('admin/estate/edit/'.$insert_id).'">'.$info_address.'</a>',
                'id'=> $this->get_XmlValue($xml_property, 'propertyid', ''),
                'preview_id'=> $insert_id
            );
            if($this->output_mode)
                echo '<a target="_blank" href="'.slug_url('admin/estate/edit/'.$insert_id).'">'.$info_address.'</a>'.PHP_EOL;
        }
        
        /* end start add new estate */
        return array(
            'info'=> $info,
            'count_skip' => $this->_count_skip,
            'count_exists_overwrite' => $_count_exists_overwrite,
            'count_exists' => $_count_exists
        );
    }
    
    
    
    /*
     * Filter and add options with lang id
     * 
     * @param $options array array with options array(optin10=>value);
     * @return array current for all lang options;
     * 
     * for other lang just copy
     */    
    protected function get_option($xml_property){
        
        $options_data = $this->get_dynamicFields($xml_property);
        $options_prepared = array();
        
            foreach($this->option_list as $key=>$option) {
                $option_name=strtolower(trim($option['option']));
                
                /* only one lang 
                if($this->CI->language_m->get_default_id() !== $option["language_id"] ) continue;
                */
                
                $index_option='option'.$option["id"].'_'.$option["language_id"];
                
                /* check if value missing in dropdown */
                
                if($this->default_lang_id == $option["language_id"])
                    if($option['type'] == 'DROPDOWN' && isset($options_data['option'.$option["id"]])) {
                        $val= trim($options_data['option'.$option["id"]]);

                        if(!empty($val) && stripos($option['values'], $val)!==FALSE) {
                            $pos = stripos($option['values'], $val);
                            $options_data['option'.$option["id"]] = substr($option['values'], $pos, strlen($val));
                        } else if(!empty($val) && strrpos($option['values'], $val)===FALSE) {
                            /* add new value in field */ 
                            $field_data = $this->CI->option_m->get_lang_array($option["id"]);
                            $f_data_lang = array();
                            $f_data_lang['values'] =$field_data->{'values_'.$option["language_id"]} .','.$val;
                            $this->CI->db->set($f_data_lang);
                            $this->CI->db->where('option_id', $option["id"]);
                            $this->CI->db->where('language_id', $option["language_id"]);
                            $this->CI->db->update($this->CI->option_m->get_table_name().'_lang');
                            $options_data['option'.$option["id"]] = $val;

                            /* update array by new values */
                            $field_data = $this->CI->option_m->get_lang_array($option["id"]);
                            $values =$field_data->{'values_'.$option["language_id"]};
                            $this->option_list[$key]['values'] = $values;
                        }
                    }
                
                /* end check if value missing in dropdown */
                
                if(isset($options_data['option'.$option["id"]]))
                {
                    // php 5.3
                    $val = trim($options_data['option'.$option["id"]]);
                    if($option['type'] == 'TEXTAREA')
                        $options_prepared[$index_option]=$val;
                    else {
                        $val = str_replace("&amp;", "&", $val);
                        $options_prepared[$index_option]= strip_tags($val);
                    }
                  }
                else {
                    $options_prepared[$index_option]='';
                }
                
            }
        if(!empty($options_prepared)) {
            return $options_prepared;
        } else {
            return false;
        }
    }
    
    /*
     * parser Dynamic fields from xml property node
     * 
     * @param object $xml_property node <Property> from xml 
     * 
     * return fields with index from db
     */
    
    
    protected function get_dynamicFields($xml_property) {
        $options_data = array();
        
            // price
            $xml_price = $this->get_XmlValue($xml_property, 'Price', '');
            $options_data['option36']= $this->get_XmlValue($xml_price,'price');
            
            $xml_description =  $this->get_XmlValue($xml_property, 'Description', '');
            
            //category
            $options_data['option4'] = $this->get_XmlValue($xml_property,'category');
            
            //category
            $options_data['option64'] = $this->get_XmlValue($xml_property,'field_64');
            
            //category
            $options_data['option79'] = $this->get_XmlValue($xml_property,'field_79');
            
            //propertyType
            $options_data['option2'] = $this->get_XmlValue($xml_description,'propertyType');
            
            //bedrooms
            $options_data['option20'] = $this->get_XmlValue($xml_description,'bedrooms');
            
            //fullBathrooms
            $options_data['option19'] = $this->get_XmlValue($xml_description,'fullBathrooms');
            
            //rooms
            $options_data['option58'] = $this->get_XmlValue($xml_description,'rooms');
            
            //title
            $options_data['option10'] = $this->get_XmlValue($xml_description,'title');
            
            //shortDescription
            $options_data['option8'] = html_entity_decode($this->get_XmlContent($xml_description,'shortDescription'));
            
            //description
            $options_data['option17'] = html_entity_decode($this->get_XmlContent($xml_description,'description'));
            
            //floorNumber
            $options_data['option53'] = $this->get_XmlValue($xml_description,'floorNumber');
            
            //heating
            $heating = $this->get_XmlValue($xml_description,'heating');
            $options_data['option28'] = ($heating && $heating=='Yes') ? true : false;
            
            //elevator
            $balcony = $this->get_XmlValue($xml_description,'balcony');
            $options_data['option11'] = ($balcony && $balcony=='Yes') ? true : false;
            
            //swimmingPool
            $swimmingPool = $this->get_XmlValue($xml_description,'swimmingPool');
            $options_data['option33'] = ($swimmingPool && $swimmingPool=='Yes') ? true : false;
           
            //offRoadParking
            $offRoadParking = $this->get_XmlValue($xml_description, 'offRoadParking');
            $options_data['option32'] = ($offRoadParking && $offRoadParking=='Yes' || $offRoadParking >0 ) ? true : false;
            
            
            //FloorSize
            if($xml_description) {
                $xml_floorSize = $this->get_XmlValue($xml_description,'FloorSize');
                $options_data['option57'] = $this->get_XmlValue($xml_floorSize,'floorSize');
            }
            
            /* Start Company */
            $xml_ListingContact = $this->get_XmlValue($xml_property,'ListingContact');
            
            //companyName
            $options_data['option67'] = $this->get_XmlValue($xml_ListingContact,'companyName');
            
            //companyWebsite
            $options_data['option69'] = $this->get_XmlValue($xml_ListingContact,'companyWebsite');
            
            //agent1Phone
            $options_data['option68'] = $this->get_XmlValue($xml_ListingContact,'agent1Phone');
            
            //Company_descrioption
            
            $company_description= '';
            if($this->get_XmlValue($xml_ListingContact,'agent1FirstName'))
                $company_description.= 'Agent: '.$this->get_XmlValue($xml_ListingContact,'agent1FirstName').' '.$this->get_XmlValue($xml_ListingContact,'agent1LastName').'<br/>';
           
            if($this->get_XmlValue($xml_ListingContact,'agent1Email'))
                $company_description.= 'Email: '.$this->get_XmlValue($xml_ListingContact,'agent1Email').'<br/>';
            
            $company_description.= 'Address: '.$this->get_XmlValue($xml_ListingContact,'companyBuildingNameNumber').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyStreet').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyTownCity').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyRegion').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyPostcode').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyCountry').' '
                                    .'<br/>';
            
            $options_data['option72'] = $company_description;
            /* End Company */
            
        return $options_data;
    }
    
    protected function get_option_list () {
        /* table names */
        $_table_name = 'option';
        
        $this->CI->db->select($_table_name.'.*, '.$_table_name.'_lang.*, language.code');
        $this->CI->db->from($_table_name);
        $this->CI->db->join($_table_name.'_lang', $_table_name.'.id = '.$_table_name.'_lang.option_id');
        $this->CI->db->join('language', 'language.id = option_lang.language_id');
        $this->CI->db->order_by($_table_name.'.id');
        $array = $this->CI->db->get()->result_array();

        return $array;
        
    }
    
    /*
     * Upload image from link
     * 
     * @param string $file_link link with image
     * @return file name or false
     */
    protected function do_upload($file_link)
        {
            if(empty($file_link)) return false;
            
            $file_name=substr(strrchr($file_link, '/'), 1);
            $file_link=  str_replace($file_name, rawurlencode($file_name), $file_link);
            
            if(preg_match($this->options['inline_file_types'], $file_link) && $this->url_exists($file_link)) {
                $file=$this->file_get_contents_curl($file_link);
                $new_file_name=time().rand(000, 999).'.jpg';
                file_put_contents(FCPATH.'/files/'.$new_file_name, $file);
                /* create thumbnail */
                $this->CI->uploadhandler->regenerate_versions($new_file_name);
                /* end create thumbnail */
                return $new_file_name;
            } else {
                return false;
            }
        }
         protected function do_upload_optimization($file_link)
    {
        if(empty($file_link)) return false;

        /* commemt for optimization
        $file_name=substr(strrchr($file_link, '/'), 1);
        $file_link=  str_replace($file_name, rawurlencode($file_name), $file_link);*/

        if(!$this->url_exists($file_link)) return false;

        $file=$this->file_get_contents_curl($file_link);
        $data = getimagesizefromstring($file);

        if(!$data) return false;
        if(empty($data['mime'])) return false;

        $mime_type = $data['mime']; // [] if you don't have exif you could use getImageSize() 
        $allowedTypes = array( 
                        'image/gif',  // [] gif 
                        'image/pjpeg',  // [] jpg 
                        'image/jpeg',  // [] jpg 
                        'image/png',  // [] png 
                        'image/bmp'   // [] bmp 
        ); 				

        if (!in_array($mime_type, $allowedTypes)) { 
            return false; 
        } 

        switch($mime_type) {
            case 'image/gif': $type ='gif'; break;
            case 'image/pjpeg': $type ='jpg'; break;
            case 'image/jpeg': $type ='jpg'; break;
            case 'image/png': $type ='png'; break;
            case 'image/bmp': $type ='bmp'; break;
        }
        
        $new_file_name=time().rand(000, 999).'.'.$type;
        file_put_contents(FCPATH.'/files/'.$new_file_name, $file);
        /* create thumbnail */
        $this->CI->uploadhandler->regenerate_versions($new_file_name);
        /* end create thumbnail */
        return $new_file_name;
    }   
    /*
     * get Value from XML for name node
     * @parem $start_node object node xml where need searsh
     * @param $name_node string  name node where need get Value
     * 
     * @return string nodeValue or empty string
     */
    protected function get_XmlValue($start_node, $name_node, $default=FALSE){
        $node_value='';
        
        return (!empty($start_node[$name_node])) ? is_array($start_node[$name_node]) ? $start_node[$name_node] : strip_tags($start_node[$name_node]) : $default ;
    }
    
    protected function get_XmlContent($start_node, $name_node, $default=FALSE){
        $node_value='';
        
        return (!empty($start_node[$name_node])) ? $start_node[$name_node] : $default ;
    }
    
    function export($lang_code = 'en', $limit_properties=NULL, $offset_properties=0) {
        
        $options = $this->optionDetails();
           
        // Fetch settings
        $this->CI->load->model('settings_m');
        $settings = $this->CI->settings_m->get_fields();
        
        $lang_id = $this->CI->language_m->get_id($lang_code);
        $lang_name = $this->CI->language_m->get_name($lang_id);
        $this->CI->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$settings['template'].'/');
        
        
        $this->dom = new domDocument("1.0", "utf-8");
        $root = $this->dom->createElement("document");
        $this->dom->appendChild($root);
                
        /*FileDetails*/
        $FileDetails=$this->create_child($root, 'FileDetails');
        
        //orderName
        $content_node= '';
        if(isset($settings['websitetitle']))
            $content_node = $settings['websitetitle'];
        $this->create_childContent($FileDetails, 'orderName', $content_node);
        
        //fileFormat
        $this->create_childContent($FileDetails, 'fileFormat', 'XML2U Default - © 2009-2015 XML2U.com. All rights reserved. This xml structure may not be reproduced, displayed, modified or distributed without the express prior written permission of the copyright holder. For permission, contact copyright@xml2u.com');
        
        //sourceURL
        $this->create_childContent($FileDetails, 'sourceURL', site_url());
        
        /* end FileDetails*/
        
        //Client
        $Client =  $this->create_child($root, 'Client');
        
        /*ClientDetails*/
        $ClientDetails =  $this->create_child($Client, 'ClientDetails');
        
        //clientName
        $content_node= '';
        if(isset($settings['websitetitle']))
            $content_node = $settings['websitetitle'];
        $this->create_childContent($ClientDetails, 'clientName', $content_node);
        
        //clientContact
        $content_node= '';
        if(isset($settings['phone']))
            $content_node = $settings['phone'];
        $this->create_childContent($ClientDetails, 'clientContact', $content_node);
        
        //clientContactEmail
        $content_node= '';
        if(isset($settings['email']))
            $content_node = $settings['email'];
        $this->create_childContent($ClientDetails, 'clientContactEmail', $content_node);
        
        //clientTelephone
        $content_node= '';
        if(isset($settings['phone']))
            $content_node = $settings['phone'];
        $this->create_childContent($ClientDetails, 'clientTelephone', $content_node);
        /* end ClientDetails*/
        
        /* properties */
        $properties = $this->create_child($Client, 'properties');
        
        // Property
        
        $where = [];
        //$where['language_id']  = $lang_id;
       // $where['is_activated'] = 1;
        $allProperties = $this->CI->estate_m->get_by($where, false, $limit_properties, 'property.id DESC', $offset_properties, array(), NULL, FALSE, TRUE);

        //$allProperties= $this->get_allProperies();
        
        if(empty($allProperties)){
            exit('Missing Property for Export');
        } 
        
        foreach ($allProperties as $key => $value) {
            
            if(empty($value->json_object)) continue;
            
            /* special */
            $fields=json_decode($value->json_object);
            /* special */
            
            /* end special */
            
            //$properties root
            $property_root = $this->create_child($properties, 'Property');
            
            //propertyid
            $content_node= '';
            if(isset($value->id))
                $content_node = $value->id;
            $this->create_childContent($property_root, 'propertyid', $content_node);
            
            //lastUpdateDate
            $content_node= '';
            if(isset($value->date_modified))
                $content_node = $value->date_modified;
            $this->create_childContent($property_root, 'lastUpdateDate', $content_node);
            
            //category
            $content_node= '';
            if(isset($fields->field_4))
                $content_node = $fields->field_4;
            $this->create_childContent($property_root, 'category', $content_node);
            
            
                /* Address */
                $Address = $this->create_child($property_root, 'Address');
                
                /* Address from gps, uncomment if need parse address
                $maps_api_key = config_db_item('maps_api_key');
                $maps_api_key_prepare='';
                if(!empty($maps_api_key)){
                    $maps_api_key_prepare=$maps_api_key;
                }
                
                $lat = '';
                $lng = '';
                list($lat,$lng)=explode(',', $value->gps);
                
                if(!empty($lat) && !empty($lng)) {
                    if(@$json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&key='.$maps_api_key_prepare)) {
                        $json= json_decode($json);
                        if(isset($json->results[0]) and isset($json->results[0]->address_components)){
                            $address = $json->results[0]->address_components;

                            if(isset($address[0]->long_name))
                            $number = $address[0]->long_name;

                            if(isset($address[1]->long_name))
                            $street = $address[1]->long_name;

                            if(isset($address[5]->long_name))
                            $postcode = $address[5]->long_name;

                            if(isset($address[3]->long_name))
                            $location = $address[3]->long_name;

                            if(isset($address[2]->long_name))
                            $region = $address[2]->long_name;

                            if(isset($address[4]->long_name))
                            $country =$address[4]->long_name;
                        }
                    }
                   // sleep(1); // for google
                }*/
                
                //number
                $content_node= '';
                if(isset($number)){
                    $content_node= $number;
                }
                $this->create_childContent($Address, 'number', $content_node);

                //street
                $content_node= '';
                if(isset($street)){
                    $content_node= $street;
                }
                $this->create_childContent($Address, 'street', $content_node);

                //postcode
                $content_node= '';
                if(isset($postcode)){
                    $content_node= $postcode;
                }
                $this->create_childContent($Address, 'postcode', $content_node);

                //location
                $content_node= '';
                $location = htmlentities($value->address);
                if(isset($location)){
                    $content_node= $location;
                }
                $this->create_childContent($Address, 'location', $content_node);

                //subRegion
                $content_node= '';
                if(isset($subRegion)){
                    $content_node= $subRegion;
                }
                $this->create_childContent($Address, 'subRegion', $content_node);

                //region
                $content_node= '';
                if(isset($region)){
                    $content_node= $region;
                }
                $this->create_childContent($Address, 'region', $content_node);

                //country
                $content_node= '';
                if(isset($country)){
                    $content_node= $country;
                }
                $this->create_childContent($Address, 'country', $content_node);

                //countryCodeISO3166-1-alpha2
                $content_node= '';
                $this->create_childContent($Address, 'countryCodeISO3166-1-alpha2', $content_node);

                //countryCodeISO3166-1-numeric
                $content_node= '';
                $this->create_childContent($Address, 'countryCodeISO3166-1-numeric', $content_node);

                //countryCodeISO3166-1-alpha3
                $content_node= '';
                $this->create_childContent($Address, 'countryCodeISO3166-1-alpha3', $content_node);

                //latitude
                $content_node= '';
                if(isset($value->lat))
                    $content_node = $value->lat;
                $this->create_childContent($Address, 'latitude', $content_node);
                
                //
                $content_node= '';
                if(isset($value->lng))
                    $content_node = $value->lng;
                $this->create_childContent($Address, 'longitude', $content_node);
                
            /* End Address */
            
            /* Price */
                $Price = $this->create_child($property_root, 'Price');
                
                //prefix
                $content_node= '';
                if(isset($options['options_prefix_36']))
                    $content_node = $options['options_prefix_36'];
                
                if(empty($content_node)) {
                    $content_node = $options['options_suffix_36'];
                }
                
                $this->create_childContent($Price, 'prefix', $content_node);
                
                //price
                
                $_price = '';
                if(!empty($fields->field_36)) 
                    $_price=$fields->field_36;
                if(!empty($fields->field_37)) 
                    $_price=$fields->field_37;
                
                $this->create_childContent($Price, 'price', $_price);
                
                //pricerange
                $content_node= '';
                $this->create_childContent($Price, 'pricerange', $content_node);
                
                //currency
                $content_node= '';
                $this->create_childContent($Price, 'currency', $content_node);
                
                //frequency
                $content_node= '';
                $this->create_childContent($Price, 'frequency', $content_node);
                
                //RentalBond
                $content_node= '';
                $this->create_childContent($Price, 'RentalBond', $content_node);
                
                //RentalAdminFee
                $content_node= '';
                $this->create_childContent($Price, 'RentalAdminFee', $content_node);
                
                //availableDate
                $content_node= '';
                $this->create_childContent($Price, 'availableDate', $content_node);
                
                //status
                $content_node= '';
                $this->create_childContent($Price, 'status', $content_node);
                
                //reference
                $content_node= '';
                $this->create_childContent($Price, 'reference', $content_node);
                
                //MlsId
                $content_node= '';
                $this->create_childContent($Price, 'MlsId', $content_node);
                
            /* End Price */
            
            /* Description */
                $Description = $this->create_child($property_root, 'Description');
                
                //propertyType
                $content_node= '';
                if(isset($fields->field_2))
                    $content_node = $fields->field_2;
                $this->create_childContent($Description, 'propertyType', $content_node);
                
                //Tenure
                $content_node= '';
                $this->create_childContent($Description, 'Tenure', $content_node);
                
                //tenanted
                $content_node= '';
                $this->create_childContent($Description, 'tenanted', $content_node);
                
                //bedrooms
                $content_node= '';
                if(isset($fields->field_20))
                    $content_node = $fields->field_20;
                $this->create_childContent($Description, 'bedrooms', $content_node);
                
                //bedroomRange
                $content_node= '';
                $this->create_childContent($Description, 'bedroomRange', $content_node);
                
                //sleeps
                $content_node= '';
                $this->create_childContent($Description, 'sleeps', $content_node);
                
                //fullBathrooms
                $content_node= '';
                if(isset($fields->field_19))
                    $content_node = $fields->field_19;
                $this->create_childContent($Description, 'fullBathrooms', $content_node);
                
                //halfBathrooms
                $content_node= '';
                $this->create_childContent($Description, 'halfBathrooms', $content_node);
                
                //rooms
                $content_node= '';
                if(isset($fields->field_58))
                    $content_node = $fields->field_58;
                $this->create_childContent($Description, 'rooms', $content_node);
                
                //receptionRooms
                $content_node= '';
                $this->create_childContent($Description, 'receptionRooms', $content_node);
                
                //furnishings
                $content_node= '';
                $this->create_childContent($Description, 'furnishings', $content_node);
                
                
                //title
                $content_node= '';
                if(isset($fields->field_10))
                    $content_node = $fields->field_10;
                $this->create_childContent($Description, 'title', $content_node);
                
                //shortDescription
                $content_node= '';
                if(isset($fields->field_8))
                    $content_node = $fields->field_8;
                
                $shortDescription = $this->create_childContent($Description, 'shortDescription');
                $shortDescription->appendChild($this->dom->createCDATASection(htmlentities($content_node))) ;
                 
                //description
                $content_node= '';
                if(isset($fields->field_17))
                    $content_node = $fields->field_17;
                
                $fullDescription = $this->create_childContent($Description, 'description');
                $fullDescription->appendChild($this->dom->createCDATASection(htmlentities($content_node))) ;
                
                //newBuild
                $content_node= '';
                $this->create_childContent($Description, 'newBuild', $content_node);
                
                //yearBuilt
                $content_node= '';
                $this->create_childContent($Description, 'yearBuilt', $content_node);
                
                //numberOfFloors
                $content_node= '';
                $this->create_childContent($Description, 'numberOfFloors', $content_node);
                
                //floorNumber
                $content_node= '';
                if(isset($fields->field_53))
                    $content_node = $fields->field_53;
                $this->create_childContent($Description, 'floorNumber', $content_node);
                
                //condition
                $content_node= '';
                if(isset($fields->field_53))
                    $content_node = (!empty($fields->field_53)) ? 'Yes' : '';
                $this->create_childContent($Description, 'condition', $content_node);
                
                //heating 
                $content_node= '';
                if(isset($fields->field_53))
                    $content_node = (!empty($fields->field_53)) ? '1' : '';
                $this->create_childContent($Description, 'heating', $content_node);
                
                //elevator 
                $content_node= '';
                if(isset($fields->field_30))
                    $content_node = (!empty($fields->field_30)) ? 'Yes' : '';
                $this->create_childContent($Description, 'elevator', $content_node);
                
                //fittedKitchen
                $content_node= '';
                $this->create_childContent($Description, 'fittedKitchen', $content_node);
                
                //assistedLiving
                $content_node= '';
                $this->create_childContent($Description, 'assistedLiving', $content_node);
                
                //wheelchairFriendly
                $content_node= '';
                $this->create_childContent($Description, 'wheelchairFriendly', $content_node);
                
                //balcony 
                $content_node= '';
                if(isset($fields->field_11))
                    $content_node = (!empty($fields->field_11)) ? 'Yes' : '';
                $this->create_childContent($Description, 'balcony', $content_node);
                
                //terrace
                $content_node= '';
                $this->create_childContent($Description, 'terrace', $content_node);
                
                //swimmingPool 
                $content_node= '';
                if(isset($fields->field_33))
                    $content_node = (!empty($fields->field_33)) ? 'Yes' : '';
                $this->create_childContent($Description, 'swimmingPool', $content_node);
                
                //orientation
                $content_node= '';
                $this->create_childContent($Description, 'orientation', $content_node);
                
                //garages 
                $content_node= '';
                $this->create_childContent($Description, 'garages', $content_node);
                
                //offRoadParking 
                $content_node= '';
                if(isset($fields->field_32))
                    $content_node = (!empty($fields->field_32)) ? 'Yes' : '';
                $this->create_childContent($Description, 'offRoadParking', $content_node);
                
                //carports
                $content_node= '';
                $this->create_childContent($Description, 'carports', $content_node);
                
                //openhouses
                $content_node= '';
                $this->create_childContent($Description, 'openhouses', $content_node);
                
                //auctionTime
                $content_node= '';
                $this->create_childContent($Description, 'auctionTime', $content_node);
                
                //auctionPlace
                $content_node= '';
                $this->create_childContent($Description, 'auctionPlace', $content_node);
                
                //FloorSize
                $content_node= '';
                $_floorSize=$this->create_child($Description, 'FloorSize');
                
                
                    //floorSize
                    $content_node= '';
                    if(isset($fields->field_57))
                        $content_node = $fields->field_57;
                    $this->create_childContent($_floorSize, 'floorSize', $content_node);
                    
                    $content_node= '';
                    $this->create_childContent($_floorSize, 'floorSizeUnits', $content_node);
                    
                //plotSize
                $content_node= '';
                $PlotSize=$this->create_child($Description, 'PlotSize');
                
                    //floorSize
                    $content_node= '';
                    $this->create_childContent($PlotSize, 'plotSize', $content_node);

                    $content_node= '';
                    $this->create_childContent($PlotSize, 'plotSizeUnits', $content_node);
                    
                /* Features  */
                    
                $content_node= '';
                $Features=$this->create_child($Description, 'Features'); 

                    $content_node= '';
                    $this->create_childContent($Features, 'Feature1', $content_node);
                    
                /* end Features  */
                
                    
                /* IMAGES */
                    //images
                    $content_node= '';
                    $images_root=$this->create_child($property_root, 'images'); 

                    $images = json_decode($value->image_repository);
                    if(!empty($images)){
                        foreach ($images as $key => $img) {

                            // image
                            $image_node = $this->dom->createElement('image');
                            $image_node->setAttribute("number", $key);
                            $images_root->appendChild($image_node); 

                            // image link
                            $image_link = $this->dom->createElement('image',  base_url('files/'.$img));
                            $image_node->appendChild($image_link);
                        }
                    }
                /*  End IMAGES */
                
                /* link */
                
                //link
                    $link = $this->create_child($property_root, 'link');

                    //dataSource
                    $href= slug_url('property/'.$value->id.'/'.$lang_code.'/'.url_title_cro($fields->field_10, '-', TRUE), 'page_m');
                    $this->create_childContent($link, 'dataSource', $href);
                    
                    //map
                    $this->create_childContent($link, 'map', '');
                    
                    //localInfo
                    $this->create_childContent($link, 'localInfo');
                    
                    //video
                    $content_node= '';
                    if(isset($fields->field_42))
                        $content_node = $fields->field_42;
                    $this->create_childContent($link, 'video', $content_node);
                    
                    //map
                    $content_node= '';
                    $this->create_childContent($link, 'virtualTour', $content_node);
                    
                    //map
                    $pdf_link= '';
                    if(file_exists(APPPATH.'libraries/Pdf.php')) {
                        $pdf_link = slug_url('api/pdf_export/'.$value->id.'/'.$lang_code);
                    }
                    $this->create_childContent($link, 'pdf', $pdf_link);
                    
                /* End link */
                    
                /* spareFields skipp */    
                /* end spareFields skipp */    
                    
                /* ListingContact */
                 
                $ListingContact_root = $this->create_child($property_root, 'ListingContact');
                    
                    //companyName
                    $content_node= '';
                    if(isset($fields->field_67))
                        $content_node = $fields->field_67;
                    $this->create_childContent($ListingContact_root, 'companyName', $content_node);
                    
                    //companyWebsite
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyOffice', $content_node);
                    
                    //companyBuildingNameNumber
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyBuildingNameNumber', $content_node);
                    
                    //companyName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyStreet', $content_node);
                    
                    //companyName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyTownCity', $content_node);
                    
                    //companyName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyRegion', $content_node);
                    
                    //companyPostcode
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyPostcode', $content_node);
                    
                    //companyCountry
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyCountry', $content_node);
                    
                    //companyWebsite
                    $content_node= '';
                    if(isset($fields->field_69))
                        $content_node = $fields->field_69;
                    $this->create_childContent($ListingContact_root, 'companyWebsite', $content_node);
                    
                    //companyLogo
                    $content_node= '';
                    if(isset($fields->field_74))
                        $content_node = $fields->field_74;
                    $this->create_childContent($ListingContact_root, 'companyLogo', $content_node);
                    
                    //agent1FirstName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'agent1FirstName', $content_node);
                    
                    //agent1LastName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'agent1LastName', $content_node);
                    
                    //agent1Phone
                    $content_node= '';
                    if(isset($fields->field_68))
                        $content_node = $fields->field_68;
                    $this->create_childContent($ListingContact_root, 'agent1Phone', $content_node);
                    
                    //agent1Email
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'agent1Email', $content_node);
               
                /* End ListingContact */
                
            /* EndDescription */
                    
           // break;
        }
        /* end properties */
        
        /* get the xml printed */
        
        return $this->dom->saveXML();
        
    }
    
    /*
     * get All properties + property_lang + language.code
     * return array
     */
    protected function get_allProperies ($lang_id =NULL) {
        if($lang_id ===NULL)
            $lang_id = $this->default_lang_id;
            
        $property=$this->CI->db->select('property.*, property_lang.*, language.code',FALSE);
        //$property=$this->CI->db->select('property.*, property_lang.*',FALSE);
        $this->CI->db->join('property_lang', 'property.id=property_lang.property_id');
        $this->CI->db->join('language', 'language.id=property_lang.language_id','left');
        $property=$this->CI->db->where('property_lang.language_id =', $lang_id);
        $this->CI->db->order_by('id', 'asc');
        $property=$property->get('property');
        
        return $property->result();
    }
    
    
    /*
     * createElement dom element
     * @param (object) $parent parent dom node
     * @param (string) $new_tag name tag
     * @param (string) $content content text
     * 
     * return( object) new dom Element
     * 
     */
    protected function create_childContent($parent, $new_tag, $content=NULL) {
        if($content===NULL) $content ='';
        $new_node = $this->dom->createElement($new_tag, htmlspecialchars($content));
        $parent->appendChild($new_node);
        return $new_node;
    }
    
    /*
     * createElement dom element without content
     * @param (object) $parent parent dom node
     * @param (string) $new_tag name tag
     * 
     * return( object) new dom Element
     */
    protected function create_child($parent, $new_tag) {
        
        $new_node = $this->dom->createElement($new_tag);
        $parent->appendChild($new_node);
        return $new_node;
    }
    
    
    function optionDetails () {
        $options_names = $this->CI->option_m->get_lang(NULL, FALSE, $this->default_lang_id );
        
        $options = array();
        
        foreach($options_names as $key=>$row)
        {
            $options['options_name_'.$row->option_id] = $row->option;
            $options['options_suffix_'.$row->option_id] = $row->suffix;
            $options['options_prefix_'.$row->option_id] = $row->prefix;
            $options['options_values_'.$row->option_id] = $row->values;
            $options['options_type_'.$row->option_id] = $row->type;
        }
        
        return $options;
    }
    
    public function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set cURL to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    
    function url_exists($url) {
        $handle   = curl_init($url);
        if (false === $handle)
        {
                return false;
        }

        curl_setopt($handle, CURLOPT_HEADER, false);
        curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
        curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
        $connectable = curl_exec($handle);
        ##print $connectable;
        curl_close($handle);
        if($connectable){
            return true;
        }
        return false;
    }
    
    protected function xmlstr_to_array($xmlstr) {
        $doc = new DOMDocument();
        
        if ( !@$doc->loadXML($xmlstr) ) {
            return false;
        }
        
        $root = $doc->documentElement;
        $output = $this->domnode_to_array($root);
        $output['@root'] = $root->tagName;
        return $output;
    }
    
    protected function domnode_to_array($node) {
        $output = array();
        switch ($node->nodeType) {
          case XML_CDATA_SECTION_NODE:
          case XML_TEXT_NODE:
            $output = trim($node->textContent);
          break;
          case XML_ELEMENT_NODE:
            for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
              $child = $node->childNodes->item($i);
              $v = $this->domnode_to_array($child);
              if(isset($child->tagName)) {
                $t = $child->tagName;
                if(!isset($output[$t])) {
                  $output[$t] = array();
                }
                $output[$t][] = $v;
              }
              elseif($v || $v === '0') {
                $output = (string) $v;
              }
            }
            if($node->attributes->length && !is_array($output)) { //Has attributes but isn't an array
              $output = array('@content'=>$output); //Change output into an array.
            }
            if(is_array($output)) {
              if($node->attributes->length) {
                $a = array();
                foreach($node->attributes as $attrName => $attrNode) {
                  $a[$attrName] = (string) $attrNode->value;
                }
                $output['@attributes'] = $a;
              }
              foreach ($output as $t => $v) {
                if(is_array($v) && count($v)==1 && $t!='@attributes') {
                  $output[$t] = $v[0];
                }
              }
            }
          break;
        }
        return $output;
    }
        
        
    /*
     * Start Import
     * 
     * @param string $file path and file name with csv
     * return array with id of new estate => address
     */
    public function import($file=null, $overwrite = FALSE, $max_images = 1, $google_gps = FALSE, $limit = 10, $ajax = false) {
        $time_start = microtime(true);
        $this->time_start = $time_start;
        
        if(empty($file)) {
            return false;
        }
        $content = $this->xmlstr_to_array($this->file_get_contents_curl($file));
        
        if(empty($content) || !isset($content["Client"]["properties"])) 
            return false;
        
        if($ajax) {
            $new_file_name='importxml_'.time().rand(000, 999).'.data';
            file_put_contents(FCPATH.'/files/'.$new_file_name, base64_encode(serialize($content["Client"]["properties"]['Property'])));
            
            return array(
                'file_name'=>$new_file_name,
                'listings'=>sw_count($content["Client"]["properties"]['Property'])
            );                    
        }
        
        $this->_count_key=0;
        $this->_count=0;
        $this->_count_skip=0;
       
        /* start add new estate */
        if(!$ajax) {
            $this->output_mode = true;
            return $this->import_process($content["Client"]["properties"]['Property'], $overwrite, $google_gps, $max_images,  $limit);
        }
        
    }
    
    public function ajax_import ( $import_ini = false, $file=null, $overwrite = FALSE, $max_images = 1, $google_gps = FALSE, $offset = 0, $user_id = 1, $activated = 1) {
        
        if($import_ini) {
            $data_output = $this->import($file, $overwrite, $max_images , $google_gps, FALSE, $ajax_import = TRUE);
            $this->_count_key_skip = $offset;
            return $data_output;
        } else {
            $this->_count_key_skip = $offset;
            $this->_count=0;
            $this->_count_skip=0;
            $new_file_name = $file;
            $csv_t = file_get_contents(FCPATH.'/files/'.$new_file_name);
            $csv_t = unserialize(base64_decode($csv_t));
            
            $data_output = $this->import_process($csv_t, $overwrite, $max_images, $google_gps, $this->ajax_limit, $user_id, $activated);
            $data_output['count_key'] = $this->_count_key;
            $data_output['count_all'] = $this->_count_all;
            return $data_output;
        }
    }
}