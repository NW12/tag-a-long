<?php


/*
----------------------------
ADMIN USERS     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL);
        // check if admin login
        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');
        //  Check rights
        if (rights(10) != true) {
            redirect(base_url('admin/dashboard'));
        }
        $this->load->model('admin_users_model');

        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    public function index() {

        $data['result'] = $this->admin_users_model->loadListing();
        $data ['content'] = $this->load->view('admin_users/listing', $data, true);
        $this->load->view('templete-view', $data);
    }

    public function add() {
        $data = array();

        if ($this->input->post()) {

            /// Profile Photo
            if ($_FILES['photo']['name'] != '') {
                unlink('uploads/admin_users/pic/' . $_POST['old_photo']);
                unlink('uploads/admin_users/small/' . $_POST['old_photo']);
                $extension = $this->common->getExtension($_FILES ['photo'] ['name']);
                $extension = strtolower($extension);
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                    return false;
                }
                $path = 'uploads/admin_users/';
                $allow_types = 'gif|jpg|jpeg|png';
                $max_height = '8000';
                $max_width = '8000';
                $image = $this->common->do_upload_profile($path, $allow_types, $max_height, $max_width, $_FILES ['photo']['tmp_name'], $_FILES ['photo']['name']);
            }

            $db_query = $this->admin_users_model->saveItem($_POST, $image);


            if ($db_query) {
                $this->session->set_flashdata('success_message', 'Information successfully saved.');
                redirect('admin/admin_users'); // due to flash data.
            } else {
                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');
            }
        }
// Check rights
        if (rights(11) != true) {
            redirect(base_url('admin/dashboard'));
        }
        $data['action'] = 'add';
//        $data["all_roles"] = $this->admin_users_model->get_roles();
        $data ['content'] = $this->load->view('admin_users/form', $data, true); //Return View as data
        $this->load->view('templete-view', $data);
    }

    /**
     * Method: edit
     * Return: Load Edit Form
     */
    public function edit($id) {
        // Check rights
        if (rights(12) != true) {
            redirect(base_url('admin/dashboard'));
        }
        $itemId = $this->common->decode($id);
        $data['id'] = $itemId;
        $data['row'] = $this->admin_users_model->getRow($itemId);
        $data['action'] = 'edit';
//        $data["all_roles"] = $this->admin_users_model->get_roles();
        $data ['content'] = $this->load->view('admin_users/form', $data, true); //Return View as data
        $this->load->view('templete-view', $data);
    }

    public function profile() {
        
        $data['profile_check'] = 1;
        $itemId = $this->session->userdata("user_id");
        $data['id'] = $itemId;
        $data['row'] = $this->admin_users_model->getRow($itemId);
        $data['action'] = 'edit';
//        $data["all_roles"] = $this->admin_users_model->get_roles();
        $data ['content'] = $this->load->view('admin_users/form', $data, true); //Return View as data
        $this->load->view('templete-view', $data);
    }

    function delete($id) {
        // Check rights
        if (rights(13) != true) {
            redirect(base_url('admin/dashboard'));
        }
        $itemId = $this->common->decode($id);
        $result = $this->admin_users_model->deleteItem($itemId);
        if ($result) {
            $this->session->set_flashdata('success_message', 'Record deleted successfully.');
            redirect('admin/admin_users'); // due to flash data.
        } else {
            $this->session->set_flashdata('error_message', 'Opps! Error occured while deleting record. Please try again.');
        }
    }

    public function ajaxChangeStatus() {
        $itemId = $_POST['itemId'];
        $status = $_POST['status'];
        $result = $this->admin_users_model->updateItemStatus($itemId, $status);
        echo $result;
    }

}
