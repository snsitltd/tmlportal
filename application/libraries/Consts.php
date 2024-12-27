<?php
class Consts
{
    private $CI;
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->setConstants();
    }
    private function setConstants()
    {
        $query = $this->CI->db->get('content_settings');

        $val = $query->row();
        
        define('WEB_PAGE_TITLE',$val->title);
        define('WEB_PAGE_SUBTITLE',$val->subtitle);
        define('WEB_PAGE_VERSION',$val->version);
        define('WEB_PAGE_LOGO',$val->logo);

        
        return ;
    }
}