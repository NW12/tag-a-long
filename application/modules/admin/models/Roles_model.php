<?php
/*
----------------------------
Roles     ----    Model
----------------------------
*/


if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Roles_model extends CI_Model {



    var $tbl = 'admin_users';

    var $tbl_roles = 'admin_roles';

    var $tbl_rights = 'admin_rights';

    var $tbl_permission = 'admin_permissions';



    public function __construct() {

        parent::__construct();

    }



//End __construct

    // Common Functions

    public function loadListing() {

        $sql_ = "SELECT

                    role.*

                FROM

                    " . $this->tbl_roles . " role where id != '0'";



        $sql_ .= "ORDER BY id DESC";

        $query = $this->db->query($sql_);

        return $query;

    }



    function getRow($id) {



        $query = "SELECT roles.`id`, GROUP_CONCAT(right_id) AS right_ids, roles.`role`,roles.status "

                . " FROM " . $this->tbl_roles . " roles "

                . " JOIN `admin_permissions` ON `admin_permissions`.`role_id` = `roles`.`id` "

                . " WHERE roles.`id` =  " . $id;

        $query = $this->db->query($query);



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

        $data_insert = array('status' => $status);

        $this->db->where('id', $itemId);

        $this->db->update($this->tbl_roles, $data_insert);

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

        $this->db->where('role_id', $itemId);

        $this->db->delete($this->tbl_permission);



        $this->db->where('id', $itemId);

        $this->db->delete($this->tbl_roles);

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

    public function saveItem($post) {



        $id = $post['role_id'];

        $data_insert = array();

        $data_insert['role'] = $post['role'];

        //var_dump($post); die();

        if ($post['action'] == 'add') {//Save Data

            $db = $this->db->insert($this->tbl_roles, $data_insert);

            $insert_id = $this->db->insert_id();

            $data_permission = array();

            unset($post['role']);

            unset($post['role_id']);

            unset($post['action']);

            foreach ($post as $key => $value) {

                $data_permission['role_id'] = $insert_id;

                $data_permission ['right_id'] = $key;

                $this->db->insert($this->tbl_permission, $data_permission);

            }

            return $db;

        } else {//Update Data

            $this->db->where('id', $id);

            $db = $this->db->update($this->tbl_roles, $data_insert);



            $this->db->where('role_id', $id);

            $this->db->delete($this->tbl_permission);



            $data_permission = array();

            unset($post['role']);

            unset($post['role_id']);

            unset($post['action']);

            unset($post['status']);

            

            foreach ($post as $key => $value) {

                $data_permission['role_id'] = $id;

                $data_permission ['right_id'] = $key;

                

                $this->db->insert($this->tbl_permission, $data_permission);

            }

           

            return $db;

        }

    }



    function rights() {

        $this->db->select('admin_rights.*');

        $this->db->select('admin_modules.module');

        $this->db->join('admin_modules', 'admin_modules.id = admin_rights.module_id', 'left');

        $this->db->where('admin_rights.status', 1);

        $this->db->order_by("admin_modules.id", "asc");

        $this->db->order_by("admin_rights.id", "asc");

        $query = $this->db->get('admin_rights');

        return $query->result_array();

    }



}



//End Class