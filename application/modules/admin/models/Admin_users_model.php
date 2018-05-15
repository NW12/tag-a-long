<?php


/*
----------------------------
ADMIN USERS     ----    Model
----------------------------
*/


if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Admin_users_model extends CI_Model {



    var $tbl = 'admin_users';



    public function __construct() {

        parent::__construct();

    }



    public function loadListing() {

        $this->db->SELECT('*');

        $this->db->from('admin_users');

        $this->db->where("role_id !=", '0');

        $query = $this->db->get();

//

//        $perpage = 10; //global_setting('perpage');

//        $offset = 0;

//        $total_records = $query->num_rows();

//        init_admin_pagination('admin/admin_users/index', $total_records, $perpage);

//        $sql_ .= "ORDER BY id DESC";

//        $sql_ .= " LIMIT " . $offset . ", " . $perpage . "";

        //echo $this->db->last_query();

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

    }



    public function saveItem($post, $image) {

        $id = $post['id'];

        $data_insert = array();

        if (is_array($post)) {

            foreach ($post as $k => $v) {

                if ($k != 'id' && $k != 'action') {

                    $data_insert[$k] = $v;

                }

            }

        }

        if ($data_insert['password'] <> '') {

//            $data_insert['orginal_password'] = trim($data_insert['password']);

            $data_insert['password'] = md5(trim($data_insert['password']));

//            unset($data_insert['con_password']);

        } else {

            unset($data_insert['password']);

        }



        if ($image <> '') {

            $data_insert['profile_image'] = $image;



            unset($data_insert['old_photo']);

        } else {

            if ($data_insert['old_photo'] != '')

                $data_insert['profile_image'] = $data_insert['old_photo'];

            else

                unset($data_insert['photo']);

            unset($data_insert['old_photo']);

        }



        if ($post['action'] == 'add') {//Save Data

            $data_insert['created_date'] = date("Y-m-d h:i:sa");

            return $this->db->insert('admin_users', $data_insert);

        } else {//Update Data

            $this->db->where('id', $id);

            return $this->db->update('admin_users', $data_insert);

        }

    }



    function getRow($id) {

        $query = $this->db->get_where('admin_users', array('id' => $id));

        if ($query->num_rows() > 0) {

            return $query->row_array();

        }

    }



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



    function deleteItem($id) {

        $this->db->where('id', $id);

        $query = $this->db->delete('admin_users');



        if ($query) {

            return true;

        }

    }



}

