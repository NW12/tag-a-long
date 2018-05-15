<?php

/*
----------------------------
Pages     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Pages extends CI_Controller {



    public function __construct() {

        parent::__construct();

//        error_reporting(E_ALL);

        // check if admin login

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

        // Check rights

        if (rights(28) != true ) {

            redirect(base_url('admin/dashboard'));

        }

        $this->load->model('pages_model');

    }



// End __construct

    /**

      @Method: index

      @Return: vehicles Listing

     */

    public function index() {

        $data['result'] = $this->pages_model->loadListing();

//        $data['pagination'] = $this->pagination->create_links();

        $data ['content'] = $this->load->view('pages/listing', $data, true);

        $this->load->view('templete-view', $data);

    }



    /**

     * Method: add

     * Return: Load Add Form

     */

    public function add() {

        $data = array();

       

        if ($this->input->post()) {

            $db_query = $this->pages_model->saveItem($_POST);



            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/pages'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        } 

// Check rights

        if (rights(29) != true ) {

            redirect(base_url('admin/dashboard'));

        }



        $data['action'] = 'add';

        $data["allpages"] = $this->pages_model->get_main_pages();

        $data ['content'] = $this->load->view('pages/form', $data, true); //Return View as data

        $this->load->view('templete-view', $data);

    }



    /**

     * Method: edit

     * Return: Load Edit Form

     */

    public function edit($id) {

        // Check rights

        if (rights(30) != true ) {

            redirect(base_url('admin/dashboard'));

        }

        $itemId = $this->common->decode($id);

        $data['id'] = $itemId;

        $data['row'] = $this->pages_model->getRow($itemId);

        $data['action'] = 'edit';

        $data["allpages"] = $this->pages_model->get_main_pages();

        $data ['content'] = $this->load->view('pages/form', $data, true); //Return View as data

        $this->load->view('templete-view', $data);

    }



    /**

      @Method: delete

      @Params: itemId

      @Retrun: True/False

     */

    public function delete($id) {

        // Check rights

        if (rights(31) != true ) {

            redirect(base_url('admin/dashboard'));

        }

        $itemId = $this->common->decode($id);

        $result = $this->pages_model->deleteItem($itemId);

        if ($result) {

            $this->session->set_flashdata('success_message', 'Record deleted successfully.');

            redirect('admin/pages'); // due to flash data.

        } else {

            $this->session->set_flashdata('error_message', 'Opps! Error occured while deleting record. Please try again.');

        }

    }



    /**

     * Method: ajaxChangeStatus

     *

     */

    public function ajaxChangeStatus() {

        $itemId = $_POST['itemId'];

        $status = $_POST['status'];

        $result = $this->pages_model->updateItemStatus($itemId, $status);

        echo $result;

    }





    /**

     * Method: Check Page & create Slug

     *

     */

    public function checkPage() {

        $data = array();

        $slug = $this->input->post('slug');

        $name = $this->pages_model->checkPage($slug);

        if ($name == 0) {

            $page_name = preg_replace('~[^\\pL\d]+~u', '-', trim($slug));

            $page_name = trim($page_name, '-');

            $page_name = iconv('utf-8', 'us-ascii//TRANSLIT', $page_name);

            $page_name = strtolower($page_name);

            $page_name = preg_replace('~[^-\w]+~', '', $page_name);

            $pageTitle = $this->pages_model->checkPage($page_name);

            if ($pageTitle == 1) {

                $data ['slug'] = $page_name . strtotime(date("Y-m-d H:i:s"));

            } else

                $data ['slug'] = $page_name;

        } else {

            $data ['slug'] = 1;

        }

        echo $data ['slug'];

        exit;

    }





}



//End Class