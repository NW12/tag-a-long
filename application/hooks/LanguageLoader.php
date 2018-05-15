<?php
class LanguageLoader {

    function initialize() {
        $ci = & get_instance();
        $ci->load->helper('language');
        
        $langer = $ci->uri->segment(1);
        if($langer == 'en' || $langer == 'ar'){
            if($langer == 'en'){
                $ci->session->set_userdata('language',1);
            }else{
                $ci->session->set_userdata('language',2);
            }
        }

        $site_lang = $ci->session->userdata('language');
        if($site_lang == 2){
            $site_lang = 'arabic';
        }else{
            $site_lang = 'english';
        }
        if ($site_lang) {
            $ci->lang->load($site_lang, $site_lang);
        } else {
            $ci->lang->load('english', 'english');
        }
    }

}
