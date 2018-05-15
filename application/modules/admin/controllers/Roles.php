<?php

/*
----------------------------
Roles     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Roles extends CI_Controller {



    public function __construct() {

        parent::__construct();

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

        $this->engineinit->_is_not_super_admin_redirect('admin/dashboard');

// Check rights

        if (rights(6) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $this->load->model('roles_model');


    }



// End __construct

    /**

      @Method: index

      @Return: vehicles Listing

     */

    public function index() {



        $data['result'] = $this->roles_model->loadListing();

        $data ['content'] = $this->load->view('roles/listing', $data, true);

        $this->load->view('templete-view', $data);

    }



    /**

     * Method: add

     * Return: Load Add Form

     */

    public function add() {

        $data = array();



        if ($this->input->post()) {



            $db_query = $this->roles_model->saveItem($_POST);



            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Role successfully saved.');

                redirect('admin/roles'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        // Check rights

        if (rights(7) != true) {

            redirect(base_url('admin/dashboard'));

        }



        $data['action'] = 'add';

        $data ['rights'] = $this->roles_model->rights();

        $data ['content'] = $this->load->view('roles/form', $data, true); //Return View as data

        $this->load->view('templete-view', $data);

    }



    /**

     * Method: edit

     * Return: Load Edit Form

     */

    public function edit($id) {

// Check rights

        if (rights(8) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $itemId = $this->common->decode($id);

        $data['id'] = $itemId;

        $data['row'] = $this->roles_model->getRow($itemId);

        $data['action'] = 'edit';

        $data ['rights'] = $this->roles_model->rights();

        $data ['content'] = $this->load->view('roles/form', $data, true); //Return View as data

        $this->load->view('templete-view', $data);

    }



    /**

      @Method: delete

      @Params: itemId

      @Retrun: True/False

     */

    public function delete($id) {

        // Check rights

        if (rights(9) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $itemId = $this->common->decode($id);



        $result = $this->roles_model->deleteItem($itemId);

        if ($result) {

            $this->session->set_flashdata('success_message', 'Record deleted successfully.');

            redirect('admin/roles'); // due to flash data.

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

        $result = $this->roles_model->updateItemStatus($itemId, $status);

        echo $result;

    }



}



//End Class