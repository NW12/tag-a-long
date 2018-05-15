<?php

/*
----------------------------
EMAIL TEMPLATES     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Email_templates extends CI_Controller {

    public function __construct() {

        parent::__construct();

        //        error_reporting(E_ALL);

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

        // Check rights

       

        $this->load->model('email_templates_model');

    }

// End __construct

    /**

      @Method: index

      @Return:  Listing

     */

    public function index() {

        $this->signup_template();

    }

    //1

    function registration_account_templete() {

        $data = array();

        $posted_data = array();

        $data['emails_data'] = $this->email_templates_model->get_all_active_email_template(1);

        $id = 0;

        if (empty($data['emails_data'])) {

            $email_footer = './application/views/includes/email_templates/email_footer.php';

            $email_content = './application/views/includes/email_templates/email_content.php';

            $handl = fopen($email_content, "rb");

            $content = fread($handl, filesize($email_content));

            fclose($handl);

            $data['content_data'] = ($content);

            $handle = fopen($email_footer, "rb");

            $contents = fread($handle, filesize($email_footer));

            fclose($handle);

            $data['footer_data'] = ($contents);

            $data['welcome_content'] = '';

        } else {

            $data['title'] = $data['emails_data']['title'];

            $data['welcome_content'] = $data['emails_data']['welcome_content'];

            $data['content_data'] = $data['emails_data']['content'];

            $data['footer_data'] = $data['emails_data']['footer'];

            $data['id'] = $id = $data['emails_data']['id'];

            $data['status']  = $data['emails_data']['status'];

        }

        if ($this->input->post()) {

            $this->session->set_flashdata('success_message', '');

            $this->session->set_flashdata('error_message', '');

            $posted_data = array();

            $posted_data['title'] = $this->input->post('title');

            $posted_data['welcome_content'] = $this->input->post('welcome_content');

            $posted_data['content'] = $this->input->post('content');

            $posted_data['footer'] = $this->input->post('footer');

            $posted_data['status'] = $this->input->post('status');

            $posted_data['email_template_type'] = 1;

            if ($id == 0) {

                $db_query = $this->email_templates_model->add_email_template($posted_data);

            } else {

                $posted_data['id'] = $id;

                $db_query = $this->email_templates_model->update_email_template($posted_data);

            }

            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/email_templates/registration_account_templete'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        $data ['controller'] = 'registration_account_templete';

        $data['shw_msg'] = 1;

        $data ['content'] = $this->load->view('email_templates/signup_template_form', $data, true);

        $this->load->view('templete-view.php', $data);

    }

    

     function forgotpassword_account_templete() {

        $data = array();

        $posted_data = array();

        $data['emails_data'] = $this->email_templates_model->get_all_active_email_template(2);

        $id = 0;

        if (empty($data['emails_data'])) {

            $email_footer = './application/views/includes/email_templates/email_footer.php';

            $email_content = './application/views/includes/email_templates/email_content.php';

            $handl = fopen($email_content, "rb");

            $content = fread($handl, filesize($email_content));

            fclose($handl);

            $data['content_data'] = ($content);

            $handle = fopen($email_footer, "rb");

            $contents = fread($handle, filesize($email_footer));

            fclose($handle);

            $data['footer_data'] = ($contents);

            $data['welcome_content'] = '';

        } else {

            $data['title'] = $data['emails_data']['title'];

            $data['welcome_content'] = $data['emails_data']['welcome_content'];

            $data['content_data'] = $data['emails_data']['content'];

            $data['footer_data'] = $data['emails_data']['footer'];

            $data['id'] = $id = $data['emails_data']['id'];

            $data['status']  = $data['emails_data']['status'];

        }

        if ($this->input->post()) {

            $this->session->set_flashdata('success_message', '');

            $this->session->set_flashdata('error_message', '');

            $posted_data = array();

            $posted_data['title'] = $this->input->post('title');

            $posted_data['welcome_content'] = $this->input->post('welcome_content');

            $posted_data['content'] = $this->input->post('content');

            $posted_data['footer'] = $this->input->post('footer');

            $posted_data['status'] = $this->input->post('status');

            $posted_data['email_template_type'] = 2;

            if ($id == 0) {

                $db_query = $this->email_templates_model->add_email_template($posted_data);

            } else {

                $posted_data['id'] = $id;

                $db_query = $this->email_templates_model->update_email_template($posted_data);

            }

            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/email_templates/forgotpassword_account_templete'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        $data ['controller'] = 'forgotpassword_account_templete';

        $data['shw_msg'] = 1;

        $data ['content'] = $this->load->view('email_templates/forgotpassword_template_form', $data, true);

        $this->load->view('templete-view.php', $data);

    }

    

    function support_content_templete() {

        $data = array();

        $posted_data = array();

        $data['emails_data'] = $this->email_templates_model->get_all_active_email_template(4);

        $id = 0;

        if (empty($data['emails_data'])) {

            $email_footer = './application/views/includes/email_templates/email_footer.php';

            $email_content = './application/views/includes/email_templates/email_content.php';

            $handl = fopen($email_content, "rb");

            $content = fread($handl, filesize($email_content));

            fclose($handl);

            $data['content_data'] = ($content);

            $handle = fopen($email_footer, "rb");

            $contents = fread($handle, filesize($email_footer));

            fclose($handle);

            $data['footer_data'] = ($contents);

            $data['welcome_content'] = '';

        } else {

            $data['title'] = $data['emails_data']['title'];

            $data['welcome_content'] = $data['emails_data']['welcome_content'];

            $data['content_data'] = $data['emails_data']['content'];

            $data['footer_data'] = $data['emails_data']['footer'];

            $data['id'] = $id = $data['emails_data']['id'];

            $data['status']  = $data['emails_data']['status'];

        }

        if ($this->input->post()) {

            $this->session->set_flashdata('success_message', '');

            $this->session->set_flashdata('error_message', '');

            $posted_data = array();

            $posted_data['title'] = $this->input->post('title');

            $posted_data['welcome_content'] = $this->input->post('welcome_content');

            $posted_data['content'] = $this->input->post('content');

            $posted_data['footer'] = $this->input->post('footer');

            $posted_data['status'] = $this->input->post('status');

            $posted_data['email_template_type'] = 4;

            if ($id == 0) {

                $db_query = $this->email_templates_model->add_email_template($posted_data);

            } else {

                $posted_data['id'] = $id;

                $db_query = $this->email_templates_model->update_email_template($posted_data);

            }

            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/email_templates/support_content_templete'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        $data ['controller'] = 'support_content_templete';

        $data['shw_msg'] = 1;

        $data ['content'] = $this->load->view('email_templates/support_content_templete_form', $data, true);

        $this->load->view('templete-view.php', $data);

    }

    

     function contact_us_templete() {

        $data = array();

        $posted_data = array();

        $data['emails_data'] = $this->email_templates_model->get_all_active_email_template(5);

       

        $id = 0;

        if (empty($data['emails_data'])) {

            $email_footer = './application/views/includes/email_templates/email_footer.php';

            $email_content = './application/views/includes/email_templates/email_content.php';

            $handl = fopen($email_content, "rb");

            $content = fread($handl, filesize($email_content));

            fclose($handl);

            $data['content_data'] = ($content);

            $handle = fopen($email_footer, "rb");

            $contents = fread($handle, filesize($email_footer));

            fclose($handle);

            $data['footer_data'] = ($contents);

            $data['welcome_content'] = '';

        } else {

            $data['title'] = $data['emails_data']['title'];

            $data['welcome_content'] = $data['emails_data']['welcome_content'];

            $data['content_data'] = $data['emails_data']['content'];

            $data['footer_data'] = $data['emails_data']['footer'];

            $data['id'] = $id = $data['emails_data']['id'];

            $data['status']  = $data['emails_data']['status'];

        }

        if ($this->input->post()) {

            $this->session->set_flashdata('success_message', '');

            $this->session->set_flashdata('error_message', '');

            $posted_data = array();

            $posted_data['title'] = $this->input->post('title');

            $posted_data['welcome_content'] = $this->input->post('welcome_content');

            $posted_data['content'] = $this->input->post('content');

            $posted_data['footer'] = $this->input->post('footer');

            $posted_data['status'] = $this->input->post('status');

            $posted_data['email_template_type'] = 5;

            if ($id == 0) {

                $db_query = $this->email_templates_model->add_email_template($posted_data);

            } else {

                $posted_data['id'] = $id;

                $db_query = $this->email_templates_model->update_email_template($posted_data);

            }

            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/email_templates/contact_us_templete'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        $data ['controller'] = 'contact_us_templete';

        $data['shw_msg'] = 1;

        $data ['content'] = $this->load->view('email_templates/contact_us_template_form', $data, true);

        $this->load->view('templete-view.php', $data);

    }

    

    function newsletter() {

        $data = array();

        $posted_data = array();

        $data['emails_data'] = $this->email_templates_model->get_all_active_email_template(6);

       

        $id = 0;

        if (empty($data['emails_data'])) {

            $email_footer = './application/views/includes/email_templates/email_footer.php';

            $email_content = './application/views/includes/email_templates/email_content.php';

            $handl = fopen($email_content, "rb");

            $content = fread($handl, filesize($email_content));

            fclose($handl);

            $data['content_data'] = ($content);

            $handle = fopen($email_footer, "rb");

            $contents = fread($handle, filesize($email_footer));

            fclose($handle);

            $data['footer_data'] = ($contents);

            $data['welcome_content'] = '';

        } else {

            $data['title'] = $data['emails_data']['title'];

            $data['welcome_content'] = $data['emails_data']['welcome_content'];

            $data['content_data'] = $data['emails_data']['content'];

            $data['footer_data'] = $data['emails_data']['footer'];

            $data['id'] = $id = $data['emails_data']['id'];

            $data['status']  = $data['emails_data']['status'];

        }

        if ($this->input->post()) {

            $this->session->set_flashdata('success_message', '');

            $this->session->set_flashdata('error_message', '');

            $posted_data = array();

            $posted_data['title'] = $this->input->post('title');

            $posted_data['welcome_content'] = $this->input->post('welcome_content');

            $posted_data['content'] = $this->input->post('content');

            $posted_data['footer'] = $this->input->post('footer');

            $posted_data['status'] = $this->input->post('status');

            $posted_data['email_template_type'] = 6;

            if ($id == 0) {

                $db_query = $this->email_templates_model->add_email_template($posted_data);

            } else {

                $posted_data['id'] = $id;

                $db_query = $this->email_templates_model->update_email_template($posted_data);

            }

            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/email_templates/newsletter'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        $data ['controller'] = 'Newsletter';

        $data['shw_msg'] = 1;

        $data ['content'] = $this->load->view('email_templates/newsletter_template_form', $data, true);

        $this->load->view('templete-view.php', $data);

    }

    



}

//End Class