<?php

/*
----------------------------
Tracks     ----    Controller
----------------------------
*/


if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Tracks extends CI_Controller {



    public function __construct() {

        parent::__construct();



        // check if admin login

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

        // Check rights

        if (rights(1) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $this->load->model('tracks_model');

    }



// End __construct

    /**

      @Method: index

      @Return: vehicles Listing

     */

    public function index() {



        $data['result'] = $this->tracks_model->loadListing();

//        $data['pagination'] = $this->pagination->create_links();

        $data ['content'] = $this->load->view('tracks/listing', $data, true);

       

        $this->load->view('templete-view', $data);



    }



    /**

     * Method: add

     * Return: Load Add Form

     */

    public function add() {

        $data = array();

        // Check rights



        if ($this->input->post()) {

            /// Profile Photo

            if ($_FILES['file_name']['name'] != '') {

                unlink('uploads/tracks/' . $_POST['old_file_name']);

                $extension = $this->common->getExtension($_FILES ['file_name'] ['name']);

                $extension = strtolower($extension);

                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {

                   // return false;

                }

                       

                $path = 'uploads/tracks/';

                $allow_types = 'gif|jpg|jpeg|png';

               

                $photo = $this->common->do_upload_track($path, $allow_types, $_FILES ['file_name']['tmp_name'], $_FILES ['file_name']['name']);

                

                }

            



            $db_query = $this->tracks_model->saveItem($_POST, $photo);





            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/tracks'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        if (rights(2) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $data['action'] = 'add';

        $data ['content'] = $this->load->view('tracks/form', $data, true); //Return View as data

        $this->load->view('templete-view', $data);

    }



    /**

     * Method: edit

     * Return: Load Edit Form

     */

    public function edit($id) {

        // Check rights

        if (rights(3) != true ) {

            redirect(base_url('admin/dashboard'));

        }

        $itemId = $this->common->decode($id);

        $data['id'] = $itemId;

        $data['row'] = $this->tracks_model->getRow($itemId);

        $data['action'] = 'edit';



        $data ['content'] = $this->load->view('tracks/form', $data, true); //Return View as data

        $this->load->view('templete-view', $data);

    }



    /**

      @Method: delete

      @Params: itemId

      @Retrun: True/False

     */

    public function delete($id) {

        // Check rights

        if (rights(4) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $itemId = $this->common->decode($id);

        $result = $this->tracks_model->deleteItem($itemId);

        if ($result) {

            $this->session->set_flashdata('success_message', 'Record deleted successfully.');

            redirect('admin/users'); // due to flash data.

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

        $result = $this->tracks_model->updateItemStatus($itemId, $status);

        echo $result;

    }



    



}



//End Class