<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Fcm_model extends CI_Model{ 

    public function sendNotication($IDS,$Message,$redirect){
        //$c = [];
        //$IDSList = array($IDS);
        $IDSList = explode(",",$IDS);
        $this->db->select('fcm_tokens');
        $this->db->from('tbl_driver_fcm_tokens');
        $this->db->where_in('DriverID', $IDSList);
        $query = $this->db->get();
        $fcm_tokens = $query->result();		$all_tokens = array();
        foreach($fcm_tokens as $fcm_token){
            $all_tokens[] = $fcm_token->fcm_tokens;
        }
        $all_tokens = array_unique($all_tokens);
        //Notification
           
            //$all_tokens = ['ehgcRyw1S6i1ffZsw97HSJ:APA91bG30aEee7hM4cpW85hqt289cNSxom4bP8faSt0J2v6i89n3WPFQ4J7Iq7LmYBvCs6MTWahRUC_tBZi2krkddZ-9GCLXmmVRo_rIZM23yfKT9b_jRkDOrlF-nTYxurF5NoOigUxs'];
    
            
                $noti_count1 = 1;
                
                define('API_ACCESS_KEY', 'AAAA_PfFzeA:APA91bH21a0glveSarZfnMAlEuwMwZWfi2J0dbGt4tkpSWh14FIf5MBvL-3o4vTYyWoA4_U57YVRpjheVr5684INx579WxbD7SPohuv6WMLiDbgv8f8TjhtGSv-YLl23Fk-aw94OzMAY');
                        $msg = array(
                        'body' => $Message,
                        'title' => 'TML broadcast',
                        // 'time' => $current_time,
                        'sound' => 'default',
                        'priority' => 'high',
                        'vibrate' => 3,
                        'page' => 'message',
                        'click_action' => $redirect, //message , noti
                        "content_available" => true);
                        $fields = array(
                            'registration_ids' => $all_tokens,
                            'data' => $msg,
                            "content_available" => true
                            );
                        $headers = array(
                        'Authorization: key=' . API_ACCESS_KEY,
                        'Content-Type: application/json'
                        );
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                        $result = curl_exec($ch);
                        //echo $result;
                        curl_close($ch);
            
        
        
        return $result;

	}

 
}

  