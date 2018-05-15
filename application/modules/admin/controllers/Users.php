<?php

/*
----------------------------
Users     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Users extends CI_Controller {



    public function __construct() {

        parent::__construct();



        // check if admin login

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

        // Check rights

        if (rights(1) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $this->load->model('users_model');

    }



// End __construct

    /**

      @Method: index

      @Return: vehicles Listing

     */

    public function index() {



        $data['result'] = $this->users_model->loadListing();


        $data ['content'] = $this->load->view('users/listing', $data, true);

       

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

            if ($_FILES['profile_image']['name'] != '') {

                unlink('uploads/admin_users/pic/' . $_POST['old_profile_image']);

                unlink('uploads/admin_users/small/' . $_POST['old_profile_image']);

                $extension = $this->common->getExtension($_FILES ['profile_image'] ['name']);

                $extension = strtolower($extension);

                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {

                    return false;

                }

                $path = 'uploads/admin_users/';

                $allow_types = 'gif|jpg|jpeg|png';

                $max_height = '8000';

                $max_width = '8000';

                $photo = $this->common->do_upload_profile($path, $allow_types, $max_height, $max_width, $_FILES ['profile_image']['tmp_name'], $_FILES ['profile_image']['name']);

            }



            $db_query = $this->users_model->saveItem($_POST, $photo);





            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/users'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        if (rights(2) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $data['action'] = 'add';

        $data ['content'] = $this->load->view('users/form', $data, true); //Return View as data

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

        $data['row'] = $this->users_model->getRow($itemId);

        $data['action'] = 'edit';



        $data ['content'] = $this->load->view('users/form', $data, true); //Return View as data

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

        $result = $this->users_model->deleteItem($itemId);

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

        $result = $this->users_model->updateItemStatus($itemId, $status);

        echo $result;

    }



    /**

     * Method: checkEmail

     *

     */

    public function checkEmail() {





        $email = $this->input->post('email');

        $name = $this->users_model->checkEmail($email);

        if ($name == 0) {

            echo 0;

        } else {

            echo 1;

        }



        exit;

    }



    public function checkUsername() {





        $username = $this->input->post('username');

        $name = $this->users_model->checkUsername($username);

        if ($name == 0) {

            echo 0;

        } else {

            echo 1;

        }



        exit;

    }



}



//End Class