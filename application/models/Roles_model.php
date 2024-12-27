<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Roles_model extends CI_Model
{
    /**
     * This function is used to get the roles listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function rolesListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('roles');        
        if(!empty($searchText)) {
            $likeCriteria = "(role  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $query = $this->db->get();
        //echo $this->db->last_query();die;        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the role listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function rolesListing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('roles');        
        if(!empty($searchText)) {
            $likeCriteria = "(role  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('roleId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();        
        //echo $this->db->last_query();
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    
    
    /**
     * This function used to get role information by id
     * @param number $roleId : This is role id
     * @return array $result : This is user information
     */
    function getRolesInfo($roleId)
    {
        $this->db->select('*');
        $this->db->from('roles');        
        $this->db->where('roleId', $roleId);
        $query = $this->db->get();
        
        return $query->row_array();
    }
    
    
    /**
     * This function is used to update the role information
     * @param array $rolesInfo : This is roles updated information
     * @param number $roleId : This is role id
     */
    function editRoles($rolesInfo, $roleId)
    {
        $this->db->where('roleId', $roleId);
        $this->db->update('roles', $rolesInfo);
        
        return TRUE;
    }    
    
    
    /**
     * This function is used to delete the role information
     * @param number $roleId : This is role id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteRoles($roleId)
    {
      $this->db->where('roleId', $roleId);
      $this->db->delete('roles');

      return $this->db->affected_rows();

    }
    

}

  