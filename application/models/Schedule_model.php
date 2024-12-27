<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model
{
        
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function contactsListing()
    {
        $this->db->select('c.*, u.name');
        $this->db->from('contacts as c');
        $this->db->join('users as u', 'u.userId = c.CreateUserID'); 
        $this->db->order_by('c.ContactID', 'DESC');
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    } 


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function getContactInformation($id)
    {
        
        $this->db->select('con.*,com.*');
        $this->db->from('contacts con');
        $this->db->join('company_to_contact  ctc','ctc.ContactID=con.ContactID');
        $this->db->join('company com','com.CompanyID=ctc.CompanyID');        
        $this->db->where("con.ContactID", $id);  
        $query=$this->db->get();
        //echo $this->db->last_query();
       return $query->row_array();

    }
 
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function getContactlist($CompanyID)
    {
        
        $this->db->select('con.*');
        $this->db->from('contacts con');
        $this->db->join('company_to_contact  ctc','ctc.ContactID=con.ContactID');               
        $this->db->where("ctc.CompanyID", $CompanyID);  
        $query=$this->db->get();
        //echo $this->db->last_query();
       return $query->result_array();

    }
 
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewContacts($contactInfo)
    {
        $this->db->trans_start();
        $this->db->insert('contacts', $contactInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

      /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function relationWithContact($rel)
    {
        $this->db->trans_start();
        $this->db->insert('company_to_contact', $rel);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }     

}

  