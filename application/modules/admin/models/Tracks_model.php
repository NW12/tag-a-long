<?php

/*
----------------------------
Tracks     ----    Model
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Tracks_model extends CI_Model {



    var $tbl = 'tracks';

    var $tbl_roles = 'admin_roles';



    public function __construct() {

        parent::__construct();

    }



//End __construct

    // Common Functions

    public function loadListing() {

        $sql_ = "SELECT * FROM tracks ";



        $sql_ .= "ORDER BY id DESC";

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

        

        if ($image <> '') {

            $data_insert['file_name'] = $image;

            unset($data_insert['old_file_name']);

        } else {

            if($data_insert['old_file_name'] != '')

            $data_insert['file_name'] = $data_insert['old_file_name'];

            else

            unset($data_insert['file_name']);

            unset($data_insert['old_file_name']);

        }



        if ($post['action'] == 'add') {//Save Data

            

            $data_insert['created_date'] = date('Y-m-d H:i:s');

            return $this->db->insert($this->tbl, $data_insert);

        } else {//Update Data

            $this->db->where('id', $id);

            return $this->db->update($this->tbl, $data_insert);

        }

    }



   



}



//End Class