<?php

/*
----------------------------
Login     ----    Model
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Login_Model extends CI_Model {

    var $tbl = 'admin_users';

    public function __construct() {

        parent::__construct();

    }

//End __construct

    /**

     * Method: ajaxLogin

     * params: $_POST

     * Retruns:

     */

    public function ajaxLogin($email, $password) {

        $password = md5($password);

        $this->db->select('id,role_id,user_name,first_name,full_name,last_name,email,profile_image');

        $this->db->where('is_active', 1);

        $this->db->where('email', $email);

        $this->db->where('password', $password);

        $this->db->limit(1);

        $qry = $this->db->get($this->tbl);

        if ($qry->num_rows() > 0) {

            foreach ($qry->result() as $result) {

                $user_id = $result->id;

                $role_id = $result->role_id;

                $user_name = $result->user_name;

                $first_name = $result->first_name;

                $last_name = $result->last_name;

                $full_name = ucwords($result->full_name);

                $photo = $result->profile_image;

                $email = $result->email;

            }

            $this->session->set_userdata(array(

                'user_id' => $user_id,

                'role_id' => $role_id,

                'user_name' => $user_name,

                'first_name' => $first_name,

                'last_name' => $last_name,

                'email' => $email,

                'full_name' => $full_name,

                'photo' => $photo,

                'user_is_logged_in' => 1,



                'is_admin' => TRUE

                    )

            );

            return true;

        } else {

            return false;

        }

    }

}

//End Class