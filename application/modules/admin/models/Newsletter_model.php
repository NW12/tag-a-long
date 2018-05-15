<?php

/*
----------------------------
newsletter     ----    Model
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class newsletter_model extends CI_Model {

    var $tbl = 'users_companies';

    public function __construct() {

        parent::__construct();

    }

//End __construct

 // Common Functions

    public function loadListing() {

        $sql_ = 'SELECT  *

            FROM(

            (SELECT

                    company_id as id,

            company_name,

            phone,

            email,

            newsletter_subscriber,

            "0" as type

                FROM

                    ' . $this->db->dbprefix . $this->tbl . '

                where newsletter_subscriber = 1)

                UNION (

               SELECT

              newsletter_id as  id,

              "" as company_name,

              "" as phone,

              email as email,

              "" as newsletter_subscriber,

              "1" as type

from  c_newlettter_subscribers

))reslut

		';



        $sql_.= " ORDER BY id DESC ";

        $query = $this->db->query($sql_);

        return $query;

    }

    function get_all_active_email_template ($email_type)

    {

	    $this->db->select("*");

        $this->db->from('c_email_templates');

	$this->db->where('email_template_type', $email_type);

        $query = $this->db->get();

        return $query->row_array();

    }

    public function loadAllSubscribers() {

        $sql_ = 'SELECT  *

            FROM(

            (SELECT

                    company_id as id,

            company_name,

            phone,

            email,

            newsletter_subscriber,

            "0" as type

                FROM

                    ' . $this->db->dbprefix . $this->tbl . '

                where newsletter_subscriber = 1)

                UNION (

               SELECT

              newsletter_id as  Id,

              "" as company_name,

              "" as phone,

              email as email,

              "" as newsletter_subscriber,

              "1" as type

from  c_newlettter_subscribers

))reslut

        ORDER BY company_name DESC

		';

        $query = $this->db->query($sql_);

        return $query;

    }

     /**

     * Method: updateItemStatus

     * Params: $itemId, $status

     */

    public function updateItemStatus($itemId, $status) {

        $data_insert = array('newsletter_subscriber' => $status);

        $this->db->where('company_id', $itemId);

        $this->db->update($this->tbl, $data_insert);

        $action = 'Status updated successfully. Please wait...';

        $msg = $action;

        return $msg;

    }

     /**

     * Method: deleteNewsLetter

     * Params: $itemId

     * Return: True/False

     */

    public function deleteNewsLetter($itemId) {

        $this->db->where('newsletter_id', $itemId);

        $this->db->delete('c_newlettter_subscribers');

        $error =$this->db->error();

        if ($error['code'] <> 0) {

            return false;

        } else {

            return true;

        }

    }

   /**

     * Method: getNewsletter Data

     * Params: $id

     * Return: data row

     */

    function getNewsletterData($id) {

        $query = $this->db->get_where('c_newlettter_subscribers', array('newsletter_id' => $id));

        if ($query->num_rows() > 0) {

            return $query->row_array();

        }

    }

}

//End Class