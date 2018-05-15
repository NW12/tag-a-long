<?php

/*
----------------------------
home     ----    model
----------------------------
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    var $tbl_users = 'users';
    

    public function __construct() {
        parent::__construct();
    }

//End __construct

    /**
     * Method: insert
     * Return: id
     */
    function create($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * Method: update
     * Return:
     */
    function update($table, $data, $where) {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }

    /**
     * Method: delete
     * Return:
     */
    function delete($table, $where) {
        $this->db->where($where);
        return $this->db->delete($table);
    }
    
    
    function isUserInactive($user_id){
        $query = " SELECT  *
                     FROM users  AS u
                     WHERE u.user_id  = " . $user_id . " ";
        $result = $this->db->query($query);
        $resultArray = $result->row_array();
        if ($resultArray['is_active'] == 0){
            return 1;
        }
        else if ($resultArray['is_active'] == 1){
            return 0;
        } 
    }
    
      /**
     * Method: get_user_data
     * Params: $user_id
     * Return: array
     */
    function get_user_data($user_id) {
        $query = " SELECT
                u.user_id,
                u.name,
                u.email,
                u.phone_no,
                u.avatar,
                u.fb_url,
                u.tw_url,
                u.soundcloud_url,
                u.web_url,
                u.cover_photo,
                u.is_verified

            FROM " . $this->db->dbprefix($this->tbl_users) . " AS u
            WHERE u.is_active = 1 AND  u.user_id = " . $user_id . " limit 1 ";
        
           $result = $this->db->query($query);

//        if ($result->num_rows() > 0) {
        $results = $result->row_array();
        if ($results['avatar'] <> '') {
            $results['avatar'] = $results['avatar'];
        }
        return $results;
//        }
    }
    
    
}

//End Class