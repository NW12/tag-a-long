<?php

/*
----------------------------
Site settings     ----    Model
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Site_settings_Model extends CI_Model {



    var $tbl = 'site_settings';



    public function __construct() {

        parent::__construct();

    }



//End __construct

    /**

     * Method: getRow

     * Params: $id

     * Return: data row

     */

    function getSettings() {

        $this->db->select('*');

        $this->db->from($this->tbl);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

    }



//End get_row

    /**

     * Method: saveItem

     * Params: $post

     * Return: True/False

     */

    public function saveItem($post, $image, $image_favicon) {

        $data_insert = array();

        if (is_array($post)) {

            foreach ($post as $k => $v) {

                $data_insert[$k] = $v;

            }

        }

        $img = $data_insert['old_logo'];

        if ($image <> '') {

            $data_insert['site_logo'] = $image;

            unlink('uploads/site/pic/' . $img);

            unset($data_insert['old_logo']);

        } else {

            unset($data_insert['logo']);

            unset($data_insert['old_logo']);

        }



        $favicon = $data_insert['old_favicon'];

        if ($image_favicon <> '') {

            $data_insert['favicon'] = $image_favicon;

            unlink('uploads/site/pic/' . $favicon);

            unset($data_insert['old_favicon']);

        } else {

            unset($data_insert['favicon']);

            unset($data_insert['old_favicon']);

        }





        $data_insert['site_keywords'] = $this->common->removeHtml($data_insert['site_keywords']);

        $data_insert['site_description'] = $this->common->removeHtml($data_insert['site_description']);

        $data_insert['site_name'] = $this->common->removeHtml($data_insert['site_name']);

        $data_insert['site_title'] = $this->common->removeHtml($data_insert['site_title']);





        unset($data_insert['id']);



        foreach ($data_insert as $key => $value) {

            $query = $this->db->query("select id from site_settings where option_name = '" . $key . "'");

            if ($query->num_rows() > 0) {

                $upData = array();

                $upData['option_value'] = $value;

                $this->db->where('option_name', $key);

                $this->db->update('site_settings', $upData);

            } else {

                $insData = array();

                $insData['option_name'] = $key;

                $insData['option_value'] = $value;

                $this->db->insert('setting', $insData);

            }

        }



        return 1;

    }



}



//End Class