<?php

/*
----------------------------
USERS     ----    Model
----------------------------
*/


if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Users_model extends CI_Model {



    var $tbl = 'users';

    var $tbl_roles = 'admin_roles';



    public function __construct() {

        parent::__construct();

    }



//End __construct

    // Common Functions

    public function loadListing() {

        $sql_ = "SELECT * FROM users ";



        $sql_ .= "ORDER BY user_id DESC";

        $query = $this->db->query($sql_);

        return $query;

    }



    function getRow($id) {

        $query = $this->db->get_where($this->tbl, array('id' => $id));

        if ($query->num_rows() > 0) {

            return $query->row_array();

        }

    }



    /**

     * Method: updateItemStatus

     * Params: $itemId, $status

     */

    public function updateItemStatus($itemId, $status) {

        if ($status == 1) {

            $status = 0;

        } else {

            $status = 1;

        }

        $data_insert = array('is_active' => $status);

        $this->db->where('id', $itemId);

        $this->db->update($this->tbl, $data_insert);

        $action = 'Status updated successfully. Please wait...';

        $msg = $action;

        return $msg;

    }



    /**

     * Method: deleteItem

     * Params: $itemId

     * Return: True/False

     */

    public function deleteItem($itemId) {

        $this->db->where('id', $itemId);

        $this->db->delete($this->tbl);

        $error = $this->db->error();

        if ($error['code'] <> 0) {

            return false;

        } else {

            return true;

        }

    }



    /**

     * Method: saveItem

     * Params: $post

     * Return: True/False

     */

    public function saveItem($post, $image) {

        

      

        $id = $post['user_id'];

        $data_insert = array();

        if (is_array($post)) {

            foreach ($post as $k => $v) {

                if ($k != 'user_id' && $k != 'action') {

                    $data_insert[$k] = $v;

                }

            }

        }

        

        if ($data_insert['password'] <> '') {

            $data_insert['password'] = md5(trim($data_insert['password']));

        }



        if ($image <> '') {

            $data_insert['profile_image'] = $image;

            unset($data_insert['old_profile_image']);

        } else {

            if($data_insert['old_profile_image'] != '')

            $data_insert['profile_image'] = $data_insert['old_profile_image'];

            else

            unset($data_insert['profile_image']);

            unset($data_insert['old_profile_image']);

        }



        if ($post['action'] == 'add') {//Save Data

            

            $data_insert['connected_by'] = 0;

            $data_insert['created_date'] = date('Y-m-d H:i:s');

            return $this->db->insert($this->tbl, $data_insert);

        } else {//Update Data

            $data_insert['updated_at'] = date('Y-m-d H:i:s');

            $this->db->where('id', $id);

            return $this->db->update($this->tbl, $data_insert);

        }

    }



    function get_roles() {

        $this->db->select("role_id,role");

        $this->db->from($this->db->dbprefix . $this->tbl_roles);

        $this->db->order_by("role", "ASC");

        $this->db->where('role_id <>', '0');

        $this->db->where('status', '1');

        $query = $this->db->get();

        return $query->result_array();

    }



    /**

     * Method: checkEmail

     * Return: 0/1

     */

    function checkEmail($email) {



        $sql_ = "SELECT email FROM " . $this->tbl . " WHERE email = '" . $email . "'";

        $query = $this->db->query($sql_);

        if ($query->num_rows() >= 1) {

            return 1;

        } else {

            return 0;

        }

    }

    function checkUsername($username) {



        $sql_ = "SELECT username FROM " . $this->tbl . " WHERE username = '" . $username . "'";

        $query = $this->db->query($sql_);

        if ($query->num_rows() >= 1) {

            return 1;

        } else {

            return 0;

        }

    }



}



//End Class